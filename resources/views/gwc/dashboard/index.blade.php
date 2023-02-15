<!DOCTYPE html>
<html lang="en">
<head>
    @include('gwc.templateIncludes.head')
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed">
@include('gwc.templateIncludes.headerMobile')
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        @include('gwc.templateIncludes.leftMenu')
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            @include('gwc.templateIncludes.header')
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="kt-container ">
                    <div class="row">
                        @if (!empty($Users))
                            <div class="col-lg-4">
                                <a href="{{ url('gwc/users') }}"
                                   class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">

                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    {{ __('adminMessage.users') }}
                                                </h3>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.total') }}<span
                                                                class="badge badge-success float-right"
                                                                style="width:50px;">{{ $Users['total'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.today') }}<span
                                                                class="badge badge-info float-right"
                                                                style="width:50px;">{{ $Users['today'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastweek') }}<span
                                                                class="badge badge-warning float-right"
                                                                style="width:50px;">{{ $Users['week'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastthritydays') }}<span
                                                                class="badge badge-danger float-right"
                                                                style="width:50px;">{{ $Users['month'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if (!empty($Freelancers))
                            <div class="col-lg-4">
                                <a href="{{ url('gwc/freelancers') }}"
                                   class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">

                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    {{ __('adminMessage.freelancers') }}
                                                </h3>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.total') }}<span
                                                                class="badge badge-success float-right"
                                                                style="width:50px;">{{ $Freelancers['total'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.today') }}<span
                                                                class="badge badge-info float-right"
                                                                style="width:50px;">{{ $Freelancers['today'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastweek') }}<span
                                                                class="badge badge-warning float-right"
                                                                style="width:50px;">{{ $Freelancers['week'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastthritydays') }}<span
                                                                class="badge badge-danger float-right"
                                                                style="width:50px;">{{ $Freelancers['month'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                            @if (!empty($UserOrders))
                                <div class="col-lg-4">
                                    <a href="{{ url('gwc/orders') }}"
                                       class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                        <div class="kt-portlet__body">
                                            <div class="kt-iconbox__body">

                                                <div class="kt-iconbox__desc">
                                                    <h3 class="kt-iconbox__title">
                                                        {{ __('adminMessage.booked_services') }}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.total') }}<span
                                                                    class="badge badge-success float-right"
                                                                    style="width:50px;">{{ $UserOrders['total'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.today') }}<span
                                                                    class="badge badge-info float-right"
                                                                    style="width:50px;">{{ $UserOrders['today'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastweek') }}<span
                                                                    class="badge badge-warning float-right"
                                                                    style="width:50px;">{{ $UserOrders['week'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastthritydays') }}<span
                                                                    class="badge badge-danger float-right"
                                                                    style="width:50px;">{{ $UserOrders['month'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif


                            @if (!empty($WorkshopOrder))
                                <div class="col-lg-4">
                                    <a href="{{ url('gwc/workshop-orders') }}"
                                       class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                        <div class="kt-portlet__body">
                                            <div class="kt-iconbox__body">
                                                <div class="kt-iconbox__desc">
                                                    <h3 class="kt-iconbox__title">
                                                        {{ __('adminMessage.booked_workshops') }}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.total') }}<span
                                                                    class="badge badge-success float-right"
                                                                    style="width:50px;">{{ $WorkshopOrder['total'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.today') }}<span
                                                                    class="badge badge-info float-right"
                                                                    style="width:50px;">{{ $WorkshopOrder['today'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastweek') }}<span
                                                                    class="badge badge-warning float-right"
                                                                    style="width:50px;">{{ $WorkshopOrder['week'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastthritydays') }}<span
                                                                    class="badge badge-danger float-right"
                                                                    style="width:50px;">{{ $WorkshopOrder['month'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if (!empty($Orders))
                                <div class="col-lg-4">
                                    <a href="{{ url('gwc/orders') }}"
                                       class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                        <div class="kt-portlet__body">
                                            <div class="kt-iconbox__body">

                                                <div class="kt-iconbox__desc">
                                                    <h3 class="kt-iconbox__title">
                                                        {{ __('adminMessage.freelancer_subscriptions') }}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.total') }}<span
                                                                    class="badge badge-success float-right"
                                                                    style="width:50px;">{{ $Orders['total'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.today') }}<span
                                                                    class="badge badge-info float-right"
                                                                    style="width:50px;">{{ $Orders['today'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastweek') }}<span
                                                                    class="badge badge-warning float-right"
                                                                    style="width:50px;">{{ $Orders['week'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastthritydays') }}<span
                                                                    class="badge badge-danger float-right"
                                                                    style="width:50px;">{{ $Orders['month'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if (!empty($Categories))
                            <div class="col-lg-4">
                                <a href="{{ url('gwc/categories') }}"
                                   class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">

                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    {{ __('adminMessage.categories') }}
                                                </h3>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.total') }}<span
                                                                class="badge badge-success float-right"
                                                                style="width:50px;">{{ $Categories['total'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.today') }}<span
                                                                class="badge badge-info float-right"
                                                                style="width:50px;">{{ $Categories['today'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastweek') }}<span
                                                                class="badge badge-warning float-right"
                                                                style="width:50px;">{{ $Categories['week'] }}</span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        {{ __('adminMessage.lastthritydays') }}<span
                                                                class="badge badge-danger float-right"
                                                                style="width:50px;">{{ $Categories['month'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                            @if (!empty($FreelancerQuotations))
                                <div class="col-lg-4">
                                    <a href=""
                                       class="kt-portlet kt-iconbox kt-iconbox--animate-slow">
                                        <div class="kt-portlet__body">
                                            <div class="kt-iconbox__body">

                                                <div class="kt-iconbox__desc">
                                                    <h3 class="kt-iconbox__title">
                                                        {{ __('adminMessage.quotations') }}
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.total') }}<span
                                                                    class="badge badge-success float-right"
                                                                    style="width:50px;">{{ $FreelancerQuotations['total'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.today') }}<span
                                                                    class="badge badge-info float-right"
                                                                    style="width:50px;">{{ $FreelancerQuotations['today'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastweek') }}<span
                                                                    class="badge badge-warning float-right"
                                                                    style="width:50px;">{{ $FreelancerQuotations['week'] }}</span>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            {{ __('adminMessage.lastthritydays') }}<span
                                                                    class="badge badge-danger float-right"
                                                                    style="width:50px;">{{ $FreelancerQuotations['month'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif

                    </div>
                </div>
            </div>


            <!-- begin:: Footer -->
        @include('gwc.includes.footer')
        <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- end:: Page -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->

<!-- js files -->
@include('gwc.js.dashboard')

@if(!empty($gaAccesstoken))
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script>
        (function(w,d,s,g,js,fjs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
            js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
        }(window,document,'script'));
    </script>

    <script>
        gapi.analytics.ready(function() {
            var ids = 'ga:236997161';
            var ACCESS_TOKEN = '@php echo $gaAccesstoken; @endphp'

            gapi.analytics.auth.authorize({
                serverAuth: {
                    access_token: ACCESS_TOKEN
                }
            });

            /**
             * Create a new ViewSelector instance to be rendered inside of an
             * element with the id "view-selector-container".
             */
            var viewSelector = new gapi.analytics.ViewSelector({
                container: 'view-selector-container'
            });

            // Render the view selector to the page.
            viewSelector.execute();

            /**
             * Create a new DataChart instance with the given query parameters
             * and Google chart options. It will be rendered inside an element
             * with the id "chart-container".
             */
            var dataChart = new gapi.analytics.googleCharts.DataChart({
                query: {
                    metrics: 'ga:sessions',
                    dimensions: 'ga:date',
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday'
                },
                chart: {
                    container: 'chart-container',
                    type: 'LINE',
                    options: {
                        width: '100%'
                    }
                }
            });

            /**
             * Render the dataChart on the page whenever a new view is selected.
             */
            viewSelector.on('change', function(ids) {
                dataChart.set({query: {ids: ids}}).execute();
            });

            /**
             * Create a ViewSelector for the first view to be rendered inside of an
             * element with the id "view-selector-1-container".
             */
            var viewSelector1 = new gapi.analytics.ViewSelector({
                container: 'view-selector-1-container'
            });

            // Render both view selectors to the page.
            viewSelector1.execute();

            /**
             * Create the first DataChart for top countries over the past 30 days.
             * It will be rendered inside an element with the id "chart-1-container".
             */
            var dataChart1 = new gapi.analytics.googleCharts.DataChart({
                query: {
                    metrics: 'ga:sessions',
                    dimensions: 'ga:country',
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'max-results': 6,
                    sort: '-ga:sessions'
                },
                chart: {
                    container: 'chart-1-container',
                    type: 'PIE',
                    options: {
                        width: '100%',
                        pieHole: 4/9
                    }
                }
            });

            /**
             * Update the first dataChart when the first view selecter is changed.
             */
            viewSelector1.on('change', function(ids) {
                dataChart1.set({query: {ids: ids}}).execute();
                $('#loading').hide();
            });
        });
    </script>
@endif
</body>
</html>