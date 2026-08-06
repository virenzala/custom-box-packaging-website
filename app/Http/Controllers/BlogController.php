<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Blog::where('status', 'published')
                     ->orderBy('published_at', 'desc')
                     ->paginate(6);
                     
        return view('blogs.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Blog::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();
                    
        $recentPosts = Blog::where('status', 'published')
                           ->where('id', '!=', $post->id)
                           ->orderBy('published_at', 'desc')
                           ->take(3)
                           ->get();

        return view('blogs.show', compact('post', 'recentPosts'));
    }
}
