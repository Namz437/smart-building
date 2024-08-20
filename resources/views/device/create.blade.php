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
                        <h2 class="content-header-title float-start mb-0">Add Device</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body"><!-- Basic Inputs start -->
            <form action="{{ route('device.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Tambah Data Device</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama_device">Nama Device</label>
                                                <input type="text" class="form-control" id="nama_device"
                                                    name="nama_device" placeholder="Nama Device">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="url">Url</label>
                                                <input type="text" class="form-control" id="url" name="url"
                                                    placeholder="URL">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="jenis_device_id">Jenis Device</label>
                                            <select class="form-select" id="jenis_device_id" name="jenis_device_id">
                                                @foreach ($jenis_devices as $jenis_device)
                                                    <option value="{{ $jenis_device->id }}">
                                                        {{ $jenis_device->nama_jenis }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="ruangan_id">Ruangan</label>
                                            <select class="form-select" id="ruangan_id" name="ruangan_id">
                                                @foreach ($ruangans as $ruangan)
                                                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="merk_id">Merk</label>
                                            <select class="form-select" id="merk_id" name="merk_id">
                                                @foreach ($merks as $merk)
                                                    <option value="{{ $merk->id }}">{{ $merk->nama_merk }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="suhu">Suhu</label>
                                                <input type="text" class="form-control" id="suhu" name="suhu"
                                                    placeholder="Suhu">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="min_suhu">Min Suhu</label>
                                                <input type="text" class="form-control" id="min_suhu"
                                                    name="min_suhu" placeholder="Min Suhu">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="max_suhu">Max Suhu</label>
                                                <input type="text" class="form-control" id="max_suhu"
                                                    name="max_suhu" placeholder="Max Suhu">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="watt">Watt</label>
                                                <input type="text" class="form-control" id="watt" name="watt"
                                                    placeholder="Watt">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="mac_address">Mac Address</label>
                                                <input type="text" class="form-control" id="mac_address"
                                                    name="mac_address" placeholder="Mac Address">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('device.index') }}"
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
