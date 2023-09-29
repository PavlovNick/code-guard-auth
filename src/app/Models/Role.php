<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title'
    ];

    /**
     * Returns the model with the specified title.
     *
     * @param string $title
     * @return Role
     */
    public static function getByTitle(string $title): Role
    {
        return Role::where('title', '=', $title)->first();
    }
}
