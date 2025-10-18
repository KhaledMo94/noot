<?php

namespace App\Traits;

trait HasImageAttributeTrait
{
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}
