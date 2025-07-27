<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Tontonan - Zona Film</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        .container h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #f0f0f0;
        }
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 3rem;
        }
        .history-card {
            background-color: #1b1b1b;
            display: flex;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(255, 128, 0, 0.2);
            transition: background 0.3s ease;
            cursor: pointer;
        }
        .history-card a {
            display: flex;
            text-decoration: none;
            color: inherit;
            flex-grow: 1;
        }
        .history-card img {
            width: 180px;
            object-fit: cover;
        }
        .history-info {
            padding: 1rem;
            flex-grow: 1;
        }
        .history-info h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #ff8000;
        }
        .history-info p {
            font-size: 0.9rem;
            color: #ccc;
        }
        .history-actions {
            display: flex;
            align-items: center;
            padding: 1rem;
        }
        .history-actions button {
            background: transparent;
            border: none;
            color: #ff5555;
            font-size: 1.2rem;
            cursor: pointer;
        }
        body {
            background-color: #0f0f0f;
            color: white;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Histori Tontonan</h2>
        <div class="history-list" id="historyList">
            <p>Memuat histori tontonan...</p>
        </div>

        <h2>Rekomendasi Acak</h2>
        <div class="history-list" id="randomList">
            <p>Memuat rekomendasi...</p>
        </div>
    </div>

    <input type="hidden" id="movieDetailRouteTemplate" value="{{ route('movie.detail', ['id' => '__MOVIE_ID__']) }}">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const apiKey = "0e42928a67f895b7127e69c7f8da106f";
            const historyList = document.getElementById("historyList");
            const randomList = document.getElementById("randomList");
            const movieDetailRouteTemplate = document.getElementById('movieDetailRouteTemplate').value;

            // Fungsi untuk memuat histori tontonan dari backend
            async function fetchWatchHistory() {
                try {
                    // --- PERBAIKAN DI SINI ---
                    // Objek konfigurasi (termasuk headers) harus menjadi argumen kedua
                    // dan berada di dalam kurung kurawal.
                    const response = await fetch("{{ route('api.watch_history.index') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (!response.ok) {
                        if (response.status === 401) {
                            historyList.innerHTML = `<p class="text-warning">Anda perlu login untuk melihat histori tontonan.</p>`;
                        } else {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        // Hentikan eksekusi jika response tidak ok
                        return;
                    }

                    const historyData = await response.json();

                    historyList.innerHTML = ""; // Bersihkan placeholder
                    if (historyData.length > 0) {
                        historyData.forEach((item) => {
                            const div = document.createElement("div");
                            div.className = "history-card";
                            // Gunakan template URL dan ganti placeholder dengan tmdb_id
                            const detailUrl = movieDetailRouteTemplate.replace('__MOVIE_ID__', String(item.tmdb_id));
                            div.innerHTML = `
                                <a href="${detailUrl}">
                                    <img src="${item.poster_url}" alt="${item.movie_title}">
                                    <div class="history-info">
                                        <h3>${item.movie_title}</h3>
                                        <p>Ditonton pada: ${new Date(item.watched_at).toLocaleString('id-ID')}</p>
                                    </div>
                                </a>
                                <div class="history-actions">
                                    <button data-id="${item.id}" onclick="hapusItem(this)">&times;</button>
                                </div>
                            `;
                            historyList.appendChild(div);
                        });
                    } else {
                        historyList.innerHTML = `<p>Belum ada histori tontonan.</p>`;
                    }
                } catch (error) {
                    console.error("Gagal mengambil histori tontonan:", error);
                    historyList.innerHTML = `<p class="text-danger">Gagal memuat histori tontonan. (${error.message})</p>`;
                }
            }

            // Fungsi hapus (perlu didefinisikan di scope global agar bisa dipanggil dari onclick)
            window.hapusItem = async function(button) {
                const id = button.getAttribute('data-id');
                if (!confirm('Apakah Anda yakin ingin menghapus item ini dari riwayat?')) {
                    return;
                }
                
                try {
                    const response = await fetch(`/api/watch-history/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Gagal menghapus item.');
                    }
                    
                    // Hapus elemen dari tampilan setelah berhasil
                    button.closest('.history-card').remove();

                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message);
                }
            }

            async function fetchRandomRecommendations() {
                try {
                    const page = Math.floor(Math.random() * 10) + 1;
                    const response = await fetch(
                        `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=id-ID&page=${page}`
                    );
                    const data = await response.json();

                    randomList.innerHTML = "";
                    if (data.results && data.results.length > 0) {
                        data.results.slice(0, 3).forEach((movie) => {
                            const posterUrl = movie.poster_path
                                ? `https://image.tmdb.org/t/p/w200${movie.poster_path}`
                                : "https://via.placeholder.com/200x300?text=No+Image";

                            const card = document.createElement("div");
                            card.className = "history-card";
                            const detailUrl = movieDetailRouteTemplate.replace('__MOVIE_ID__', String(movie.id));
                            card.innerHTML = `
                                <a href="${detailUrl}">
                                    <img src="${posterUrl}" alt="${movie.title}">
                                    <div class="history-info">
                                        <h3>${movie.title}</h3>
                                        <p>Rating: ${movie.vote_average}</p>
                                    </div>
                                </a>
                            `;
                            randomList.appendChild(card);
                        });
                    } else {
                        randomList.innerHTML = `<p>Tidak dapat memuat rekomendasi.</p>`;
                    }
                } catch (err) {
                    console.error("Gagal mengambil rekomendasi film:", err);
                    randomList.innerHTML = `<p class="text-danger">Gagal memuat rekomendasi.</p>`;
                }
            }

            fetchWatchHistory();
            fetchRandomRecommendations();
        });
    </script>
</body>
</html>