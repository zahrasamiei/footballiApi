<?php


namespace App\Repositories\Eloquent;


use App\Models\Repository;
use App\Repositories\StarredRepositoriesInterface;
use App\Traits\SendHttpRequest;
use App\Traits\Validation;
use GuzzleHttp\Exception\GuzzleException;

class StarredRepositories extends BaseRepository implements StarredRepositoriesInterface
{

    use SendHttpRequest,Validation;
    #hold starred repositories
    private $repositories = [];

    /**
     * StarredRepositories constructor.
     *
     * @param Repository $model
     */
    public function __construct(Repository $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all starred repositories
     *
     * @method  GET api/repositories/{user}/starred
     * @access  public
     * @param $username
     */
    public function getStarredRepositories($username)
    {
        #username is necessary
        $requiredUsername = $this->validation("required", $username, "username");
        #if userename is empty,return error
        if($requiredUsername) return $requiredUsername;

        #get github url form env
        $url = env("GITHUB_API_URL")."/users/$username/starred";
        #send http get request to github for receive starred repositories
        try {
            $userRepositories = $this->sendGetRequest($url);
        } catch (GuzzleException $e) {
            return $this->error($e->getMessage(), 404);
        }

        #if error to get data(username not found or ..),return error
        $userRepositoriesError = $this->validation("httpError", $userRepositories);
        if($userRepositoriesError) return $userRepositoriesError;

        #if starred repositories is empty,send error
        $emptyRepository = $this->validation("empty", $userRepositories["response"], "starred repositories");
        if($emptyRepository) return $emptyRepository;

        #fill $repositories
        $this->needFields($userRepositories["response"], $username);
        #add starred repositories to repositories table
        $this->add();
        #send json data
        return $this->success("repositories found", $this->repositories);
    }

    /**
     * fill $repositories with needed fields values
     *
     * @access  public
     * @param $repositories
     * @param $username
     */

    public function needFields($repositories, $username)
    {
        foreach ($repositories as $repository)
        {
            $this->repositories[] = [
                "repositoryId" => $repository["id"],
                "username" => $username,
                "name" => $repository["name"],
                "description" => $repository["description"],
                "language" => $repository["language"],
                "html_url" => $repository["html_url"]
            ];
        }
    }

    /**
     * add $repositories to repositories table
     *
     * @access  public
     */

    public function add()
    {
        $this->createMany($this->repositories);
    }

}
