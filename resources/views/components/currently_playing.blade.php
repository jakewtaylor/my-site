@inject('currentlyPlaying', 'App\Contracts\CurrentTrack')

@if ($currentlyPlaying->hasTrack())
<div class="md:absolute bottom-0 md:bottom-auto md:top-0 left-0 p-4 md:p-8 z-20 text-gray-100">
    <p class="leading-none mb-2">i'm currently listening to</p>
    <div class="flex items-center">
        <div class="w-16 h-16 md:w-20 md:h-20">
            @if ($currentlyPlaying->hasAlbumArt())
            <img src="{{ $currentlyPlaying->getAlbumArt() }}" class="block w-full rounded shadow" id="album__art"
                alt="Artwork for the album '{{ $currentlyPlaying->getAlbumName() }}' by {{ $currentlyPlaying->getArtistName() }}">
            @else
            <div class="block w-full h-full rounded shadow bg-gray-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
            </div>
            @endif
        </div>

        <div class="block ml-2 leading-none text-gray-100 mix-blend-difference">
            <p class="font-bold">{{ $currentlyPlaying->getTrackName() }}</p>
            <p class="my-1">{{ $currentlyPlaying->getArtistName() }}</p>
            <p class="italic">{{ $currentlyPlaying->getAlbumName() }}</p>
        </div>
    </div>
</div>

<div style="background-image: url('{{ $currentlyPlaying->getAlbumArt() }}')"
    class="h-full fixed inset-0 transform scale-150 bg-full filter blur-2xl brightness-75 z-10" />
@endif