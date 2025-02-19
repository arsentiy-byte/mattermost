<?php

declare(strict_types=1);

namespace App\Models\Mattermost;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $team_id
 * @property string $name
 * @property string $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Team $team
 */
final class Channel extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'mattermost_channels';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'team_id',
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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
