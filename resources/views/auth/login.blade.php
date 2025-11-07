
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5">

  <div class="brand-logo text-center mb-3">
    <img src="{{ asset('assets/A/logo.png') }}" alt="logo" style="width:150px;height:80px;object-fit:contain;">
  </div>

  <h4 class="text-center">Hello! Let's get started</h4>
  <h6 class="fw-light text-center mb-4">Sign in to continue.</h6>

  {{-- ALERTAS --}}
  @if (session('error'))
    <div class="alert alert-danger text-center" role="alert">
      {{ session('error') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger text-center" role="alert">
      @foreach ($errors->all() as $error)
        {{ $error }}<br>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="pt-3">
    @csrf
    <div class="form-group">
      <input id="email" type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" required autofocus>
    </div>
    <br>
    
    <div class="form-group">
      <input id="password" type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" required>
    </div>
    <div class="mt-3 d-grid gap-2">
      <button type="submit" class="btn btn-primary btn-lg btn-block">SIGN IN</button>
    </div>
  </form>
</div>

        </div>
      </div>
    </div>
  </div>
</div>

