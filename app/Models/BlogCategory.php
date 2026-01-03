<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $primaryKey = 'categoryID';

    protected $fillable = [
        'categoryName',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'categoryID');
    }
}
