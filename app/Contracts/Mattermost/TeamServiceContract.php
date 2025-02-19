<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Collections\ChannelCollection;
use Arsentiyz\MattermostDriver\Collections\TeamCollection;
use Arsentiyz\MattermostDriver\Requests\Team\ChannelsRequest;
use Arsentiyz\MattermostDriver\Requests\Team\IndexRequest;

interface TeamServiceContract
{
    public function getTeams(IndexRequest $request): TeamCollection;

    public function getPublicChannels(ChannelsRequest $request): ChannelCollection;

    public function getPrivateChannels(ChannelsRequest $request): ChannelCollection;
}
