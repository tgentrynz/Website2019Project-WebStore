<?php

namespace App\Http\Controllers;

use App\User;
use App\Grower;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use Image;

class AccountController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check())
        {
            return view('account');
        }
        else
        {
            return redirect('/');
        }
    }

    public function showGrowerProfile($user)
    {
        $user = User::where('id', $user)->get()->first();
        $grower = Grower::where('id', $user->grower)->get()->first();
        if(!is_null($user) && !is_null($grower))
        {
            $GLOBALS['currentGrower'] = $user;
            return view('growerProfile');
        }
        // Return to home page if there's an error
        return redirect('/');
    }

    public function updateName(Request $request)
    {
        $data = $request->all();
        if(Auth::check())
        {
            // Get the user model
            $user = auth()->user();
            // Change the name and update the database
            $user->name = $data['name'];
            $user->update();

            return redirect(route('account'));
        }
        // Users with incorrect authentication return to home page.
        return redirect('/');
    }

    public function updateDescription(Request $request)
    {
        $data = $request->all();
        if(Auth::check())
        {
            // Get the user model
            $grower = auth()->user()->getGrower();
            if(!is_null($grower))
            {
                // Change the description and update the database
                $grower->description = strip_tags( strval($data['desc']) );
                $grower->update();

                return redirect(route('account'));
            }
        }
        // Users with incorrect authentication return to home page.
        return redirect('/');
    }

    public function updateAvatar(Request $request)
    {
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if(Auth::check())
        {
            $user = auth()->user();
            // Remove user's old image
            Image::RemoveImage($user->image);

            // Resize new image
            $img = new Image($request->file('avatar'));
            $img->Resize(400, 400);
            // Store the image to the disk
            $user->image = $img->Store();
            // Update the model
            $user->save();

            return redirect(route('account'));
        }
        // Users with incorrect authentication return to home page.
        return redirect('/');
    }

    public function getGrowers(Request $request)
    {
        return Grower::getGrowers($request->position, $request->count);
    }

    public function getGrowerCount()
    {
        return Grower::getGrowerCount();
    }

    public function getImage(Request $request)
    {
        $user = User::where('id', $request->user)->get()->first();
        return [
            'id' => $request->user,
            'image' => is_null($user) ? User::DEFAULT_LOGO : $user->Avatar()
        ];
    }
}
