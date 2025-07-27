<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Zona Film</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <style>
      body {
        font-family: Poppins, sans-serif;
        background-color: #000;
        color: #fff;
      }

      .container {
        margin-top: 100px;
        max-width: 400px;
      }

      .btn-orange {
        background-color: #ff8000;
        border: none;
        color: #fff;
        font-weight: bold;
      }

      .btn-orange:hover {
        background-color: #e67300;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h3 class="text-center mb-4">Login ke Zona Film</h3>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required autofocus />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi</label>
          <input type="password" class="form-control" name="password" required />
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" name="remember" id="remember">
          <label class="form-check-label" for="remember">Ingat Saya</label>
        </div>
        <button type="submit" class="btn btn-orange w-100">Login</button>
      </form>

      <div class="text-center mt-3">
        <small>Belum punya akun?</small><br />
        <a href="/register" class="btn btn-link text-info">Daftar di sini</a>
      </div>
    </div>
  </body>
</html>
