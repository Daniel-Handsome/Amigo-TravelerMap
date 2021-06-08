@extends('layouts.amigo')

@section('title')
  @parent
  旅人簽到
@endsection

@section('nav')
  {{-- <div class="position-fixed w-100 text-center h1">
    <a class="logo text-secondary" href="/">Amigo</a>
  </div> --}}
@endsection

@section('css')
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Megrim&display=swap" rel="stylesheet">
  <style>
    body {
      /* background-color: #9ad3bc; */
      background: url('images/sign-in.png') no-repeat center center;
      background-size: cover;
    }

    .container {
      height: 100vh;
    }

    i {
      transform: rotate(-15deg);
    }

    .logo {
      font-family: 'Megrim', cursive !important;
      text-decoration: none;
    }

  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-10 col-sm-8 col-md-6 col-lg-5">
        <div class="card">
          {{-- <div class="card-body text-center h2 mb-0">
            <div>
              <span>Hola!</span>
            </div>
          </div> --}}
          <hr class="my-0" />
          <div class="card-body p-4">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              {{-- 輸入信箱欄位 --}}
              <div class="form-outline mb-4">
                <input id="login-form__email" type="email" class="form-control @error('email') is-invalid @enderror"
                  name="email" value="{{ old('email') }}" required autofocus />
                <label class="form-label" for="login-form__email">
                  <i class="fas fa-fw fa-envelope me-1"></i>
                  Email
                </label>
                @error('email')
                  <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
              {{-- 輸入密碼欄位 --}}
              <div class="form-outline mb-4">
                <input id="login-form__password" type="password"
                  class="form-control @error('password') is-invalid @enderror" name="password" required />
                <label class="form-label" for="login-form__password">
                  <i class="fas fa-fw fa-key me-1"></i>
                  Password
                </label>
                @error('password')
                  <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
              {{-- 記住我 --}}
              <div class="row mb-4">
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                    <label class="form-check-label" for="form1Example3">
                      <small>給我記住</small>
                    </label>
                  </div>
                </div>

                <div class="col-6 text-end">
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                      <small>我忘記密碼了！</small>
                    </a>
                  @endif
                </div>

                <div class="col-12 text-end">
                  <a href="{{ route('sign-up') }}">
                    <small>先註冊一個帳號</small>
                  </a>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-block">登入</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
