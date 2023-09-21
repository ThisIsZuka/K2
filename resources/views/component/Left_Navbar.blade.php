<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<header class="topbar topbar_custom" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="{{ url('/') }}">
                <b class="logo-icon text-center">
                    <img src={{ asset('images/management-k2.png') }} alt="homepage" class="dark-logo ufound-Navbar-Logo" />
                </b>
            </a>

            <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

            <div class="container text-center text-white">
                <h2><i class="fa-solid fa-bug-slash"></i> K2 SUPPORT</h2>
            </div>
        </div>

    </nav>
</header>


<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item">
                    <a class="{{ Request::is('/') ? 'sidebar-link waves-effect waves-dark sidebar-link active' : 'sidebar-link waves-effect waves-dark sidebar-link' }}"
                        aria-expanded="false" href="{{ url('/cancelContract') }}">
                        <i class="me-1 far fa-solid fa-file-prescription" aria-hidden="true"></i>
                        <span class="hide-menu">Gen หนังสือบอกเลิกสัญญา</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="{{ Request::is('/PAYCOLLECT_PENALTY') ? 'sidebar-link waves-effect waves-dark sidebar-link active' : 'sidebar-link waves-effect waves-dark sidebar-link' }}" aria-expanded="false"
                        href="{{ url('/PAYCOLLECT_PENALTY') }}">
                        <i class="me-1 fa fa-table" aria-hidden="true"></i>
                        <span class="hide-menu">เอาค่าปรับ / ค่าติดตามออก</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="{{ Request::is('/discount') ? 'sidebar-link waves-effect waves-dark sidebar-link active' : 'sidebar-link waves-effect waves-dark sidebar-link' }}" aria-expanded="false"
                        href="{{ url('/discount') }}">
                        <i class="me-1 fa-solid fa-tags" aria-hidden="true"></i>
                        <span class="hide-menu">เพิ่มส่วนลด</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"
                        href="{{ url('/profile') }}">
                        <i class="me-3 fa fa-user" aria-hidden="true"></i>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li> --}}
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

