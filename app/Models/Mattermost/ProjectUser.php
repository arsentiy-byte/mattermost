<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $channel_project_id
 * @property string $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ChannelProject $channelProject
 * @property-read User $user
 */
final class ProjectUser extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'mattermost_projects_users';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'channel_project_id',
        'user_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function channelProject(): BelongsTo
    {
        return $this->belongsTo(ChannelProject::class, 'channel_project_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
