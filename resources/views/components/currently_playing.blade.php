@inject('currentlyPlaying', 'App\Contracts\CurrentTrack')

@if ($currentlyPlaying->hasTrack())
<div class="md:absolute bottom-0 md:bottom-auto md:top-0 left-0 p-4 z-20 text-gray-100">
    <p class="leading-none mb-2">i'm currently listening to</p>
    <div class="flex items-center">
        <div class="w-16 md:w-20">
            <img src="{{ $currentlyPlaying->getAlbumArt() }}" class="block w-full rounded shadow" id="album__art"
                alt="Artwork for the album '{{ $currentlyPlaying->getAlbumName() }}' by {{ $currentlyPlaying->getArtistName() }}">
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