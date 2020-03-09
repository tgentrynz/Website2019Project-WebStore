@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-header">My Products</div>

                <div class="card-body">
                    <a class="" href="{{ route('newauction') }}"><button type="button" class="btn btn-primary">{{ __('Start a new auction.') }}</button></a>
                    <hr />
                    <?php
                        // Get auctions user has been a part of
                        $auctions = App\Auction::where('grower', auth()->user()->grower)->get();
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
                                echo "<h2>Auctions That are Currently Running</h2> \n";
                                echo "<div id='live-auction-box-display' class='clearfix'> \n";
                                    foreach($liveAuctions as $auction)
                                    {
                                        $auctionURL = route('showAuction', $auction->id);
                                        $imageURL = App\Image::getImage($auction->image);
                                        
                                        echo "  <a href='{$auctionURL}' class='ibga-display-box' id='live-display-box-{$loadedLiveAuctions}' style='display : none'> \n";
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
                    <div id="closed-container" class="ibga-display-container">
                        <?php
                            $closedAuctions = [ ];
                            foreach($auctions as $auction)
                            {
                                if($auction->hasEnded())
                                {
                                    array_push($closedAuctions, $auction);
                                }
                            }
                            if(count($closedAuctions) > 0)
                            {
                                $loadedClosedAuctions = 0;
                                echo "<h2>Auctions That Have Finished</h2>\n";
                                echo "<div id='closed-auction-box-display' class='clearfix'>\n";
                                foreach($closedAuctions as $auction)
                                {
                                    $warn = $auction->hasNoBids() ? "ibga-display-bid-warning" : "";
                                    $auctionURL = route('showAuction', $auction->id);
                                    $imageURL = App\Image::getImage($auction->image);
                                    
                                    echo "  <a href='{$auctionURL}' class='ibga-display-box {$warn}' id='closed-display-box-{$loadedClosedAuctions}' style='display : none'> \n";
                                    echo "      <div class='ibga-display-box-content'> \n";
                                    echo "          <img class='ibga-display-image' src={$imageURL} /> \n";
                                    echo "      </div> \n";
                                    echo "      <div class='ibga-display-box-details'>  \n";
                                    echo "          {$auction->title}<br />  \n";
                                    echo "      </div> \n";
                                    echo "  </a> \n";
                                    
                                    $loadedClosedAuctions += 1;
                                }
                                echo "</div> \n";
                                echo "<div class='row'> \n";
                                echo "    <div id='closed-auction-load-holder' class='col'> \n";
                                $function = "onclick='" . 'showRow("closed")' . "'";
                                echo "        <button id='load-closed-auctions' type='button' class='btn btn-primary btn-block' {$function}>Show More</button> \n";
                                echo "    </div> \n";
                                echo "    <div id='closed-auction-hide-holder' class='col'> \n";
                                $function = "onclick='" . 'hideAuctions("closed")' . "'";
                                echo "        <button id='load-closed-auctions' type='button' class='btn btn-primary btn-block' {$function}>Hide</button> \n";
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
if(count($closedAuctions) > 0)
{
    echo "loadedAuctions['closed'] = 0;";
    echo "showRow('closed');";
}

?>
</script>
@endsection