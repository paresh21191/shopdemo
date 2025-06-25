@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="prose max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-xl prose-indigo">
    <h1 class="font-serif font-extrabold drop-shadow-sm">{{ $post->title }}</h1>

    <hr class="my-6 border-gray-200">

    <section class="leading-relaxed text-lg whitespace-pre-line">
        {!! nl2br(e($post->content)) !!}
    </section>

    <div class="mt-10 text-right">
        <a href="{{ route('dashboard') }}" class="text-indigo-700 hover:text-indigo-900 font-semibold underline transition">← Back to Home</a>
    </div>
</article>
@endsection