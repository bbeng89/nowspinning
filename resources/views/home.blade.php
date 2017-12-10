@extends('layouts.public.base')

@section('content')
    <div class="container">

        <div class="jumbotron text-center" style="margin-top:50px;">
            <h1 class="logo-text">NowSpinning</h1>
            <h2 class="">Discogs <em>Socialized</em></h2>
            <hr/>
            <p><a class="btn btn-primary btn-lg" href="{{ route('auth.login') }}">Login With Your Discogs Account</a></p>
        </div>

    </div><!-- /.container -->
@endsection