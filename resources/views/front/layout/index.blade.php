<!DOCTYPE HTML>
<html>
	<head>
        @yield('title')
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="facebook-domain-verification" content="0iq5xzidv9ivoc3gnlyho6gk9tcvmy" />
		<link rel="stylesheet" href="{{asset('front/assets/bootstrap/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('front/assets/css/main.css')}}" />
		<noscript><link rel="stylesheet" href="{{asset('front/assets/css/noscript.css')}}" /></noscript>
		@toastr_css
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">
				<!-- Header -->
				<header id="header" class="alt">
					<a href="{{url('/')}}" class="logo"><strong>{{App\Models\Information::name()}}</strong> <span>Website</span></a>
					<nav>
						<a href="#menu">Menu</a>
					</nav>
				</header>

				<!-- Menu -->
				<nav id="menu">
					<ul class="links">
		                <li class="active"> <a href="{{route('home.index')}}">HOME </a> </li>
		                <li> <a href="{{route('admin.login')}}">ADMIN LOGIN</a> </li>
            		</ul>
				</nav>
				<!-- Banner -->
				<section id="banner" class="major">
					<div class="inner">
						<header class="major">
							<h1>Welcome To {{App\Models\Information::name()}}</h1>
							{{-- <p>a scholarly journal of the AGBRP</p> --}}
						</header>
						<div class="content">
							<p>Sign in as a Site Owner & Supplier.</p>
							<ul class="actions">
								<li><a href="{{route('user.login')}}" class="button next scrolly">SIGN IN</a></li>
							</ul>
						</div>
					</div>
				</section>
				
				<section>
					<div class="inner">
						<ul class="actions">
							<li><a href="{{route('home.index')}}" class="button next">RETURN TO MAIN PAGE</a></li>
						</ul>
					</div>
				</section>
                @yield('contents')
				<section>
					<div class="inner">
						<ul class="actions">
							<li><a href="{{route('home.index')}}" class="button next">RETURN TO MAIN PAGE</a></li>
						</ul>
					</div>
				</section
				<!-- Footer -->
				<footer id="footer">
					<div class="inner">
						<ul class="copyright">
							<li>Copyright © 2022 Reserved by:</li>
							<li> <a href="{{url('/')}}">jgbrt@wordpress.com</a></li>
						</ul>
					</div>
				</footer>
			</div>

		<!-- Scripts -->
			<script src="{{asset('front/assets/js/jquery.min.js')}}"></script>
			<script src="{{asset('front/assets/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
			<script src="{{asset('front/assets/js/jquery.scrolly.min.js')}}"></script>
			<script src="{{asset('front/assets/js/jquery.scrollex.min.js')}}"></script>
			<script src="{{asset('front/assets/js/browser.min.js')}}"></script>
			<script src="{{asset('front/assets/js/breakpoints.min.js')}}"></script>
			<script src="{{asset('front/assets/js/util.js')}}"></script>
			<script src="{{asset('front/assets/js/main.js')}}"></script>
			@toastr_js
			@toastr_render
            @yield('scripts')
	</body>
</html>