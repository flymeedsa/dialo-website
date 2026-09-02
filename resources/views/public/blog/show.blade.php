@extends('layouts.public')
@section('title', $post->localized('seo_title') ?: $post->localized('title').' — Dialo')
@section('description', $post->localized('seo_description') ?: $post->localized('excerpt'))
@section('content')
<article><header class="page-hero inner-page-hero"><div class="container narrow"><a class="eyebrow" href="{{ route(app()->getLocale().'.blog') }}">{{ $post->category?->localized('name') }} · {{ $post->published_at?->format('Y.m.d') }}</a><h1>{{ $post->localized('title') }}</h1><p>{{ $post->localized('excerpt') }}</p></div></header><div class="section inner-content-section"><div class="container narrow prose article-prose">{!! nl2br(e($post->localized('body'))) !!}</div></div></article>
<x-inner-cta />
@endsection
