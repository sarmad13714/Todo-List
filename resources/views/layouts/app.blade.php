<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME', 'To do list')}}</title>
    <script type="text/javascript" src="{{asset('plugins/jQuery-3.6.0/jquery-3.6.0.min.js')}}"></script>
    <link href="{{asset('bootstrap-4.0.0-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('bootstrap-4.0.0-dist/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables.min.css')}}"/>
    <script type="text/javascript" src="{{asset('plugins/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/modules.js')}}"></script>
</head>
<body>
@include("layouts.header")
@yield("content")
@include("layouts.footer")
</body>
</html>
