@extends('admins.layouts.client',['title' => 'Danh sách bài báo'])
@section('content')
    <div class="row">
        @foreach($getPosts as $item)
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row no-gutters">
                            <div class="col-md-12 col-lg-4">
                                <a href="{{route('get.detail',['id' => $item->id])}}">
                                    <img src="{{$item->thumbnail}}" alt="Bài báo không có ảnh nên ko lấy về được" class="h-100 w-100 rounded-left">
                                </a>

                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="card-body">
                                    <p class="card-text text-ellipsis">
                                        <a href="{{route('get.detail',['id' => $item->id])}}" style="color: #0b1015">{{$item->title}}</a>
                                    </p>
                                    <p class="card-text text-ellipsis">
                                        <a href="{{route('get.detail',['id' => $item->id])}}" style="color: #0b1015">{{$item->content}}</a>
                                    </p>
                                    <span><i class="bx bx-heart font-size-large align-middle mr-50"></i>
                                        <a href="{{route('get.detail',['id' => $item->id])}}" style="color: #0b1015">Đọc tiếp</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{$getPosts->links()}}

@endsection
