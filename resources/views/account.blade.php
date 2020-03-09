@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Manage Account: {{ Auth::user()->name }}</h1>
                    <div class="w-100 row">
                        <div class="col-3">
                            <div class="ibga-image-holder">
                                <?php
                                    // Get the users logo image
                                    $url = auth()->user()->Avatar();
                                    echo "<img src=\"{$url}\" class=\"rounded img-fluid\" alt=\"Display Image\">";
                                ?>
                            </div>
                        </div>
                        <div class="col-9">
                            <form method="POST" action="{{ route('updateName') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="name">{{ __('Change your display name') }}</label>

                                    <div>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Change It') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <form method="POST" enctype="multipart/form-data" action="{{ route('updateAvatar') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="avatar">{{ __('Change your display picture') }}</label>

                                    <div>
                                        <input id="avatar" type="file" class="form-control-file @error('avatar') is-invalid @enderror" name="avatar" size="40" required>

                                        @error('avatar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-groug">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Upload Display Image') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            @grower
                            <form id="description-form" method="POST" action="{{ route('updateDescription') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="desc">{{ __('Update your description.') }}</label>

                                    <div>
                                        <textarea form="description-form" id="desc" class="form-control @error('name') is-invalid @enderror" name="desc" rows="4" required autofocus>
{{ auth()->user()->getGrower()->description }}
                                        </textarea>
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Description') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form>

                            </form>

                            @endgrower

                        </div>
                        
                    </div>
                
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection