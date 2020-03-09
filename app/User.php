<?php

namespace App;

use App\Customer;
use App\Grower;
use App\Image;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'grower', 'customer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Avatar()
    {
        return Image::GetImage($this->image);

    }

    public function getGrower()
    {
        return Grower::where('id', $this->grower)->get()->first();
    }

    public function isGrower()
    {
        return !is_null($this->grower);
    }

    public function getCustomer()
    {
        return Customer::where('id', $this->customer)->get()->first();
    }

    public function isCustomer()
    {
        return !is_null($this->customer);
    }

    const DEFAULT_LOGO = "public/logos/default";
}
