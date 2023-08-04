<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="fixed no-mobile-device custom-scroll
        sidebar-left-collapsed
        {{$visual->header == 'dark' ? 'header-dark' : ''}}
        {{$visual->sidebars == 'dark' ? '' : 'sidebar-light'}}
        {{$visual->bg == 'dark' ? 'dark' : ''}}
        ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facturación Electrónica</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <script src="{{asset('socket/socket_io.js')}}"></script>
     <link rel="stylesheet" href="{{ asset('porto-light/vendor/bootstrap/css/bootstrap.css') }}" />
     <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />
     <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i&display=swap" rel="stylesheet">		
     <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   
    <script src="{{ asset('qz/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script src="{{ asset('qz/dependencies/sha-256.min.js') }}"></script>
    <script src="{{ asset('qz/qz-tray.js') }}"></script>
    <style type="text/css">
        * {
            box-sizing: border-box
        }
        html, body {
            width: 100%;
            overflow: hidden;
        }
        .glider-contain {
            width: 95%;
            max-width: 1200;
            margin: 0 auto;
        }
        .glider-slide {
            min-height: 50px;
        }
        .glider-slide img {
            width: 100%;
        }
    </style>
    <style>
            .container{
                max-width: 99% !important;
                padding:5ppx !important;
            }
            .bg_sliders{
                background-color: #EDEDED;
                padding-top:20px;
                padding-bottom: 20px;
            }
            tr {
                border: 0;
                display: block;
                margin: 5px;

            }
            .solid {
                border: 2px red solid;
                border-radius: 10px;
            }
            .dotted {
                border: 2px #ddd solid;
                border-radius: 10px;
                background-color:#FFF;
            }
            
            .content{
                margin: auto !important;
                padding: 10px !important;
                width: 100% !important;
            }
            td {
                padding: 5px;
            }
            .demo{ background-color: #e7e7e7; }
            .cursor{
                cursor:pointer;
            }
            .product-grid{
                font-family: 'Montserrat', sans-serif;
                text-align: center;
                margin: 5px 0px 10px;
                border-radius: 10px;
                box-shadow:  0 0 10px rgba(0,0,0,0.1);
                transition: all 0.5s;
                border: 1px solid #cccc;
                transition: 1.0s ease;
                    -moz-transition: 1.0s ease; /* Firefox */
                    -webkit-transition: 1.0s ease; /* Chrome - Safari */
                    -o-transition: 1.0s ease; /* Opera */
            }
            .product-grid:hover{ 
            box-shadow:  0 0 15px rgba(0,0,0,0.1);
                    transform : scale(1.1);
                    -moz-transform : scale(1.1); /* Firefox */
                    -webkit-transform : scale(1.1); /* Chrome - Safari */
                    -o-transform : scale(1.1); /* Opera */
                    -ms-transform : scale(1.1); /* IE9 */
            }
            .product-grid .product-image{ position: relative; }
            .product-grid .product-image a.image{
                border-radius: 10px 10px 0 0;
                overflow: hidden;
                display: block;
            }
            .product-grid .product-image img{
                width: 100%;
                height:140px !important;
                cursor:pointer;
            }
            .product-grid .product-sale-label{
                color: #fff;
                background: #409EFF;
                font-size: 13px;
                text-transform: uppercase;
                padding: 2px 6px;
                border-radius: 3px;
                position: absolute;
                left: -4px;
                top: -2px;
            }
            .product-grid .price{
                color: #fff;
                background: #409EFF;
                font-size: 13px;
                padding: 2px 6px 2px 18px;
                border: 1px solid rgba(0,0,0,0.08);
                border-radius: 1px 3px 3px 1px;
                position: absolute;
                top: 25px;
                left: -15px;
                clip-path: polygon(10% 0, 100% 0, 100% 100%, 10% 100%, 0 50%);
            }
            .product-grid  .price span{
                font-weight: 400;
                text-decoration: line-through;
                opacity: 0.5;
            }
            .product-grid .price:before{
                content: "";
                background: #fff;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                position: absolute;
                top: 8px;
                left: 7px;
            }
            .product-grid .price.fixed{
                background: #b71540;
                top: -4px;
            }
            .add-to-cart {
                z-index:999 !important;
            }
            .product-grid .add-to-cart{
                color: #fff;
                background: #009de1;
                font-size: 10px;
                text-transform: uppercase;
                padding: 5px;
                border-radius: 3px;
                box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.1);
                opacity: 0;
                position: absolute;
                right:0px;
                bottom:5px;
                transition: all 0.2s ease-out;
            }
            .product-grid .add-to-cart:hover{ box-shadow: 0px 8px 8px 0px rgba(0,0,0,0.1);
                cursor:pointer;
            }
            .product-grid:hover .add-to-cart{ opacity:1; }
            .product-content{
                align-items: center;
                justify-content: center;
                display:flex;
            }
            .product-grid .product-content{
                background-color: #fff;
                text-align: center;
                padding:5px;
                min-height:30px;
                border-top: 1px solid transparent;
                border-radius: 0 0 10px 10px;
                transition: all 0.3s;
                line-height:2em;
                height: 4em;       /* height is 2x line-height, so two lines will display */
                overflow: hidden; 
            }
            .product-grid:hover .product-content{ border-top-color: #dbdbdb; }
            .product-grid .title{
                font-size: 12px;
                font-weight: 500;
                text-transform: capitalize;
                margin: 0;
            }
            .product-grid .title a{
                color: #323b45;
                transition: all 0.4s ease-out;
            }
            .product-grid .title a:hover{ color: #b71540; }
            .product-grid .rating{
                padding: 0;
                margin: 0;
                list-style: none;
            }
            .product-grid .rating li{
                color: #f1c40f;
                font-size: 12px;
                display: inline-block;
            }
            .bg-slider{
            background-color: #F5F7FA;
            }
            .product-grid .rating li.far{ color: #dbdbdb; }
            @media screen and (max-width:990px){
                .product-grid{ margin: 5px 15px 30px; }
            }
            
</style>
@laravelPWA
</head>
<body class="pr-0">
    <section class="body" id="main">
        <!-- start: header -->
         <!-- end: header -->
        <div class="inner-wrapper border-danger">
              @yield('content')
        </div>
    </section> 
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ mix('/js/clear_cache.js') }}"></script>
  
</body>
</html>
