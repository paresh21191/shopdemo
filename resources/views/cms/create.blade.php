@extends('layouts.app')

@section('title', 'Add New Post')

@section('content')
<div class="max-w-3xl mx-auto my-5">
  <h1 class="display-4 fw-bold mb-4">Add New Post</h1>
  @include('cms.form')
</div>
@endsection