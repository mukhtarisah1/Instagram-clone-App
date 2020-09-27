<?php

namespace App;
use Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'username', 'password',
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

    protected static function boot(){
        parent::boot();

        static::created(function($user){
            $user->profile()->create([
                'title'=>$user->username,
            ]);

            //App\Mail::to($user->email)->send(new NewUserWelcomeMail());
        }

    );
    }

    public function posts(){
        return $this->hasMany('App\Post')->orderBy('created_at', 'DESC');
    }

    public function following(){
        return $this->belongsToMany('App\Profile');
    }

    public function profile(){
        return $this->hasOne('App\Profile');
    }
}