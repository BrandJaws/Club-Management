@extends('__layouts.admin')
@section('main')

    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body"> Widget settings form goes here</div>
                <div class="modal-footer">
                    <button type="button" class="btn blue">Save changes</button>
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                </div>
            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>

    <!-- /.modal -->

    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="#">Dashboard</a></li>
        </ul>
        <div class="page-toolbar">
            <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt"
                 data-placement="top" data-original-title="Change dashboard date range"><i class="icon-calendar"></i>&nbsp;
                <span class="uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i></div>
        </div>
    </div>

    <h1 class="page-title">
        Dashboard
        <small>reports & statistics</small>
    </h1>

    <!-- END PAGE HEADER-->

    <!-- BEGIN DASHBOARD STATS -->

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue-madison">
                <div class="visual"><i class="fa fa-facebook"></i></div>
                <div class="details">
                    <div class="number"> 1300</div>
                    <div class="desc"> Likes</div>
                </div>
                <a class="more" href="javascript:;"> View more <i class="m-icon-swapright m-icon-white"></i> </a></div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <div class="visual"><i class="fa fa-twitter"></i></div>
                <div class="details">
                    <div class="number"> 1000</div>
                    <div class="desc"> Tweets</div>
                </div>
                <a class="more" href="javascript:;"> View more <i class="m-icon-swapright m-icon-white"></i> </a></div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-flamingo">
                <div class="visual"><i class="fa fa-instagram"></i></div>
                <div class="details">
                    <div class="number"> 1200</div>
                    <div class="desc">Followers</div>
                </div>
                <a class="more" href="javascript:;"> View more <i class="m-icon-swapright m-icon-white"></i> </a></div>
        </div>
    </div>

    <!-- END DASHBOARD STATS -->

    <div class="clearfix"></div>
    <div class="row">

        <div class="col-md-12">
            @include('__partials.announcement_panel')
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="feeds-title">
                <h3>Facebook Feeds</h3>
            </div>
            <div class="dashboard-stat">
                <figure>
                    <img src="{{asset("assets/img/fbfeed.png")}}" alt="fb feed" class="img-responsive">
                </figure>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="feeds-title">
                <h3>Twitter Feeds</h3>
            </div>
            <div class="dashboard-stat">
                <figure>
                    <img src="{{asset("assets/img/twitter-feed.png")}}" alt="twitter feed" class="img-responsive">
                </figure>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="feeds-title">
                <h3>Instagram Feeds</h3>
            </div>
            <div class="dashboard-stat">

                <figure>
                    <img src="{{asset("assets/img/insta-feeds.jpg")}}" alt="Instagram feed" class="img-responsive">
                </figure>
            </div>
        </div>
    </div>
    @include('__partials.communication_announcement_js')

    <link href="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")}}" type="text/javascript"></script>

@stop