@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    <div id="berry-container" class="ibga-display-container">
                        <?php
                         
                        if(App\Fruit::getNumberOfBerriesWithAuctions() > 0)
                        {
                            echo "<h2>Browse Locally Grown Berries</h2>";
                            echo "<div id='berry-box-display' class='clearfix'> </div>";
                            echo "<button id='load-berries' type='button' class='ibga-load-button btn btn-primary btn-block' onclick='loadBerries()'>Load More</button>";
                        }
                        else
                        {
                            echo "<h2>Sorry, there are currently no berries on auction. Try again later. </h2>";
                        }

                        ?>
                    </div>
                    <div id="grower-container" class="ibga-display-container">
                        <?php

                        if(App\Grower::getGrowerCount() > 0)
                        {
                            echo "<h2>Browse Local Growers</h2>";
                            echo "<div id='grower-box-display' class='clearfix'> </div>";
                            echo "<button id='load-growers' type='button' class='ibga-load-button btn btn-primary btn-block' onclick='loadGrowers()'>Load More</button>";
                        }
                        else
                        {
                            echo "<h2>Sorry, there are currently no growers registered on the site. Try again later. </h2>";
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
    function checkForMoreBerries(){
        // Check that there are still berries unloaded
        $.get("/get-current-berries-count", { }, function(data){
            var totalBerries = data;
            // If enough berries have been loaded, hide the button
            document.getElementById('load-berries').style.display = ((berriesLoaded >= totalBerries) ? 'none' : 'block');
        }, "json");
    }
    function loadBerries(){
        // Load more berries to the view
        $.get("/get-current-berries", { position:berriesLoaded, count:4 }, function(data){
            var box = document.getElementById('berry-box-display');
            for(var i = 0; i < data.length; i++){
                var link = document.createElement("a");
                link.setAttribute("class", 'ibga-display-box rounded');
                link.setAttribute("href", "{{ route('berryAuctions', '') }}" + "/" + data[i].name.toLowerCase());
                
                var content = document.createElement("div");
                content.setAttribute("class", 'ibga-display-box-content');

                var image = document.createElement("img");
                image.id = "image-berry-" + data[i].id;
                image.setAttribute("class", "ibga-display-image");
                $.get("/get-berry-image", {berry:data[i].id}, function(data){
                    var image = document.getElementById('image-berry-'+data.id);
                    image.setAttribute("src", data.image);
                });
                
                var div = document.createElement("div");
                div.setAttribute("class", "ibga-display-text");
                div.innerHTML = data[i].name;

                content.appendChild(image);
                content.appendChild(div);
                link.appendChild(content);
                box.appendChild(link);
            }
            // Update number of berries loaded
            berriesLoaded += data.length;
            // Hide load button if needed
            checkForMoreBerries();
        }, "json");
    }
    function checkForMoreGrowers(){
        // Check that there are still growers unloaded
        $.get("/get-grower-count", { }, function(data){
            var totalGrowers = data;
            // If enough growers have been loaded, hide the button
            document.getElementById('load-growers').style.display = ((growersLoaded >= totalGrowers) ? 'none' : 'block');
        }, "json");
    }
    function loadGrowers(){
        // Load more growers to the view
        $.get("/get-growers", { position:growersLoaded, count:4 }, function(data){
            var box = document.getElementById('grower-box-display');
            for(var i = 0; i < data.length; i++){
                var link = document.createElement("a");
                link.setAttribute("class", 'ibga-display-box rounded');
                link.setAttribute("href", "{{ route('showProfile', '') }}" + "/" + data[i].id);

                var content = document.createElement("div");
                content.setAttribute("class", 'ibga-display-box-content');

                var image = document.createElement("img");
                image.id = "image-grower-" + data[i].id;
                image.setAttribute("class", "ibga-display-image w-100 h-100");
                $.get("/get-grower-image", {user:data[i].id}, function(data){
                    var image = document.getElementById('image-grower-'+data.id);
                    image.setAttribute("src", data.image);
                });
            
                var div = document.createElement("div");
                div.setAttribute("class", "ibga-display-text");
                div.innerHTML = data[i].name;

                
                content.appendChild(image);
                content.appendChild(div);
                link.appendChild(content);
                box.appendChild(link);
            }
            // Update number of growers loaded
            growersLoaded += data.length;
            // Hide load button if needed
            checkForMoreGrowers();
        }, "json");
    }
    var berriesLoaded = 0;
    var growersLoaded = 0;
    loadBerries();
    loadGrowers();
</script>

@endsection
