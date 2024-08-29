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
                        <h2 class="content-header-title float-start mb-0">Edit Data Users</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                </div>
            </div>
        </div>

        <div class="content-body">
            <form action="{{ route('settingusers.update', $users->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Form Edit Data Users</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="no_id">No_ID</label>
                                                <input type="text" class="form-control" id="no_id" name="no_id"
                                                    value="{{ $users->no_id }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="name">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $users->name }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $users->email }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" value="{{ $users->password }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <label class="form-label" for="roles_id">Roles</label>
                                            <select class="form-select" id="roles_id" name="roles_id">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" 
                                                        {{ $role->id == $users->roles_id ? 'selected' : '' }}>
                                                        {{ $role->nama_role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="rfid">RFID</label>
                                                <input type="text" class="form-control" id="rfid" name="rfid"
                                                    value="{{ $users->rfid }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="perusahaan_id">Perusahaan</label>
                                                <input type="text" class="form-control" id="perusahaan_id" name="perusahaan_id"
                                                    value="{{ $users->perusahaan_id }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <a href="{{ route('settingusers.index') }}"
                                                class="btn btn-secondary mt-2">Back</a>
                                            <button class="btn btn-primary mt-2" type="submit">Edit Data Users</button>
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
