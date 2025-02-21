<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Requests\Action\Dialog\OpenRequest;

interface DialogServiceContract
{
    public function open(OpenRequest $request): void;
}
