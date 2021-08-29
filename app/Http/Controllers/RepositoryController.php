<?php

namespace App\Http\Controllers;

use App\Repositories\StarredRepositoriesInterface;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{

    private $starredRepository;

    public function __construct(StarredRepositoriesInterface $starredRepository)
    {
        $this->starredRepository = $starredRepository;
    }

    /**
     * Display starred repository for specific user
     *
     * @param $username
     * @return void
     */
    public function show($username)
    {
        return $this->starredRepository->getStarredRepositories($username);
    }

}
