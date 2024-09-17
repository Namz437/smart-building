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
                        <h2 class="content-header-title float-start mb-0">Table Users</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <!-- Bordered table start -->
        {{-- Buat Alert aja --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        {{-- End Alert --}}

        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('settingusers.create') }}">Tambah Data Users +</a>

                        <!-- Input Search -->
                        <div class="input-group w-25">
                            <span class="input-group-text" id="basic-addon1">Search</span>
                            <input type="text" id="search-input" class="form-control" placeholder="Cari Users..." onkeyup="searchUsers()" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No_ID</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>RFID</th>
                                    <th>Perusahaan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Pesan No Data Result -->
                        <tr id="no-data" style="display: none;">
                            <td colspan="7" class="text-center">No data result.</td>
                        </tr>
                                @foreach ($users as $data)
                                    <tr>
                                        <td>{{ $data->no_id }}</td>
                                        <td>
                                            {{ $data->name }}
                                        </td>
                                        <td>{{ $data->email }}</td> 
                                        <td>{{ $data->roles->nama_role }}</td>
                                        <td>{{ $data->rfid }}</td> 
                                        <td>
                                            {{ $data->perusahaan ? $data->perusahaan->nama : '' }}
                                        </td>
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
                                                        href="{{ route('settingusers.edit', $data->id) }}">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); 
                                                        if(confirm('Apakah Anda yakin ingin menghapus user ini?')) 
                                                        document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>

                                                    <form id="delete-form-{{ $data->id }}" method="POST"
                                                        action="{{ route('settingusers.destroy', $data->id) }}"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                    {{-- Cek PW --}}
                                                    <a class="dropdown-item"
                                                        href="{{ route('settingusers.resetpassword', $data->id) }}"
                                                        onclick="return confirm('Apakah Anda yakin ingin reset password user ini?');">
                                                        <i data-feather="lock" class="me-50"></i>
                                                        <span>Reset Password</span>
                                                    </a>
                                                    {{-- Cek PW --}}

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
    function searchUsers() {
        // Ambil input pencarian
        let input = document.getElementById('search-input').value.toLowerCase();
        
        // Ambil semua baris data users
        let rows = document.querySelectorAll('tbody tr:not(#no-data)');
        let noData = document.getElementById('no-data');
        let found = false; // Penanda apakah ada data yang cocok

        rows.forEach(row => {
            // Ambil teks dari beberapa kolom (No_ID, Nama User, Email, Roles, RFID, Perusahaan)
            let no_id = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            let name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            let email = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
            let roles = row.querySelector('td:nth-child(4)').innerText.toLowerCase();
            let rfid = row.querySelector('td:nth-child(5)').innerText.toLowerCase();
            let perusahaan = row.querySelector('td:nth-child(6)').innerText.toLowerCase();

            // Cek apakah input ada di salah satu kolom
            if (no_id.includes(input) || name.includes(input) || email.includes(input) ||
                roles.includes(input) || rfid.includes(input) || perusahaan.includes(input)) {
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
