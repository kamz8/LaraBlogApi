<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(string[] $role)
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
