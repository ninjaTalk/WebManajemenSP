@extends('layouts.app')
@section('content')

    <center xmlns="http://www.w3.org/1999/html">
{{--            <h5 class="text-uppercase" style="color: white"><strong>{{$data->sistemName}}</strong></h5>--}}
{{--            <h1 class="text-uppercase" style="color: white"><strong>{{$data->name}}</strong></h1>--}}
        <h5 class="text-uppercase" style="color: white"><strong>{{$data->sistemName}}</strong></h5>
        <h1 class="text-uppercase" style="color: white"><strong>{{$data->name}}</strong></h1>
        <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
                <img class="mb-3 mt-3 brand_logo" src="{{asset('admin/assets/img/login logo.png')}}"
                     alt="logo" height="150px" width="200px" >
            </div>
        </div>
    </center>

    <div class="container col-md-7 pb-3" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-5 bg-white rounded">
                    <div class="card-header"><strong style="font-size: 18px">{{ __('Login Form') }}</strong></div>
                    <div class="panel-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success m-0 p-2">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-warning m-0 p-2">
                                {{session()->get('error')}}
                            </div>
                        @endif
                    <div class="card-body">
                        <form method="POST" action="/login/admin">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('ID Pegawai') }}</label>
                                <input type="hidden" name="koperasiID" value="{{$data->id}}">
                                <div class="col-md-6">
                                    <input  type="text" class="form-control @error('idPegawai') is-invalid @enderror"
                                            name="idPegawai" value="{{ old('idPegawai') }}" required
                                            autofocus placeholder="Masukkan ID Admin">

                                    @error('idPegawai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control mb-5 @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password" placeholder="Masukkan Password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-6 offset-md-4">--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                        <label class="form-check-label" for="remember">--}}
{{--                                            {{ __('Remember Me') }}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-10 offset-md-1" >
                                    <button type="submit" class="col-md-12 pt-2 btn btn-primary">
                                        <h5><strong>{{ __('Login') }}</strong></h5>
                                    </button>

{{--                                    @if (Route::has('password.request'))--}}
{{--                                        <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                            {{ __('Forgot Your Password?') }}--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
