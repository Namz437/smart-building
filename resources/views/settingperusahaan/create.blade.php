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
                        <h2 class="content-header-title float-start mb-0">Add Perusahaan</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body"><!-- Basic Inputs start -->
            <form action="{{ route('settingperusahaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Tambah Data Perusahaan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama">Nama Perusahaan</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    placeholder="Nama Perusahaan....">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="lokasi">Lokasi</label>
                                                <small class="text-muted">example.<i>Jl.Baru Raya</i></small>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                                    placeholder="Lokasi">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi"
                                                    name="deskripsi" placeholder="Deskripsi">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="kwh">KwH</label>
                                                <input type="text" id="kwh" name="kwh" class="form-control"
                                                    placeholder="KwH">
                                                <p><small class="text-muted">Tegangan KwH.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12 mb-1 mb-md-0">
                                            <label class="form-label" for="harga_kwh">Harga KwH</label>
                                            <input type="text" id="harga_kwh" name="harga_kwh" class="form-control"
                                                placeholder="Harga KwH">
                                            <p><small class="text-muted">Harga KwH.</small></p>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label for="image" class="form-label">Foto Perusahaan</label>
                                            <input class="form-control" type="file" id="image" name="image"
                                                placeholder="pilih gambar perusahaan">
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settingperusahaan.index') }}"
                                                class="btn btn-secondary mt-2">Back</a>
                                            <button class="btn btn-primary mt-2" type="submit">Tambah + </button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>
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
