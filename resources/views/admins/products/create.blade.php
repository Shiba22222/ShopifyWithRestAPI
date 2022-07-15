@extends('admins.layouts.master',['title'=>'Tạo sản phẩm'])
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
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" action="{{route('admin.get.createProduct')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12 mr-1">
                                        <div class="form-group">
                                            <label for="last-name-column">Tiêu đề :</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                                   placeholder="Tiêu đề"
                                                   name="title" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mr-1">
                                        <div class="form-group">
                                            <label for="city-column">Mô tả :</label>
                                            <input type="text" id="city-column" class="form-control"
                                                   placeholder="Mô tả sản phẩm" name="description"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mr-1">
                                        <div class="form-group">
                                            <label for="city-column">Giá :</label>
                                            <input type="number" id="city-column" class="form-control"
                                                   placeholder="Giá của sản phẩm" name="price"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <p>Upload Image</p>
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" id="customFile" name="url"
                                                   value="" multiple>
                                            <label class="form-file-label" for="customFile">
                                                <span class="form-file-text">Choose file...</span>
                                                <span class="form-file-button">Browse</span>
                                            </label>
                                        </div>
                                    </div>
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


