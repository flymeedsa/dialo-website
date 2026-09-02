@extends('layouts.public')
@section('title', $article->localized('title').' — Dialo Help')
@section('description', $article->localized('excerpt'))
@section('content')
<article><header class="page-hero inner-page-hero"><div class="container narrow"><a class="eyebrow" href="{{ route(app()->getLocale().'.help') }}">{{ $article->category->localized('name') }}</a><h1>{{ $article->localized('title') }}</h1><p>{{ $article->localized('excerpt') }}</p></div></header><div class="section inner-content-section"><div class="container narrow prose article-prose">{!! nl2br(e($article->localized('body'))) !!}</div></div></article>
<x-inner-cta />
@endsection
