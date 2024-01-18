<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Eventify &mdash;UNDER CONSTRUCTION</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="UDER CONSTRUCTION" />
	<meta name="keywords" content="UNDER CONSTRUCTION" />
	<meta name="author" content="UNDER CONSTRUCTION" />

	

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="<?php echo base_url().'assets/frontend/fonts/googlefonts.css';?>" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/animate.css';?>">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/icomoon.css';?>">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/bootstrap.css';?>">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/magnific-popup.css';?>">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/owl.carousel.min.css';?>">
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/owl.theme.default.min.css';?>">

	<!-- Theme style  -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/css/style.css';?>">

	<!-- Modernizr JS -->
	<script src="<?php echo base_url().'assets/frontend/js/modernizr-2.6.2.min.js';?>"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<?php
	$active = '';
	$active1 = '';
	if($this->uri->segment(1) === 'contact-us')
	{
		$backgroundImage = 'FAST2.jpg';
		$backgroundText = 'Contact Form';
		$active1 = 'class="active"';
	}
	elseif($this->uri->segment(1) === 'socities')
	{
		$backgroundImage = 'FAST2.jpg';
		$backgroundText = 'Socities';
		
	}
	elseif($this->uri->segment(1) === 'signup')
	{
		$backgroundImage = 'FAST.jpg';
		$backgroundText = 'Signup';
		$active2 = 'class="active"';
	}
	elseif($this->uri->segment(1) === 'errorregister')
	{
		$backgroundImage = 'FAST.jpg';
		$backgroundText = 'Error Registeration';
		$active2 = 'class="active"';
	}
	elseif($this->uri->segment(1) === 'ACM')
	{
		$backgroundImage = 'acm-cover.png';
		$backgroundText = 'ACM';
	}
	elseif($this->uri->segment(1) === 'TNC')
	{
		$backgroundImage = 'tnc-cover.jpg';
		$backgroundText = 'TNC';
	}
	elseif($this->uri->segment(1) === 'DECS')
	{
		$backgroundImage = 'DECS-COVER.jpg';
		$backgroundText = 'DECS';
	}
	elseif($this->uri->segment(1) === 'logineventify')
	{
		$backgroundImage = 'FAST2.jpg';
		$backgroundText = 'Login';
	}
	elseif($this->uri->segment(1) === 'TLC')
	{
		$backgroundImage = 'tlccover.jpg';
		$backgroundText = 'TLC';
	}
	elseif($this->uri->segment(1) === 'WEBMASTERS')
	{
		$backgroundImage = 'webmasterscover.jpg';
		$backgroundText = 'WEBMASTERS';
	}
	elseif($this->uri->segment(1) === 'CBS')
	{
		$backgroundImage = 'cbscover.jpg';
		$backgroundText = 'CBS';
	}
	elseif($this->uri->segment(1) === 'FMS')
	{
		$backgroundImage = 'fmscover.jpg';
		$backgroundText = 'FMS';
	}
	elseif($this->uri->segment(1) === 'SPORTICS'){
		$backgroundImage = 'Sporticscover.jpg';
		$backgroundText = 'SPORTICS';
	}
	else
	{
		$backgroundImage = 'FAST2.jpg';
		$backgroundText = 'EVENTS WITH ELEGENCE';
		$active = 'class="active"';
	}
	?>

	<body>
		
	<div class="fh5co-loader"></div>
	
	<div id="page">
	<nav class="fh5co-nav" role="navigation">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 text-right">
						<p class="num">Call: +92 305 2070760</p>
						<ul class="fh5co-social">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-dribbble"></i></a></li>
							<li><a href="https://github.com/saadaminj/Eventify-final/"><i class="icon-github"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-1">
						<div id="fh5co-logo"><a href="<?php echo base_url()?>">Eventify<span>.</span></a></div>
					</div>
					<div class="col-xs-11 text-right menu-10">
						<ul>
							<li ><a href="<?php echo base_url()?>">Home</a></li>
							
							<li class="has-dropdown">
								<a href="<?php echo base_url().'socities';?>">Socities</a>
								<ul class="dropdown">
									<li><a href="<?php echo base_url().'ACM'?>">ACM</a></li>
									<li><a href="<?php echo base_url().'DECS'?>">DECS</a></li>
									<li><a href="<?php echo base_url().'TNC'?>">TNC</a></li>
									<li><a href="<?php echo base_url().'WEBMASTERS'?>">WEBMASTERS</a></li>
									<li><a href="<?php echo base_url().'CBS'?>">CBS</a></li>
									<li><a href="<?php echo base_url().'TLC'?>">TLC</a></li>
									<li><a href="<?php echo base_url().'FMS'?>">FMS</a></li>
									<li><a href="<?php echo base_url().'SPORTICS'?>">Sportics</a></li>
									
								</ul>
							</li>
							
							<li ><a href="<?php echo base_url().'contact-us'?>">Contact</a></li>
							<li class="btn-cta"><a href="<?php echo base_url().'dashboard'?>"><span>Dashboard</span></a></li>
							<li class="btn-cta"><a href="<?php echo base_url().'logout'?>"><span>Logout</span></a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</nav>
	
	<header id="fh5co-header" class="fh5co-cover" role="banner" style="background-image:url(<?php echo base_url().'assets/images/'.$backgroundImage;?>);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="display-t">
						<div class="display-tc animate-box" data-animate-effect="fadeIn">
							
							<h1><?php echo $backgroundText ?></h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>