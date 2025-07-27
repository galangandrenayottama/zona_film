<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran Berhasil</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap");

      :root {
        --primary: #6692ff;
        --accent: #ff8000;
        --dark: #0f0f0f;
        --light: #ffffff;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Poppins", sans-serif;
        background-color: var(--dark);
        color: var(--light);
        line-height: 1.6;
      }

      header {
        background-color: var(--dark);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--accent);
      }

      .logo {
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--accent);
      }

      nav a {
        color: var(--light);
        margin-left: 1.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
      }

      nav a:hover {
        color: var(--primary);
      }

      .payment-success {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        min-height: 80vh;
        background: linear-gradient(120deg, #1a1a1a, #0d0d0d);
      }

      .success-box {
        background: #1b1b1b;
        border: 2px solid var(--primary);
        border-radius: 12px;
        padding: 2.5rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 0 25px rgba(102, 146, 255, 0.2);
      }

      .icon-check {
        font-size: 3.5rem;
        color: #2ecc71;
        margin-bottom: 1rem;
      }

      .success-box h2 {
        margin-bottom: 0.75rem;
        color: var(--primary);
        font-size: 1.8rem;
        font-weight: 700;
      }

      .success-box p {
        margin-bottom: 1rem;
        color: #dddddd;
      }

      .success-box code {
        background-color: #333;
        padding: 0.3rem 0.5rem;
        border-radius: 5px;
        font-size: 0.95rem;
        color: var(--accent);
      }

      .success-box .btn {
        display: inline-block;
        background-color: var(--accent);
        color: var(--light);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1rem;
        transition: background 0.3s ease;
      }

      .success-box .btn:hover {
        background-color: #e47400;
      }

      footer {
        text-align: center;
        padding: 1rem;
        background: var(--dark);
        color: #aaa;
        font-size: 0.9rem;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="logo">Zona Film</div>
      <nav>
        <a href="home.html">Home</a>
        <a href="playlist.html">Playlist</a>
        <a href="riwayat.html">Riwayat</a>
      </nav>
    </header>

    <section class="payment-success">
      <div class="success-box">
        <div class="icon-check">✔️</div>
        <h2>Pembayaran Berhasil</h2>
        <p>Kamu telah membayar sebesar <strong>Rp {{ number_format($amount, 0, ',', '.') }}</strong></p>
        <p>Paket yang kamu pilih: <strong>{{ $package }}</strong></p>
        <p>ke dompet: <code>35Ew58n7obe...kJcSeF</code></p>
        <a href="{{ url('/home') }}" class="btn">Kembali Ke Beranda</a>
      </div>
    </section>

    <footer>
      <p>&copy; 2025 Zona Film - Semua hak dilindungi.</p>
    </footer>
  </body>
</html>
