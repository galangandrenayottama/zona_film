<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Paket Zona Film</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <style>
      :root {
        --primary: #6692ff;
        --accent: #ff8000;
        --text-light: #ffffff;
        --bg-dark: #121212;
        --card-bg: #1e1e1e;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Poppins", sans-serif;
        background-color: var(--bg-dark);
        color: var(--text-light);
        line-height: 1.6;
      }

      header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 2rem;
        background-color: #000;
        box-shadow: 0 2px 5px rgba(255, 255, 255, 0.05);
      }

      .logo {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: 1px;
      }

      .hero {
        text-align: center;
        padding: 3rem 1rem 2rem;
      }

      .hero h2 {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
      }

      .hero p {
        color: #bbb;
        font-size: 1rem;
      }

      #movies {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1rem;
      }

      #movies h3 {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: #fff;
      }

      .packages {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
      }

      .card {
        background-color: var(--card-bg);
        border: 2px solid transparent;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.05);
      }

      .card.selected {
        border-color: var(--primary);
        box-shadow: 0 0 15px rgba(102, 146, 255, 0.3);
      }

      .checkmark {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--primary);
        color: #fff;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.3s ease;
      }

      .card.selected .checkmark {
        opacity: 1;
        transform: scale(1);
      }

      .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--accent);
      }

      .card-text {
        font-size: 1rem;
        color: #ccc;
      }

      .btn-next {
        display: inline-block;
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: bold;
        background-color: var(--accent);
        color: #fff;
        border-radius: 16px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        margin-top: 2.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(255, 128, 0, 0.4);
      }

      .btn-next:hover {
        background: linear-gradient(90deg, #ff9933, #ff8000);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 128, 0, 0.5);
      }

      .btn-next:active {
        transform: scale(0.98);
      }

      footer {
        text-align: center;
        padding: 1.5rem 1rem;
        color: #888;
        font-size: 0.9rem;
        background-color: #0d0d0d;
        margin-top: 4rem;
      }
    </style>
  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="logo">🎬 Zona Film</div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <h2>Pilih Paket yang Tepat untukmu</h2>
      <p>Sesuaikan paket dengan kebutuhan tontonan kamu</p>
    </section>

    <!-- Paket Section -->
    <section id="movies">
      <h3>Paket Langganan</h3>

      <form action="{{ route('paket.process') }}" method="POST">
        @csrf
        <input type="hidden" id="selected_package_name" name="package_name" required />
        <input type="hidden" id="selected_package_price" name="price" required />

        <div class="packages">
          <div class="card" data-name="Premium" data-price="186000">
            <div class="checkmark">✔</div>
            <h4 class="card-title">Premium</h4>
            <p class="card-text">Rp 186.000 / bulan</p>
          </div>
          <div class="card" data-name="Standar" data-price="120000">
            <div class="checkmark">✔</div>
            <h4 class="card-title">Standar</h4>
            <p class="card-text">Rp 120.000 / bulan</p>
          </div>
          <div class="card" data-name="Dasar" data-price="65000">
            <div class="checkmark">✔</div>
            <h4 class="card-title">Dasar</h4>
            <p class="card-text">Rp 65.000 / bulan</p>
          </div>
        </div>

        <div style="text-align: center">
          <button type="submit" class="btn-next">Berikutnya</button>
        </div>
      </form>
    </section>

    <!-- Footer -->
    <footer>
      <p>&copy; 2025 Zona Film - Semua hak dilindungi.</p>
    </footer>

    <!-- Script -->
    <script>
      const cards = document.querySelectorAll(".card");
      const packageNameInput = document.getElementById("selected_package_name");
      const priceInput = document.getElementById("selected_package_price");

      cards.forEach((card) => {
        card.addEventListener("click", () => {
          cards.forEach((c) => c.classList.remove("selected"));
          card.classList.add("selected");

          // Set nilai input tersembunyi
          packageNameInput.value = card.dataset.name;
          priceInput.value = card.dataset.price;
        });
      });
    </script>
  </body>
</html>
