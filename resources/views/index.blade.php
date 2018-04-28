<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            .block {
              display: flex;
              flex-wrap: wrap;
            }

            .block .form-group {
              flex: 1 1 45%;
              margin: 5px;
            }

            select[multiple] {
              height: 250px;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>
