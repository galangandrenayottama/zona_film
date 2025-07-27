<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zona Film - Detail Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    {{-- Sisipkan CSRF Token untuk keamanan request AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Poppins, sans-serif;
            background-color: #000;
            color: #fff;
        }
        .navbar-custom {
            background-color: #000;
            border-bottom: 3px solid #ff8000;
            padding: 15px 0;
        }
        .navbar-custom nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar-custom nav a:hover {
            color: #ff8000;
        }
        .text-accent {
            color: #ff8000;
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
        .video-container {
            position: relative;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            margin-bottom: 30px;
        }
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(102, 146, 255, 0.5);
        }
        .tag {
            background-color: #6692ff;
            color: white;
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 20px;
            margin-right: 10px;
            display: inline-block;
        }
        .footer {
            background-color: #000;
            color: #aaa;
            padding: 20px;
            text-align: center;
            margin-top: 4rem;
        }
        .comment-box {
            background-color: #111;
            border-radius: 10px;
            padding: 20px;
            margin-top: 40px;
        }
        .comment {
            background-color: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #333;
            flex-shrink: 0;
        }
        .comment-content {
            flex-grow: 1;
        }
        .comment-meta {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
        }
        .comment-actions a {
            font-size: 0.75rem;
            color: #888;
            text-decoration: none;
            margin-left: 10px;
        }
        .comment-actions a:hover {
            color: #ff8000;
        }
        .form-control {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
        }
        .form-control:focus {
            background-color: #222;
            color: #fff;
            border-color: #ff8000;
            box-shadow: none;
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

    <main>
        <section class="container py-5">
            <h1 class="mb-3" id="movie-title">Memuat Judul Film...</h1>
            <div class="video-container" id="video-container">
                <!-- Video player akan dimuat di sini -->
            </div>
            <div class="mb-3" id="genre-tags">
                <!-- Genre tags akan dimuat di sini -->
            </div>
            <p id="movie-description">Memuat deskripsi...</p>
            <a href="{{ url('home') }}" class="btn btn-orange mt-3">Kembali ke Beranda</a>

            <div class="comment-box mt-5">
                <h4 class="mb-3">💬 Komentar</h4>
                <div id="comment-list">
                    <!-- Daftar komentar akan dimuat di sini -->
                </div>

                @auth
                <form id="comment-form" class="mt-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="comment-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill m-auto d-block" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">Anda berkomentar sebagai: <strong>{{ Auth::user()->name }}</strong></p>
                            <textarea id="message" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                            <button type="submit" class="btn btn-orange mt-2">Kirim Komentar</button>
                        </div>
                    </div>
                </form>
                @endauth

                @guest
                <div class="alert alert-info mt-4">
                    Login dulu untuk berkomentar. <a href="{{ route('login') }}" class="alert-link">Klik di sini untuk login</a>.
                </div>
                @endguest
            </div>
        </section>
    </main>

    <footer class="footer">&copy; 2025 Zona Film. All rights reserved.</footer>

    <script>
        // ===================================================================
        // KONFIGURASI DAN VARIABEL GLOBAL
        // ===================================================================
        const movieId = {{ $movieId }};
        const apiKey = "0e42928a67f895b7127e69c7f8da106f";
        const baseUrl = "https://api.themoviedb.org/3";
        const cdnBaseUrl = "http://127.0.0.1:8000/storage/movies/"; // Ganti dengan URL CDN Anda
        const videoFilename = `${movieId}.mp4`;
        const fullVideoUrl = `${cdnBaseUrl}${videoFilename}`;
        const authUserId = {{ Auth::id() ?? 'null' }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ===================================================================
        // FUNGSI-FUNGSI UTAMA
        // ===================================================================

        /**
         * Mengambil dan menampilkan daftar komentar dari server.
         */
        async function fetchComments() {
            try {
                const response = await fetch(`/comments/${movieId}`);
                const comments = await response.json();
                const commentList = document.getElementById("comment-list");
                commentList.innerHTML = ""; // Kosongkan daftar sebelum diisi ulang

                comments.forEach((comment) => {
                    const commentDiv = document.createElement("div");
                    commentDiv.className = "comment";
                    commentDiv.id = `comment-${comment.id}`;
                    const commentDate = new Date(comment.created_at).toLocaleDateString("id-ID", {
                        day: 'numeric', month: 'long', year: 'numeric'
                    });

                    const actions = (authUserId && authUserId === comment.user_id) ? `
                        <div class="comment-actions">
                            <a href="#" class="edit-comment-btn" data-comment-id="${comment.id}">Edit</a>
                            <a href="#" class="delete-comment-btn" data-comment-id="${comment.id}">Hapus</a>
                        </div>
                    ` : '';

                    commentDiv.innerHTML = `
                        <div class="comment-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill m-auto d-block" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                        </div>
                        <div class="comment-content flex-grow-1">
                            <strong>${comment.user.name}</strong>
                            <p class="mb-0 comment-message">${comment.message}</p>
                            <div class="comment-meta">${commentDate}</div>
                        </div>
                        ${actions}
                    `;
                    commentList.appendChild(commentDiv);
                });
            } catch (error) {
                console.error("Gagal mengambil komentar:", error);
            }
        }

        /**
         * Mengirim data ke server untuk mencatat riwayat tontonan.
         * @param {object} movieData - Objek data film dari TMDB.
         */
        async function addToHistory(movieData) {
            @auth
                try {
            // Panggil rute API yang benar untuk menyimpan
                    await fetch("{{ route('api.watch_history.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            tmdb_id: movieData.id,
                            movie_title: movieData.title,
                            poster_url: `https://image.tmdb.org/t/p/w200${movieData.poster_path}`,
                        }),
                    });
                } catch (error) {
                    console.error('Gagal menambahkan ke riwayat:', error);
                }
            @endauth
}

        // ===================================================================
        // PEMUATAN DATA AWAL
        // ===================================================================

        // Mengambil detail film dari TMDB dan menampilkannya di halaman
        fetch(`${baseUrl}/movie/${movieId}?api_key=${apiKey}&language=id-ID`)
            .then((response) => response.json())
            .then((movie) => {
                document.title = `Zona Film - ${movie.title}`;
                document.getElementById("movie-title").innerText = movie.title;
                
                const videoContainer = document.getElementById("video-container");
                videoContainer.innerHTML = `<video controls controlsList="nodownload" poster="https://image.tmdb.org/t/p/w780${movie.poster_path}"><source src="${fullVideoUrl}" type="video/mp4" />Browser Anda tidak mendukung tag video.</video>`;
                
                const genreContainer = document.getElementById("genre-tags");
                movie.genres.forEach((genre) => {
                    genreContainer.innerHTML += `<span class="tag">${genre.name}</span>`;
                });

                document.getElementById("movie-description").innerText = movie.overview;

                // <<< PERUBAHAN DI SINI >>>
                // Setelah detail film berhasil didapat, panggil fungsi untuk mencatatnya sebagai riwayat.
                addToHistory(movie);
            })
            .catch((err) => {
                console.error("Gagal mengambil data film:", err);
                document.getElementById("movie-title").innerText = "Film Tidak Ditemukan";
                document.getElementById("movie-description").innerText = "Maaf, terjadi kesalahan saat memuat detail film.";
            });

        // Panggil fungsi untuk memuat komentar saat halaman siap
        document.addEventListener("DOMContentLoaded", fetchComments);

        // ===================================================================
        // EVENT LISTENERS
        // ===================================================================

        // ... sisa event listener Anda untuk komentar, dll. ...
        const commentForm = document.getElementById("comment-form");
        if (commentForm) {
            commentForm.addEventListener("submit", async function (e) {
                e.preventDefault();
                const messageInput = document.getElementById("message");
                const message = messageInput.value.trim();
                
                if (message) {
                    try {
                        const response = await fetch('/comments', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ movie_id: movieId, message: message })
                        });
                        if (response.ok) {
                            messageInput.value = '';
                            fetchComments();
                        } else {
                            alert('Gagal mengirim komentar. Status: ' + response.status);
                        }
                    } catch (error) {
                        console.error('Error saat mengirim komentar:', error);
                        alert('Terjadi kesalahan koneksi.');
                    }
                }
            });
        }

        document.getElementById('comment-list').addEventListener('click', async function(e) {
            e.preventDefault();
            const target = e.target;
            const commentId = target.dataset.commentId;

            if (target.classList.contains('delete-comment-btn')) {
                if (confirm('Anda yakin ingin menghapus komentar ini?')) {
                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken }
                        });
                        if (response.ok) {
                            document.getElementById(`comment-${commentId}`).remove();
                        } else {
                            alert('Gagal menghapus komentar. Status: ' + response.status);
                        }
                    } catch (error) {
                        console.error('Error menghapus komentar:', error);
                    }
                }
            }

            if (target.classList.contains('edit-comment-btn')) {
                const commentDiv = document.getElementById(`comment-${commentId}`);
                const messageP = commentDiv.querySelector('.comment-message');
                const originalMessage = messageP.textContent;
                messageP.innerHTML = `
                    <textarea class="form-control edit-textarea" rows="2">${originalMessage}</textarea>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-orange save-edit-btn" data-comment-id="${commentId}">Simpan</button>
                        <button class="btn btn-sm btn-secondary cancel-edit-btn">Batal</button>
                    </div>
                `;
            }

            if (target.classList.contains('save-edit-btn')) {
                const commentDiv = document.getElementById(`comment-${commentId}`);
                const newText = commentDiv.querySelector('.edit-textarea').value.trim();
                if (newText) {
                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ message: newText })
                        });
                        if (response.ok) {
                            fetchComments();
                        } else {
                            alert('Gagal menyimpan perubahan. Status: ' + response.status);
                        }
                    } catch (error) {
                        console.error('Error menyimpan perubahan:', error);
                    }
                }
            }

            if (target.classList.contains('cancel-edit-btn')) {
                fetchComments();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
