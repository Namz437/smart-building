<!DOCTYPE html>

<!-- BEGIN: Body-->


<!-- BEGIN: Header-->
@include('layouts.header')
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
@include('layouts.sidebar')
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Table Ruangan</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <!-- Bordered table start -->
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('settingruangan.create') }}">Tambah Data Ruangan +</a>
                        <!-- Input Search -->
                <div class="input-group w-25 mt-2">
                    <span class="input-group-text">Search</span>
                    <input type="text" id="search-input" class="form-control" placeholder="Cari Ruangan..." onkeyup="searchRuangan()">
                </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    {{-- <th>Lantai</th> --}}
                                    <th>Nama Ruangan</th>
                                    <th>Deskripsi</th>
                                    <th>Ukuran</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <!-- Pesan No Data -->
                        <tr id="no-data" style="display: none;">
                            <td colspan="5" class="text-center">No data result.</td>
                        </tr>
                                @foreach ($ruangans as $data)
                                    <tr>
                                        <td>
                                            @if ($data->lantai && $data->lantai->gedung && $data->lantai->gedung->perusahaan)
                                                {{ $data->lantai->gedung->perusahaan->nama }}
                                            @elseif ($data->perusahaan)
                                                {{ $data->perusahaan->nama }}
                                            @else
                                                Tidak ada perusahaan
                                            @endif
                                        </td>
                                        {{-- <td>
                                            {{ $data->lantai ? $data->lantai->nama :  ''}}
                                        </td> --}}
                                        <td>{{ $data->nama_ruangan }}</td>
                                        <td>{{ $data->deskripsi }}</td>
                                        <td>{{ $data->ukuran }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                    data-bs-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>

                                                {{-- Edit dan Delete --}}
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('settingruangan.edit', $data->id) }}">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); 
                               if(confirm('Apakah Anda yakin ingin menghapus ruangan ini?')) 
                               document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>

                                                    <form id="delete-form-{{ $data->id }}" method="POST"
                                                        action="{{ route('settingruangan.destroy', $data->id) }}"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                    {{-- End Edit dan Delete --}}

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bordered table end -->

    </div>
</div>
</div>
<!-- END: Content-->

<!-- BEGIN: Footer-->
@include('layouts.footer')
<!-- END: Footer-->

</body>
<!-- END: Body-->
<script>
    function searchRuangan() {
        // Ambil input pencarian
        let input = document.getElementById('search-input').value.toLowerCase();
        
        // Ambil semua baris data ruangan
        let rows = document.querySelectorAll('tbody tr:not(#no-data)');
        let noData = document.getElementById('no-data');
        let found = false; // Penanda apakah ada data yang cocok

        rows.forEach(row => {
            // Ambil teks dari beberapa kolom (Perusahaan, Nama Ruangan, Deskripsi, Ukuran)
            let perusahaan = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            let namaRuangan = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            let deskripsi = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            let ukuran = row.querySelector('td:nth-child(4)').innerText.toLowerCase();

            // Cek apakah input ada di salah satu kolom
            if (perusahaan.includes(input) || namaRuangan.includes(input) || deskripsi.includes(input) || ukuran.includes(input)) {
                row.style.display = ''; // Tampilkan baris
                found = true; // Ada data yang sesuai
            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });

        // Tampilkan atau sembunyikan pesan "No data result"
        if (found) {
            noData.style.display = 'none'; // Sembunyikan pesan
        } else {
            noData.style.display = ''; // Tampilkan pesan
        }
    }
</script>

</html>
