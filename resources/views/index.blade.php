@extends('layouts.main')
@inject('currentlyPlaying', 'App\Contracts\CurrentTrack')

@section('content')
<div class="w-full flex items-center justify-center px-4">
    <section class="bg-white flex flex-col md:flex-row justify-stretch shadow rounded max-w-2xl relative z-20">
        <div class="p-8">
            <div class="flex flex-col-reverse md:flex-row items-start md:items-center justify-between mb-6">
                <h1 class="text-5xl font-bold leading-none text-gray-900">Jake Taylor</h1>

                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="heart"
                    class="w-12 h-12 opacity-80 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
            </div>

            <article class="text-lg text-gray-800">
                <p class="mb-2">I'm a freelance full-stack web developer with experience using Laravel & React, among
                    other technologies. I have
                    expertise in both the frontend and backend, so I can
                    help you build something fully functional that looks and feels great&mdash;get in touch and let's
                    work
                    together. 🙂</p>

                <p>Feel free to email me at
                    <a href="mailto:{{ env('EMAIL') }}"
                        class="text-blue-600 hover:text-blue-700 hover:underline font-bold">
                        {{ env('EMAIL') }}</a>, connect on
                    <a href="{{ env('LINKED_IN') }}"
                        class="text-blue-600 hover:text-blue-700 hover:underline font-bold">LinkedIn</a>,
                    or look through my
                    <a href="https://github.com/{{ env('GITHUB') }}"
                        class="text-blue-600 hover:text-blue-700 hover:underline font-bold">
                        GitHub</a>.
                </p>
            </article>
        </div>
    </section>
</div>

@include('components.currently_playing')

<script>
    const heart = document.getElementById('heart');

    heart.addEventListener('click', () =>{
        heart.classList.add('heart-animation');

        setTimeout(() => {
            heart.classList.remove('heart-animation');
        }, 400);
    });
</script>

<style>
    .heart-animation {
        -webkit-animation: wobble .4s ease 0s 1 normal none;
        animation: wobble .4s ease 0s 1 normal none;
    }

    /* Copy this @keyframes block to your CSS*/
    @keyframes wobble {
        0% {}

        100% {}

        20% {
            transform: scale(1.2);
        }

        40% {
            transform: scale(1);
        }

        70% {
            transform: scale(1.4);
        }
    }
</style>

@endsection