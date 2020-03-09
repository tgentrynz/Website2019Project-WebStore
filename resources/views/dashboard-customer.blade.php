@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-body">
                    <a href="/"><button type="button" class="btn btn-primary">Start searching for auctions!</button></a>
                    <hr />
                    <?php
                        // Get auctions user has been a part of
                        $auctions = App\Auction::getAllAuctionsByCustomer(auth()->user()->customer);
                        $defaultNumberOfAuctionsToDisplay = 4;
                    ?>
                    <div id="live-container" class="ibga-display-container">
                        <?php
                            $liveAuctions = [ ];
                            foreach($auctions as $auction)
                            {
                                if(!$auction->hasEnded())
                                {
                                    array_push($liveAuctions, $auction);
                                }
                            }
                            if(count($liveAuctions) > 0)
                            {
                                $loadedLiveAuctions = 0;
                                echo "<h2>Auctions I've Bid On</h2> \n";
                                echo "<div id='live-auction-box-display' class='clearfix'> \n";
                                    foreach($liveAuctions as $auction)
                                    {
                                        $warn = $auction->getWinner() == auth()->user()->customer ? "" : "ibga-display-bid-warning";
                                        $auctionURL = route('showAuction', $auction->id);
                                        $imageURL = App\Image::getImage($auction->image);
                                        
                                        echo "  <a href='{$auctionURL}' class='ibga-display-box {$warn}' id='live-display-box-{$loadedLiveAuctions}' style='display : none'> \n";
                                        echo "      <div class='ibga-display-box-content'> \n";
                                        echo "          <img class='ibga-display-image' src={$imageURL} /> \n";
                                        echo "      </div> \n";
                                        echo "      <div class='ibga-display-box-details'>  \n";
                                        echo "          {$auction->title}<br />  \n";
                                        echo "      </div> \n";
                                        echo "  </a> \n";
                                        
                                        $loadedLiveAuctions += 1;
                                    }
                                echo "</div> \n";
                                echo "<div class='row'> \n";
                                echo "    <div id='live-auction-load-holder' class='col'> \n";
                                $function = "onclick='" . 'showRow("live")' . "'";
                                echo "        <button id='load-live-auctions' type='button' class='btn btn-primary btn-block' {$function}>Show More</button> \n";
                                echo "    </div> \n";
                                echo "    <div id='live-auction-hide-holder' class='col'> \n";
                                $function = "onclick='" . 'hideAuctions("live")' . "'";
                                echo "        <button id='load-live-auctions' type='button' class='btn btn-primary btn-block' {$function}>Hide</button> \n";
                                echo "    </div> \n";
                                echo "</div> \n";
                            }
                        ?>
                    </div>
                    <div id="won-container" class="ibga-display-container">
                        <?php
                            $wonAuctions = [ ];
                            foreach($auctions as $auction)
                            {
                                if($auction->hasEnded() && $auction->getWinner() == auth()->user()->customer)
                                {
                                    array_push($wonAuctions, $auction);
                                }
                            }
                            if(count($wonAuctions) > 0)
                            {
                                $loadedWonAuctions = 0;
                                echo "<h2>Auctions I've Won</h2>\n";
                                echo "<div id='won-auction-box-display' class='clearfix'>\n";
                                foreach($wonAuctions as $auction)
                                {
                                    $auctionURL = route('showAuction', $auction->id);
                                    $imageURL = App\Image::getImage($auction->image);
                                    
                                    echo "  <a href='{$auctionURL}' class='ibga-display-box' id='won-display-box-{$loadedWonAuctions}' style='display : none'> \n";
                                    echo "      <div class='ibga-display-box-content'> \n";
                                    echo "          <img class='ibga-display-image' src={$imageURL} /> \n";
                                    echo "      </div> \n";
                                    echo "      <div class='ibga-display-box-details'>  \n";
                                    echo "          {$auction->title}<br />  \n";
                                    echo "      </div> \n";
                                    echo "  </a> \n";
                                    
                                    $loadedWonAuctions += 1;
                                }
                                echo "</div> \n";
                                echo "<div class='row'> \n";
                                echo "    <div id='won-auction-load-holder' class='col'> \n";
                                $function = "onclick='" . 'showRow("won")' . "'";
                                echo "        <button id='load-won-auctions' type='button' class='btn btn-primary btn-block' {$function}>Show More</button> \n";
                                echo "    </div> \n";
                                echo "    <div id='won-auction-hide-holder' class='col'> \n";
                                $function = "onclick='" . 'hideAuctions("won")' . "'";
                                echo "        <button id='load-won-auctions' type='button' class='btn btn-primary btn-block' {$function}>Hide</button> \n";
                                echo "    </div> \n";
                                echo "</div> \n";
                            }
                        ?>
                    </div>
                    <div id="lost-container" class="ibga-display-container">
                        <?php
                            $lostAuctions = [ ];
                            foreach($auctions as $auction)
                            {
                                if($auction->hasEnded() && $auction->getWinner() != auth()->user()->customer)
                                {
                                    array_push($lostAuctions, $auction);
                                }
                            }
                            if(count($lostAuctions) > 0)
                            {
                                $loadedLostAuctions = 0;
                                echo "<h2>Auctions I've Lost</h2>\n";
                                echo "<div id='lost-auction-box-display' class='clearfix'>\n";
                                foreach($lostAuctions as $auction)
                                {
                                    $auctionURL = route('showAuction', $auction->id);
                                    $imageURL = App\Image::getImage($auction->image);
                                    
                                    echo "  <a href='{$auctionURL}' class='ibga-display-box' id='lost-display-box-{$loadedLostAuctions}' style='display : none'> \n";
                                    echo "      <div class='ibga-display-box-content'> \n";
                                    echo "          <img class='ibga-display-image' src={$imageURL} /> \n";
                                    echo "      </div> \n";
                                    echo "      <div class='ibga-display-box-details'>  \n";
                                    echo "          {$auction->title}<br />  \n";
                                    echo "      </div> \n";
                                    echo "  </a> \n";
                                    
                                    $loadedLostAuctions += 1;
                                }
                                echo "</div> \n";
                                echo "<div class='row'> \n";
                                echo "    <div id='lost-auction-load-holder' class='col'> \n";
                                $function = "onclick='" . 'showRow("lost")' . "'";
                                echo "        <button id='load-lost-auctions' type='button' class='btn btn-primary btn-block' {$function}>Show More</button> \n";
                                echo "    </div> \n";
                                echo "    <div id='lost-auction-hide-holder' class='col'> \n";
                                $function = "onclick='" . 'hideAuctions("lost")' . "'";
                                echo "        <button id='load-lost-auctions' type='button' class='btn btn-primary btn-block' {$function}>Hide</button> \n";
                                echo "    </div> \n";
                                echo "</div> \n";
                            }
                        ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

// Unhides another row of auctions
function showRow(auctionType){
    for(var i = 0; i < <?= $defaultNumberOfAuctionsToDisplay ?>; i++){
        var id = loadedAuctions[auctionType];
        loadedAuctions[auctionType] = id + 1;
        var idString = auctionType + "-display-box-" + id;
        var element = document.getElementById(idString);
        if(element == null){ // Getting no element must mean there are no more to show
            document.getElementById(auctionType + "-auction-load-holder").style.display = "none";
            break;
        }
        else{
            element.style.display = "block";
        }
    }
    document.getElementById(auctionType + "-auction-hide-holder").style.display = loadedAuctions[auctionType] > <?= $defaultNumberOfAuctionsToDisplay ?> ? "block" : "none";
    document.getElementById(auctionType + "-auction-load-holder").style.display = document.getElementById(auctionType + "-display-box-" + loadedAuctions[auctionType]) == null ? "none" : "block";
}
// Hides auctions except for the first row
function hideAuctions(auctionType){
    var currentIndex = <?= $defaultNumberOfAuctionsToDisplay ?>;
    var element = document.getElementById(auctionType + "-display-box-" + currentIndex);
    while(element != null){
        element.style.display = "none";
        ++currentIndex;
        element = document.getElementById(auctionType + "-display-box-" + currentIndex);
    }
    loadedAuctions[auctionType] = <?= $defaultNumberOfAuctionsToDisplay ?>;
    document.getElementById(auctionType + "-auction-hide-holder").style.display = "none";
    document.getElementById(auctionType + "-auction-load-holder").style.display = document.getElementById(auctionType + "-display-box-" + loadedAuctions[auctionType]) == null ? "none" : "block";
}
var loadedAuctions = [];
<?php

if(count($liveAuctions) > 0)
{
    echo "loadedAuctions['live'] = 0;";
    echo "showRow('live');";
}
if(count($wonAuctions) > 0)
{
    echo "loadedAuctions['won'] = 0;";
    echo "showRow('won');";
}
if(count($lostAuctions) > 0)
{
    echo "loadedAuctions['lost'] = 0;";
    echo "showRow('lost');";
}
?>
</script>
@endsection