<!DOCTYPE html>
<html>
<head>
	
	@yield('title')

	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="{{ App::getLocale() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <meta name="google-site-verification" content="WoEFPm5mEA4IkWE-EDSpSDrG7zg1ETt3LppVMm5Y5Mg" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="all"/>

	<link rel="icon" type="image/png" href="{{ asset('asset/picture/data-bazis/'.$lgBazis->picture) }}" />
	
	<link rel="stylesheet" href="{{ asset('backend/vendors/fontawesome-free-5.0.6/on-server/css/fontawesome-all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/css/public.css') }}">
	@yield("include_css")
	
	<script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>


</head>
<body>
	@include('frontend._layout.navigasibar')
	@yield("body")
	@include('frontend._layout.footer')

	<script type="text/javascript" src="{{ asset('backend/vendors/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('frontend/js/public.js') }}"></script>
	@yield("include_js")
</body>
</html>