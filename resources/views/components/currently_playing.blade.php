@inject('currentlyPlaying', 'App\Contracts\CurrentTrack')

@if ($currentlyPlaying->hasTrack())
    <div class="album__container">
        <p class="album__title">i'm currently listening to</p>
        <div class="album">
            <div class="album__art__container">
                <img
                    src="{{ $currentlyPlaying->getAlbumArt() }}"
                    class="album__art"
                    id="album__art"
                >
            </div>

            <div class="album__info">
                <p class="album__song">{{ $currentlyPlaying->getTrackName() }}</p>
                <p class="album__artist">{{ $currentlyPlaying->getArtistName() }}</p>
                <p class="album__name">{{ $currentlyPlaying->getAlbumName() }}</p>
            </div>
        </div>
    </div>

    <script>
        window.palette = {{ $currentlyPlaying->getPalette()->toJson() }};
    </script>
    <script src="/js/theme.js"></script>
@endif
