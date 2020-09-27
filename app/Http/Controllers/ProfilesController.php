<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
     public function __construct(){
        $this->middleware('auth');
    }
    public function index(User $user)
    {
        $follows = (auth()->user())? auth()->user()->following->contains($user->id) : false;
    
        $postscount=Cache::remember('
        count.posts'.$user->id,
         now()->addSeconds(30), 
         function() use($user){
           return $user->posts->count(); 
        });

        $followerscount=Cache::remember('
        count.followers'.$user->id,
         now()->addSeconds(30), 
         function() use($user){
           return  $user->profile->followers->count(); 
        });    
        $followingcount=Cache::remember('
        count.following'.$user->id,
         now()->addSeconds(30), 
         function() use($user){
            return $user->following->count(); 
        });            
        return view('profiles.index', compact('user', 'follows', 'postscount', 'followerscount', 'followingcount'));
    }

    public function edit(User $user){
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user){
        $this->authorize('update', $user->profile);

        $data= request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>'',
        ]);
        if(request('image')){
            $imagepath = request('image')->store('profile','public');
            $image= Image::make(public_path("storage/{$imagepath}"))->fit(1200,1200);
            $image->save();

            $imagearray= ['image'=>$imagepath];
        }

        //$user->profile->update($data);
       
        auth()->user()->profile->update(array_merge(
        $data,
        $imagearray  ?? []  
        ));

        return redirect("/profile/{$user->id}");
    }

}
