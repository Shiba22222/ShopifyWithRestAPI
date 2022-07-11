@extends('admins.layouts.client',['title' => ''])
@section('content')
    <style>
        .huska{
            margin-left: 150px;
            margin-right: 150px;
        }
        .img-huska{
            margin-left: inherit;
        }
    </style>
    <div class="huska">
        <h1>{{$getPost->title}}</h1>
        <p>Ngày đăng: {{$getPost->created_at->format('d-m-Y')}}</p>
        <h6>{{$getPost->content}}</h6>
        <img class="img-huska" src="{{$getPost->thumbnail}}" alt="">
        <p>{{$getPost->description}}</p>
    </div>
@endsection
