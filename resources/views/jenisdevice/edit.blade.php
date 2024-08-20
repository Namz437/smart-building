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
                        <h2 class="content-header-title float-start mb-0">Edit Data Jenis Device</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body">
            <form action="{{ route('jenisdevice.update', $jenis_devices->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('patch')

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Edit Data Jenis Device</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="category_device_id">Category Device</label>
                                            <select class="form-select" id="category_device_id"
                                                name="category_device_id">
                                                @foreach ($category_devices as $category_device)
                                                    <option value="{{ $category_device->id }}">
                                                        {{ $category_device->nama_category }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama_jenis">Nama Jenis</label>
                                                <input type="text" class="form-control" id="nama_jenis"
                                                    name="nama_jenis" value="{{ $jenis_devices->nama_jenis }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi"
                                                    name="deskripsi" value="{{ $jenis_devices->deskripsi }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('jenisdevice.index') }}"
                                                class="btn btn-secondary mt-2">Back</a>
                                            <button class="btn btn-primary mt-2" type="submit">Edit Data Jenis
                                                Device</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>

        <!-- Basic Inputs end -->

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
