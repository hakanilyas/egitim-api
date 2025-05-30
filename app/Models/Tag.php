<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description'];

    /**
     * Get the educations that have this tag.
     */
    public function educations()
    {
        return $this->belongsToMany(Education::class);
    }
}
