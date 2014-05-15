<!DOCTYPE HTML>
<!--
Miniport 2.5 by HTML5 UP
html5up.net | @n33co
Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>HitSeven - The Album Network</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,600,700" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	<body>

		<!-- Nav -->
		<nav id="nav">
			<li class="facebook">
			<?php
				if($user_id) {
					echo "<a href='#' class='fa fa-facebook'>&nbsp;  Logout </a>";
				}else {
					echo "<a href='#' class='fa fa-facebook'>&nbsp;  Login with Facebook</a>";
				}
			?>
<!-- 				<a href="#" class="fa fa-facebook">&nbsp;  Login with Facebook</a> -->
			</li>
			<ul class="container">
				<li>
					<a href="#top">Home</a>
				</li>
				<li>
					<a href="#work">How it works?</a>
				</li>
				<li>
					<a href="#portfolio">Apps</a>
				</li>
				<li>
					<a href="#contact">Contact</a>
				</li>
			</ul>
		</nav>

		<!-- Home -->
		<div class="wrapper wrapper-style1 wrapper-first">
			<article class="container" id="top">
				<div class="row">
					<div class="4u">
						<span class="me image image-full"><img src="images/me.jpg" alt="" /></span>
					</div>
					<div class="8u">
						<header>
							<h1>Collect, Play, and Trade.</h1>
						</header>
						<p>
							The album collection and competition Social platform for exchanging collectible media.
						</p>
						<p>
							HitSeven offers B2B solutions, to operate and host cloud-based media albums and competitions, with full customization.
						</p>
						<a href="#work" class="button button-small">How it works?!</a>
					</div>
				</div>
			</article>
		</div>

		<!-- Work -->
		<div class="wrapper wrapper-style2">
			<article id="work">
				<header>
					<h2>Build new competitions and Media collection Albums on HitSeven cloud</h2>
					<span>HitSeven albums available to your users as Facebook App, Website, iOS, and Android smart phones.</span>
				</header>
				<div class="container">
					<div class="row">
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-th-large"></span>
								<h3>Create Multiple Category Collections</h3>
								<p>
									Ornare nulla proin odio consequat sapien vestibulum ipsum primis sed amet consequat lorem dolore.
								</p>
							</section>
						</div>
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-trophy"></span>
								<h3>Manage Competitions in Rounds</h3>
								<p>
									Ornare nulla proin odio consequat sapien vestibulum ipsum primis sed amet consequat lorem dolore.
								</p>
							</section>
						</div>
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-cogs"></span>
								<h3>Complete Platform Administration</h3>
								<p>
									Ornare nulla proin odio consequat sapien vestibulum ipsum primis sed amet consequat lorem dolore.
								</p>
							</section>
						</div>
					</div>
				</div>
			</article>
		</div>

		<!-- Work2 -->
		<div class="wrapper wrapper-style2">
			<article id="work2">
				<header>
					<h2>Users collect media Cards, and play games with Facebook friends!</h2>
					<span>Play different games with each card to earn higher Score, and go up in rankings!</span>
				</header>
				<div class="container">
					<div class="row">
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-th"></span>
								<h3>Collect</h3>
								<p>
									Purchase card packs, build your collection, and use the images, music, videos that come with each card.
								</p>
							</section>
						</div>
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-gamepad"></span>
								<h3>Play</h3>
								<p>
									Each card has a set of games, that you can play with your friends to earn more score..
								</p>
							</section>
						</div>
						<div class="4u">
							<section class="box box-style1">
								<span class="fa featured fa-retweet"></span>
								<h3>Trade</h3>
								<p>
									Ornare nulla proin odio consequat sapien vestibulum ipsum primis sed amet consequat lorem dolore.
								</p>
							</section>
						</div>
					</div>
				</div>
			</article>
		</div>

		<!-- Portfolio -->
		<div class="wrapper wrapper-style3">
			<article id="portfolio">
				<header>
					<h2>All Applitcations powered by HitSeven</h2>
					<span>Login to see which apps you are enrolled in ...</span>
				</header>
				<div class="container">
					<div class="row">
						<div class="12u"></div>
					</div>
					<div class="row">
						<?php
							foreach ($site_info->result() as $row) {
							echo "<div class=\"4u\">";
							echo "<article class=\"box box-style2\">";
							$img = "images\\" . $row->name. ".jpg";
							$url = $row->url;
							echo "<a href=$url class=\"image image-full\"><img src=$img alt=\"\" /></a>";
							echo "<h3><a href=$url >$row->name</a></h3>";
							echo "</article>";
							echo "</div>";
						}
						?>
						</div>
					</div>
					<footer>
						<p>
							Lorem ipsum dolor sit sapien vestibulum ipsum primis?
						</p>
						<a href="#contact" class="button button-big">Get in touch with me</a>
					</footer>
			</article>
		</div>
		
		<!-- Contact -->
		<div class="wrapper wrapper-style4">
			<article id="contact" class="container small">
				<header>
					<h2>Want to hire me? Get in touch!</h2>
					<span>Ornare nulla proin odio consequat sapien vestibulum ipsum sed lorem.</span>
				</header>
				<div>
					<div class="row">
						<div class="12u">
							<form method="post" action="#">
								<div>
									<div class="row half">
										<div class="6u">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>
										<div class="6u">
											<input type="text" name="email" id="email" placeholder="Email" />
										</div>
									</div>
									<div class="row half">
										<div class="12u">
											<input type="text" name="subject" id="subject" placeholder="Subject" />
										</div>
									</div>
									<div class="row half">
										<div class="12u">
											<textarea name="message" id="message" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="12u">
											<a href="#" class="button form-button-submit">Send Message</a>
											<a href="#" class="button button-alt form-button-reset">Clear Form</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="12u">
							<hr />
							<h3>Find me on ...</h3>
							<ul class="social">
								<li class="twitter">
									<a href="http://twitter.com/n33co" class="fa fa-twitter"><span>Twitter</span></a>
								</li>
								<li class="facebook">
									<a href="#" class="fa fa-facebook"><span>Facebook</span></a>
								</li>
								<li class="dribbble">
									<a href="http://dribbble.com/n33" class="fa fa-dribbble"><span>Dribbble</span></a>
								</li>
								<li class="linkedin">
									<a href="#" class="fa fa-linkedin"><span>LinkedIn</span></a>
								</li>
								<li class="tumblr">
									<a href="#" class="fa fa-tumblr"><span>Tumblr</span></a>
								</li>
								<li class="googleplus">
									<a href="#" class="fa fa-google-plus"><span>Google+</span></a>
								</li>
								<li class="github">
									<a href="http://github.com/n33" class="fa fa-github"><span>Github</span></a>
								</li>
								<!--
								<li class="rss"><a href="#" class="fa fa-rss"><span>RSS</span></a></li>
								<li class="instagram"><a href="#" class="fa fa-instagram"><span>Instagram</span></a></li>
								<li class="foursquare"><a href="#" class="fa fa-foursquare"><span>Foursquare</span></a></li>
								<li class="skype"><a href="#" class="fa fa-skype"><span>Skype</span></a></li>
								<li class="soundcloud"><a href="#" class="fa fa-soundcloud"><span>Soundcloud</span></a></li>
								<li class="youtube"><a href="#" class="fa fa-youtube"><span>YouTube</span></a></li>
								<li class="blogger"><a href="#" class="fa fa-blogger"><span>Blogger</span></a></li>
								<li class="flickr"><a href="#" class="fa fa-flickr"><span>Flickr</span></a></li>
								<li class="vimeo"><a href="#" class="fa fa-vimeo"><span>Vimeo</span></a></li>
								-->
							</ul>
							<hr />
						</div>
					</div>
				</div>
				<footer>
					<ul id="copyright">
						<li>
							&copy; 2013 Jane Doe
						</li>
						<li>
							Images: <a href="http://fotogrph.com">fotogrph</a>
						</li>
						<li>
							Design: <a href="http://html5up.net/">HTML5 UP</a>
						</li>
					</ul>
				</footer>
			</article>
		</div>

	</body>
</html>