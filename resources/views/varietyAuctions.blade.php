@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php
                        $fruitName = App\Fruit::where('id', $GLOBALS['currentVariety']->fruit)->get()->first()->name;
                        $fruitLink = route('berryAuctions', $fruitName);
                        
                        echo "<a href='/'>Home</a>><a href='{$fruitLink}'>{$fruitName}</a>>{$GLOBALS['currentVariety']->name}";
                    ?>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md">
                            <h2>Colours for this variety</h2>
                            <ul>
                            <?php
                                foreach($GLOBALS['currentVariety']->getColorTags() as $tag)
                                {
                                    echo "<li>\n";
                                    echo $tag;
                                    echo "</li>\n";
                                }
                            ?>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md">
                            <h2>Tastes for this variety</h2>
                            <ul>
                            <?php
                                foreach($GLOBALS['currentVariety']->getTasteTags() as $tag)
                                {
                                    echo "<li>\n";
                                    echo $tag;
                                    echo "</li>\n";
                                }
                            ?>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md">
                            <h2>Uses for this variety</h2>
                            <ul>
                            <?php
                                foreach($GLOBALS['currentVariety']->getUsesTags() as $tag)
                                {
                                    echo "<li>\n";
                                    echo $tag;
                                    echo "</li>\n";
                                }
                            ?>
                            </ul>
                        </div>  
                    </div>
                    <hr />
                    <div id="auction-container" class="ibga-display-container">
                        <?php

                        if(App\Auction::getAuctionCountByVariety($GLOBALS['currentVariety']->id) > 0)
                        {
                            echo "<h2>Browse Auctions</h2>";
                            echo "<div id='auction-box-display' class='clearfix'> </div>";
                            echo "<button id='load-auctions' type='button' class='ibga-load-button btn btn-primary btn-block' onclick='loadAuctions()'>Load More</button>";
                        }    
                        else
                        {
                            echo "<h2> Our apologies. Currently, auctions can not be displayed. </h2>";
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
    function checkForMoreAuctions(){
        // Check that there are still auctions unloaded
        $.get("/get-auction-count-by-variety?variety=${loadedVariety}", { }, function(data){            
            var totalAuctions = data;
            // If enough berries have been loaded, hide the button
            document.getElementById('load-auctions').style.display = ((auctionsLoaded >= totalAuctions) ? 'none' : 'block');
        }, "json");
        
    }
    function loadAuctions(){
        // Load more auctions to the view
        $.get("/get-auctions-by-variety", { variety:loadedVariety, position:auctionsLoaded, count:4 }, function(data){
            var box = document.getElementById('auction-box-display');
            for(var i = 0; i < data.length; i++){
                var link = document.createElement("a");
                link.setAttribute("class", 'ibga-display-box rounded');
                link.setAttribute("href", "{{ route('showAuction', '') }}" + "/" + data[i].id);
                
                var content = document.createElement("div");
                content.setAttribute("class", 'ibga-display-box-content');

                var image = document.createElement("img");
                image.id = "image-auction-" + data[i].id;
                image.setAttribute("class", "ibga-display-image w-100 h-100");
                $.get("/get-auction-image", {auction:data[i].id}, function(data){
                    var image = document.getElementById('image-auction-'+data.id);
                    image.setAttribute("src", data.image);
                });
                
                content.appendChild(image);

                var details = document.createElement("div");
                details.setAttribute("class", "ibga-display-box-details");
                details.innerHTML += data[i].title + "<br />";
                details.innerHTML += data[i].amount + "kilograms <br />";
                details.innerHTML += "$" + data[i].starting_price + "<br />";
                

                link.appendChild(content);
                link.appendChild(details);

                box.appendChild(link);
            }
            // Update number of berries loaded
            auctionsLoaded += data.length;
            // Hide load button if needed
            checkForMoreAuctions();
        }, "json");
        
    }
    var loadedVariety = {{ $GLOBALS['currentVariety']->id }};
    var auctionsLoaded = 0;
    loadAuctions();
</script>

@endsection
