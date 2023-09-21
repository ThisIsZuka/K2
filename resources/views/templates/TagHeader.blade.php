<script src="{{ asset('assets/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/axios.min.js') }}"></script>

{{-- bootstrap --}}
<link href="{{ asset('assets/bootstrap-5.3.0/css/bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/bootstrap-5.3.0/js/bootstrap.min.js') }}"></script>


<!-- Font Awesome -->
<link href="{{ asset('assets/fontawesome-free-6.2.1-web/css/all.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/fontawesome-free-6.2.1-web/js/all.min.js') }}"></script>


{{-- DASHBOARD --}}

<link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
<!-- Custom CSS -->
<link href={{ asset('assets/monster-html/plugins/chartist/dist/chartist.min.css') }} rel="stylesheet">
<!-- Custom CSS -->
<link href={{ asset('assets/monster-html/css/style.min.css') }} rel="stylesheet">


<script src={{ asset('assets/monster-html/js/app-style-switcher.js') }}></script>
<!--Wave Effects -->
<script src={{ asset('assets/monster-html/js/waves.js') }}></script>
<!--Menu sidebar -->
<script src={{ asset('assets/monster-html/js/sidebarmenu.js') }}></script>
<!--Custom JavaScript -->
<script src={{ asset('assets/monster-html/js/custom.js') }}></script>
<!--This page JavaScript -->
<script src={{ asset('assets/monster-html/js/pages/dashboards/dashboard1.js') }}></script>
<!--flot chart-->
<script src={{ asset('assets/monster-html/plugins/flot/jquery.flot.js') }}></script>
<script src={{ asset('assets/monster-html/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js') }}></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js"></script>

<script>
    var token = document.head.querySelector('meta[name="csrf-token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
</script>
