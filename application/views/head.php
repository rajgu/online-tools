<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      foreach ($css AS $inc)
        print ("\t\t<link rel=\"stylesheet\" href=\"{$inc}\" media=\"screen\">\n")
    ?>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
    <?php
      foreach ($js_ie8 AS $inc)
        print ("\t\t<script src=\"{$inc}\"></script>\n")
    ?>
		<![endif]-->
    <?php
      foreach ($js AS $inc)
        print ("\t\t<script src=\"{$inc}\"></script>\n")
    ?>
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="<?php echo base_url (); ?>" class="navbar-brand">online-tools.it</a>
				</div>

				<div class="navbar-collapse collapse" id="navbar-main">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-road"></span> Domains &amp; Network<span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="themes">
								<li><a href="<?php echo base_url('domains/whois'); ?>"><span class="glyphicon glyphicon-search"></span> Whois</a></li>
								<li><a href="<?php echo base_url('domains/dropped'); ?>"><span class="glyphicon glyphicon-trash"></span> Dropped</a></li>
								<li><a href="<?php echo base_url('domains/records'); ?>"><span class="glyphicon glyphicon-link"></span> Records (DIG)</a></li>
								<li><a href="<?php echo base_url('domains/blacklists'); ?>"><span class="glyphicon glyphicon-eye-close"></span> BlackList Checker</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo base_url('network/lookup'); ?>"><span class="glyphicon glyphicon-screenshot"></span> IP Lookup</a></li>
								<li><a href="<?php echo base_url('network/ping'); ?>"><span class="glyphicon glyphicon-hand-right"></span> Ping</a></li>
								<li><a href="<?php echo base_url('network/traceroute'); ?>"><span class="glyphicon glyphicon-globe"></span> Traceroute</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-tower"></span> Web Pages &amp; Sites <span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="themes">
								<li><a href="../cosmo/">HTTP Requester</a></li>
								<li><a href="../cosmo/">Web Proxy</a></li>
								<li><a href="../cosmo/">Link Checker</a></li>
								<li><a href="../cosmo/">Sitemap Generator</a></li>
								<li><a href="../cosmo/">Web Scores</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-refresh"></span> Converters &amp; Parsers <span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="themes">
								<li><a href="/domain">IP Lookup</a></li>
								<li><a href="../cerulean/">Ping</a></li>
								<li><a href="../cosmo/">Traceroute</a></li>
								<li><a href="../cosmo/">HTTP Requester</a></li>
								<li><a href="../cosmo/">Web Proxy</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-lock"></span> Security &amp; Encryption <span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="themes">
								<li><a href="/domain">IP Lookup</a></li>
								<li><a href="../cerulean/">Ping</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo base_url('encryption/hash'); ?>"><span class="glyphicon glyphicon-flash"></span> Hash Functions</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><span class="glyphicon glyphicon-random"></span> Other &amp; Misc <span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="themes">
								<li><a href="/domain">IP Lookup</a></li>
								<li><a href="../cerulean/">Ping</a></li>
								<li><a href="../cosmo/">Traceroute</a></li>
								<li><a href="../cosmo/">HTTP Requester</a></li>
								<li><a href="../cosmo/">Web Proxy</a></li>
							</ul>
						</li>

					</ul>

				</div>
			</div>
		</div>

