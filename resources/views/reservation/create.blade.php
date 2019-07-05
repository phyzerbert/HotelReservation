@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Reservations - Create</h4>
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
                        <a href="{{route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="{{route('reservation.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Reservations</a>
                        <span class="breadcrumb-item active">Create Reservation</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="container content">
            <div class="card">
                <div class="card-header bg-white header-elements-inline">
                    <h6 class="card-title">Add Reservation</h6>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <form class="wizard-form steps-validation" action="{{route('reservation.save')}}" method="POST" id="create_reservation_form" enctype="multipart/form-data" data-fouc>
                    @csrf
                    <h6>Visitor Information</h6>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="visitor_name" class="form-control" placeholder="Visitor Name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address: <span class="text-danger">*</span></label>
                                    <input type="email" name="visitor_email" class="form-control" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number:</label>
                                    <input type="text" name="visitor_phone_number" class="form-control" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Visit Date:</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input type="text" name="visit_date" class="form-control pickadate" value="{{date('Y-m-d')}}" placeholder="Visit Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Id Number: <span class="text-danger">*</span></label>
                                    <input type="text" name="id_number" class="form-control" placeholder="Id Number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Passport Id: <span class="text-danger">*</span></label>
                                    <input type="text" name="passport_id" class="form-control" placeholder="Passport Id">
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
                    </fieldset>

                    <h6>Companions</h6>
                    <fieldset>
                        <div class="row" id="companion_pad">
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
                        </div>
                        <div class="btn-group float-right mb-2">
                            <button type="button" id="btn-add-companion" class="btn bg-teal-400"><i class="icon-plus-circle2"></i></button>
                            <button type="button" id="btn-remove-companion" class="btn btn-info"><i class="icon-minus-circle2"></i></button>
                        </div>
                    </fieldset>

                    <h6>Hotel Information</h6>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hotel Name: <span class="text-danger">*</span></label>
                                    <select name="hotel_id" placeholder="Hotel Name" class="form-control required">
                                        <option value="" hidden >Select a Hotel</option>
                                        @foreach ($hotels as $item)
                                            <option value="{{$item->id}}" data-type="{{$item->room_type}}" data-rooms="{{$item->number_of_rooms}}">{{$item->name}}</option>
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
                                        <option value="0">Room</option>
                                        <option value="1">Suite</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Number Of Rooms: <span class="text-danger">*</span></label>
                                    <input type="number" name="number_of_rooms" class="form-control" id="form_number_of_rooms" placeholder="Number Of Rooms">
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
                                        <input type="text" name="check_in_date" class="form-control pickadate" value="{{date('Y-m-d')}}" placeholder="Check In Date">
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
                                        <input type="text" name="check_out_date" class="form-control pickadate" value="{{date('Y-m-d')}}" placeholder="Check Out Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note:</label>
                                    <textarea name="note" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
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
    });
</script>
@endsection
