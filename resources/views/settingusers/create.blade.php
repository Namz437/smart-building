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
                        <h2 class="content-header-title float-start mb-0">Add Data Users</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body"><!-- Basic Inputs start -->
            <form action="{{ route('settingusers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Tambah Data Users</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="no_id">No_ID</label>
                                                <input type="text" class="form-control" id="no_id" name="no_id"
                                                    placeholder="Nomor ID">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="name">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Nama Users">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Example@gmail.com">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="*********">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settingusers.index') }}"
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
