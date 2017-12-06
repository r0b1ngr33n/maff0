@extends('layouts.user')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/cus.css') }}">
    <style>
        .btn{
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-user"></i> User Details</strong></div>

                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="well well-lg">
                        <div class="profile-header-container">
                            <div class="profile-header-img">
                                <img class="img-circle" src="{{ asset('assets/images') }}/{{ $member->image }}" />
                                <!-- badge -->
                                <div class="rank-label-container">
                                    <span class="label label-default rank-label">{{ $member->amount }} - {{ $basic->currency }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="profile-body text-center">
                            <h3>{{ $member->name }}</h3>
                            <h4> E-Mail : {{ $member->email }}</h4>
                            <h4> Phone : {{ $member->phone }}</h4>
                            <h4> Address : {{ $member->address }}</h4>
                            <h4> Reference ID : <span style="color: #fff;font-size: 13px;" class="label label-danger">{{ $member->reference }}</span></h4>
                            <h4> Reference Account : {{ $total_reference_user }} - Account</h4>
                            <button style="margin-top: 10px;" class="btn has btn-info btn-block btn-icon icon-left" data-clipboard-text="{{ $member->reference }}">
                                <i class="fa fa-clipboard" aria-hidden="true"></i>  Copy Reference ID
                            </button>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <a href="{{ route('user-edit') }}" class="btn btn-info btn-icon icon-left btn-block"><i class="fa fa-edit"></i> Edit User</a>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <a href="{{ route('user-password') }}" class="btn btn-danger btn-icon icon-left btn-block"><i class="fa fa-bolt"></i> Change Password</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-danger btn-icon icon-left btn-block"><i class="fa fa-sign-out"></i> User Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-12">
            <div class="panel panel-info" data-collapsed="0">

                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-cloud-upload"></i> Last Deposit Status</strong></div>

                </div>

                <!-- panel body -->
                <div class="panel-body">
                    <table class="table table-striped table-hover table-bordered datatable" id="table-4">
                        <thead>
                        <tr>
                            <th>Date Time</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Profit Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 0;@endphp
                        @foreach($last_deposit as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ date('d M y - H:s A',strtotime($p->created_at)) }}</td>
                                <td><span class="aaaa"><strong>{{ $p->plan->name }}</strong></span></td>
                                <td>{{ $p->amount }} - USD</td>
                                <td>
                                    <div class="row">
                                        @php $rep = \App\Repeat::whereDeposit_id($p->id)->first() @endphp
                                        @php $wid = (100*$rep->rebeat) /$p->time  @endphp
                                        <div class="col-xs-12 col-sm-10 col-sm-offset-1 progress-container">
                                            @if($wid == 0)
                                                <div class="progress progress-striped">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        <span style="color: green"><strong>Not Start Yet.</strong></span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="progress progress-striped active">
                                                    <div class="progress-bar bar{{ $i }} progress-bar-success" style="width:0%"><span>{{ round($wid) }}% Complete</span></div>
                                                </div>
                                            @endif
                                        </div>
                                        <script>
                                            $('.bar{{ $i }}').animate({
                                                width: '{{ $wid }}%'
                                            }, 2500);
                                        </script>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <a style="margin-bottom: 0px;" href="{{ route('deposit-history') }}" class="btn btn-info btn-block btn-icon icon-left">
                                <i class="fa fa-cloud-upload"></i> All Deposit History
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a style="margin-bottom: 0px;" href="{{ route('repeat-history') }}" class="btn btn-info btn-block btn-icon icon-left">
                                <i class="fa fa-reply-all"></i> All Rebet History
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info" data-collapsed="0">

                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-cloud-upload"></i> User Activity</strong></div>

                </div>
                <!-- panel body -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">

                            <div class="tile-stats tile-red">
                                <div class="icon"><i class="fa fa-money"></i></div>
                                <div class="num" data-start="0" data-end="{{ $member->amount }}" data-postfix="" data-duration="1500" data-delay="0">{{ $member->amount }}</div>
                                <h3>Total Balance</h3>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">

                            <div class="tile-stats tile-green">
                                <div class="icon"><i class="fa fa-cloud-upload"></i></div>
                                <div class="num" data-start="0" data-end="{{ $total_deposit }}" data-postfix="" data-duration="1500" data-delay="0">0</div>
                                <h3>Total Deposit</h3>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">

                            <div class="tile-stats tile-red">
                                <div class="icon"><i class="fa fa-reply-all"></i></div>
                                <div class="num" data-start="0" data-end="{{ $total_rebeat }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                                <h3>Total Profit</h3>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">

                            <div class="tile-stats tile-blue">
                                <div class="icon"><i class="entypo-credit-card"></i></div>
                                <div class="num" data-start="0" data-end="{{ $total_reference }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                                <h3>Reference Bonus</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info" data-collapsed="0">

                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-cloud-upload"></i> User Deposit Activity</strong></div>

                </div>
                <!-- panel body -->
                <div class="panel-body">
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-list"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_deposit_time }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Deposit Time</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-arrows-ccw"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_deposit_pending }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Deposit Pending</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-green">
                            <div class="icon"><i class="entypo-check"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_deposit_complete }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Deposit Complete</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-credit-card"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_deposit }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Total Deposit</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success" data-collapsed="0">

                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><strong><i class="fa fa-cloud-upload"></i> User Withdraw Activity</strong></div>
                </div>
                <!-- panel body -->
                <div class="panel-body">
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-list"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_withdraw_time }}" data-postfix="" data-duration="1500" data-delay="0">0</div>
                            <h3>Request Time</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-arrows-ccw"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_withdraw_pending }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Withdraw Pending</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-green">
                            <div class="icon"><i class="entypo-check"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_withdraw_complete }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Withdraw Complete</h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">

                        <div class="tile-stats tile-red">
                            <div class="icon"><i class="entypo-credit-card"></i></div>
                            <div class="num" data-start="0" data-end="{{ $total_withdraw }}" data-postfix="" data-duration="1500" data-delay="0">0</div>

                            <h3>Total Withdraw</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/dashboard/js/clipboard.min.js') }}"></script>
    <script>
        new Clipboard('.has');
    </script>
@endsection