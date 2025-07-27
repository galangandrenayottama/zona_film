<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- 
      PENTING: Anda harus memastikan server Anda menyisipkan token CSRF yang benar di sini.
      Ini adalah cara untuk melindungi dari serangan CSRF saat menggunakan JavaScript.
    -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Playlist Saya - Zona Film</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6692ff;
            --accent: #ff8000;
            --dark: #0f0f0f;
            --light: #ffffff;
        }
        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--dark);
            color: var(--light);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .playlist-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 2rem;
        }
        .playlist-container h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--primary);
            font-weight: 700;
        }
        .playlist-form {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .playlist-form input {
            padding: 0.75rem;
            border-radius: 8px;
            border: none;
            width: 60%;
            font-size: 1rem;
            background-color: #1c1c1c;
            color: var(--light);
        }
        .playlist-form button {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            background: var(--accent);
            color: var(--light);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        .playlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        .playlist-item {
            background: #1b1b1b;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .playlist-item a {
            text-decoration: none;
        }
        .playlist-item:hover {
            transform: scale(1.03);
            box-shadow: 0 0 10px rgba(255, 128, 0, 0.3);
        }
        .playlist-item img {
            width: 100%;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .playlist-item h3 {
            font-size: 1rem;
            color: var(--accent);
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .playlist-item button {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 0.4rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 0.5rem;
        }
        .playlist-item button:hover {
            background: var(--accent);
            color: #fff;
        }
    </style>
</head>
<body>

    <main>
        <section class="playlist-container">
            <h2>Playlist Saya</h2>
            <form class="playlist-form" id="playlistForm">
                <input type="text" id="movieTitle" placeholder="Masukkan judul film..." required />
                <button type="submit">Tambah</button>
            </form>
            <div class="playlist-grid" id="playlist">
                <!-- Data playlist akan dimuat di sini oleh JavaScript -->
                <p class="text-center" style="grid-column: 1 / -1;">Memuat playlist...</p>
            </div>
        </section>
    </main>

    <script>
        // Fungsi untuk menghapus item playlist dari DOM dan server
        async function removePlaylistItem(buttonElement) {
            const tmdbId = buttonElement.dataset.id;
            if (!confirm("Anda yakin ingin menghapus film ini dari playlist?")) {
                return;
            }

            try {
                const url = `/playlist/${tmdbId}`; // URL endpoint untuk hapus
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json",
                    }
                });

                if (response.ok) {
                    document.getElementById(`movie-${tmdbId}`).remove();
                    // Cek jika grid menjadi kosong setelah item dihapus
                    if (document.querySelectorAll('.playlist-item').length === 0) {
                        document.getElementById('playlist').innerHTML = '<p class="text-center" style="grid-column: 1 / -1;">Playlist Anda masih kosong.</p>';
                    }
                } else {
                    const errorData = await response.json();
                    alert("Gagal menghapus film: " + (errorData.message || "Terjadi kesalahan."));
                }
            } catch (error) {
                console.error("Error saat menghapus item:", error);
                alert("Terjadi kesalahan koneksi saat menghapus film.");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const apiKey = "0e42928a67f895b7127e69c7f8da106f";
            const form = document.getElementById("playlistForm");
            const input = document.getElementById("movieTitle");
            const grid = document.getElementById("playlist");

            // Fungsi untuk membuat elemen HTML untuk satu film
            function createMovieElement(movie) {
                const item = document.createElement("div");
                item.classList.add("playlist-item");
                item.id = `movie-${movie.tmdb_id}`;
                const detailUrl = `/movie/${movie.tmdb_id}`;

                item.innerHTML = `
                    <a href="${detailUrl}">
                        <img src="${movie.poster_url}" alt="${movie.title}">
                        <h3>${movie.title}</h3>
                    </a>
                    <button data-id="${movie.tmdb_id}" onclick="removePlaylistItem(this)">Hapus</button>
                `;
                return item;
            }

            // Fungsi untuk memuat data playlist awal dari server
            async function loadInitialPlaylist() {
                try {
                    // Anda perlu membuat rute ini di web.php: Route::get('/playlist/data', [PlaylistController::class, 'fetchData']);
                    const response = await fetch('/playlist/data'); 
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const playlists = await response.json();
                    
                    grid.innerHTML = ''; // Kosongkan pesan "Memuat..."
                    if (playlists.length > 0) {
                        playlists.forEach(movie => {
                            grid.appendChild(createMovieElement(movie));
                        });
                    } else {
                        grid.innerHTML = '<p class="text-center" style="grid-column: 1 / -1;">Playlist Anda masih kosong.</p>';
                    }
                } catch (error) {
                    console.error("Gagal memuat playlist:", error);
                    grid.innerHTML = '<p class="text-center" style="color: #ff8000; grid-column: 1 / -1;">Gagal memuat playlist. Pastikan Anda sudah login.</p>';
                }
            }

            // Panggil fungsi untuk memuat data saat halaman dibuka
            loadInitialPlaylist();

            // Event listener untuk form penambahan playlist
            form.addEventListener("submit", async function(e) {
                e.preventDefault();
                const title = input.value.trim();
                if (!title) return;

                try {
                    const searchUrl = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&query=${encodeURIComponent(title)}`;
                    const res = await fetch(searchUrl);
                    const data = await res.json();

                    if (!data.results || data.results.length === 0) {
                        alert("Film tidak ditemukan.");
                        return;
                    }

                    const movie = data.results[0];
                    const posterUrl = movie.poster_path ? `https://image.tmdb.org/t/p/w500${movie.poster_path}` : "https://via.placeholder.com/300x170?text=No+Image";
                    
                    const storeUrl = "/playlist";
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const response = await fetch(storeUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json",
                        },
                        body: JSON.stringify({
                            title: movie.title,
                            poster_url: posterUrl,
                            tmdb_id: String(movie.id),
                        }),
                    });
                    
                    const responseData = await response.json();

                    if (response.ok) {
                        const emptyMessage = grid.querySelector('p');
                        if (emptyMessage) emptyMessage.remove();
                        
                        grid.appendChild(createMovieElement(responseData.playlist));
                        input.value = "";
                    } else {
                        alert(responseData.message || "Gagal menambahkan film.");
                    }
                } catch (err) {
                    console.error("Terjadi kesalahan:", err);
                    alert("Gagal mengambil atau menyimpan data film.");
                }
            });
        });
    </script>
</body>
</html>
