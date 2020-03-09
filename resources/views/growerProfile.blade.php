@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-3">
                            <div class="ibga-image-holder">
                                <?php
                                    // Get the users logo image
                                    $url = $GLOBALS['currentGrower']->Avatar();
                                    echo "<img src=\"{$url}\" class=\"rounded img-fluid\" alt=\"Display Image\">";
                                ?>
                            </div>
                        </div>
                        <div class="col-9">
                            <h1>{{ $GLOBALS['currentGrower']->name }}</h1>
                            <hr>
                            <div>
                                <h2> About {{ $GLOBALS['currentGrower']->name }} </h2>
                                <?php
                                    echo nl2br( App\Grower::where('id', $GLOBALS['currentGrower']->grower)->get()->first()->description );
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="auction-container" class="ibga-display-container">
                        <?php
                        $name = $GLOBALS['currentGrower']->name;
                        if(App\Auction::getAuctionCountByGrower($GLOBALS['currentGrower']->grower) > 0)
                        {
                            
                            echo "<h2>Browse $name's Auctions</h2>";
                            echo "<div id='auction-box-display' class='clearfix'> </div>";
                            echo "<button id='load-auctions' type='button' class='ibga-load-button btn btn-primary btn-block' onclick='loadAuctions()'>Load More</button>";
                        }    
                        else
                        {
                            echo "<h2> $name does not currently have any auctions.</h2>";
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
        $.get("/get-auction-count-by-grower?grower={{ $GLOBALS['currentGrower']->grower }}", { }, function(data){
            var totalAuctions = data;
            // If enough berries have been loaded, hide the button
            document.getElementById('load-auctions').style.display = ((auctionsLoaded >= totalAuctions) ? 'none' : 'block');
        }, "json");
    }
    function loadAuctions(){
        // Load more auctions to the view
        $.get("/get-auctions-by-grower", { grower:loadedGrower, position:auctionsLoaded, count:4 }, function(data){
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
    var loadedGrower = {{ $GLOBALS['currentGrower']->grower }};
    var auctionsLoaded = 0;
    loadAuctions();
</script>

@endsection
