<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        
        $imagepath= ($this->image)? $this->image: 'profile/noimage.png';
        return  '/storage/'.$imagepath; 
        
    } 

    public function followers(){
        return $this->belongsToMany('App\User');
    } 

    public function user(){
        return $this->belongsTo(User::class);
    } 
}
