@extends('admins.layouts.master',['title'=>'Sửa sản phẩm'])
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    @if (\Session::has('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('message') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-content" >
                        <div class="card-body">

                            <form class="form" action="{{route('admin.post.updateProductApp',['id'=>$product->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12 mr-1">
                                        <div class="form-group">
                                            <label for="last-name-column">Tiêu đề :</label>
                                            <input type="text" id="last-name-column" class="form-control" placeholder=""
                                                   name="title" value="{{$product->title}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mr-1">
                                        <div class="form-group">
                                            <label for="city-column">Mô tả :</label>
                                            <input type="text" id="city-column" class="form-control" placeholder="" name="description"
                                                   value="{{$product->description}}">
                                        </div>
                                    </div>
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="country-floating">Giá :</label>--}}
{{--                                            <input type="text" id="country-floating" class="form-control" name="price"--}}
{{--                                                   placeholder="" value="{{$product->price}}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 col-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="country-floating">Mô tả</label>--}}
{{--                                            <input type="text" id="country-floating" class="form-control" name="description"--}}
{{--                                                   placeholder="" value="{{$product->description}}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6 col-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <p>Danh mục :</p>--}}
{{--                                            <fieldset class="form-group">--}}
{{--                                                <select class="form-select" id="basicSelect" name="category_id">--}}
{{--                                                    @foreach($categories as $category)--}}
{{--                                                        <option @if($category->id == $product->category_id)selected @endif value="{{$category->id}}">{{$category->name}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </fieldset>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-6 col-md-12">--}}
{{--                                        <p>Upload Image</p>--}}
{{--                                        <div class="form-file">--}}
{{--                                            <input type="file" class="form-file-input" id="customFile" name="image" value="{{$product->image}}">--}}
{{--                                            <label class="form-file-label" for="customFile">--}}
{{--                                                <span class="form-file-text">Choose file...</span>--}}
{{--                                                <span class="form-file-button">Browse</span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Lưu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


