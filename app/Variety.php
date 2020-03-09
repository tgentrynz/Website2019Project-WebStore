<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    //
    public static function getVarietiesWithAuctions($berry, $position, $count)
    {
        $allVarieties = self::getAllVarietiesWithAuctions($berry);
        $varieties = [ ];

        $maxIndex = min([$allVarieties->count(), $position + $count]);

        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($varieties, $allVarieties[$i]);
        }

        return $varieties;
    }

    public function hasAuctions()
    {
        $result = false;
        $allVarieties = self::getAllVarietiesWithAuctions($this->fruit);
        foreach($allVarieties as $variety)
        {
            if($variety->id == $this->id)
            {
                $result = true;
                break;
            }
        }
        return $result;
    }

    public static function getNumberOfVarietiesWithAuctions($berry)
    {
        return count(self::getAllVarietiesWithAuctions($berry));
    }

    /**
     * Returns the ids of fruits that have auctions running.
     */
    public static function getAllVarietiesWithAuctions($berry)
    {
        // Get all auctions currently running
        $auctions = Auction::getCurrentAuctions();
        $varietyIds = [ ];
        // Get Varieties present
        foreach($auctions as $auction)
        {
            // Get variety
            $variety = Variety::where('id', $auction->variety)->get()->first();
            if(!in_array($variety->id, $varietyIds, false) && $variety->fruit == $berry)
            {
                array_push($varietyIds, $variety->id);
            }
        }
        // Get berries present
        return Variety::whereIn('id', $varietyIds)->orderBy('name', 'asc')->get();
    }

    public function getRandomImageURL()
    {   
        // Get auctions with this variety
        $auctions = Auction::getCurrentAuctions();
        $images = [ ];
        $imageID = " ";
        foreach($auctions as $auction)
        {
            // Get variety
            if($auction->variety == $this->id)
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
        $rawTags = Auction::where('variety', $this->id)->select('color_tags')->distinct()->get();
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
        $rawTags = Auction::where('variety', $this->id)->select('taste_tags')->distinct()->get();
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
        $rawTags = Auction::where('variety', $this->id)->select('uses_tags')->distinct()->get();
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
