<?php

declare(strict_types=1);

namespace App\Providers\Mattermost;

use App\Contracts\Mattermost\ChannelServiceContract;
use App\Contracts\Mattermost\CommandServiceContract;
use App\Contracts\Mattermost\DialogServiceContract;
use App\Contracts\Mattermost\PostServiceContract;
use App\Contracts\Mattermost\TeamServiceContract;
use App\Contracts\Mattermost\UserServiceContract;
use App\Services\Mattermost\ChannelService\Service as ChannelService;
use App\Services\Mattermost\CommandService\Service as CommandService;
use App\Services\Mattermost\DialogService\Service as DialogService;
use App\Services\Mattermost\PostService\Service as PostService;
use App\Services\Mattermost\TeamService\Service as TeamService;
use App\Services\Mattermost\UserService\Service as UserService;
use Arsentiyz\MattermostDriver\Facades\Mattermost;
use Illuminate\Foundation\Application;

final class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $loginServer = Mattermost::server();

        $this->app->singleton(
            TeamServiceContract::class,
            fn (Application $app) => new TeamService($loginServer->getTeamEndpoint())
        );

        $this->app->singleton(
            CommandServiceContract::class,
            fn (Application $app) => new CommandService($loginServer->getCommandEndpoint())
        );

        $this->app->singleton(
            UserServiceContract::class,
            fn (Application $app) => new UserService($loginServer->getUserEndpoint())
        );

        $this->app->singleton(
            ChannelServiceContract::class,
            fn (Application $app) => new ChannelService($loginServer->getChannelEndpoint()),
        );

        $this->app->singleton(
            DialogServiceContract::class,
            fn (Application $app) => new DialogService($loginServer->getDialogEndpoint()),
        );

        $this->app->singleton(
            PostServiceContract::class,
            fn (Application $app) => new PostService($loginServer->getPostEndpoint()),
        );
    }
}
