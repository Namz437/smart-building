
{{-- Begin Footer --}}
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2024<a
                class="ms-25" href="https://takumi.ac.id/" target="_blank">Politeknik Takumi</a><span
                class="d-none d-sm-inline-block">, All rights Reserved</span></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
{{-- End Footer --}}

 <!-- BEGIN: Vendor JS-->
 <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>  
 <!-- BEGIN Vendor JS-->

 <!-- BEGIN: Page Vendor JS-->
 <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
 <!-- END: Page Vendor JS-->

 <!-- BEGIN: Theme JS-->
 <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
 <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
 <!-- END: Theme JS-->

 <!-- BEGIN: Page JS-->
 <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.min.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/forms/form-select2.min.js') }}"></script>

 <!-- END: Page JS-->

 {{-- Script --}}
 <script>
     $(window).on('load', function() {
         if (feather) {
             feather.replace({
                 width: 14,
                 height: 14
             });
         }
     })
 </script>
 {{-- End Script --}}

 {{-- untuk alert --}}
 <script>
    // Buat ngilangin alert aja
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        });
    }, 10000); //waktu ilangnya
</script>