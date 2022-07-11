@extends('admins.layouts.master',['title' => 'Crawler'])
@section('content')
    <div class="row" id="table-inverse">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (\Session::has('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('message') !!}</li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-content">
                    <form action="">
                        <div class="card-body">
                            <a href="{{route('get.hacker')}}" class="btn btn-outline-primary">Bắt đầu lấy dữ liệu từ VNExpress</a>
                            <a href="{{route('get.index')}}" class="btn btn-outline-success">Trang bài báo</a>
{{--                            <label for="">Tìm kiếm:</label>--}}
{{--                            <input type="search" name="search" placeholder="Tìm kiếm" value="{{$searches}}">--}}
                        </div>
                    </form>

                    <!-- table with light -->
                    <div class="table-responsive">
                        <table class="table table-light mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Trạng thái</th>
                                <th>Người lấy</th>
                                <th>Ngày lấy</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody id="ListCategory">
                            @foreach($getAll as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><img src="{{$item->thumbnail}}" alt="" height="100px" width="120px"></td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>ádsaasdkj</td>
                                    <td>{{date('d-m-Y H:i:s',strtotime($item->created_at))}}</td>
                                    <td>
                                        <div class="buttons">
                                            <a href="{{route('admin.get.edit',['id' => $item->id])}}" class="btn icon icon-left btn-primary"><i data-feather="edit"></i> Sửa</a>
                                            <a href="{{route('admin.get.delete',['id' => $item->id])}}" class="btn icon icon-left btn-danger"><i data-feather="alert-triangle"></i> Xóa</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{$getAll ->links()}}
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
