@extends('layouts.backend.chatbox')
@section('content')
<div class="d-lg-flex">

    <div class="chat-leftsidebar mr-lg-4">
        <div class="">
            <div class="py-2 border-bottom">
                <div class="media">
                    <div class="align-self-center mr-2">
                        <img  src="{{asset('assets/images/dost.png')}}" class="avatar-md rounded-circle img-thumbnail" alt="">
                    </div>
                  
                    <div class="media-body">
                        <h5 style="font-size: 12.5px;" class="mt-3 mb-1">S-Landslide Early Warning System</h5>
                        <p class="text-muted font-size-11" style="margin-left: -3px;"><i class="icofont icofont-check-circled text-success align-middle mr-1"></i>Department of Science and Technology IX</p>
                    </div>
                </div>
            </div> 
            <side-bar ref="sidebar"></side-bar>
        </div>
    </div>

    <div class="w-100 user-chat">
        <div class="card">
            <div class="chat-conversation p-3" style="height: calc(100vh - 50px);">
                <main-bar ref="mainbar"></main-bar>
            </div>
        </div>
    </div>
</div>

@endsection
