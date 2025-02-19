<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $channel_id
 * @property string $project
 * @property bool $workflow_enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Channel $channel
 * @property-read string $project_link
 * @property-read string $formatted_project_link
 * @property-read ProjectUser[]|Collection $attachedUsers
 */
final class ChannelProject extends Model
{
    use ConfigTrait;
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'mattermost_channels_projects';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'channel_id',
        'project',
        'workflow_enabled',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'project_link',
        'formatted_project_link',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function getProjectLinkAttribute(): string
    {
        return sprintf('%s/projects/%s', self::getJiraHost(), $this->project);
    }

    public function getFormattedProjectLinkAttribute(): string
    {
        return sprintf('[%s](%s)', $this->project, $this->project_link);
    }

    public function attachedUsers(): HasMany
    {
        return $this->hasMany(ProjectUser::class, 'channel_project_id', 'id');
    }
}
