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
                        <h2 class="content-header-title float-start mb-0">Add Data Ruangan</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body"><!-- Basic Inputs start -->
            <form action="{{ route('settingruangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Tambah Data Ruangan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama_ruangan">Nama Ruangan</label>
                                                <input type="text" class="form-control" id="nama_ruangan"
                                                    name="nama_ruangan" placeholder="Nama Ruangan">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="ukuran">Ukuran Ruangan</label>
                                                <input type="text" class="form-control" id="ukuran" name="ukuran"
                                                    placeholder="Ukuran Ruangan">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="lokasi">Lokasi</label>
                                            <select class="form-select" id="lokasi" name="lokasi">
                                                <option value="outdoor">Outdoor</option>
                                                <option value="dalam">Dalam Ruangan</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="perusahaan_id">Perusahaan</label>
                                            <select class="form-select" id="perusahaan_id" name="perusahaan_id">
                                                @foreach ($perusahaans as $perusahaan)
                                                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12" id="lantai_container" style="display: none;">
                                            <label class="form-label" for="lantai_id">Lantai</label>
                                            <select class="form-select" id="lantai_id" name="lantai_id">
                                                @foreach ($lantais as $lantai)
                                                    <option value="{{ $lantai->id }}">{{ $lantai->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi"
                                                    name="deskripsi" placeholder="Deskripsi">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settingruangan.index') }}"
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
<script>
    document.getElementById('lokasi').addEventListener('change', function () {
        var lokasi = this.value;
        var lantaiContainer = document.getElementById('lantai_container');

        if (lokasi === 'dalam') {
            lantaiContainer.style.display = 'block'; // Tampilkan field lantai
        } else {
            lantaiContainer.style.display = 'none';  // Sembunyikan field lantai
            document.getElementById('lantai_id').value = ''; // Kosongkan pilihan lantai
        }
    });
</script>

<script>
    window.onload = function () {
        var lokasi = document.getElementById('lokasi').value;
        var lantaiContainer = document.getElementById('lantai_container');

        if (lokasi === 'dalam') {
            lantaiContainer.style.display = 'block';
        } else {
            lantaiContainer.style.display = 'none';
        }
    };
</script>

</html>
