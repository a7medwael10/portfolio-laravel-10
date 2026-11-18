<?php

namespace App\Models\Concerns;

use App\Support\MediaAsset;

trait DeletesReplacedMedia
{
    public static function bootDeletesReplacedMedia(): void
    {
        static::updated(function ($model): void {
            $oldMedia = [];

            foreach ($model->mediaAttributes() as $attribute) {
                if (! $model->wasChanged($attribute)) {
                    continue;
                }

                $oldValue = $model->getOriginal($attribute);

                if (filled($oldValue) && $oldValue !== $model->getAttribute($attribute)) {
                    $oldMedia[] = $oldValue;
                }
            }

            foreach (array_unique($oldMedia) as $oldValue) {
                MediaAsset::delete($oldValue);
            }
        });

        static::deleted(function ($model): void {
            foreach ($model->mediaAttributes() as $attribute) {
                MediaAsset::delete($model->getAttribute($attribute));
            }
        });
    }

    /**
     * @return array<int, string>
     */
    abstract protected function mediaAttributes(): array;
}
