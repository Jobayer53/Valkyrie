<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $guarded= ['id'];

    function rel_to_category(){
        return $this->belongsTo(category::class,'category_id');
    }
}
