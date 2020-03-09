<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    //
    /**
     * Returns a collection of <Fruit> that have auctions running.
     * $position: Index to start pulling from
     * $count: The number of results to pull
     */
    public static function getBerriesWithAuctions($position, $count)
    {
        
        $allFruits = self::getAllBerriesWithAuctions();
        $fruits = [ ];

        $maxIndex = min([$allFruits->count(), $position + $count]);

        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($fruits, $allFruits[$i]);
        }

        return $fruits;
    }

    public function hasAuctions()
    {
        $result = false;
        $allFruits = self::getAllBerriesWithAuctions();
        foreach($allFruits as $fruit)
        {
            if($fruit->id == $this->id)
            {
                $result = true;
                break;
            }
        }
        return $result;
    }

    /**
     * Returns the number of fruits that have auctions running.
     */
    public static function getNumberOfBerriesWithAuctions()
    {
        return count(self::getAllBerriesWithAuctions());
    }

    /**
     * Returns the ids of fruits that have auctions running.
     */
    private static function getAllBerriesWithAuctions()
    {
        // Get all auctions currently running
        $auctions = Auction::getCurrentAuctions();
        $fruitIds = [ ];
        // Get Varieties present
        foreach($auctions as $auction)
        {
            // Get variety
            $variety = Variety::where('id', $auction->variety)->get()->first();
            if(!in_array($variety->fruit, $fruitIds, false))
            {
                array_push($fruitIds, $variety->fruit);
            }
        }
        // Get berries present
        return Fruit::whereIn('id', $fruitIds)->orderBy('name', 'asc')->get();
    }

    public function getRandomImageURL()
    {   
        // Get auctions with this berry
        $auctions = Auction::getCurrentAuctions();
        $images = [ ];
        $imageID = " ";
        foreach($auctions as $auction)
        {
            // Get variety
            $variety = Variety::where('id', $auction->variety)->get()->first();
            if($variety->fruit == $this->id)
            {
                array_push($images, $auction->image);
            }
        }
        if(count($images) > 0){
            $imageID = $images[rand ( 0 , count($images)-1)];
        }
        return Image::GetImage($imageID);
    }

    public function getColorTags()
    {
        $varieties = Variety::getAllVarietiesWithAuctions($this->id);
        $varietyIDs = [ ];
        foreach($varieties as $variety)
        {
            array_push($varietyIDs, $variety->id);
        }
        $rawTags = Auction::whereIn('variety', $varietyIDs)->select('color_tags')->distinct()->get();
        $tags = [ ];
        foreach($rawTags as $rawTag)
        {
            // Separate by comma
            $arr = explode(',', $rawTag->color_tags);
            foreach($arr as $tag)
            {
                if(!ctype_space($tag))
                {
                    if(!in_array($tag, $tags))
                    {
                        array_push($tags, $tag);
                    }
                }
            }
        }
        return $tags;
    }

    public function getTasteTags()
    {
        $varieties = Variety::getAllVarietiesWithAuctions($this->id);
        $varietyIDs = [ ];
        foreach($varieties as $variety)
        {
            array_push($varietyIDs, $variety->id);
        }
        $rawTags = Auction::whereIn('variety', $varietyIDs)->select('taste_tags')->distinct()->get();
        $tags = [ ];
        foreach($rawTags as $rawTag)
        {
            // Separate by comma
            $arr = explode(',', $rawTag->taste_tags);
            foreach($arr as $tag)
            {
                if(!ctype_space($tag))
                {
                    if(!in_array($tag, $tags))
                    {
                        array_push($tags, $tag);
                    }
                }
            }
        }
        return $tags;
    }

    public function getUsesTags()
    {
        $varieties = Variety::getAllVarietiesWithAuctions($this->id);
        $varietyIDs = [ ];
        foreach($varieties as $variety)
        {
            array_push($varietyIDs, $variety->id);
        }
        $rawTags = Auction::whereIn('variety', $varietyIDs)->select('uses_tags')->distinct()->get();
        $tags = [ ];
        foreach($rawTags as $rawTag)
        {
            // Separate by comma
            $arr = explode(',', $rawTag->uses_tags);
            foreach($arr as $tag)
            {
                if(!ctype_space($tag))
                {
                    if(!in_array($tag, $tags))
                    {
                        array_push($tags, $tag);
                    }
                }
            }
        }
        return $tags;
    }

}
