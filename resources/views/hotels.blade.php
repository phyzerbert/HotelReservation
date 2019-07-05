@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Hotels</h4>
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
                        <span class="breadcrumb-item active">Hotels</span>
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
                    @if ($role == 'general_manager')
                        <button type="button" class="btn btn-primary float-right" id="btn-add"><i class="icon-plus-circle2 mr-2"></i> Add New</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width:30px;">#</th>
                                    <th>Name</th>
                                    <th>Stars</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Number Of Rooms</th>
                                    <th>Room Type</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="stars" data-id="{{$item->stars}}">
                                            @for ($i = 1; $i <= $item->stars; $i++)
                                                <img src="{{asset('images/star.png')}}" width="20" alt="">
                                            @endfor
                                        </td>
                                        <td class="city">{{$item->city}}</td>
                                        <td class="address">{{$item->address}}</td>
                                        <td class="number_of_rooms">{{$item->number_of_rooms}}</td>
                                        <td class="room_type" data-id="{{$item->room_type}}">
                                            @if (!$item->room_type)
                                                <span class="badge badge-danger">Room</span>
                                            @else
                                                <span class="badge badge-primary">Suite</span>
                                            @endif
                                        </td>
                                        <td class="py-1 action">
                                            <a href="#" class="btn bg-blue btn-icon rounded-round btn-edit" data-id="{{$item->id}}"  data-popup="tooltip" title="Edit" data-placement="top"><i class="icon-pencil7"></i></a>
                                            <a href="{{route('hotel.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="Delete" data-placement="top" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a>
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
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Hotel Information</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Stars</label>
                            <input class="form-control stars" type="text" name="stars" placeholder="Stars">
                            <span id="stars_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control city" type="text" name="city" placeholder="City">
                            <span id="city_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control address" type="text" name="address" placeholder="Address">
                            <span id="address_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Room Type</label>
                            <select class="form-control room_type" name="room_type" placeholder="Room Type">
                                <option value="0">Room</option>
                                <option value="1">Suite</option>
                            </select>
                            <span id="room_type_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Number Of Rooms</label>
                            <input class="form-control number_of_rooms" type="number" name="number_of_rooms" placeholder="Number Of Rooms">
                            <span id="number_of_rooms_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Hotel Information</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                            <span id="edit_name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Stars</label>
                            <input class="form-control stars" type="text" name="stars" placeholder="Stars">
                            <span id="edit_stars_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control city" type="text" name="city" placeholder="City">
                            <span id="edit_city_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control address" type="text" name="address" placeholder="Address">
                            <span id="edit_address_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Room Type</label>
                            <select class="form-control room_type" name="room_type" placeholder="Room Type">
                                <option value="0">Room</option>
                                <option value="1">Suite</option>
                            </select>
                            <span id="edit_room_type_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Number Of Rooms</label>
                            <input class="form-control number_of_rooms" type="number" name="number_of_rooms" placeholder="Number Of Rooms">
                            <span id="edit_number_of_rooms_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        
        $("#btn-add").click(function(){
            $("#create_form input.form-control").val('');
            $("#create_form .invalid-feedback strong").text('');
            $("#addModal").modal();
        });

        $("#btn_create").click(function(){          
            $.ajax({
                url: "{{route('hotel.create')}}",
                type: 'post',
                dataType: 'json',
                data: $('#create_form').serialize(),
                success : function(data) {
                    if(data == 'success') {
                        alert('Created successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#name_error').show();
                            $('#create_form .name').focus();
                        }
                        
                        if(messages.stars) {
                            $('#stars_error strong').text(data.responseJSON.errors.stars[0]);
                            $('#stars_error').show();
                            $('#create_form .stars').focus();
                        }
                        
                        if(messages.city) {
                            $('#city_error strong').text(data.responseJSON.errors.city[0]);
                            $('#city_error').show();
                            $('#create_form .city').focus();
                        }
                        
                        if(messages.address) {
                            $('#address_error strong').text(data.responseJSON.errors.address[0]);
                            $('#address_error').show();
                            $('#create_form .stars').focus();
                        }
                        
                        if(messages.room_type) {
                            $('#room_type_error strong').text(data.responseJSON.errors.room_type[0]);
                            $('#room_type_error').show();
                            $('#create_form .room_type').focus();
                        }
                        
                        if(messages.number_of_rooms) {
                            $('#number_of_rooms_error strong').text(data.responseJSON.errors.number_of_rooms[0]);
                            $('#number_of_rooms_error').show();
                            $('#create_form .number_of_rooms').focus();
                        }
                    }
                }
            });
        });

        $(".btn-edit").click(function(){
            let id = $(this).attr("data-id");
            let name = $(this).parents('tr').find(".name").text().trim();
            let stars = $(this).parents('tr').find(".stars").data('id');
            let city = $(this).parents('tr').find(".city").text().trim();
            let address = $(this).parents('tr').find(".address").text().trim();
            let room_type = $(this).parents('tr').find(".room_type").data('id');
            let number_of_rooms = $(this).parents('tr').find(".number_of_rooms").text().trim();

            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .name").val(name);
            $("#editModal .stars").val(stars);
            $("#editModal .city").val(city);
            $("#editModal .address").val(address);
            $("#editModal .room_type").val(room_type);
            $("#editModal .number_of_rooms").val(number_of_rooms);

            $("#editModal").modal();
        });

        $("#btn_update").click(function(){
            $.ajax({
                url: "{{route('hotel.edit')}}",
                type: 'post',
                dataType: 'json',
                data: $('#edit_form').serialize(),
                success : function(data) {
                    console.log(data);
                    if(data == 'success') {
                        alert('Updated successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#edit_name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#edit_name_error').show();
                            $('#edit_form .name').focus();
                        }
                        
                        if(messages.stars) {
                            $('#edit_stars_error strong').text(data.responseJSON.errors.stars[0]);
                            $('#edit_stars_error').show();
                            $('#edit_form .stars').focus();
                        }
                        
                        if(messages.city) {
                            $('#edit_city_error strong').text(data.responseJSON.errors.city[0]);
                            $('#edit_city_error').show();
                            $('#edit_form .city').focus();
                        }
                        
                        if(messages.address) {
                            $('#edit_address_error strong').text(data.responseJSON.errors.address[0]);
                            $('#edit_address_error').show();
                            $('#edit_form .stars').focus();
                        }
                        
                        if(messages.room_type) {
                            $('#edit_room_type_error strong').text(data.responseJSON.errors.room_type[0]);
                            $('#edit_room_type_error').show();
                            $('#edit_form .room_type').focus();
                        }
                        
                        if(messages.number_of_rooms) {
                            $('#edit_number_of_rooms_error strong').text(data.responseJSON.errors.number_of_rooms[0]);
                            $('#edit_number_of_rooms_error').show();
                            $('#edit_form .number_of_rooms').focus();
                        }
                    }
                }
            });
        });

    });
</script>
@endsection
