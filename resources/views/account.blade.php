<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Profil Akun - Zona Film</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: "Poppins", sans-serif; background-color: #0f0f0f; color: #ffffff; }
        .sidebar { background-color: #1c1c1c; padding: 2rem 1rem; height: 100vh; position: sticky; top: 0; display: flex; flex-direction: column; align-items: center; }
        .sidebar img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; border: 3px solid #6692ff; }
        .sidebar h5 { text-align: center; margin-bottom: 2rem; }
        .sidebar .nav-link { display: block; width: 100%; text-align: left; color: #fff; padding: 0.6rem 1rem; margin-bottom: 0.6rem; border-radius: 8px; text-decoration: none; transition: background 0.3s; cursor: pointer; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: #6692ff; }
        .sidebar .nav-link.text-danger { color: #dc3545; }
        .sidebar .nav-link.text-danger:hover { background-color: rgba(220, 53, 69, 0.2); }
        .sidebar .btn-logout { background-color: #ff8000; border: none; color: #fff; width: 100%; margin-top: auto; transition: background-color 0.3s; padding: 0.6rem 1rem; border-radius: 8px; }
        .sidebar .btn-logout:hover { background-color: #e67300; }
        .content-section { padding: 2rem; background-color: #1a1a1a; border-radius: 16px; margin: 2rem 1rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4); }
        input.form-control, .form-control-plaintext { background-color: #1c1c1c; border: 1px solid #444; color: #fff; }
        input.form-control:focus { border-color: #6692ff; box-shadow: none; background-color: #1c1c1c; color: #fff; }
        .form-control-plaintext { padding-left: .75rem; }
        h4 { color: #ff8000; margin-bottom: 1.5rem; }
        .btn-save { background-color: #6692ff; border: none; color: #fff; }
        .btn-save:hover { background-color: #4a7ee5; }
        .btn-danger { background-color: #dc3545; }
        .badge { font-size: 0.9rem; }
        .table { color: #fff; }
        .table th { color: #ff8000; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-3 sidebar">
                <img src="{{ $user->photo ? asset('storage/photos/' . $user->photo) : 'https://placehold.co/100x100/0f0f0f/FFF?text=' . substr($user->name, 0, 1) }}" alt="Profile" />
                <h5>Hello, <br /><strong>{{ $user->name }}</strong></h5>
                <a class="nav-link active" onclick="showSection('account')">Informasi Akun</a>
                <a class="nav-link" onclick="showSection('riwayat')">Riwayat Transaksi</a>
                <a class="nav-link" onclick="showSection('status')">Status Langganan</a>
                <a class="nav-link" onclick="showSection('berhenti')">Berhenti Berlangganan</a>
                <a href="{{ route('home') }}" class="nav-link">Kembali ke Home</a>
                <!-- Menu Hapus Akun -->
                <a class="nav-link text-danger mt-3" onclick="showSection('hapus')">Hapus Akun</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto w-100">
                    @csrf
                    <button class="btn btn-logout" type="submit">Keluar</button>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9">
                <!-- Session Messages -->
                @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger m-3">{{ session('error') }}</div>
                @endif

                <!-- Akun -->
                <section class="content-section" id="account-section">
                    <h4>Informasi Akun</h4>
                    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3"><label for="photo">Foto Profil</label><input type="file" name="photo" class="form-control" /></div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Nama</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required /></div>
                            <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required /></div>
                            <div class="col-md-6 mb-3"><label>Nomor HP</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" /></div>
                        </div>
                        <button class="btn btn-save mt-3">Simpan Perubahan</button>
                    </form>
                </section>

                <!-- Riwayat Transaksi -->
                <section class="content-section" id="riwayat-section" style="display: none">
                    <h4>Riwayat Transaksi</h4>
                    @if($subscriptions->isEmpty())
                        <p>Anda belum memiliki riwayat transaksi.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Paket</th>
                                        <th>Harga</th>
                                        <th>Metode Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $sub)
                                    <tr>
                                        <td>{{ $sub->created_at->format('d M Y') }}</td>
                                        <td>{{ $sub->package_name }}</td>
                                        <td>Rp {{ number_format($sub->price, 0, ',', '.') }}</td>
                                        <td>{{ $sub->payment_method }}</td>
                                        <td>
                                            <span class="badge {{ $sub->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($sub->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

                <!-- Status Langganan -->
                <section class="content-section" id="status-section" style="display: none">
                    <h4>Status Langganan Anda</h4>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Paket Saat Ini</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $user->current_package ?? 'Tidak Aktif' }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                            @if($user->current_package)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Berlangganan</span>
                            @endif
                        </div>
                    </div>
                     @if(!$user->current_package)
                        <a href="{{ route('paket') }}" class="btn btn-primary mt-3">Pilih Paket Sekarang</a>
                    @endif
                </section>

                <!-- Berhenti Berlangganan -->
                <section class="content-section" id="berhenti-section" style="display: none">
                    <h4>Berhenti Berlangganan</h4>
                    @if($user->current_package)
                        <p>Anda yakin ingin berhenti berlangganan paket <strong>{{ $user->current_package }}</strong>? Anda akan kehilangan akses ke semua film premium dan akan langsung dikeluarkan dari akun.</p>
                        <form action="{{ route('subscription.cancel') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin berhenti berlangganan?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">Ya, Berhenti Berlangganan</button>
                        </form>
                    @else
                        <p>Anda saat ini tidak memiliki langganan aktif.</p>
                         <a href="{{ route('paket') }}" class="btn btn-primary mt-3">Pilih Paket</a>
                    @endif
                </section>

                <!-- Hapus Akun -->
                <section class="content-section" id="hapus-section" style="display: none">
                    <h4>Hapus Akun Anda</h4>
                    <div class="alert alert-danger">
                        <strong>PERINGATAN:</strong> Tindakan ini tidak dapat diurungkan. Semua data Anda, termasuk riwayat transaksi dan playlist, akan dihapus secara permanen.
                    </div>
                    <p>Untuk melanjutkan, mohon konfirmasi dengan menekan tombol di bawah ini.</p>
                    <form id="delete-account-form" action="{{ route('account.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya Secara Permanen</button>
                    </form>
                </section>
            </main>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach((section) => {
                section.style.display = 'none';
            });
            document.getElementById(`${sectionId}-section`).style.display = 'block';
            document.querySelectorAll('.sidebar .nav-link').forEach((link) => {
                link.classList.remove('active');
            });
            const activeLink = document.querySelector(`.sidebar .nav-link[onclick="showSection('${sectionId}')"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }

        // Tambahkan event listener untuk form hapus akun
        document.getElementById('delete-account-form').addEventListener('submit', function(event) {
            const isConfirmed = confirm('APAKAH ANDA BENAR-BENAR YAKIN? Tindakan ini akan menghapus semua data Anda secara permanen.');
            
            if (isConfirmed) {
                const finalConfirmation = prompt('Untuk konfirmasi akhir, ketik "HAPUS" di bawah ini:');
                if (finalConfirmation !== 'HAPUS') {
                    alert('Konfirmasi tidak valid. Penghapusan akun dibatalkan.');
                    event.preventDefault(); 
                }
            } else {
                event.preventDefault(); 
            }
        });
    </script>
</body>
</html>
