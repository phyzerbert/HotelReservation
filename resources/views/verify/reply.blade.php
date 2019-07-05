@extends('layouts.auth')

@section('content')    
    <div class="content d-flex justify-content-center align-items-center">
        <div class="card mb-0">
            <div class="">
                <img src="{{asset('images/hotel_inside.jpg')}}" width="350" class="m-0" alt="">
            </div>  
            @if ($item->hotel_status == 0)
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h5 class="mb-0">Pleae confirm to the reservation.</h5>
                        <span class="d-block text-muted">You can use this link only once.</span> 
                        @if(session('success') != "")
                            <span class="form-text text-danger" role="alert">
                                <strong>{{ session('success') }}</strong>
                            </span>
                        @endif      
                    </div>

                    <div class="form-group mt-3 text-center text-light">
                        <a href="{{route('hotel_reply', [$item->id, 2])}}" class="btn btn-primary mr-3">Accept <i class="icon-checkmark4 ml-2"></i></a>
                        <a href="{{route('hotel_reply', [$item->id, 1])}}" class="btn btn-danger" onclick="return window.confirm('Are you sure?')">Reject <i class="icon-cross2 ml-2"></i></a>
                    </div>
                </div>
            @else
                <div class="card-body">
                    <div class="text-center text-warning my-3">
                        <h5 class="mb-0">You have already replied for this request.</h5>     
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')

@endsection
