<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CMSController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('cms.index', compact('posts'));
    }

    public function create()
    {
        return view('cms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts,title|max:255',
            'content' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        Post::create($validated);

        return redirect()->route('cms.index')->with('success', 'Post created successfully!');
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('cms.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('cms.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:posts,title,' . $post->id,
            'content' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $post->update($validated);

        return redirect()->route('cms.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('cms.index')->with('success', 'Post deleted successfully!');
    }
}