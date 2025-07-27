<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zona Film</title>
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

      .navbar {
        background-color: #6692ff;
      }

      .hero {
        background: url("https://image.tmdb.org/t/p/original/2vFuG6bWGyQUzYS9d69E5l85nIz.jpg")
          no-repeat center center/cover;
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
      }

      .hero-overlay {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 40px;
        border-radius: 15px;
      }

      .btn-orange {
        background-color: #ff8000;
        border: none;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s ease;
      }

      .btn-orange:hover {
        background-color: #e67300;
      }

      .carousel-item img {
        max-height: 450px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(255, 128, 0, 0.4);
      }

      .movie-grid img {
        border-radius: 10px;
        margin-bottom: 15px;
        transition: transform 0.3s;
      }

      .movie-grid img:hover {
        transform: scale(1.05);
      }

      .carousel-control-prev-icon,
      .carousel-control-next-icon {
        filter: invert(1);
      }

      .footer {
        background-color: #000;
        padding: 20px;
        color: #aaa;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-expand-lg navbar-dark sticky-top"
      style="background-color: #000"
    >
      <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
          <img
            src="https://cdn-icons-png.flaticon.com/512/1179/1179069.png"
            alt="Logo"
            width="30"
            height="30"
            class="me-2"
          />
          Zona Film
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarContent"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div
          class="collapse navbar-collapse justify-content-end"
          id="navbarContent"
        >
          <a href="{{ route('login') }}" class="btn btn-orange me-2">Login</a>
          <a href="{{ url('/register') }}" class="btn btn-outline-light">Daftar</a>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-overlay">
        <h1>Unlimited Movies, TV Shows & More</h1>
        <p>Watch anywhere. Cancel anytime.</p>
        <a href="{{ route('paket') }}" class="btn btn-orange btn-lg"
          >Subscribe Now</a
        >
      </div>
    </section>

    <!-- Carousel Section -->
    <section class="bg-dark py-5">
      <div class="container">
        <h2 class="text-white text-center mb-4">Featured Movies</h2>
        <div id="filmCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active text-center">
              <img
                src="https://image.tmdb.org/t/p/w780/2vFuG6bWGyQUzYS9d69E5l85nIz.jpg"
                class="img-fluid"
                alt="Moana 2"
              />
            </div>
            <div class="carousel-item text-center">
              <img
                src="https://image.tmdb.org/t/p/w780/6faYaQyiBPhqAizldJKq21mIVaE.jpg"
                class="img-fluid"
                alt="Mufasa"
              />
            </div>
            <div class="carousel-item text-center">
              <img
                src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/shOVFku8daIGRpgjTdMZBxUAvsV.jpg"
                class="img-fluid"
                alt="Hell's Kitchen"
              />
            </div>
            <div class="carousel-item text-center">
              <img
                src="https://image.tmdb.org/t/p/w780/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg"
                class="img-fluid"
                alt="Red Swan"
              />
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#filmCarousel"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#filmCarousel"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </section>

    <!-- More Movies -->
    <section class="bg-black py-5">
      <div class="container">
        <h3 class="text-white mb-4">More Movies</h3>
        <div class="row movie-grid">
          <div class="col-6 col-md-3">
            <img
              src="https://image.tmdb.org/t/p/w300/bXi6IQiQDHD00JFio5ZSZOeRSBh.jpg"
              class="img-fluid"
              alt="Movie 1"
            />
          </div>
          <div class="col-6 col-md-3">
            <img
              src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/SNEoUInCa5fAgwuEBMIMBGvkkh.jpg"
              class="img-fluid"
              alt="Movie 2"
            />
          </div>
          <div class="col-6 col-md-3">
            <img
              src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/vGXptEdgZIhPg3cGlc7e8sNPC2e.jpg"
              class="img-fluid"
              alt="Movie 3"
            />
          </div>
          <div class="col-6 col-md-3">
            <img
              src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/dmo6TYuuJgaYinXBPjrgG9mB5od.jpg"
              class="img-fluid"
              alt="Movie 4"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
      <p class="mb-0">&copy; 2025 Zona Film. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
