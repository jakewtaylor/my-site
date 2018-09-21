@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card__inner">
            <h1 class="card__title">Something went wrong.</h1>
            <article class="card__content">
                <p>A token probably expired, please try again:</p>

                <form action="{{ route('setup') }}" method="GET">
                    <input type="text" name="passcode" placeholder="Passcode">

                    <input type="submit" value="Restart Process">
                </form>
            </article>
        </div>
    </div>
@endsection
