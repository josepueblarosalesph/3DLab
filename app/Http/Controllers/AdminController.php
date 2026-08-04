<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Post;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'postsCount' => Post::count(),
            'publishedCount' => Post::published()->count(),
            'inquiriesCount' => Inquiry::whereNull('read_at')->count(),
            'recentPosts' => Post::latest()->take(5)->get(),
        ]);
    }
}
