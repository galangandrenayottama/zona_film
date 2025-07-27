<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Zona Film</title>
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
      <h3 class="text-center mb-4">Daftar ke Zona Film</h3>
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">No. HP</label>
          <input type="text" name="phone" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-orange w-100">Daftar</button>
      </form>

      <div class="text-center mt-3">
        <small>Sudah punya akun?</small><br />
        <a href="/login" class="btn btn-link text-info">Login di sini</a>
      </div>
    </div>
  </body>
</html>
