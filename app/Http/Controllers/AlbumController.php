<?php

namespace App\Http\Controllers;

use App\Contracts\Albums;
use App\Http\Requests\GetAlbumsRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class AlbumController extends Controller
{
    public function getAlbums(GetAlbumsRequest $request)
    {
        $page = $request->getPage();

        $albums = app(Albums::class, [
            'page' => $page,
        ]);

        return new LengthAwarePaginator(
            $albums->items(),
            $albums->totalCount(),
            50,
            $page,
            ['path' => '/api/albums']
        );
    }
}
