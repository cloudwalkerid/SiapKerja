<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="base_url" content="">
    <meta name="port" content="8000">
    <title>Siap Kerja</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- index -->

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ URL::asset('css/tambahan/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/tambahan/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{ URL::asset('css/tambahan/dataTables.bootstrap4.min.css')}}">
     <link rel="stylesheet" href="{{ URL::asset('css/tambahan/select.bootstrap4.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/components.css')}}">


</head>

<body>
    <app-root></app-root>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src="{{ URL::asset('js/stisla.js')}}"></script>

    <!-- JS Libraies -->

    <script src="{{ URL::asset('js/tambahan/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/select.bootstrap4.min.js')}}"></script>

    <!-- JS index -->
    <script src="{{ URL::asset('js/tambahan/jquery.sparkline.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/Chart.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/owl.carousel.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/summernote-bs4.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/jquery.chocolat.min.js')}}"></script>
    <script src="{{ URL::asset('js/tambahan/cleave.js')}}"></script>



    <!-- Template JS File -->
    <script src="{{ URL::asset('js/scripts.js')}}"></script>
    <script src="{{ URL::asset('js/custom.js')}}"></script>

    <!-- Page Specific JS File -->
    <!-- <script src="{{ URL::asset('js/page/index.js')}}"></script> -->

    <script src="{{ URL::asset('angular/runtime.js')}}" defer></script>
    <script src="{{ URL::asset('angular/polyfills.js')}}" defer></script>
    <script src="{{ URL::asset('angular/styles.js')}}" defer></script>
    <script src="{{ URL::asset('angular/vendor.js')}}" defer></script>
    <script src="{{ URL::asset('angular/main.js')}}" defer></script>

    <script>
        var user = {!!$user!!};
        var allseksi = {!!$allseksi!!};
        var seksi_kepala = "{{env('KEPALA')}}";
        
    </script>


</body>

</html>
