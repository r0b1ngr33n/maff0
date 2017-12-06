@extends('layouts.dashboard')
@section('style')
    <style>
        span.label{
            font-size: 12px; !important;
        }
    </style>
@endsection
@section('content')

    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var $table4 = jQuery( "#table-4" );

            $table4.DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        } );
    </script>

    <table class="table table-striped table-hover table-bordered datatable" id="table-4">
        <thead>
        <tr>
            <th>Sl No</th>
            <th>Date Time</th>
            <th>Payment Type</th>
            <th>Transaction ID</th>
            <th>Payment Amount</th>
            <th>Rate</th>
            <th>Total Amount</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 0;@endphp
        @foreach($fund as $p)
            @php $i++;@endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ date('d-F-Y H:s:i A',strtotime($p->created_at)) }}</td>
                <td>
                    @if($p->payment_type == 1)
                        <span class="label label-success label-lg"><i class="fa fa-paypal"></i> Paypal</span>
                    @elseif($p->payment_type == 2)
                        <span class="label label-success label-lg"><i class="fa fa-cc-mastercard"></i> Perfect Money</span>
                    @elseif($p->payment_type == 3)
                        <span class="label label-success label-lg"><i class="fa fa-btc"></i> BTC - ( Blockchain )</span>
                    @elseif($p->payment_type == 4)
                        <span class="label label-success label-lg"><i class="fa fa-credit-card"></i> Credit Card</span>
                    @endif
                </td>
                <td>
                    # {{ $p->transaction_id }}
                </td>
                <td>{{ $p->amount }} - USD</td>
                <td width="13%">1 USD = {{ $p->rate }} - {{ $basic->currency }}</td>
                <td>{{ $p->total }} - {{ $basic->currency }}</td>
                <td>
                    @if($p->status == 0)
                        <span class="label label-secondary"><i class="fa fa-spinner"></i> Pending</span>
                    @elseif($p->status == 1)
                        <span class="label label-success"><i class="fa fa-check"></i> Success</span>
                    @elseif($p->status == 2)
                        <span class="label label-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Refunded</span>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-exclamation-triangle'></i> Confirmation..!</h4>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Delete this.?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('delete-news') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">

                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Yes I'm Sure..!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>




@endsection
@section('scripts')

    <script>
        $(document).ready(function () {

            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                $(".abir_id").val(id);

            });

        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.css') }}">

    <script src="{{ asset('assets/dashboard/js/datatables.js') }}"></script>

@endsection