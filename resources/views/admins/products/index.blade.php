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
                            <a href="{{route('admin.get.createProduct')}}" class="btn btn-outline-primary">Tạo sản phẩm</a>
                            {{--                            <a href="{{route('get.index')}}" class="btn btn-outline-success">Trang bài báo</a>--}}
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
                                <th>Giá</th>
                                <th>Giá nhập vào</th>
                                <th>Số lượng</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody id="ListCategory">
                            @foreach($getProducts as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        @foreach($item->image as $images)
                                            <img src="{{$images->image}}" alt="" height="100px" width="120px">
                                        @endforeach
                                    </td>
                                    <td>{{$item->title}}</td>
                                    @foreach($item->variants as $variants)
                                        <td>{{$variants->price}} đ</td>
                                        <td>{{$variants->old_price}} đ</td>
                                        <td>{{$variants->quantity}}</td>
                                    @endforeach
                                    <td>
                                        <div class="buttons">
                                            <a href="{{route('admin.get.updateProductApp',['id' => $item->id])}}"
                                               class="btn icon icon-left btn-primary"><i data-feather="edit"></i>
                                                Sửa</a>
                                            <a href="{{route('admin.get.deleteProductApp',['id' => $item->id])}}"
                                               class="btn icon icon-left btn-danger"><i
                                                    data-feather="alert-triangle"></i> Xóa</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{$getProducts ->links()}}
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

