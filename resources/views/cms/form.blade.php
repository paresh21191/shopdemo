@php
  $action = isset($post) ? route('cms.update', $post) : route('cms.store');
  $method = isset($post) ? 'PUT' : 'POST';
@endphp

<form method="POST" action="{{ $action }}" novalidate>
  @csrf
  @if ($method !== 'POST') @method($method) @endif

  <div class="mb-4">
    <label for="title" class="form-label fw-semibold">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
           value="{{ old('title', $post->title ?? '') }}" required>
    @error('title')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-4">
    <label for="content" class="form-label fw-semibold">Content</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="d-flex justify-content-between align-items-center">
    <a href="{{ route('cms.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">
      @if(isset($post)) Update Post @else Save Post @endif
    </button>
  </div>
</form>