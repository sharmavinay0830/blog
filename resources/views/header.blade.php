<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>	
	<script src="{{ URL('/') }}/js/admin/header.jquery.min.js"></script>
  <link href="{{ URL('/') }}/css/admin/style.css" rel="stylesheet">
  <link href="{{ URL('/') }}/css/admin/style-responsive.css" rel="stylesheet">
</head>
<body class="sticky-header">
<section>  
    <!-- main content start-->
    <div class="main-content" >
        <!-- header section start-->
        <div class="header-section">
			<!--toggle button start-->
			<!--toggle button end-->
			@include('showuserdetail')
		</div>
    <!-- header section end-->