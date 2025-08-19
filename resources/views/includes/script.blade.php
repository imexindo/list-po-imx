<!-- JAVASCRIPT -->
<script src="{{ asset('cms/assets/jquery.min.js') }}"></script>
<script src="{{ asset('cms/assets/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('cms/assets/metisMenu.min.js') }}"></script>
<script src="{{ asset('cms/assets/simplebar.min.js') }}"></script>
<script src="{{ asset('cms/assets/waves.min.js') }}"></script>
<script src="{{ asset('cms/assets/feather.min.js') }}"></script>
<!-- pace js -->
<script src="{{ asset('cms/assets/pace.min.js') }}"></script>

<!-- apexcharts -->
{{-- <script src="{{ asset('cms/assets/apexcharts.min.js') }}"></script> --}}
{{-- plugins --}}
<script src="{{ asset('cms/assets/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('cms/assets/jquery-jvectormap-world-mill-en.js') }}"></script>
{{-- <script src="{{ asset('cms/assets/dashboard.init.js') }}"></script> --}}
<script src="{{ asset('cms/assets/app.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="{{ asset('cms/assets/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('cms/assets/sweetalert2.js') }}"></script>



<script>
    
    document.addEventListener('DOMContentLoaded', function() {

        let errorMessages = document.getElementById('error-messages');

        if (errorMessages) {
            let messages = Array.from(errorMessages.getElementsByTagName('p')).map(p => p.innerText).join('<br>');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: messages,
            });
        }
        // Check for success messages
        let successMessages = document.getElementById('success-messages');
        if (successMessages) {
            let messages = Array.from(successMessages.getElementsByTagName('p')).map(p => p.innerText).join('<br>');
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: messages,
            });
        }
    });
    
</script>
