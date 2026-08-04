<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()->latest('published_at')->take(3)->get();

        return view('home', compact('posts'));
    }
}
