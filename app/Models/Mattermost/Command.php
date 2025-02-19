<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use Arsentiyz\MattermostDriver\Enums\Command\Method;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $external_id
 * @property string|null $token
 * @property Carbon|null $create_at
 * @property Carbon|null $update_at
 * @property Carbon|null $delete_at
 * @property string|null $creator_id
 * @property string $team_id
 * @property string $trigger
 * @property Method $method
 * @property string|null $username
 * @property string|null $icon_url
 * @property bool $auto_complete
 * @property string|null $auto_complete_desc
 * @property string|null $auto_complete_hint
 * @property string|null $display_name
 * @property string|null $description
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Team $team
 */
final class Command extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'mattermost_commands';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'external_id',
        'token',
        'create_at',
        'update_at',
        'delete_at',
        'creator_id',
        'team_id',
        'trigger',
        'method',
        'username',
        'icon_url',
        'auto_complete',
        'auto_complete_desc',
        'auto_complete_hint',
        'display_name',
        'description',
        'url',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'create_at' => 'datetime',
        'update_at' => 'datetime',
        'delete_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'method' => Method::class,
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
