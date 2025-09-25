<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
    <style>
        .inner-box {
            padding: 10px !important;
            text-align: center !important;
        }
        .aboutus-text p {
            text-align: justify;
            color: black;
        }
        .lightbox-image img {
            width: 100%;
        }
        .default-section {
            padding-top:10px !important;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- Header -->
        @include('include.header')

        <!-- Content -->
        @yield('content')

        <!-- Footer -->
        @include('include.footer') 

    </div>

    <!-- Scroll to top -->
    <div class="scroll-to-top scroll-to-target" data-target=".main-header">
        <span class="icon flaticon-airplane-1"></span>
    </div>

    {{-- Scripts --}}
    {{-- <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/revolution.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('js/owl.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script> --}}
</body>
</html>
