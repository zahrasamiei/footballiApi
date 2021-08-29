<?php

namespace App\Repositories;

interface StarredRepositoriesInterface
{

    /**
     * Get all starred repositories
     *
     * @method  GET api/repositories/{user}/starred
     * @access  public
     * @param $username
     */

    public function getStarredRepositories($username);

}
