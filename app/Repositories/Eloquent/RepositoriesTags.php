<?php


namespace App\Repositories\Eloquent;

use App\Models\Repository;
use App\Models\Tag;
use App\Repositories\TagsInterface;
use App\Traits\SendHttpRequest;
use App\Traits\Validation;
use Illuminate\Http\Request;

class RepositoriesTags extends BaseRepository implements TagsInterface
{

    use SendHttpRequest,Validation;
    private $tags = [];

    /**
     * RepositoriesTags constructor.
     *
     * @param Tag $model
     */
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    /**
     * add tags
     *
     * @method  POST api/users/{user}/addTags
     * @access  public
     * @param $username
     * @param $data
     */

    public function adds($username,$data)
    {
        $tags = $data["tags"];
        $repositoryId = $data["repositoryId"];

        #repository is required
        $requiredRepository = $this->validation("required", $repositoryId, "repository id");
        if($requiredRepository) return $requiredRepository;
        #end

        #check this username,has given repository
        $repository = $this->findRepository($repositoryId,$username);
        $repositoryFound = $this->validation("repositoryFound", $repository, "repository id");
        if($repositoryFound) return $repositoryFound;
        #end

        $data = [];
        foreach ($tags as $key => $tag) {
            #Check that each item has a name
            $requiredTagName = $this->validation("required", $tag, "tag name");
            if($requiredTagName) return $requiredTagName;
            #end

            $data[$key] = [
                "name" => $tag,
                "repId" => $repository["id"],
            ];
        }

        #insert all data to tags table
        $this->createMany($data);

        #send response
        return $this->success("successfully added tags ", array("repository id" => $repositoryId));
    }

    /**
     * find
     *
     * @access  public
     * @param $id
     * @param $username
     * @return Repository
     */

    public function findRepository($id,$username)
    {
        return Repository::where("username",$username)->where("repositoryId",$id)->first();
    }

    /**
     * search tags by part of name column
     *
     * @method  GET api/users/{user}/search/{tag}
     * @access  public
     * @param $tag
     * @param $username
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function search($tag, $username)
    {
        #tag name is required
        $requiredTagName = $this->validation("required", $tag, "tag name");
        if($requiredTagName) return $requiredTagName;

        #get tags for username
        $data = $this->findTagsByNameAndUsername($username, $tag);

        #return error if tag is empty
        $emptyTags = $this->validation("empty", $data, "tags");
        if($emptyTags) return $emptyTags;

        return $this->success("successfully find tags " , $data);
    }

    /**
     * add tag
     *
     * @method  POST  api/users/{user}/tag/add
     * @access  public
     * @param $username
     * @param Request $request
     */

    public function add($username,Request $request)
    {
        try
        {
            $repositoryId = $request->repositoryId;
            $name = $request->name;

            #check this username,has given repository
            $repository = $this->findRepository($repositoryId,$username);
            $repositoryFound = $this->validation("repositoryFound", $repository, "repository id");
            if($repositoryFound) return $repositoryFound;
            #end

            $data = array("name" => $name, "repId" => $repository["id"]);
            $result = $this->create($data);

            return $this->success("successfully add tag", $result);

        }catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * add tag
     *
     * @method  PUT|PATCH  api/users/{user}/tag/update
     * @access  public
     * @param $username
     * @param $request
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function edit($username, $request, $id)
    {
        $data = [];

        #check tag exist
        $tag = $this->find($id);
        $emptyTag = $this->validation("empty", $tag, "tag");
        if($emptyTag) return $emptyTag;
        #end

        #check this username,has given repository
        if(!empty($request["repositoryId"]))
        {
            $repositoryId = $request["repositoryId"];
            $repository = $this->findRepository($repositoryId,$username);
            $repositoryFound = $this->validation("repositoryFound", $repository, "repository id");
            if($repositoryFound) return $repositoryFound;

            $data["repId"] = $repository["id"];
        }
        #end

        #check name filled
        if(!empty($request["name"]))
        {
            $data["name"] = $request["name"];
        }
        #end

        #update
        $result = $this->update($data, $id);

        return $this->success("successfully edit tag", $result);

    }

    /**
     * find tag by name for given username
     *
     * @access  public
     * @param $username
     * @param $name
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function findTagByNameAndUsername($username, $name)
    {
        #get tag data from tag name
        $data = $this->findByColumn("name", $name)->get();

        #get only tags for given username
        $data = $this->getTagForUsername($username, $data);
        return $data[0]->id;
    }

    /**
     * give tags for given username
     *
     * @access  public
     * @param $username
     * @param $data
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function getTagForUsername($username, $data)
    {
        return $data = $data->filter(function ($value, $key) use($username){
            $repository = $value->repository->username;
            return $username == $repository;
        });
    }

    /**
     * find tags by name for given username
     *
     * @access  public
     * @param $username
     * @param $name
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function findTagsByNameAndUsername($username, $name)
    {
        #find tags by name
        $data = $this->findLikeByColumn("name", $name)->get();

        #get only tags for given username
        $data = $this->getTagForUsername($username, $data);
        return $data;
    }

    /**
     * destroy specific tag
     *
     * @method  DELETE api/users/{user}/tags/{tag}
     * @access  public
     * @param $username
     * @param $name
     */

    public function destroy($username, $name)
    {
        #fidn tag for given username
        $id = $this->findTagByNameAndUsername($username, $name);

        #check if tag not found
        $emptyTags = $this->validation("empty", $name, "tag");
        if($emptyTags) return $emptyTags;

        #remove tag
        $this->delete($id);
        return $this->success("successfully remove tags ", array("name" => $name));
    }

}
