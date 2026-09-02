<?php

namespace App\Models\Concerns;

trait HasLocalizedContent
{
    public function localized(string $field, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $localized = $this->getAttribute($field.'_'.$locale);

        return filled($localized) ? $localized : $this->getAttribute($field.'_ar');
    }
}
