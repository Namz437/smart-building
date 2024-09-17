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
                        <h2 class="content-header-title float-start mb-0">Table Setting Kode Kontrol</h2>
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
                        <a class="btn btn-primary" href="{{ route('settingkodekontrol.create') }}">Tambah Data Kode
                            Kontrol +</a>
                             <!-- Input Search -->
                <div class="input-group w-25 mt-2">
                    <span class="input-group-text" id="basic-addon1">Search</span>
                    <input type="text" id="search-input" class="form-control" placeholder="Cari Kode Kontrol..." onkeyup="searchSettingKodeKontrol()" aria-describedby="basic-addon1">
                </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Kode Kontrol</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <!-- Pesan No Data Result -->
                        <tr id="no-data" style="display: none;">
                            <td colspan="3" class="text-center">No data result.</td>
                        </tr>
                                @foreach ($setting_kode_kontrols as $data)
                                    <tr>
                                        <td>
                                            {{ $data->device_id }}
                                        </td>
                                        <td>{{ $data->kode_kontrol_id }}</td>
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
                                                        href="{{ route('settingkodekontrol.edit', $data->id) }}">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); 
                               if(confirm('Apakah Anda yakin ingin menghapus setting kodew kontrol ini?')) 
                               document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>

                                                    <form id="delete-form-{{ $data->id }}" method="POST"
                                                        action="{{ route('settingkodekontrol.destroy', $data->id) }}"
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
    function searchSettingKodeKontrol() {
        // Ambil input pencarian
        let input = document.getElementById('search-input').value.toLowerCase();
        
        // Ambil semua baris data kode kontrol
        let rows = document.querySelectorAll('tbody tr:not(#no-data)');
        let noData = document.getElementById('no-data');
        let found = false; // Penanda apakah ada data yang cocok

        rows.forEach(row => {
            // Ambil teks dari kolom 'Device' dan 'Kode Kontrol'
            let device = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            let kodeKontrol = row.querySelector('td:nth-child(2)').innerText.toLowerCase();

            // Tampilkan atau sembunyikan baris berdasarkan pencarian
            if (device.includes(input) || kodeKontrol.includes(input)) {
                row.style.display = ''; // Tampilkan
                found = true; // Ada data yang sesuai
            } else {
                row.style.display = 'none'; // Sembunyikan
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
