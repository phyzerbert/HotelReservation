@extends('layouts.auth')

@section('content')    
    <div class="content d-flex justify-content-center align-items-center">
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{asset('images/avatar128.png')}}" width="90" class="border-slate-300 border-3 rounded-round mb-2 mt-1" alt="">
                        <h5 class="mb-0">Login to your account</h5>
                        <span class="d-block text-muted">Enter your credential below</span>                        
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">                    
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input-styled-primary" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} data-fouc="">
                            Remember Me
                        </label>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary btn-block">Sign In <i class="icon-circle-right2 ml-2"></i></button>
                    </div>
                    {{-- @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    @endif --}}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
	<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('master/assets/js/login.js')}}"></script>
@endsection
