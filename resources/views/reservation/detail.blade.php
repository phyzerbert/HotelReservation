@extends('layouts.master')

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
                        <a href="{{url('/')}}" class="breadcrumb-item"><i class="icon-list2 mr-2"></i> Reservations</a>
                        <span class="breadcrumb-item active">Detail</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="container content">
            <form action="{{route('reservation.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$reservation->id}}" />
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="text-uppercase font-size-sm font-weight-semibold">Visitor Information</span>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="visitor_name" class="form-control" value="{{$reservation->visitor_name}}" placeholder="Visitor Name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address: <span class="text-danger">*</span></label>
                                    <input type="email" name="visitor_email" class="form-control" value="{{$reservation->visitor_email}}" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number:</label>
                                    <input type="text" name="visitor_phone_number" class="form-control" value="{{$reservation->visitor_phone_number}}" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Visit Date:</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input type="text" name="visit_date" class="form-control pickadate" value="{{$reservation->visit_date}}" placeholder="Visit Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Id Number: <span class="text-danger">*</span></label>
                                    <input type="text" name="id_number" class="form-control" value="{{$reservation->id_number}}" placeholder="Id Number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Passport Id: <span class="text-danger">*</span></label>
                                    <input type="text" name="passport_id" class="form-control" value="{{$reservation->passport_id}}" placeholder="Passport Id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-block">Passport Image:</label>
                                    <input name="passport_image" type="file" class="form-input-styled" accept="image/*" data-fouc>
                                    <span class="form-text text-muted">Accepted formats: pdf, doc. Max file size 2Mb</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Companions --}}
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="text-uppercase font-size-sm font-weight-semibold">Companions</span>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="companion_pad">
                            @foreach ($companions as $item)
                                <input type="hidden" name="companion_id[]" value="{{$item->id}}">
                                <div class="col-md-4 companion_name">
                                    <div class="form-group">
                                        <label>Name: <span class="text-danger">*</span></label>
                                        <input type="text" name="companion_name[]" value="{{$item->name}}" placeholder="Companion Name" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-md-4 companion_id_number">
                                    <div class="form-group">
                                        <label>Id Number:</label>
                                        <input type="text" name="companion_id_number[]" value="{{$item->id_number}}" placeholder="Companion Id Number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 companion_phone_number">
                                    <div class="form-group">
                                        <label>Phone Number:</label>
                                        <input type="text" name="companion_phone_number[]" value="{{$item->phone_number}}" placeholder="Companion Phone Number" class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="btn-group float-right mb-2">
                            <button type="button" id="btn-add-companion" class="btn bg-teal-400"><i class="icon-plus-circle2"></i></button>
                            <button type="button" id="btn-remove-companion" class="btn btn-info"><i class="icon-minus-circle2"></i></button>
                        </div> --}}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="text-uppercase font-size-sm font-weight-semibold">Hotel Information</span>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hotel Name: <span class="text-danger">*</span></label>
                                    <select name="hotel_id" placeholder="Hotel Name" class="form-control required">
                                        <option value="" hidden >Select a Hotel</option>
                                        @foreach ($hotels as $item)
                                            <option value="{{$item->id}}" @if($reservation->hotel_id == $item->id) selected @endif data-type="{{$item->room_type}}" data-rooms="{{$item->number_of_rooms}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room Type: </label>
                                    <select name="room_type" class="form-control" id="form_room_type">
                                        <option value="0" @if($reservation->room_type == 0) selected @endif>Room</option>
                                        <option value="1" @if($reservation->room_type == 1) selected @endif>Suite</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Number Of Rooms: <span class="text-danger">*</span></label>
                                    <input type="number" name="number_of_rooms" class="form-control" id="form_number_of_rooms" value="{{$reservation->number_of_rooms}}" placeholder="Number Of Rooms">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Check In Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input type="text" name="check_in_date" class="form-control pickadate" value="{{$reservation->check_in_date}}" placeholder="Check In Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Check Out Date:</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input type="text" name="check_out_date" class="form-control pickadate" value="{{$reservation->check_out_date}}" placeholder="Check Out Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note:</label>
                                    <textarea name="note" cols="30" rows="5" class="form-control">{{$reservation->note}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{route('reservation.index')}}" class="btn btn-info text-white">Back <i class="icon-undo2 ml-2"></i></a>
                            <a href="#" class="btn btn-success text-white btn-reply">Reply <i class="icon-checkmark4 ml-2"></i></a>
                            <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </div>     
            </form>
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
                        <input type="hidden" name="id" class="id" value="{{$reservation->id}}">
                        <div class="form-group">
                            <label class="control-label">Visitor Name</label>
                            <input class="form-control visitor" type="text" name="visitor" value="{{$reservation->id}}" readonly placeholder="Visitor Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hotel Name</label>
                            <input class="form-control hotel" type="text" name="hotel" value="{{$reservation->hotel->name}}" readonly placeholder="Hotel Name">
                        </div>
                        @php
                            if($role == 'general_manager'){
                                $status = $reservation->gm_satus;
                            }else if($role == 'office_manager'){
                                $status = $reservation->om_satus;
                            }
                        @endphp
                        <div class="form-group">
                            <label class="control-label">Status:</label>
                            <select class="form-control status" name="status">
                                <option value="0" @if($status == 0) selected @endif>Pending</option>
                                <option value="1" @if($status == 1) selected @endif>Reject</option>
                                <option value="2" @if($status == 2) selected @endif>Accept</option>
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

<!-- Theme JS files -->
<script src="{{asset('master/global_assets/js/plugins/forms/wizards/steps.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/forms/inputs/inputmask.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/extensions/cookie.js')}}"></script>

<script src="{{asset('master/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{asset('master/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>


<script src="{{asset('js/reservation.js')}}"></script>

<script>
    $(document).ready(function () {
        $("#btn-add-companion").click(function(){
            $("#companion_pad").append(`
                <div class="col-md-4 companion_name">
                    <div class="form-group">
                        <label>Name: <span class="text-danger">*</span></label>
                        <input type="text" name="companion_name[]" placeholder="Companion Name" class="form-control required">
                    </div>
                </div>
                <div class="col-md-4 companion_id_number">
                    <div class="form-group">
                        <label>Id Number:</label>
                        <input type="text" name="companion_id_number[]" placeholder="Companion Id Number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 companion_phone_number">
                    <div class="form-group">
                        <label>Phone Number:</label>
                        <input type="text" name="companion_phone_number[]" placeholder="Companion Phone Number" class="form-control">
                    </div>
                </div>
            `);
        });

        $("#btn-remove-companion").click(function(){
            $("#companion_pad .companion_phone_number:last-child").remove();
            $("#companion_pad .companion_id_number:last-child").remove();
            $("#companion_pad .companion_name:last-child").remove();
        });

        $('input.pickadate').daterangepicker({ 
            singleDatePicker: true,
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD',
                direction: 'rtl'
            }
        });

        $(".btn-reply").click(function(e){
            e.preventDefault(); 
            $("#replyModal").modal();
        });
    });
</script>
@endsection
