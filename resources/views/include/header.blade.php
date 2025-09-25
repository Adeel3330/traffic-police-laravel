<header class="main-header">

    <!-- Header Upper -->
    <div class="header-upper">
        <div class="auto-container">
            <div class="clearfix">

                <div class="pull-left logo-outer">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Traffic Police" title="Traffic Police" style="width:70px !important">
                        </a>
                    </div>
                </div>

                <div class="pull-right upper-right clearfix">

                    <!-- Info Box -->
                    <div class="upper-column info-box">
                        <div class="icon-box"><span class="flaticon-location"></span></div>
                        <ul>
                            <li><strong>Muzaffarabad</strong></li>
                            <li>CPO Azad Jammu & Kashmir, Muzaffarabad</li>
                        </ul>
                    </div>

                    <!-- Social Links -->
                    <div class="upper-column info-box">
                        <div class="social-links-one">
                            {{-- Uncomment if you want --}}
                            {{-- <a href="#"><span class="fa fa-facebook-f"></span></a>
                            <a href="#"><span class="fa fa-twitter"></span></a>
                            <a href="#"><span class="fa fa-google-plus"></span></a>
                            <a href="#"><span class="fa fa-linkedin"></span></a> --}}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Header Lower -->
    <div class="header-lower">
        <div class="bg-layer"></div>
        <div class="container-fluid">
            <div class="nav-outer clearfix">
                <!-- Main Menu -->
                <nav class="main-menu">
                    <div class="navbar-header">
                        <!-- Toggle Button -->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="navbar-collapse collapse clearfix">
                        <ul class="navigation clearfix">
                            <li class="current"><a href="{{ url('/') }}">Home</a></li>
                            <li class="dropdown"><a href="#">Services</a>
                                <ul>
                                    <li><a href="{{ route('license.form') }}">Verification</a></li>
                                    <li><a href="#">Track Application</a></li>
                                    <li><a href="#">Challan Codes</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">About Us</a>
                                <ul>
                                    <li><a href="#">License Issuance Office Locations</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">Download</a>
                                <ul>
                                    <li><a target="_blank" href="{{ asset('docs/DLMS-Application-form-front.pdf') }}">DLMS Application form (front)</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/DLMS-Application-form-back.pdf') }}">DLMS Application form (back)</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/medical-form-1.pdf') }}">Medical Form</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/CHALLAN-FORM-NEW.pdf') }}">Fee Challan Form</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/WhatsApp-Image-2021-01-15-at-12.08.05-PM.jpeg') }}">License Fee Details</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/application-for-character-certificate.pdf') }}">Character Certificate</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/Theory-test-book-for-Website-28-02-2019.pdf') }}">Theory Book for Test</a></li>
                                    <li><a target="_blank" href="{{ asset('docs/road_sings.pdf') }}">Traffic Signs</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Gallery</a></li>
                            <li><a href="#">Latest News</a></li>
                            <li><a href="#">Contact Us</a></li>
                            {{-- <li><a href="{{ route('post.store') }}">Uploads</a></li> --}}
                        </ul>
                    </div>
                </nav><!-- End Main Menu -->

                <div class="btn-outer">
                    <a href="http://trafficpolice.ajk.gov.pk/tms" style="font-size:12px;" class="theme-btn quote-btn">
                        Tenants Management System
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
