<?php

declare(strict_types=1);

namespace App\Handlers\Jenkins;

use App\Contracts\Mattermost\PostServiceContract;
use App\DTO\Jenkins\WebhookRequestDTO;
use App\Enums\Jenkins\Phase;
use App\Enums\Jenkins\Status;
use App\Models\Mattermost\ChannelProject;
use App\Traits\ConfigTrait;
use Arsentiyz\MattermostDriver\Requests\Post\CreateRequest;
use Illuminate\Support\Str;

final readonly class WebhookHandler
{
    use ConfigTrait;

    public function __construct(
        private PostServiceContract $postService,
    ) {
    }

    public function handle(WebhookRequestDTO $dto, string $project): void
    {
        /** @var ChannelProject|null $channelProject */
        $channelProject = ChannelProject::query()->where('project', $project)->first();

        if (null === $channelProject) {
            return;
        }

        $status = $this->getStatus(
            Phase::tryFrom($dto->build->phase),
            null === $dto->build->status ? Status::NO_VALUE : Status::tryFrom($dto->build->status),
        );

        if (null === $status) {
            return;
        }

        $url = sprintf('%s/%s', self::getJenkinsHost(), $dto->url);

        $isRepositoryNotNull = null !== $dto->build->scm->branch && null !== $dto->build->scm->url;
        $isCommitNotNull = null !== $dto->build->scm->commit && null !== $dto->build->scm->url;

        $repository = sprintf(
            'Репозиторий: [%s](%s)',
            $dto->build->scm->branch,
            $dto->build->scm->url
        );

        $commit = sprintf(
            'Коммит: [%s](%s/-/commit/%s)',
            $dto->build->scm->commit,
            Str::before($dto->build->scm->url, '.git'),
            $dto->build->scm->commit,
        );

        $this->postService->createPost(new CreateRequest(
            true,
            $channelProject->channel_id,
            implode("\n", [
                sprintf('#jenkins #jenkins_%s', Str::lower($dto->build->phase)),
                "\n",
                sprintf('[%s](%s)', $dto->name, $url),
                $isRepositoryNotNull ? $repository : '',
                $isCommitNotNull ? $commit : '',
                "\n",
                sprintf('[%s](%s)', $status, $dto->build->fullUrl),
                sprintf(
                    ':alarm_clock: [%s](%s)',
                    sprintf('%.2f минут', $dto->build->duration / 1000 / 60),
                    sprintf('%s/buildTimeTrend', $url),
                )
            ]),
        ));
    }

    private function getStatus(?Phase $phase, ?Status $status): ?string
    {
        if ( ! in_array($phase, [Phase::STARTED, Phase::FINALIZED], true)) {
            return null;
        }

        if (Phase::STARTED === $phase) {
            return ':large_blue_circle: Запуск обновлений';
        }

        if (Status::SUCCESS === $status) {
            return ':large_green_circle: Обновление загружено';
        }

        return ':red_circle: Что то пошло не так';
    }
}
