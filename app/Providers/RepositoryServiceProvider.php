<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\FileRepositoryInterface;
use App\Repositories\FileRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
