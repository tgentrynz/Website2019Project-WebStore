<?php

namespace App;

use App\Bid;
use App\User;
use App\Grower;
use App\Variety;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    public function getWinner()
    {
        return $this->getHighestBid()->customer;
    }
    public function getHighestBid()
    {
        $bids = $this->getBids();
        return $bids->count() > 0 ? $bids[0] : null;
    }

    public function getBids()
    {
        return Bid::where('auction', $this->id)->orderBy('value', 'desc')->get();
    }

    public function getEndTime()
    {
        $startTime = new DateTime($this->starting_time);
        date_add($startTime, date_interval_create_from_date_string("$this->length days"));
        return $startTime->format('Y-m-d H:i:s');
    }

    public function hasEnded()
    {
        $endTime = new DateTime($this->getEndTime());
        return $endTime < new DateTime(date('Y-m-d H:i:s'));
    }

    public function hasNoBids()
    {
        return is_null($this->getHighestBid());
    }

    public static function getCurrentAuctions()
    {
        $rawAuctions = Auction::whereRaw('DATE_ADD(`starting_time`, INTERVAL `length` DAY) > NOW()')->get();
        // Convert to PHP array
        $auctions = [ ];
        foreach($rawAuctions as $auction)
        {
            array_push($auctions, $auction);
        }
        return $auctions;
    }

    public static function getAuctionsByBerry($berry, $position, $count)
    {
        // Get all current auctions
        $allAuctions = self::getAllAuctionsByBerry($berry);

        // Get required amount of auctions for return
        $auctions = [ ];
        $maxIndex = min([count($allAuctions), $position + $count]);
        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($auctions, $allAuctions[$i]);
        }

        return $auctions;
    }

    public static function getAuctionCountByBerry($berry)
    {
        return count(self::getAllAuctionsByBerry($berry));
    }

    private static function getAllAuctionsByBerry($berry)
    {
        $auctions = [ ];
        foreach(Auction::getCurrentAuctions() as $auction)
        {
            // Get variety present in auction
            $variety = Variety::where('id', $auction->variety)->get()->first();
            if($variety->fruit == $berry) // If the berry matches, add the auction list
            {
                array_push($auctions, $auction);
            }
        }
        return $auctions;
    }

    public static function getAuctionsByVariety($variety, $position, $count)
    {
        // Get all current auctions
        $allAuctions = self::getAllAuctionsByVariety($variety);
        $auctions = [ ];
        
        $maxIndex = min([count($allAuctions), $position + $count]);

        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($auctions, $allAuctions[$i]);
        }

        return $auctions;
    }

    public static function getAuctionCountByVariety($variety)
    {
        return count(self::getAllAuctionsByVariety($variety));
    }

    private static function getAllAuctionsByVariety($variety)
    {
        $auctions = [ ];
        foreach(Auction::getCurrentAuctions() as $auction)
        {
            // Get variety present in auction. If it matches, add auction to list
            if($auction->variety == $variety)
            {
                array_push($auctions, $auction);
            }
        }
        return $auctions;
    }

    public static function getAuctionsByGrower($grower, $position, $count)
    {
        // Get all current auctions
        $allAuctions = self::getAllAuctionsByGrower($grower);
        $auctions = [ ];
        
        $maxIndex = min([count($allAuctions), $position + $count]);

        for($i = $position; $i < $maxIndex; $i++)
        {
            array_push($auctions, $allAuctions[$i]);
        }

        return $auctions;
    }

    public static function getAuctionCountByGrower($grower)
    {
        return count(self::getAllAuctionsByGrower($grower));
    }

    private static function getAllAuctionsByGrower($grower)
    {
        $auctions = [ ];
        foreach(Auction::getCurrentAuctions() as $auction)
        {
            // Get variety present in auction. If it matches, add auction to list
            if($auction->grower == $grower)
            {
                array_push($auctions, $auction);
            }
        }
        return $auctions;
    }

    public static function getAllAuctionsByCustomer($customer)
    {
        $auctionIDs = Bid::where('customer', $customer)->select('auction')->distinct()->get();
        $auctions = self::whereIn('id', $auctionIDs)->get();
        return $auctions;
    }

    public function getColorTags()
    {
        $rawTag = $this->color_tags;
        $tags = [ ];

        // Separate by comma
        $arr = explode(',', $rawTag);
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

        return $tags;
    }

    public function getTasteTags()
    {
        $rawTag = $this->taste_tags;
        $tags = [ ];

        // Separate by comma
        $arr = explode(',', $rawTag);
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

        return $tags;
    }

    public function getUsesTags()
    {
        $rawTag = $this->uses_tags;
        $tags = [ ];

        // Separate by comma
        $arr = explode(',', $rawTag);
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
        return $tags;
    }
}
