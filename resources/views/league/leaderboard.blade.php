@extends('__layouts.admin') @section('main')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
                        class="fa fa-angle-right"></i></li>
            <li><a href="{{url('/league')}}">Leagues</a> <i
                        class="fa fa-angle-right"></i></li>
            <li><a href="#.">Leaderboard</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-6 text-left">
            <h1 class="page-title">
                Men's Single League - Leaderboard
            </h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('league.show',[1])}}" class="btn btn-circle red page-title-btn">View League Details</a>
        </div>
    </div>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->


    <!-- BEGIN PROFILE CONTENT -->
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Leaderboard Stats</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- BEGIN: Actions -->
                        <div class="mt-actions">
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar1.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">Natasha Kim</span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar2.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">Gavin Bond</span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar3.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">Diana Berri</span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar4.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">John Clark</span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar5.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">Donna Clarkson </span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="{{asset("assets/img/avatar6.jpg")}}"> </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author">Tom Larson</span>
                                                <p class="mt-action-desc">Next match: 18 Dec. 2017</p>
                                            </div>
                                        </div>
                                        <div class="mt-action-datetime text-center ">
                                            Exp. Level: <strong>2.5</strong>
                                        </div>
                                        <div class="mt-action-datetime ">
                                            Matches Won: <strong>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Actions -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Upcoming Matches</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar1.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar2.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar3.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar4.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar5.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar6.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar7.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar8.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar9.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar10.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="row league-match">
                            <div class="col-md-3">
                                <span class="match-date">13 Dec 2017</span>
                                <span class="match-court">Court 2</span>
                            </div>
                            <div class="col-md-9">
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar3.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                                <div class="match-user">
                                    <div class="user-img">
                                        <img src="{{asset("assets/img/avatar7.jpg")}}" />
                                    </div>
                                    <div class="user-name">
                                        John Barbosa
                                    </div>
                                    <div class="exp-level">Exp. Level <strong>2.5</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- END PROFILE CONTENT -->
    <!-- END PAGE CONTENT-->
@section('page-specific-scripts')
    <script src="{{asset("assets/custom/jquery.steps.min.js")}}"></script>
    <link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.min.js")}}" type="text/javascript"></script>
@endSection
@stop
