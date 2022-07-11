<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        $getAll = Post::orderBy('id','desc')->simplepaginate(10);
        dd($getAll);
        return view('admins.posts.index')->with([
            'getAll' => $getAll,
        ]);
    }

    public function edit($id){
        $getPost = Post::find($id);
        if (empty($getPost)){
            return back()->with('message','Thao tác lỗi mời bạn ấn lại thao tác');
        }
        return view('admins.posts.edit')->with([
            'getPost' => $getPost,
        ]);
    }

    public function update(PostRequest $request, $id){
        $data = $request->validated();
        $updatePost = Post::find($id);
        $updatePost->update($data);
        return redirect()->route('get.indexPost')->with('message', 'Sửa bài báo thành công');
    }

    public function delete($id){
        $deletePost = Post::find($id);
        if (empty($deletePost)){
            return back()->with('message','Thao tác lỗi mời bạn ấn lại thao tác');
        }
        $deletePost->delete();
        return back()->with('message', 'Xóa bài báo thành công');
    }

}
