<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bid;
use App\Image;
use App\Fruit;
use App\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function showBerryAuctionPage($berry)
    {
        //Check fruit exists
        $fruit = Fruit::where('name', $berry)->get()->first();
        if(!is_null($fruit))
        {
            if($fruit->hasAuctions())
            {
                $GLOBALS['currentBerry'] = $fruit;
                return view('berryAuctions');
            }
        }

        // Catch any errors with a redirect to the home page
        return redirect('/');
    }

    public function showVarietyAuctionPage($variety)
    {
        //Check variety exists
        $variety = Variety::where('name', $variety)->get()->first();
        if(!is_null($variety))
        {
            if($variety->hasAuctions())
            {
                $GLOBALS['currentVariety'] = $variety;
                return view('varietyAuctions');
            }
        }

        // Catch any errors with a redirect to the home page
        return redirect('/');
    }

    public function showAuctionPage($auction)
    {
        //Check auction eixsts
        $auction = Auction::where('id', $auction)->get()->first();
        if(!is_null($auction))
        {
            $GLOBALS['currentAuction'] = $auction;
            return view('auction');
        }

        // Catch any errors with a redirect to the home page
        return redirect('/');
    }

    public function placeBid($auction, Request $request)
    {
        $auction = Auction::where('id', $auction)->get()->first();
        if(!is_null($auction) && Auth::check())
        {
            if(auth()->user()->isCustomer())
            {
                // Bid must be higher than current price
                $currentBid = $auction->getHighestBid();
                if(!is_null($currentBid))
                {
                    if($request->bid > $currentBid->value)
                    {
                        $newBid = new Bid();
                        $newBid->auction = $auction->id;
                        $newBid->value = $request->bid;
                        $newBid->customer = auth()->user()->customer;
                        $newBid->save();
                    }
                }
                else
                {
                    if($request->bid >= $auction->starting_price)
                    {
                        $newBid = new Bid();
                        $newBid->auction = $auction->id;
                        $newBid->value = $request->bid;
                        $newBid->customer = auth()->user()->customer;
                        $newBid->save();
                    }
                }
                return back();
            }
        }
        // If there is an error go back
        return back();
    }

    public function showMyAuctions()
    {
        if(Auth::check())
        {
            $user = auth()->user();
            $grower = !is_null($user->grower);
            $customer = !is_null($user->customer);
            if($grower)
            {
                return view('dashboard-grower');
            }
            else if($customer)
            {
                return view('dashboard-customer');
            }
        }
        // Return home if there is an error
        return redirect('/');
    }

    public function showNewAuctionForm()
    {
        $user = auth()->user();
        $grower = !is_null($user->grower);
        if($grower)
        {
            return view('newauction');
        }
        else
        {
            // If user is not a grower, send them to the home page.
            return redirect('/');
        }
    }

    public function createNewAuction(Request $request)
    {
        $request->validate([
            'variety' => 'required',
            'name' => 'required|max:255',
            'desc' => 'required',
            'color_tags' => 'required',
            'taste_tags' => 'required',
            'uses_tags' => 'required',
            'amount' => 'required|numeric|min:0.1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'fresh' => 'required',
            'defects' => 'required',
            'age' => 'required|numeric',
            'starting_price' => 'required|numeric|min:0.01',
        ]);

        $auction = new Auction();
        $auction->grower = auth()->user()->grower;
        $auction->variety = $request->variety;
        $auction->title = $request->name;
        
        $img = new Image($request->file('image'));
        $auction->image = $img->Store();

        $auction->color_tags = $request->color_tags;
        $auction->taste_tags = $request->taste_tags;
        $auction->uses_tags = $request->uses_tags;
        $auction->description = $request->desc;
        $auction->amount = $request->amount;
        $auction->starting_time = DB::raw('now()');
        $auction->length = 7;
        $auction->grade = BerryController::calculateGrade($request->fresh == "true", $request->defects == "true", floatval($request->age));
        $auction->starting_price = $request->starting_price;
        $auction->save();

        return redirect('/');
    }

    public function getAuctionsByBerry(Request $request)
    {
        return Auction::getAuctionsByBerry($request->berry, $request->position, $request->count);
    }

    public function getAuctionCountByBerry(Request $request)
    {
        return Auction::getAuctionCountByBerry($request->berry);
    }

    public function getAuctionsByVariety(Request $request)
    {
        return Auction::getAuctionsByVariety($request->variety, $request->position, $request->count);
    }

    public function getAuctionCountByVariety(Request $request)
    {
        return Auction::getAuctionCountByVariety($request->variety);
    }

    public function getAuctionsByGrower(Request $request)
    {
        return Auction::getAuctionsByGrower($request->grower, $request->position, $request->count);
    }

    public function getAuctionCountByGrower(Request $request)
    {
        return Auction::getAuctionCountByGrower($request->grower);
    }

    public function getAuctionImage(Request $request)
    {
        $auction = Auction::where('id', $request->auction)->get()->first();
        return [
            'id' => $request->auction,
            'image' => !is_null($auction) ? Image::GetImage($auction->image) : Image::DEFAULT_IMAGE
        ];
    }

    
}
