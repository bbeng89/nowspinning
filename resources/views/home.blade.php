<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Welcome back, {{ Auth::user()->username }}!</h1>
                    <h2>Your collection</h2>
                    <ul>
                        @foreach($collection->releases as $release)
                            <li>{{ $release->basic_information->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>