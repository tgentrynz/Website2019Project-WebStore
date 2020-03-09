@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php
                        $variety = App\Variety::where('id', $GLOBALS['currentAuction']->variety)->get()->first();
                        $fruit = App\Fruit::where('id', $variety->fruit)->get()->first();
                        
                        $fruitLink = route('berryAuctions', $fruit->name);
                        $varietyLink = route('varietyAuctions', $variety->name);
                        echo "<a href='/'>Home</a>><a href='{$fruitLink}'>{$fruit->name}</a>><a href='{$varietyLink}'>{$variety->name}</a>>{$GLOBALS['currentAuction']->title}";
                    ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <?php
                                // Get auction image
                                $url = App\Image::getImage($GLOBALS['currentAuction']->image);
                            ?>
                            <a href="{{ $url }}">
                                <div class="ibga-image-holder">                                
                                    <img src="{{ $url }}" class="rounded img-fluid" alt="Display Image">;
                                </div>
                            </a>
                        </div>
                        <div class="col-9">
                            <h1>{{ $GLOBALS['currentAuction']->title }}</h1>
                            <?php
                                if(!Auth::check() || auth()->user()->isCustomer() || (auth()->user()->isGrower() && $GLOBALS['currentAuction']->grower != auth()->user()->grower))
                                {
                                    echo "By " . App\User::where('grower', $GLOBALS['currentAuction']->grower)->get()->first()->name;
                                }
                                elseif(Auth::check() && auth()->user()->isGrower() && $GLOBALS['currentAuction']->grower == auth()->user()->grower)
                                {
                                    echo "This is your auction";
                                }
                            ?>
                            <br />
                            <?php
                                if(!$GLOBALS['currentAuction']->hasEnded())
                                {
                                    $start = new DateTime($GLOBALS['currentAuction']->starting_time);
                                    echo "Started: " . $start->format('h:iA d-m-Y');
                                }
                            ?>
                            <br />
                            <?php
                                $end = new DateTime($GLOBALS['currentAuction']->getEndTime());
                                $pefix = $GLOBALS['currentAuction']->hasEnded() ? "This auction ended at" : "Ends";
                                echo "{$pefix}: " . $end->format('h:iA d-m-Y');
                            ?>
                            <hr />
                            <div class="row">
                                <?php
                                if(Auth::check() && auth()->user()->isCustomer()) // If Customer
                                {
                                    if($GLOBALS['currentAuction']->hasEnded()) // If acution has ended
                                    {
                                        echo "<div class='col'>\n";
                                        if($GLOBALS['currentAuction']->getWinner() == auth()->user()->customer) // If user won
                                        {
                                            echo "You won this auction. <br />\n";
                                            echo "The auction ID is " . $GLOBALS['currentAuction']->id . " and your final bid was $" . $GLOBALS['currentAuction']->getHighestBid()->value . "NZD<br/>\n";
                                            echo "You can contact the seller using this email: " . App\User::where('id', $GLOBALS['currentAuction']->grower)->get()->first()->email . "<br />\n";
                                        }
                                        else // If user lost
                                        {
                                            echo "This auction has ended.<br />\n";
                                            $finalBid = $GLOBALS['currentAuction']->getHighestBid();
                                            if(!is_null(finalBid))
                                            {
                                                echo "The final bid was $" . $finalBid->value . "NZD<br/>\n";
                                            }
                                            else
                                            {
                                                echo "This auction had no bids\n";
                                            }
                                        }
                                        echo "</div>\n";
                                    }
                                    else // If auction is running
                                    {
                                        // Show estimated price
                                        $price = App\MarketPrice::where([['variety', $GLOBALS['currentAuction']->variety],['grade', $GLOBALS['currentAuction']->grade]])->select('value')->get()->first();
                                        if($price != null)
                                        {
                                            $price = $price->value * $GLOBALS['currentAuction']->amount;
                                            echo "<div class='col-12'>\n";
                                            echo "Before you bid!\n";
                                            echo "Our estimated market price for this auction is \${$price}NZD.\n";
                                            echo "</div>\n";
                                        }
                                        // Show bid interface
                                        echo "<div class='col'>\n";
                                        $currentBid = $GLOBALS['currentAuction']->getHighestBid();
                                        $suggestedBid = 0;
                                        if(!is_null($currentBid)) // If there are already bids on the auction
                                        {
                                            $currentBidder = App\User::where('customer', $currentBid->customer)->get()->first();
                                            $userIsCurrentBidder = auth()->user() == $currentBidder;
                                            $currentBid = $currentBid->value;
                                            $suggestedBid = $currentBid+1;
                                            if($userIsCurrentBidder)
                                            {
                                                echo "<div class=\"alert alert-primary\" role=\"alert\">";
                                                echo "You currently have the highest bid! <br />";
                                                echo "</div>";

                                                
                                            }
                                            echo "Current Bid: {$currentBid}NZD";
                                            if(!$userIsCurrentBidder)
                                            {
                                                echo " by $currentBidder->name";
                                            }
                                        }
                                        else // If no one has bidded on the auction yet
                                        {
                                            $currentBid = $GLOBALS['currentAuction']->starting_price;
                                            $suggestedBid = $currentBid;
                                            echo "Starting Bid: \${$currentBid}NZD\n";
                                        }
                                       
                                        $route = route('placeBid', $GLOBALS['currentAuction']->id);
                                        echo "<form method='POST' action='{$route}'>\n";
                                        echo csrf_field() . "\n";
                                        echo "<div class='form-group'>\n";
                                        echo "<label for='bid'>Place a bid?</label>\n";
                                        $invalid = $errors->has('bid') ? "is-invalid" : "";
                                        $value = old('bid') == null ? $suggestedBid  : old('bid');
                                        echo "<input id='bid' type='text' class='form-control {$invalid}' name='bid' value='{$value}' required autocomplete='bid' autofocus>\n";
                                        if ($errors->has('bid'))
                                        {
                                            if (isset($message)) { $messageCache = $message; }
                                            $message = $errors->first('bid');
                                            echo "<span class='invalid-feedback' role='alert'>\n";
                                            echo "<strong>{$message}</strong>\n";
                                            echo "</span>\n";

                                            unset($message);
                                            if (isset($messageCache)) { $message = $messageCache; }
                                        }
                                        echo "</div>\n";
                                        echo "<div class='form-group'>\n";
                                        echo "<button type='submit' class='btn btn-primary'>\n";
                                        echo "Place Bid\n";
                                        echo "</button>\n";
                                        echo "</div>\n";
                                        echo "</form>\n";


                                        echo "</div>\n
                                        <div class='col'>";
                                        echo "Bid History<br />\n";
                                        $bids = $GLOBALS['currentAuction']->getBids();
                                        $number = min([$bids->count(), 3]);
                                        for($i = 0; $i < $number; $i++)
                                        {
                                            $bid = $bids[$i];
                                            $name = App\User::where('customer', $bid->customer)->get()->first()->name;
                                            echo "{$name}: \${$bid->value}NZD<br />\n";
                                        }
                                        echo "</div>\n";
                                    }
                                }
                                elseif(Auth::check() && auth()->user()->isGrower()) // If Grower
                                {
                                    // If acution has ended and it was the user's auction
                                    if($GLOBALS['currentAuction']->hasEnded() && $GLOBALS['currentAuction']->grower == auth()->user()->grower) 
                                    {
                                        echo "<div class='col'>\n";
                                        echo "This was your auction. <br />\n";
                                        $finalBid = $GLOBALS['currentAuction']->getHighestBid();
                                        if(!is_null($finalBid))
                                        {
                                            echo "The auction ID is " . $GLOBALS['currentAuction']->id . " and the final bid was $" . $finalBid->value . "NZD<br/>\n";
                                            $customer = App\Customer::where('id', $finalBid->customer)->get()->first();
                                            echo "You can contact the buyer using this email: " . App\User::where('customer', $customer->id)->get()->first()->email . "<br />\n";
                                        }
                                        else
                                        {
                                                echo "This auction had no bids\n";
                                        }
                                        echo "</div>\n";
                                    }
                                }
                                ?>
                            </div>
                            <hr />
                            <div>
                                <h2>Description</h2>
                                <div class="row">
                                    <div class="col-sm-12 col-md">
                                        <h3>Colours for this product</h3>
                                        <ul>
                                        <?php
                                            foreach($GLOBALS['currentAuction']->getColorTags() as $tag)
                                            {
                                                echo "<li>\n";
                                                echo $tag;
                                                echo "</li>\n";
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12 col-md">
                                        <h3>Tastes for this product</h3>
                                        <ul>
                                        <?php
                                            foreach($GLOBALS['currentAuction']->getTasteTags() as $tag)
                                            {
                                                echo "<li>\n";
                                                echo $tag;
                                                echo "</li>\n";
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12 col-md">
                                        <h3>Uses for this product</h3>
                                        <ul>
                                        <?php
                                            foreach($GLOBALS['currentAuction']->getUsesTags() as $tag)
                                            {
                                                echo "<li>\n";
                                                echo $tag;
                                                echo "</li>\n";
                                            }
                                        ?>
                                        </ul>
                                    </div>  
                                </div>
                                <?php
                                    echo nl2br( $GLOBALS['currentAuction']->description );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection