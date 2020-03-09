<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grower extends Model
{
    //
    public static function getGrowers($position, $count)
    {
        $allGrowers = User::where('grower', '<>', null)->get();
        
        $growers = [ ];
        $maxIndex = min([$allGrowers->count(), $position + $count]);
        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($growers, $allGrowers[$i]);
        }
        return $growers;
    }

    public static function getGrowerCount()
    {
        return User::where('grower', '<>', null)->get()->count();
    }
}
