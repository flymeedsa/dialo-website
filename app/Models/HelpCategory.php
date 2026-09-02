<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpCategory extends Model
{
    use HasLocalizedContent;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean'];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(HelpArticle::class);
    }
}
