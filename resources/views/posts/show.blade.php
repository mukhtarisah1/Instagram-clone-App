@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{$post->image}}" class="w-100" alt="{{$post->caption}}">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{($post->user->profile->profileImage()}}" class="rounded-circle w-100" style="max-width:50px"> 
                    </div>
                    <div class="pl-3">
                         <div class="font-weight-bold" >
                             <a href="/profile/{{$post->user->id}}">
                                <span class="text-dark"> {{$post->user->username}}
                                </span><a class="pl-2" href="#">Follow </a>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <hr/>
                <p><a href="/profile/{{$post->user->id}}">
                    <span class="font-weight-bold text-dark" >
                        {{$post->user->username}}
                    </span>
                     </a> {{$post->caption}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection