@extends('layouts.app')

@section('content')

<!-- Main Slider -->
<section class="main-slider negative-margin">
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="{{ asset('images/main-slider/1.jpg') }}" data-saveperformance="off" data-title="Awesome Title Here">
                    <img src="{{ asset('images/main-slider/2.jpg') }}" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                </li>
            </ul>
            <div class="tp-bannertimer"></div>
        </div>
    </div>
</section>

<!-- Featured Services -->
<section class="featured-services" style="padding-top:10px;margin-bottom:5px;padding-bottom:5px;">
    <div class="auto-container">
        <div class="sec-title text-center" style="margin-bottom:5px;">
            <h2 style="color:#ff304d;">MESSAGE</h2>
        </div>

        <div class="row clearfix">
            <div class="featured-service-column col-md-4 col-md-offset-4" style="background:#79dfff;padding-top:10px;">
                <div class="inner-box wow fadeIn" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <figure class="image-box">
                        <img src="{{ asset('images/Jabbar.jpeg') }}" alt="">
                    </figure>
                    <div class="lower-content text-center">
                        <h3 style="font-size:14px;font-weight:bold;">Rana Abdul Jabbar</h3>
                        <div class="text" style="font-size:14px;font-weight:bold;">
                            INSPECTORS GENERAL OF POLICE<br>AJ&K
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" style="background-image:url('{{ asset('images/background/image-2.jpg') }}');">
    <div class="auto-container">
        <div class="sec-title light text-center">
            <h1>Our Service</h1>
        </div>

        <div class="row clearfix">
            <div class="default-service-block col-md-3 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <a href="https://trafficpolice.ajk.gov.pk/VerifyLicense/">
                        <img src="{{ asset('images/services/license-1-150x150.png') }}">
                        <h3>License Verification</h3>
                    </a>
                </div>
            </div>

            <div class="default-service-block col-md-3 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <img src="{{ asset('images/services/license-150x150.png') }}">
                    <h3>License Procedure</h3>
                </div>
            </div>

            <div class="default-service-block col-md-3 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <img src="{{ asset('images/services/traffic-education1-150x150.jpg') }}">
                    <h3>Traffic Education</h3>
                </div>
            </div>

            <div class="default-service-block col-md-3 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <img src="{{ asset('images/services/1-150x150.jpg') }}">
                    <h3>Traffic Sign</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="default-section">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="column text-column col-md-6 col-sm-12 col-xs-12">
                <div class="inner-box">
                    <div class="title-box">
                        <h2>ABOUT US</h2>
                    </div>
                    <div class="text aboutus-text">
                        <p>
                            In exercise of the power conferred by sections 22, 43, 68, 69, 70, 74, 96, of the Azad Jammu and Kashmir Motor Vehicles Ordinance, rolex replica for sale 1971 the Azad Government of the State of Jammu and Kashmir is pleased to make the following rules, namely
                        </p>
                    </div>
                    <div class="link-box"><a href="#" class="theme-btn btn-style-one">Find More</a></div>
                </div>
            </div>
            <div class="column col-md-6 col-sm-12 col-xs-12">
                <div class="inner-box">
                    <img src="{{ asset('images/aboutus.jpg') }}" style="width:100%;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="default-section">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="column col-md-12">
                <div class="inner-box">
                    <div class="title-box"><h2>Gallery</h2></div>
                    <div class="row">
                        @foreach([1,2,3,4] as $img)
                        <div class="col-md-3">
                            <figure class="image">
                                <a href="{{ asset("images/gallery/$img.jpg") }}" class="lightbox-image">
                                    <img src="{{ asset("images/gallery/$img.jpg") }}" alt="">
                                </a>
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
