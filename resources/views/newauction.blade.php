@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('newauction') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="berry">{{ __('What type of berry are you auctioning?') }}</label>

                                    <select id="berry" class="form-control" name="berry" size="5" onchange="updateVarietyInformation();runPriceCalculation()" required>

                                    <?php
                                        // Populate list with all berry types in the database
                                        $berries = App\Fruit::all()->sortBy('name');
                                        $first = true;
                                        foreach($berries as $berry){
                                            // Determing if option should be selected by default
                                            $selected = $first ? 'selected' : '';
                                            $first = false;

                                            // Add option to page
                                            echo "<option value=\"{$berry->id}\" {$selected}> {$berry->name} </option>";
                                        }
                                    ?>

                                    </select>

                                    Is your berry not here?
                                    <a href="{{ route('newBerry') }}">
                                        {{ __('Register a new berry type.') }}
                                    </a>
                                </div>

                                <div class="form-group">
                                    <label for="variety">{{ __('What specific variety are you auctioning?') }}</label>

                                    <select id="variety" class="form-control" name="variety" size="5" onchange="runPriceCalculation()" required>
                                        <!-- Options loaded by javascript -->
                                    </select>

                                    Is your variety not here?
                                    <a id="variety-link" href="">
                                        {{ __('Register a new variety.') }}
                                    </a>
                                </div>

                                <div class="form-group">
                                    <label for="name">{{ __('Please enter a title for your acution.') }}</label>
                                    
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">{{ __('Please upload an image of your product.') }}</label>

                                    <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required autocomplete="image" autofocus>

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="amount">{{ __('How many kilograms of your product are you putting up for auction?') }}</label>

                                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') == null ? '0.00' : old('amount') }}" required autocomplete="amount" autofocus>

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="color_tags">{{ __('Please add some tags to describe the colour of your product. You can separate tags using a comma.') }}</label>

                                    <input id="color_tags" type="text" class="form-control @error('amount') is-invalid @enderror" name="color_tags" value="{{ old('color_tags') }}" required autocomplete="color_tags" autofocus>

                                    @error('color_tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="taste_tags">{{ __('Please add some tags to describe the taste of your product. You can separate tags using a comma.') }}</label>

                                    <input id="taste_tags" type="text" class="form-control @error('amount') is-invalid @enderror" name="taste_tags" value="{{ old('taste_tags') }}" required autocomplete="taste_tags" autofocus>

                                    @error('taste_tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="uses_tags">{{ __('Please add some tags to describe the uses for your product. You can separate tags using a comma.') }}</label>

                                    <input id="uses_tags" type="text" class="form-control @error('amount') is-invalid @enderror" name="uses_tags" value="{{ old('uses_tags') }}" required autocomplete="uses_tags" autofocus>

                                    @error('uses_tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="desc">{{ __('Please provide a detailed description of your product.') }}</label>

                                    <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" rows="10" value="{{ old('desc') }}" required autocomplete="desc" autofocus></textarea>

                                    @error('desc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="desc">{{ __('Please provide some information about the quality of your product.') }}</label>
                                <div class="form-group">
                                    <label for="fresh">{{ __('Is your product fresh or frozen?') }}</label>
                                    <br />
                                    <input type="radio" name="fresh" value="true" onchange="runPriceCalculation()">Fresh<br>
                                    <input type="radio" name="fresh" value="false" onchange="runPriceCalculation()">Frozen<br>
                                
                                    @error('fresh')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="defects">{{ __('Are there any defects present on the fruit? (Bruises, blemishes, etc.)') }}</label>
                                    <br />
                                    <input type="radio" name="defects" value="false" onchange="runPriceCalculation()">No<br>
                                    <input type="radio" name="defects" value="true" onchange="runPriceCalculation()">Yes<br>
                                
                                    @error('defects')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="age">{{ __('How long ago (in months) was the product harvested?') }}</label>

                                    <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') == null ? '0' : old('age') }}" onchange="runPriceCalculation()" required autocomplete="age" autofocus>
                                
                                    @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class='row'>
                                    <div id="price-suggest-container" class='col'>
                                        <p> Based on our calculations, the market price for your product is: </p>
                                        <p id='price-suggest'>Not in our system</p>
                                    </div>
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for="starting_price">{{ __('What price would you like the bidding to start bidding?') }}</label>

                                            <input id="starting_price" type="text" class="form-control @error('starting_price') is-invalid @enderror" name="starting_price" value="{{ old('starting_price') == null ? '0.00' : old('starting_price') }}" required autocomplete="starting_price" autofocus>
                                        
                                            @error('starting_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Product') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

function updateVarietyInformation(){
    var berryElement = document.getElementById("berry")
    var berry = berryElement.options[berryElement.selectedIndex].value;

    populateVarietyList(document.getElementById("variety"), berry);
    
    var link = document.getElementById("variety-link");
    link.setAttribute("href", "{{ route('newBerry') }}?fruit=" + berry);
}

function populateVarietyList(element, fruit){
    // Clear existing options
    for(var i = element.options.length; i > -1; i--){
        var option = element.options[i];
        element.remove(option);
    }
    // Load new options based on users's selection
    $.get("/get-varieties", {fruit:fruit}, function(data){
        for(var i = 0; i < data.length; i++){
            var option = document.createElement("option");
            option.setAttribute("value", data[i].id);
            option.innerHTML = data[i].name;
            element.add(option);
        }
        }, "json");
}

function runPriceCalculation(){
    // Check all values have been provided
    var variety = document.getElementById("variety").value; 
    var fresh = null;
    var radios = document.getElementsByName('fresh');
    for (var i = 0; i < radios.length; i++)
    {
        if (radios[i].checked)
        {
            fresh = radios[i].value == "true";
            break;
        }
    }
    var defects = null;
    radios = document.getElementsByName('defects');
    for (var i = 0; i < radios.length; i++)
    {
        if (radios[i].checked)
        {
            defects = radios[i].value == "true";
            break;
        }
    }
    var age = parseFloat(document.getElementById("age").value);
    if(variety !== null && fresh != null && defects != null){
        $.get('/get-price-calculation', {variety:variety, fresh:fresh, defects:defects, age:age}, function(data){
            if(data.value == null){
                updatePriceSuggestion("Not in our system");
            }
            else{
                updatePriceSuggestion("$" + data.value + "NZD per kilogram");
            }
        }, "json");
    }
    else{
        updatePriceSuggestion("Unable to be calculated. Please complete all fields of the form.");
    }
}
function updatePriceSuggestion($price){
    document.getElementById("price-suggest").innerHTML = $price; 
}
updateVarietyInformation();
runPriceCalculation();
</script>
@endsection