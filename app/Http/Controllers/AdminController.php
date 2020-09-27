<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Photo;

class AdminController extends Controller
{
    //
    public function index() {

        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $mediasCount = Photo::count();

        return view('admin.index', compact('postsCount', 'categoriesCount', 'mediasCount'));

    }
}
