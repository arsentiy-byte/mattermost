<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Entities\Channel;

interface ChannelServiceContract
{
    public function direct(string $senderId, string $receiverId): Channel;
}
