<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
{{-- Buat Loading --}}
<html class="loading" lang="en" data-textdirection="ltr">
{{-- End Buat Loading --}}

  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Smart Building</title>
    {{-- <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="../../../../../css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet"> --}}

     <!-- BEGIN: Vendor CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">

     <!-- END: Vendor CSS-->
 
     <!-- BEGIN: Theme CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.min.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/semi-dark-layout.min.css')}}">
 
     <!-- BEGIN: Page CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
     <!-- END: Page CSS-->
 
     <!-- BEGIN: Custom CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
     <!-- END: Custom CSS-->

 
  </head>
  <!-- END: Head-->



{{-- Part Begin Body --}}
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">



{{-- Begin Header --}}
<nav
class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
<div class="navbar-container d-flex content">
    <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                        data-feather="menu"></i></a></li>
        </ul>

        <ul class="nav navbar-nav">
            <div class="bookmark-input search-input">
                <div class="bookmark-input-icon"><i data-feather="search"></i></div>
                <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0"
                    data-search="search">
                <ul class="search-list search-list-bookmark"></ul>
            </div>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav align-items-center ms-auto">

        {{-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                    data-feather="moon"></i></a></li>
        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"
                    data-feather="search"></i></a>
            <div class="search-input">
                <div class="search-input-icon"><i data-feather="search"></i></div>
                <input class="form-control input" type="text" placeholder="Explore Smart Building"
                    tabindex="-1" data-search="search">
                <div class="search-input-close"><i data-feather="x"></i></div>
                <ul class="search-list search-list-main"></ul>
            </div>
        </li> --}}

        <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">
                        {{ Auth::user()->name }}</span><span class="user-status">{{ Auth::user()->email }}</span></div><span
                    class="avatar"><img class="round" src="{{ Auth::user()->profile_photo_url }}"
                        alt="avatar" height="40" width="40"><span
                        class="avatar-status-online"></span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a
                    class="dropdown-item" href="#"><i class="me-50"
                        data-feather="message-square"></i> {{ Auth::user()->email }}</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i
                        class="me-50" data-feather="power"></i> Logout</a>
            </div>
        </li>
    </ul>
</div>
</nav>
{{-- End Header --}}