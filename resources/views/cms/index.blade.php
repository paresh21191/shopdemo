@extends('layouts.app')

@section('title', 'CMS - Posts')

@section('content')
<div class="d-flex justify-content-between flex-wrap align-items-center mb-4 gap-2">
  <h1 class="display-4 fw-bold">CMS Posts</h1>
  <a href="{{ route('cms.create') }}" class="btn btn-primary btn-lg">
    <i class="bi bi-plus-lg"></i> New Post
  </a>
</div>

@if($posts->isEmpty())
  <p class="text-muted text-center fs-5 my-5">No CMS posts found. Start adding some!</p>
@else
  <div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach($posts as $post)
      <div class="col">
        <div class="card shadow-sm h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text text-truncate">{{ Str::limit(strip_tags($post->content), 120) }}</p>
            <p class="text-muted small mb-2">Slug: <code>{{ $post->slug }}</code></p>
            <p class="text-muted small mb-3">Created: {{ $post->created_at->format('M d, Y') }}</p>
            <div class="mt-auto d-flex flex-wrap gap-2">
              <a href="{{ url('/content/' . $post->slug) }}" target="_blank" class="btn btn-outline-info btn-sm flex-grow-1">
                <i class="bi bi-eye"></i> View
              </a>
              <a href="{{ route('cms.edit', $post) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <form action="{{ route('cms.destroy', $post) }}" method="POST" class="flex-grow-1 m-0" onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="d-flex justify-content-center mt-5">
    {{ $posts->links() }}
  </div>
@endif
@endsection