@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-3xl mx-auto my-5">
  <h1 class="display-4 fw-bold mb-4">Edit Post</h1>
  @include('cms.form')
</div>
@endsection