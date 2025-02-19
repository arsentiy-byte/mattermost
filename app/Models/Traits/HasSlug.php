<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
trait HasSlug
{
    public string $slugAttributeName = 'slug';

    public function checkSlugBeforeSaving(?string $slug): ?string
    {
        return empty($slug) ? '' : $this->getUniqueSlug($slug);
    }

    /**
     * Example:
     * ->afterStateUpdated(fn (Closure $set, $state, ?Model $record) => $set('slug', ($record ?? new Model())->generateSlug($state)))
     *
     */
    public function generateSlug(?string $title): string
    {
        return empty($title) ? '' : $this->getUniqueSlug(Str::slug($title));
    }

    protected static function bootHasSlug(): void
    {
        static::saving(static function (self $model): void {
            $model->{$model->slugAttributeName} = $model->checkSlugBeforeSaving($model->{$model->slugAttributeName});
        });
    }

    private function getUniqueSlug(string $slug): string
    {
        if ( ! $this->otherRecordExistsWithSlug($slug)) {
            return $slug;
        }

        $counter = 2;
        while ($this->otherRecordExistsWithSlug(sprintf('%s-%d', $slug, $counter))) {
            $counter++;
        }

        return sprintf('%s-%d', $slug, $counter);
    }

    private function otherRecordExistsWithSlug(string $slug): bool
    {
        $query = static::query()
            ->where($this->slugAttributeName, 'like', $slug)
            ->withoutGlobalScopes();

        if ($this->exists) {
            $query->whereNot($this->getKeyName(), $this->getKey());
        }

        if (in_array(SoftDeletes::class, class_uses_recursive(self::class), true)) {
            $query->withTrashed();
        }

        return $query->exists();
    }
}
