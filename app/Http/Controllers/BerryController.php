<?php

namespace App\Http\Controllers;

use App\Fruit;
use App\Image;
use App\Variety;
use App\MarketPrice;
use Illuminate\Http\Request;

class BerryController extends Controller
{
    //

    public function showNewBerryForm()
    {
        return view("newberry");
    }

    public function createNewBerry(Request $request)
    {
        $request->validate([
            'berry_name' => 'required|max:255',
            'variety_name' => 'required|max:255',
        ]);

        // It's possible the fruit already exists, so we need to check
        $existingFruit = Fruit::where('name', $request->berry_name)->first();
        if($existingFruit == null){ // Need to upload a new berry type
            $fruit = new Fruit;
            $fruit->name = $request->berry_name;
            $fruit->save();
        }
        else // Adding a variety to an existing berry type
        {
            $fruit = $existingFruit;
        }

        // It's always possible someone tries to add a variety that's already present, so we should check that too
        if(Variety::where([['name', $request->variety_name], ['fruit', $fruit->id]])->doesntExist())
        {
            $variety = new Variety;
            $variety->name = $request->variety_name;
            $variety->fruit = $fruit->id;
            $variety->save();
        }
        
        return redirect(route('newauction'));
    }

    public function getAllVarieties(Request $request)
    {
        $fruit = $request->input('fruit', -1);
        if($fruit != -1)
        {
            $varieties = [ ];
            $data = Variety::where('fruit', $fruit)->get()->sortBy('name');
            foreach($data as $variety)
            {
                array_push($varieties, ['id' => $variety->id, 'name' => $variety->name]);
            }
        }
        else
        {
            $varieties = [ ];
        }
        return $varieties;
    }

    public function getBerriesWithAuctions(Request $request)
    {
        return Fruit::getBerriesWithAuctions($request->position, $request->count);
    }

    public function getNumberOfBerriesWithAuctions()
    {
        return Fruit::getNumberOfBerriesWithAuctions();
    }

    public static function getVarietiesWithAuctions(Request $request)
    {
        return Variety::getVarietiesWithAuctions($request->berry, $request->position, $request->count);
    }

    public function getNumberOfVarietiesWithAuctions(Request $request)
    {
        return Variety::getNumberOfVarietiesWithAuctions($request->berry);
    }

    public function getBerryImage(Request $request)
    {
        $berry = Fruit::where('id', $request->berry)->get()->first();
        return [
            'id' => $request->berry,
            'image' => !is_null($berry) ? $berry->getRandomImageURL() : Image::DEFAULT_IMAGE
        ];
    }

    public function getVarietyImage(Request $request)
    {
        $variety = Variety::where('id', $request->variety)->get()->first();
        return [
            'id' => $request->variety,
            'image' => !is_null($variety) ? $variety->getRandomImageURL() : Image::DEFAULT_IMAGE
        ];
    }

    public function getPriceEstimate(Request $request)
    {
        $fresh = $request->fresh == 'true';
        $defects = $request->defects == 'true';

        $grade = self::calculateGrade($fresh, $defects, floatval($request->age));

        return MarketPrice::where([['variety', $request->variety],['grade', $grade]])->select('value')->get()->first();
    }

    public static function calculateGrade($fresh, $defects, $age)
    {
        // Score starts at 0 and loses points for lack of quality
        $score = 0;
        $score -= ($fresh ? 0 : 1);
        $score -= ($defects ? 1 : 0);

        // Age depends on if the berries are frozen or not
        if($fresh)
        {
            if($age > 0 && $age < 3)
            {
                $score -= 1;
            }
            elseif($age > 2)
            {
                $score -= 4;
            }
        }
        else
        {
            if($age > 0 && $age < 3)
            {
                $score -= 1;
            }
            elseif($age > 2 && $age < 5)
            {
                $score -= 2;
            }
            elseif($age > 4 && $age < 9)
            {
                $score -= 3;
            }
            elseif($age > 8)
            {
                $score -= 4;
            }
        }

        // Pick grade based on score
        if($score == 0)
        {
            $grade = 1;
        }
        elseif($score > -4)
        {
            $grade = 2;
        }
        else
        {
            $grade = 3;
        }

        return $grade;
    }
}
