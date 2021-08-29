<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\RepositoriesTags;
use App\Repositories\Eloquent\StarredRepositories;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\StarredRepositoriesInterface;
use App\Repositories\TagsInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(StarredRepositoriesInterface::class, StarredRepositories::class);
        $this->app->bind(TagsInterface::class, RepositoriesTags::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
