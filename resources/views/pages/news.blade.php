@extends('layout_inner.master')
@section('content')
<div class="news">
    <div class="news__inner">
        <div class="news__top">
            <div class="inner-title inner-title--nomargin inner-title--bg">
                <div class="inner-title__back">
                    <a class="back-btn" href="/">
                        <img class="back-btn__icon" src="/img/arrow-left.svg" alt="" />
                        <div class="back-btn__title">На главную</div>
                    </a>
                </div>
                <h1 class="inner-title__heading">Новости</h1>
            </div>
        </div>
        @if(isset($news) && !empty($news))
        <div class="news__slider">
            <div class="gallery-slider">
                <div class="gallery-slider__items">
                    <div class="swiper-wrapper">
                        @foreach($news as $post)
                        <div class="swiper-slide">
                            <div class="gallery-slider__item js-news" data-news="{{$post->id}}">
                                <div class="gallery-slider__date">{{(new \Carbon\Carbon($post->active_from))->format('d.m.Y')}}</div>
                                <div class="gallery-slider__title">{{$post->name}}</div>
                                <div class="gallery-slider__text">{!! $post->preview_text !!}</div>
                            </div>
                            <section class="news-popup" id="news{{$post->id}}">
                                <div class="news-popup__date">{{(new \Carbon\Carbon($post->active_from))->format('d.m.Y')}}</div>
                                <h2 class="news-popup__title">{{$post->name}}</h2>
                                <div class="news-popup__text">{!! $post->detail_text !!}</div>
                                <a class="news-popup__close js-popup-close"></a>
                            </section>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection