<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>UBakrie</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("assets/css/fonts.min.css")}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/atlantis.css')}}">
	
	@yield('style')
</head>

<body class="login">
	<div class="wrapper wrapper-login">
		@yield('content')
	</div>
	<a href="https://wa.me/62859106642630" title="hubungi kami" target="new" class="whatsapp-button position-fixed" style="bottom: 60px;right: 40px;">
		<img src="{{asset('assets/img/wa.png')}}" width="70px">
	</a>
	<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('assets/js/atlantis.js')}}"></script>
	@yield('script')
</body>

</html>