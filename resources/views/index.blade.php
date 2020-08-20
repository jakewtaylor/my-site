@extends('layouts.main')
@inject('currentlyPlaying', 'App\Contracts\CurrentTrack')

@section('content')
<section class="card">
    <div class="card__inner">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom:1.5rem">
            <h1 class=" card__title">Jake Taylor</h1>

            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="heart"
                style="height: 3rem; width: 3rem; opacity: 0.8; color: #E53E3E;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
        </div>

        <article class="card__content">
            <p>I'm a full-stack web developer, currently working at @workplace.</p>

            <p>Feel free to email me at <a href="mailto:{{ env('EMAIL') }}">{{ env('EMAIL') }}</a>, or look through my
                <a href="https://github.com/{{ env('GITHUB') }}">GitHub</a>.</p>
        </article>
    </div>
</section>

<script>
    const heart = document.getElementById('heart');

    heart.addEventListener('click', () =>{
        heart.classList.add('heart-animation');

        setTimeout(() => {
            heart.classList.remove('heart-animation');
        }, 400);
    });
</script>

@include('components.currently_playing')
@endsection