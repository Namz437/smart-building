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
                        <h2 class="content-header-title float-start mb-0">Edit Data Lantai</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body">
            <form action="{{ route('settinglantai.update', $lantais->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('patch')

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Edit Data Lantai</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nama">Nama Lantai</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $lantais->nama }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="gedung_id">Gedung</label>
                                            <select class="form-select" id="gedung_id" name="gedung_id">
                                                @foreach ($gedungs as $gedung)
                                                    <option value="{{ $gedung->id }}" 
                                                        @if($gedung->id == $lantais->gedung_id) selected @endif>
                                                        {{ $gedung->nama_gedung }}, 
                                                        ({{ $gedung->perusahaan ? $gedung->perusahaan->nama : 'No Perusahaan' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi"
                                                    name="deskripsi" value="{{ $lantais->deskripsi }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settinglantai.index') }}"
                                                class="btn btn-secondary mt-2">Back</a>
                                            <button class="btn btn-primary mt-2" type="submit">Edit Data
                                                Lantai</button>
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
