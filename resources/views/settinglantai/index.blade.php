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
                        <h2 class="content-header-title float-start mb-0">Table Lantai</h2>
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
                        <a class="btn btn-primary" href="{{ route('settinglantai.create') }}">Tambah Data Lantai +</a>
                         <!-- Input Search -->
                        <div class="input-group w-25">
                            <span class="input-group-text">Search</span>
                            <input type="text" id="search-input" class="form-control" placeholder="Cari Lantai..." onkeyup="searchLantai()">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Lantai</th>
                                    <th>Gedung</th>
                                    <th>Deskripsi</th> 
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ini adalah elemen yang akan muncul jika tidak ada data yang ditemukan -->
                                <tr id="no-data" style="display: none;">
                                    <td colspan="4" class="text-center">No data result.</td>
                                </tr>
                                @foreach ($lantais as $data)
                                    <tr>
                                        <td>
                                            {{ $data->nama }}
                                        </td>
                                        <td>{{ $data->gedung->nama_gedung }}</td>
                                        <td>{{ $data->deskripsi }}</td>
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
                                                        href="{{ route('settinglantai.edit', $data->id) }}">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); 
                               if(confirm('Apakah Anda yakin ingin menghapus lantai ini?')) 
                               document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>

                                                    <form id="delete-form-{{ $data->id }}" method="POST"
                                                        action="{{ route('settinglantai.destroy', $data->id) }}"
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
    function searchLantai() {
        // Ambil input pencarian
        let input = document.getElementById('search-input').value.toLowerCase();
        
        // Ambil semua baris data lantai
        let rows = document.querySelectorAll('tbody tr:not(#no-data)');
        let noData = document.getElementById('no-data');
        let found = false; // Penanda untuk apakah ada data yang sesuai

        rows.forEach(row => {
            // Ambil teks dari beberapa kolom (Lantai, Gedung, Deskripsi)
            let lantai = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            let gedung = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            let deskripsi = row.querySelector('td:nth-child(3)').innerText.toLowerCase();

            // Cek apakah input ada di salah satu kolom
            if (lantai.includes(input) || gedung.includes(input) || deskripsi.includes(input)) {
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
