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
                        <h2 class="content-header-title float-start mb-0">Edit Data Ruangan</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body">
            <form action="{{ route('settingruangan.update', $ruangans->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('patch')

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Edit Data Ruangan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama_ruangan">Nama Ruangan</label>
                                                <input type="text" class="form-control" id="nama_ruangan"
                                                    name="nama_ruangan" value="{{ $ruangans->nama_ruangan }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="ukuran">Ukuran Ruangan</label>
                                                <input type="text" class="form-control" id="ukuran" name="ukuran"
                                                    value="{{ $ruangans->ukuran }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="lokasi">Lokasi</label>
                                            <select class="form-select" id="lokasi" name="lokasi">
                                                <option value="outdoor">Outdoor</option>
                                                <option value="dalam">Dalam Ruangan</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-xl-4 col-md-6 col-12" id="perusahaan_container">
                                            <label class="form-label" for="perusahaan_id">Perusahaan</label>
                                            <select class="form-select" id="perusahaan_id" name="perusahaan_id">
                                                <option value="" {{ is_null($ruangans->perusahaan_id) ? 'selected' : '' }}>Kosongkan Perusahaan</option>
                                                @foreach ($perusahaans as $perusahaan)
                                                    <option value="{{ $perusahaan->id }}" 
                                                        {{ $ruangans->perusahaan_id == $perusahaan->id ? 'selected' : '' }}>
                                                        {{ $perusahaan->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-xl-4 col-md-6 col-12" id="lantai_container">
                                            <label class="form-label" for="lantai_id">Lantai</label>
                                            <select class="form-select" id="lantai_id" name="lantai_id">
                                                <option value="" {{ is_null($ruangans->lantai_id) ? 'selected' : '' }}>Kosongkan Lantai</option>
                                                @foreach ($lantais as $lantai)
                                                    <option value="{{ $lantai->id }}" 
                                                        {{ $ruangans->lantai_id == $lantai->id ? 'selected' : '' }}>
                                                        {{ $lantai->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi"
                                                    name="deskripsi" value="{{ $ruangans->deskripsi }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settingruangan.index') }}"
                                                class="btn btn-secondary mt-2">Back</a>
                                            <button class="btn btn-primary mt-2" type="submit">Edit Data
                                                Ruangan</button>
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

<script>
    document.getElementById('lokasi').addEventListener('change', function () {
        var lokasiValue = this.value;
        var perusahaanContainer = document.getElementById('perusahaan_container');
        var lantaiContainer = document.getElementById('lantai_container');

        if (lokasiValue === 'dalam') {
            perusahaanContainer.style.display = 'none';
            lantaiContainer.style.display = 'block';
        } else if (lokasiValue === 'outdoor') {
            perusahaanContainer.style.display = 'block';
            lantaiContainer.style.display = 'none';
        }
    });

    // Trigger the change event to set initial visibility
    document.getElementById('lokasi').dispatchEvent(new Event('change'));
</script>

</html>
