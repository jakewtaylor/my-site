@extends('layouts.main')

@section('content')
<div class="card" style="max-width: 50%;">
    <div class="card__inner" style="width: 100%;">
        <h1 class="card__title">Your code:</h1>
        <article class="card__content">
            <pre
                style="display: block; width: 100%; overflow-x: scroll; white-space: pre-wrap;">{{ request()->get('code') }}</pre>

            <p>
                <a href="/">Back to website.</a>
            </p>
        </article>
    </div>
</div>
@endsection