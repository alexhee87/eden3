@include('layouts.head')
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation" style="margin-bottom: 0">
            <!-- sidebar -->
            @include('layouts.sidebar')
        </nav>
        <div id="page-wrapper" class="gray-bg">

            <!-- header navigation-->
            <div class="row L">
            @include('layouts.header')
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <h2>@yield('breadcrumb_title')</h2>
                <div class="col-lg-10">
                    @yield('breadcrumb')
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            @include('common.message')

            <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
            </div>
        </div>
    </div>
    <div id="overlay"></div>
    <div class="modal fade" id="myModal" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
@include('layouts.foot')
