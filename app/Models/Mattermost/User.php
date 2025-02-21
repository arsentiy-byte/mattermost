<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read Collection<Team>|array<int, Team> $teams
 */
final class User extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'mattermost_users';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'first_name',
        'last_name',
        'nickname',
        'email',
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
        'full_name',
    ];

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }


    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'mattermost_users_teams',
            'user_id',
            'team_id',
        );
    }
}
