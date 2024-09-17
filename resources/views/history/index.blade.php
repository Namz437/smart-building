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
                        <h2 class="content-header-title float-start mb-0">Table History</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <!-- Date Filter Form -->
<form method="GET" action="{{ route('history.index') }}">
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<!-- Search Input -->
<div class="row mb-2">
    <div class="col-12">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">Search</span>
            <input type="text" id="search-input" class="form-control w-80" placeholder="Cari Data..." onkeyup="searchHistory()" aria-describedby="basic-addon1">
        </div>
    </div>
</div>

        <!-- Bordered table start -->
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User ID</th> 
                                    {{-- User Id biarin --}}
                                    <th>Device</th>
                                    {{-- Ganti nama device --}}
                                    <th>Status</th>
                                    {{-- Biarin --}}
                                    <th>Deskripsi</th>
                                    {{-- Biarin --}}

                                    {{-- Datanya tampilin 50 aja yang terbaru descending, yang terbaru paling atas --}}
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Pesan No Data Result -->
                        <tr id="no-data" style="display: none;">
                            <td colspan="4" class="text-center">No data result.</td>
                        </tr>
                                @foreach ($historys as $data)
                                    <tr>
                                        <td>
                                            {{ $data->users_id }}
                                        </td>
                                        <td>{{ $data->device->nama_device }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->deskripsi }}</td>
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
    function searchHistory() {
        // Ambil input pencarian
        let input = document.getElementById('search-input').value.toLowerCase();
        
        // Ambil semua baris data history
        let rows = document.querySelectorAll('tbody tr:not(#no-data)');
        let noData = document.getElementById('no-data');
        let found = false; // Penanda apakah ada data yang cocok

        rows.forEach(row => {
            // Ambil teks dari setiap kolom
            let userId = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            let device = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            let status = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            let deskripsi = row.querySelector('td:nth-child(4)').innerText.toLowerCase();

            // Tampilkan atau sembunyikan baris berdasarkan pencarian
            if (userId.includes(input) || device.includes(input) || status.includes(input) || deskripsi.includes(input)) {
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
