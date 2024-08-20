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
                        <h2 class="content-header-title float-start mb-0">Table Perusahaan</h2>
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
                        <a class="btn btn-primary" href="{{ route('settingperusahaan.create') }}">Tambah Data Perusahaan
                            +</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <th>Lokasi</th>
                                    <th>Image</th>
                                    <th>KwH</th>
                                    <th>Harga KwH</th>
                                    <th>Deskripsi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perusahaans as $data)
                                    <tr>
                                        <td>
                                            {{ $data->nama }}
                                        </td>
                                        <td>{{ $data->lokasi }}</td>
                                        <td>
                                            @if ($data->image)
                                                <img src="{{ asset('storage/' . $data->image) }}" alt="Image"
                                                    width="140" class="img-thumbnail">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->kwh }}</td>
                                        <td>{{ $data->harga_kwh }}</td>
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
                                                        href="{{ route('settingperusahaan.edit', $data->id) }}">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); 
                               if(confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')) 
                               document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>

                                                    <form id="delete-form-{{ $data->id }}" method="POST"
                                                        action="{{ route('settingperusahaan.destroy', $data->id) }}"
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

</html>
