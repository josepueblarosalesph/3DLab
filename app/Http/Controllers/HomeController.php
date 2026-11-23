<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function about(): View
    {
        return view('about', ['content' => PageContent::home()->content]);
    }

    public function index(): View
    {
        $posts = Post::published()->latest('published_at')->take(3)->get();
        $content = PageContent::home()->content;

        $projects = \App\Models\Project::orderBy('id')->take(4)->get();

        return view('home', compact('posts', 'content', 'projects'));
    }
}
