@extends('admins.layouts.master',['title' => 'Sửa bài báo'])
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
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
                            <form class="form" action="{{route('admin.post.update',['id' => $getPost->id])}}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md- col-12 mr-1">
                                            <div class="form-group">
                                                <label for="first-name-column">Tiêu đề:</label>
                                                <input type="text" id="first-name-column" class="form-control"
                                                       value="{{$getPost->title}}"
                                                       name="title">
                                            </div>
                                        </div>
                                        <div class="col-md- col-12 mr-1">
                                            <div class="form-group">
                                                <label for="first-name-column">Nội dung:</label>
                                                <input type="text" id="first-name-column" class="form-control"
                                                       value="{{$getPost->content}}"
                                                       name="content">
                                            </div>
                                        </div>
                                        <section class="section">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Mô tả</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="full">
                                                        <textarea name="description" id="" cols="30" rows="10">{{$getPost->description}}</textarea>
                                                        <img src="{{$getPost->thumbnail}}" alt="" height="300" width="300">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="col-md-6 mb-4">
                                            <h6>Trạng thái</h6>
                                            <div class="form-group">
                                                <select class="choices form-select" name="status">
                                                    <option {{old('status',$getPost->status) == 'Publish' ? 'selected' : ""}} value="Publish">Publish</option>
                                                    <option {{old('status',$getPost->status) == 'Unpublish' ? 'selected' : ""}} value="Unpublish">Unpublish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Lưu</button>
                                        </div>
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
