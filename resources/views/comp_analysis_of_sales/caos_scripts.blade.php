<script src="{{url('public/site_resource/js/stickytableheaders.min.js')}}"></script>
<script>
    $('table').stickyTableHeaders();
	$('.toggle-btn').click(function(){
        $(window).trigger('resize.stickyTableHeaders');
    });

</script>