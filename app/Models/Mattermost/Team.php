<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property string $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Channel[]|Collection $channels
 * @property-read Command[]|Collection $commands
 * @property-read array<int, User>|Collection<User> $users
 */
final class Team extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'mattermost_teams';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'display_name',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'team_id', 'id');
    }

    public function commands(): HasMany
    {
        return $this->hasMany(Command::class, 'team_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'mattermost_users_teams',
            'team_id',
            'user_id',
            'id',
            'id',
        );
    }
}
