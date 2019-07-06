@extends('layouts.master')
@section('style')    
	<link href="{{asset('master/global_assets/js/plugins/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Reservations</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Reservations</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="content">
            <div class="card">
                <div class="card-header">
                    @include('reservation.filter')
                    @if ($role == 'data_editor')
                        <a href="{{route('reservation.create')}}" class="btn btn-primary float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> Add New</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    {{-- <th>Created User</th> --}}
                                    <th>Visitor Name</th>
                                    <th>Hotel</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Office Manager Status</th>
                                    <th>General Manager Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        {{-- <td class="user">{{$item->user->name}}</td> --}}
                                        <td class="visitor_name">{{ $item->visitor_name }}</td>
                                        <td class="hotel" data-id="{{$item->hotel_id}}">{{$item->hotel->name}}</td>
                                        <td class="check_in_date">{{$item->check_in_date}}</td>
                                        <td class="check_out_date">{{$item->check_out_date}}</td>
                                        <td class="om_status" data-id="{{$item->om_status}}">
                                            @if ($item->om_status == 0)
                                                <span class="badge badge-info">Pending</span>
                                            @elseif($item->om_status == 1)
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif($item->om_status == 2)
                                                <span class="badge badge-success">Accepted</span>
                                            @endif
                                        </td>
                                        <td class="gm_status" data-id="{{$item->gm_status}}">
                                            @if ($item->gm_status == 0)
                                                <span class="badge badge-info">Pending</span>
                                            @elseif($item->gm_status == 1)
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif($item->gm_status == 2)
                                                <span class="badge badge-success">Accepted</span>
                                            @endif
                                        </td>
                                        <td class="request_date">{{date('Y-m-d', strtotime($item->created_at))}}</td>
                                        <td class="py-1 action">
                                            <a href="{{route('reservation.edit', $item->id)}}" class="btn bg-blue btn-icon rounded-round btn-edit" data-popup="tooltip" title="Detail" data-placement="top"><i class="icon-file-eye2"></i></a>
                                            @if ($role == 'data_editor') 
                                                <a href="{{route('reservation.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="Delete" data-placement="top" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
                                            @else                                              
                                                <a href="#" class="btn bg-info text-pink-800 btn-icon rounded-round ml-2 btn-reply" data-id="{{$item->id}}" data-status="@if($role=="general_manager"){{$item->gm_status}}@elseif($role == 'office_manager'){{$item->om_status}}@endif" data-popup="tooltip" title="Reply" data-placement="top"><i class="icon-reply"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-1">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="replyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reply For Request</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('reservation.reply')}}" method="post" id="reply_form">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label class="control-label">Visitor Name</label>
                            <input class="form-control visitor" type="text" name="visitor" readonly placeholder="Visitor Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hotel Name</label>
                            <input class="form-control hotel" type="text" name="hotel" readonly placeholder="Hotel Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status:</label>
                            <select class="form-control status" name="status">
                                <option value="0">Pending</option>
                                <option value="1">Reject</option>
                                <option value="2">Accept</option>
                            </select>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" id="btn_create" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
{{-- <script src="{{asset('master/global_assets/js/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script> --}}
<script>
    $(document).ready(function () {
        $(".btn-reply").click(function(){
            let om_status = $(this).parents('tr').find('.om_status').data('id');
            let gm_status = $(this).parents('tr').find('.gm_status').data('id');
            let role = "{{ $role }}";

            if(role == 'general_manager'){
                if(gm_status != "0"){
                    alert("Already replied."); return false;
                }
            }

            if(role == 'office_manager'){
                if(gm_status != "0"){
                    alert("General Manager replied already."); return false;
                }
            }

            let id = $(this).data('id');
            let visitor = $(this).parents('tr').find('.visitor_name').text().trim();
            let hotel = $(this).parents('tr').find('.hotel').data('id');
            let status = $(this).data('status');
            // alert(status);
            $("#reply_form .id").val(id);
            $("#reply_form .visitor").val(visitor);
            $("#reply_form .hotel").val(hotel);
            $("#reply_form .status").val(status);
            $("#replyModal").modal();
        });

        // $("#period").dateRangePicker({
        //     autoClose: false,
        // });

        $('.daterange-basic').daterangepicker({
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-light',
            autoApply: true, 
            locale: {
                format: 'YYYY-MM-DD',
                direction: 'rtl'
            }
        });

        $("#btn-reset").click(function(){
            $("#search_visitor_name").val('');
            $("#search_hotel_id").val('');
            $("#search_gm_status").val('');
            $("#search_om_status").val('');
            $("#period").val('');
        });
        var initial_range = "{{$period}}";
        if(initial_range == ""){            
            $("#period").val("");
        }
    });
</script>
@endsection
