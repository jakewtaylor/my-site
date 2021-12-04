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
        $perPage = $request->getPerPage();

        $albums = app(Albums::class, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        return new LengthAwarePaginator(
            $albums->items(),
            $albums->totalCount(),
            $perPage,
            $page,
            ['path' => '/api/albums']
        );
    }
}
