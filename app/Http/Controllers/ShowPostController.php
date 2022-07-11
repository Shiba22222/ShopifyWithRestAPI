<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ShowPostController extends Controller
{
    public function index(){
        $getPosts = Post::where('status','Unpublish')->orderBy('id','desc')->simplepaginate(10);
        return view('admins.posts.showDetail')->with([
            'getPosts' => $getPosts,
        ]);
    }

    public function detail($id){
        $getPost = Post::find($id);
        return view('admins.posts.detail')->with([
            'getPost' => $getPost,
        ]);
    }
}
