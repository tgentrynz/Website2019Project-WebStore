@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-header">Register a new Berry type</div>

                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('newBerry') }}">
                                @csrf           

                                <h2>Berry Information</h2>
                                
                                <div class="form-group">
                                    <label for="berry_name">{{ __('Name') }}</label>

                                    <?php // Check if fruit was set by the request
                                        $fruitID = app('request')->input('fruit', -1);
                                        $fruitSet = $fruitID != -1;
                                    ?>

                                    <input id="berry_name" type="text" class="form-control @error('name') is-invalid @enderror" name="berry_name" value="{{ $fruitSet ? $berries = App\Fruit::where('id', $fruitID)->first()->name : old('berry_name') }}" required autocomplete="name" autofocus {{ $fruitSet ? "readonly" : ""}}> 
                                    
                                    @error('berry_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                <h2>Variety Information</h2>

                                <div class="form-group">
                                    <label for="variety_name">{{ __('Name') }}</label>
                                    <input id="variety_name" type="text" class="form-control @error('name') is-invalid @enderror" name="variety_name" value="{{ old('variety_name') }}" required autocomplete="name" autofocus>

                                    @error('variety_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Upload New Berry Type') }}
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