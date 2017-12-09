@extends('layouts.private.base')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
            </div>
        </div>

    </div><!-- /.container -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            axios.get('/api/collection/all').then(response => {
                console.log(response.data);
            })
        })
    </script>
@endsection