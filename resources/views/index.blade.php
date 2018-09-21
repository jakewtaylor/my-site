@extends('layouts.main')

@section('content')
    <section class="card">
        <div class="image__container">
            <img src="/img/plant.jpg" alt="Plant" class="image">
        </div>

        <div class="card__inner">
            <h1 class="card__title">Jake Taylor</h1>

            <article class="card__content">
                <p>I'm a @age year old full-stack web developer, currently working at @workplace.</p>

                <p>Feel free to email me at <a href="mailto:{{ env('EMAIL') }}">{{ env('EMAIL') }}</a>, or look through my <a href="https://github.com/{{ env('GITHUB') }}">GitHub</a>.</p>
            </article>
        </div>
    </section>

    @include('components.currently_playing')
@endsection
