<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran - Zona Film</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: "Poppins", sans-serif;
        background-color: #0f0f0f;
        color: #fff;
      }
      nav {
        background-color: #000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        position: sticky;
        top: 0;
        z-index: 100;
      }
      nav .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ff8000;
        text-decoration: none;
      }
      nav ul {
        list-style: none;
        display: flex;
        gap: 1.5rem;
      }
      nav ul li a {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
      }
      nav ul li a:hover {
        color: #ff8000;
      }
      .hero {
        text-align: center;
        padding: 4rem 1rem 2rem;
        background-color: #111;
      }
      .hero h2 {
        color: #ff8000;
        font-size: 2rem;
        margin-bottom: 0.5rem;
      }
      .hero p {
        color: #ccc;
      }
      .container {
        max-width: 600px;
        margin: auto;
        padding: 2rem 1rem;
      }
      form {
        background-color: #1a1a1a;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
      }
      label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
      }
      select,
      input[type="text"] {
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        background-color: #333;
        color: #fff;
      }
      .input-group {
        display: flex;
        align-items: center;
      }
      .input-group span {
        background-color: #444;
        padding: 0.75rem;
        border-radius: 8px 0 0 8px;
        color: #fff;
      }
      .input-group input {
        border-radius: 0 8px 8px 0;
        border-left: none;
      }
      .hidden {
        display: none;
      }
      .info-box {
        background-color: #222;
        padding: 1rem;
        border-radius: 8px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1rem;
      }
      .checkbox-container {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
      }
      .checkbox-container input {
        margin-right: 0.5rem;
      }
      .btn {
        width: 100%;
        padding: 0.9rem;
        background-color: #ff8000;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
      }
      .btn:hover {
        background-color: #e67100;
      }
      footer {
        text-align: center;
        color: #888;
        padding: 2rem 0;
        font-size: 0.9rem;
      }
      a {
        color: #6692ff;
        text-decoration: none;
      }
      a:hover {
        text-decoration: underline;
      }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
      <a href="#" class="logo">🎬 Zona Film</a>
    </nav>

    <!-- Hero -->
    <section class="hero">
      <h2>Pembayaran</h2>
      <p>Konfigurasikan metode pembayaran kamu</p>
    </section>

    <!-- Payment Form -->
    <section>
      <div class="container">
        <form action="{{ route('pembayaran.process') }}" method="POST">
          
          <!-- PERBAIKAN: Tambahkan CSRF Token di sini -->
          @csrf

          <!-- Metode Pembayaran -->
          <label for="metode">Pilih Metode Pembayaran</label>
          <select id="metode" name="metode" required>
            <option value="">-- Pilih --</option>
            <option value="ovo">OVO</option>
            <option value="dana">DANA</option>
            <option value="gopay">GoPay</option>
            <option value="virtual">Virtual Account</option>
            <option value="shopeepay">ShopeePay</option>
          </select>

          <!-- Nomor HP -->
          <div class="hidden" id="phoneSection">
            <label for="nomor">Nomor Ponsel</label>
            <div class="input-group">
              <span>+62</span>
              <input
                type="text"
                id="nomor"
                name="nomor"
                placeholder="Masukkan nomor ponsel"
                pattern="[0-9]{9,13}"
                title="Nomor HP harus terdiri dari 9-13 digit angka"
              />
            </div>
          </div>

          <!-- Virtual Account -->
          <div class="hidden" id="vaSection">
            <p>
              Gunakan nomor Virtual Account berikut untuk melakukan pembayaran:
            </p>
            <div class="info-box">1234 5678 9012 3456</div>
            <p class="text-muted">
              VA ini berlaku selama 24 jam. Lanjutkan pembayaran melalui
              m-banking atau ATM.
            </p>
          </div>

          <!-- Info Paket Dinamis -->
          @php
            $packageName = $package['package_name'] ?? 'Belum Dipilih';
            $packagePrice = $package['price'] ?? 0;
          @endphp

          <p>
            <strong>Rp {{ number_format($packagePrice, 0, ',', '.') }}/bulan</strong><br />
            Paket:
            <span style="color: #6692ff; font-weight: bold">{{ $packageName }}</span>
            <a href="{{ route('paket') }}">Ubah</a>
          </p>

          <!-- Persetujuan -->
          <p class="text-muted">
            Dengan mencentang kotak di bawah ini, berarti kamu menyetujui
            <a href="#">Ketentuan Penggunaan</a> dan
            <a href="#">Kebijakan Privasi</a> kami.
          </p>
          <div class="checkbox-container">
            <input type="checkbox" id="agree" name="agree" required />
            <label for="agree">Saya setuju</label>
          </div>

          <!-- Tombol Submit -->
          <button type="submit" class="btn">Subscribe Now</button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer>&copy; 2025 Zona Film. All rights reserved.</footer>

    <script>
      const metodeSelect = document.getElementById("metode");
      const phoneSection = document.getElementById("phoneSection");
      const vaSection = document.getElementById("vaSection");

      metodeSelect.addEventListener("change", function () {
        const selected = this.value;
        if (selected === "virtual") {
          vaSection.classList.remove("hidden");
          phoneSection.classList.add("hidden");
        } else if (selected) {
          phoneSection.classList.remove("hidden");
          vaSection.classList.add("hidden");
        } else {
          phoneSection.classList.add("hidden");
          vaSection.classList.add("hidden");
        }
      });
    </script>
</body>
</html>
