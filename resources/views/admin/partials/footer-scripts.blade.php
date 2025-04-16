<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{asset('assets/admin')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap Bundle js -->
<script src="{{asset('assets/admin')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ionicons js -->
<script src="{{asset('assets/admin')}}/plugins/ionicons/ionicons.js"></script>
<!-- Moment js -->
<script src="{{asset('assets/admin')}}/plugins/moment/moment.js"></script>

<!-- Rating js-->
<script src="{{asset('assets/admin')}}/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{asset('assets/admin')}}/plugins/rating/jquery.barrating.js"></script>
<!--Internal  Perfect-scrollbar js -->
<script src="{{asset('assets/admin')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/perfect-scrollbar/p-scroll.js"></script>
<!--Internal Sparkline js -->
<script src="{{asset('assets/admin')}}/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<!-- Custom Scroll bar Js-->
<script src="{{asset('assets/admin')}}/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- right-sidebar js -->
<script src="{{asset('assets/admin')}}/plugins/sidebar/sidebar-rtl.js"></script>
<script src="{{asset('assets/admin')}}/plugins/sidebar/sidebar-custom.js"></script>
<!-- Eva-icons js -->
<script src="{{asset('assets/admin')}}/js/eva-icons.min.js"></script>

<script src="{{asset('assets/admin')}}/plugins/parsleyjs/parsley.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/parsleyjs/i18n/{{app()->getLocale()}}.js"></script>

<!-- toastr js -->
<link rel="stylesheet" href="{{asset('assets/admin')}}/plugins/toastr/toastr.min.css">
<script src="{{asset('assets/admin')}}/plugins/toastr/toastr.min.js"></script>

@livewireScripts
@stack('js')

<!-- Internal Nice-select js-->
<script src="{{asset('assets/admin')}}/plugins/jquery-nice-select/js/jquery.nice-select.js"></script>
<script src="{{asset('assets/admin')}}/plugins/jquery-nice-select/js/nice-select.js"></script>
<!-- Sticky js -->
<script src="{{asset('assets/admin')}}/js/sticky.js"></script>
<!-- custom js -->
<script src="{{asset('assets/admin')}}/js/custom.js"></script><!-- Left-menu js-->
<script src="{{asset('assets/admin')}}/plugins/side-menu/sidemenu.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
	    toastr.options.positionClass = 'toast-bottom-left';
	    toastr.options.progressBar = true;
	    toastr.options.rtl = true;
	});
</script>

<script type="text/javascript">
	Livewire.on('alert',(data)=>{
        var data = data[0];
        toastr[data.type](data.message);
    });
</script>

@if(session('generatePdf')) 
    <script>
	    window.onload = function() { window.open("{{ session('generatePdf') }}", '_blank'); };
    </script> 
@endif

<script>
    Livewire.on('openPdf', (event) => {
        window.open(event[0].url, '_blank');
    });
</script>
