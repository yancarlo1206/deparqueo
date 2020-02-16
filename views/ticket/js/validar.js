jQuery(document).ready(function($) {
	$('.photo').click(function(event) {
		event.preventDefault();
		var ticket = $(this).attr('ticket');
		$('#imgPhotoIn').attr('src', 'http://'+BASE.url_server+':8085/files/fotos/'+ticket+'-in.jpg');
		$('#imgPhotoOut').attr('src', 'http://'+BASE.url_server+':8085/files/fotos/'+ticket+'-out.jpg');
		$('#photoModal').modal();
	});
	$('#photo-list a').on('click', function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})	
});