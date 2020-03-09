<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    protected $table = 'Countries';

    //
    // Get a country id from a 2 letter ISO country code
    // Allows countries to represented by a code in views, but as a numeric id in the database
    public static function idFromCountryCode($code){
        return DB::table('countries')->where('code', $code)->first()->id;
    }

    // Get get name and country code of all countries
    public static function getAll(){
        return DB::table('countries')->get();
    }
}
