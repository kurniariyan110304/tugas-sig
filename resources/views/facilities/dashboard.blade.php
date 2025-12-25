@extends('layouts.app')

@section('title', 'Dashboard Peta Fasilitas Umum')

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="header-title">
            <i class="fas fa-map-marked-alt me-2"></i>
            Dashboard Peta Fasilitas Umum
        </h1>

        <div class="header-actions">
            <a href="{{ route('facilities.create') }}"><button class="btn btn-primary">Tambah Data</button></a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $facilities->count() }}</h3>
                    <p>Total Fasilitas</p>
                </div>
                <div class="stat-icon text-primary">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-success">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $facilities->where('type', 'sekolah')->count() }}</h3>
                    <p>Sekolah</p>
                </div>
                <div class="stat-icon text-success">
                    <i class="fas fa-school"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-danger">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $facilities->where('type', 'rumah_sakit')->count() }}</h3>
                    <p>Rumah Sakit</p>
                </div>
                <div class="stat-icon text-danger">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-card-warning">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $facilities->where('type', 'tempat_ibadah')->count() }}</h3>
                    <p>Tempat Ibadah</p>
                </div>
                <div class="stat-icon text-warning">
                    <i class="fas fa-place-of-worship"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Facilities Table -->
    @if ($facilities->count() > 0)
        <div class="table-responsive">
            <table id="facilitiesTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Koordinat</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facilities as $index => $facility)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $facility->name }}</td>
                            <td>{{ $facility->type_label }}</td>
                            <td>
                                {{ number_format($facility->latitude, 6) }},
                                {{ number_format($facility->longitude, 6) }}
                            </td>
                            <td>{{ $facility->address ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('facilities.destroy', $facility) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3 class="empty-state-title">Belum Ada Fasilitas</h3>
            <p class="empty-state-description">
                Mulai dengan menambahkan fasilitas pertama Anda. Klik tombol "Tambah Baru" di atas
                atau klik langsung pada peta untuk memilih lokasi.
            </p>
            <a href="{{ route('facilities.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i> Tambah Fasilitas Pertama
            </a>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#facilitiesTable').DataTable({
                responsive: true,
                paging: true,
                pagingType: "simple_numbers",
                pageLength: 15,
                lengthChange: false,
                ordering: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        next: "›",
                        previous: "‹"
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [5]
                    } // kolom Aksi tidak bisa sort
                ]
            });

            // Konfirmasi hapus
            $('.delete-btn').on('click', function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus data?',
                    text: 'Data yang dihapus tidak bisa dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
