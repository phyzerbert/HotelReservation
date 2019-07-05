@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Notification</h4>
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
                        <span class="breadcrumb-item active">Notification</span>
                    </div>
                </div>
            </div>
        </div>
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="content">
            <div class="card">
                <div class="navbar navbar-light navbar-expand-lg shadow-0 py-lg-2">
                    <div class="text-center d-lg-none w-100">
                        <button type="button" class="navbar-toggler w-100" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
                            <i class="icon-circle-down2"></i>
                        </button>
                    </div>

                    <div class="navbar-collapse text-center text-lg-left flex-wrap collapse" id="inbox-toolbar-toggle-single">
                        <div class="mt-3 mt-lg-0">
                            <div class="btn-group">
                                <input type="checkbox" id="select-all" class="form-input-styled" data-fouc>
                            </div>

                            <div class="btn-group ml-3 mr-lg-3">
                                <button type="button" id="top-delete-btn" class="btn btn-light"><i class="icon-bin"></i> <span class="d-none d-lg-inline-block ml-2">Delete</span></button>
                            </div>
                        </div>

                        <div class="navbar-text ml-lg-auto"><span class="font-weight-semibold">1-50</span> of <span class="font-weight-semibold">528</span></div>

                        <div class="ml-lg-3 mb-3 mb-lg-0">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-icon disabled"><i class="icon-arrow-right13"></i></button>
                                <button type="button" class="btn btn-light btn-icon"><i class="icon-arrow-left12"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /action toolbar -->


                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-inbox">
                        <tbody data-link="row" class="rowlink">
                            @foreach ($data as $item)
                                @php
                                    $posted_time = new DateTime($item->created_at);
                                    $now = new DateTime();
                                    $interval = $posted_time->diff($now);
                                    if($interval->d >= 1){
                                        $time = $interval->d. " Days";
                                    }else if($interval->h >= 1){
                                        $time = $interval->h. " Hours";
                                    }else if($interval->i >= 1){
                                        $time = $interval->i. " Mins";
                                    }else{
                                        $time = "Just Now";
                                    }                                    
                                @endphp
                                <tr class="unread">
                                    <td class="table-inbox-checkbox rowlink-skip">
                                        <input type="checkbox" data-id="{{$item->id}}" class="form-input-styled mail-check" data-fouc>
                                    </td>
                                    <td class="text-center" width="80">                                        
                                        @switch($item->type)
                                            @case("new_reservation")
                                                <span class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-new"></i></span>
                                                @break
                                            @case("om_accept")
                                                <span class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-file-check"></i></span>                                                    
                                                @break
                                            @case("gm_accept")
                                                <span class="btn bg-transparent border-info text-info rounded-round border-2 btn-icon"><i class="icon-file-check2"></i></span>
                                                @break
                                            @default
                                                <span class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon"><i class="icon-bubble-notification"></i></span>
                                        @endswitch
                                    </td>
                                    <td class="table-inbox-name">
                                        <a href="#">                                            
                                            @switch($item->type)
                                                @case("new_reservation")
                                                    <div class="letter-icon-title text-default">New Reservation</div>
                                                    @break
                                                @case("om_accept")
                                                    <div class="letter-icon-title text-default">Office Manager Accept</div>
                                                    @break
                                                @case("gm_accept")
                                                    <div class="letter-icon-title text-default">General Manager Accept</div>
                                                    @break
                                                @default
                                                    <div class="letter-icon-title text-default">New Notification</div>
                                            @endswitch 
                                        </a>
                                    </td>
                                    <td class="table-inbox-message">
                                        <span class="text-muted font-weight-normal">{{$item->content}}</span>
                                    </td>
                                    <td class="table-inbox-time w-25">
                                        {{ date('M, d H:i', strtotime($item->created_at))}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /table -->

            </div>
        </div>                
    </div>



@endsection

@section('script')
<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.form-input-styled').uniform();

        $('.table-inbox').find('tr > td:first-child').find('input[type=checkbox]').on('change', function() {
            if($(this).is(':checked')) {
                $(this).parents('tr').addClass("alpha-slate");
            }
            else {
                $(this).parents('tr').removeClass("alpha-slate");
            }
        });


        var selectedmessages = [];
        $("#select-all").change(function(){
            if(this.checked){
                $(".mail-check").prop("checked", true).uniform();
            }else{
                $(".mail-check").prop("checked", false).uniform();
            }
        })

        $("#top-delete-btn").click(function(){
            selectedmessages = [];
            $(".mail-check:checked").each(function(){
                selectedmessages.push($(this).data("id"));
            });

            if (selectedmessages.length == 0) {
                alert("Please select first.");
                return false;
            }

            if (!confirm("Are you sure?")) {
                return false;
            }
            var deletemessages = selectedmessages.join();
            console.log(deletemessages);
            $.ajax({
                url: "{{route('notification.delete')}}",
                type: "POST",
                data: {deletemessages : deletemessages},
                success: function(data){
                    if(data == 'success'){
                        alert('Deleted Successfully');
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>
@endsection
