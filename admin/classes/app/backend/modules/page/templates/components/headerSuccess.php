<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title>ClientAlert admin</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<!-- Included CSS Files -->
<link rel="stylesheet" href="/css/foundation.css">
<link rel="stylesheet" href="/css/normalize.css">

<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/offcanvas.css">
<link rel="stylesheet" href="/css/responsive-tables.css">
<link rel="stylesheet" href="/css/overwrite.css">
<link rel="stylesheet" href="/css/overwrite-more.css">
<link rel="stylesheet" href="/css/calendar.css">

<script src="/js/jquery.min.js"></script> 
<script src="/js/modernizr.js"></script>
<script src="/js/tersel.js"></script>
</head>
<body>
		<?php if (isset($_SESSION['accountId'])) :?>
		
<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="/">Home</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
						<li><a href="/account/logout">Logout</a></li>
    </ul>

    <!-- Left Nav Section -->
    <ul class="left">
						<li><a href="/client/index/">clienti</a></li>
				</ul>
  </section>
</nav>

		<?php endif;?>
