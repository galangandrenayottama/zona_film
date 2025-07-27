{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zona Film - Streaming Film Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

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

      .navbar-custom {
        background-color: var(--dark);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid var(--accent);
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

      .text-accent {
        color: var(--accent);
      }

      .text-primary-custom {
        color: var(--primary);
      }

      .btn-accent {
        background-color: var(--accent);
        color: #fff;
        border: none;
      }

      .btn-accent:hover {
        background-color: #e67300;
      }

      .btn-primary {
        background-color: var(--primary);
        border: none;
      }

      .btn-primary:hover {
        background-color: #4a7ee5;
      }

      .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("https://image.tmdb.org/t/p/original/8rpDcsfLJypbO6vREc0547VKqEv.jpg") center/cover;
        background-attachment: fixed;
        text-align: center;
        padding: 5rem 2rem;
      }

      .hero h2 {
        font-size: 2.8rem;
        margin-bottom: 1rem;
        font-weight: 700;
      }

      .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: #dddddd;
      }

      .hero a.btn {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        background: var(--accent);
        color: var(--light);
        border: none;
        border-radius: 10px;
        transition: background 0.3s ease;
        font-weight: 600;
      }

      .hero a.btn:hover {
        background: #e47400;
      }

      #movies {
        padding: 3rem 2rem;
        background-color: #111;
      }

      #movies h3 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 2rem;
        color: var(--primary);
        font-weight: 700;
      }

      .card {
        background-color: #1b1b1b;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .card:hover {
        transform: scale(1.04);
        box-shadow: 0 0 15px rgba(102, 146, 255, 0.3);
      }

      .card-title {
        color: var(--accent);
        font-size: 1rem;
        font-weight: 600;
      }

      .card-text {
        font-size: 0.9rem;
        color: #cccccc;
      }

      .card button.btn-outline-success {
        background-color: #28a745;
        color: white;
        border: none;
      }

      .card button.btn-outline-success:hover {
        background-color: #218838;
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
    <header class="navbar-custom">
      <div class="container d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-accent">🎬 Zona Film</h1>
        <nav class="d-flex align-items-center">
          <a href="{{ route('home') }}" class="nav-link text-white">Home</a>
          <a href="{{ route('playlist') }}" class="nav-link text-white">Playlist</a>
          <a href="{{ route('riwayat.index') }}" class="nav-link text-white">Riwayat</a>
          <a href="{{ route('account') }}" class="nav-link text-white">Profil</a>
          <div class="ms-3">
            <select id="genre-select" class="form-select">
              <option value="">Pilih Genre</option>
              <option value="28">Aksi</option>
              <option value="12">Petualangan</option>
              <option value="16">Animasi</option>
              <option value="35">Komedi</option>
            </select>
          </div>
        </nav>
      </div>
    </header>

    <section class="hero text-center text-white py-5">
      <div class="container">
        <h2 class="display-5 mb-3 text-accent">Nonton Film Favoritmu Kapan Saja</h2>
        <p class="lead mb-4">Streaming film terbaru & terbaik dalam kualitas HD</p>
        <a href="#movies" class="btn btn-accent btn-lg">Mulai Menonton</a>
      </div>
    </section>

    <form id="search-form" class="mb-4 d-flex justify-content-center">
      <input type="text" id="search-input" class="form-control w-50 me-2" placeholder="Cari film..." />
      <button class="btn btn-primary" type="submit">Cari</button>
    </form>

    <section id="movies" class="py-5">
      <div class="container">
        <h3 class="text-center mb-4 text-primary-custom">Film Populer Saat Ini</h3>
        <div id="movie-list" class="row g-4"></div>
      </div>
    </section>

    <footer class="text-center text-secondary py-3">
      &copy; {{ date('Y') }} Zona Film. All rights reserved.
    </footer>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title text-accent" id="detailTitle">Judul Film</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <div id="detailContent" class="row g-4"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JavaScript tetap inline --}}

<script>
  const apiKey = "0e42928a67f895b7127e69c7f8da106f";
  const baseUrl = "https://api.themoviedb.org/3";
  const movieList = document.getElementById("movie-list");
  const searchForm = document.getElementById("search-form");
  const searchInput = document.getElementById("search-input");
  const genreSelect = document.getElementById("genre-select");

  getPopularMovies();

  function getPopularMovies() {
    fetch(`${baseUrl}/movie/popular?api_key=${apiKey}&language=id-ID&page=1`)
      .then((res) => res.json())
      .then((data) => displayMovies(data.results))
      .catch((err) => console.error("Gagal memuat film:", err));
  }

  function getMoviesByGenre(genreId) {
    fetch(`${baseUrl}/discover/movie?api_key=${apiKey}&with_genres=${genreId}&language=id-ID&page=1`)
      .then((res) => res.json())
      .then((data) => displayMovies(data.results))
      .catch((err) => console.error("Gagal memuat genre:", err));
  }

  function displayMovies(movies) {
    movieList.innerHTML = "";
    if (movies.length === 0) {
      movieList.innerHTML = "<p class='text-center text-muted'>Film tidak ditemukan.</p>";
      return;
    }

    movies.slice(0, 8).forEach((movie) => {
      const col = document.createElement("div");
      col.classList.add("col-md-3");
      col.innerHTML = `
          <div class="card h-100 text-white bg-dark border-0 shadow-sm">
            <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" class="card-img-top" alt="${movie.title}">
            <div class="card-body">
              <h5 class="card-title">${movie.title}</h5>
              <p class="card-text"><small>⭐ ${movie.vote_average} | 📅 ${movie.release_date}</small></p>
              <button class="btn btn-sm btn-outline-info w-100 mt-2" onclick="showDetail(${movie.id})">Detail</button>
              <button class="btn btn-sm btn-outline-success w-100 mt-2" onclick="goToDetailPage(${movie.id})">Play</button>
            </div>
          </div>`;
      movieList.appendChild(col);
    });
  }

  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const query = searchInput.value.trim();
    if (query) {
      fetch(`${baseUrl}/search/movie?api_key=${apiKey}&language=id-ID&query=${encodeURIComponent(query)}`)
        .then((res) => res.json())
        .then((data) => displayMovies(data.results))
        .catch((err) => console.error("Gagal mencari film:", err));
    }
  });

  genreSelect.addEventListener("change", () => {
    const genreId = genreSelect.value;
    genreId ? getMoviesByGenre(genreId) : getPopularMovies();
  });

  function showDetail(movieId) {
    fetch(`${baseUrl}/movie/${movieId}?api_key=${apiKey}&language=id-ID`)
      .then((res) => res.json())
      .then((movie) => {
        document.getElementById("detailTitle").textContent = movie.title;
        document.getElementById("detailContent").innerHTML = `
            <div class="col-md-4">
              <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
              <p><strong>Rilis:</strong> ${movie.release_date}</p>
              <p><strong>Rating:</strong> ${movie.vote_average}</p>
              <p>${movie.overview}</p>
            </div>`;
        new bootstrap.Modal(document.getElementById("detailModal")).show();
      })
      .catch((err) => console.error("Gagal menampilkan detail:", err));
  }

  function goToDetailPage(movieId) {
    window.location.href = `/movie/${movieId}`; // Ganti dari /detail/${movieId} menjadi /movie/${movieId}
  }
</script>
  </body>
</html>
