<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable= ['category_image'];
    protected $guarded = ['id'];

    function rel_to_user(){
        return $this->belongsTo(User::class, 'added_by');

    }
}
