<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'class',
        'min_required_entries',
    ];

    /**
     * Get the users who have the achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('unlocked_at');
    }
}

