<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class BillingDetails extends Model
{
    use HasFactory;

    // function rel_to_country(){
    //     return $this->belongsTo(Country::class, 'country_id');
    // }
}