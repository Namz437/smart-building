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
                        <h2 class="content-header-title float-start mb-0">Table History</h2>
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

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User ID</th> 
                                    {{-- User Id biarin --}}
                                    <th>Device</th>
                                    {{-- Ganti nama device --}}
                                    <th>Status</th>
                                    {{-- Biarin --}}
                                    <th>Deskripsi</th>
                                    {{-- Biarin --}}

                                    {{-- Datanya tampilin 50 aja yang terbaru descending, yang terbaru paling atas --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historys as $data)
                                    <tr>
                                        <td>
                                            {{ $data->users_id }}
                                        </td>
                                        <td>{{ $data->device->nama_device }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->deskripsi }}</td>
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
