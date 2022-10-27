jQuery(document).ready(function($) {
	jQuery('.input-images').imageUploader({
		imagesInputName: 'photos',
		extensions:['.jpg', '.jpeg', '.png', '.gif'],
		maxFiles: 5
	});

	jQuery( "#sortable" ).sortable({
		cursor: "move",
		update: function(event, ui) {  
			var positions = $(this).sortable( "toArray");  
			jQuery.ajax( {
				url: slideshow_ajax_var.url,
				type: 'post',
				data: {
					action: 'save_slider_image_postion',
					nonce: slideshow_ajax_var.nonce,   // pass the nonce here
					changedposition: positions,
				},
				success( data ) {
					if ( data ) {
						jQuery('.wpss-sortable').html('');
						jQuery('.wpss-sortable').append('<div class="alert alert-success" role="alert">'+data.data+'</div>');
					}
				},
			} );
		} 		
	});

	jQuery('.wpssicon_anchor').click( function() {
		if(confirm("Are you sure you want to delete this?")){
			let idval = jQuery(this).data('id');
			let attachid = jQuery(this).data('attachid');
			jQuery.ajax( {
				url: slideshow_ajax_var.url,
				type: 'post',
				data: {
					action: 'delete_slider_image',
					nonce: slideshow_ajax_var.nonce,   // pass the nonce here
					id_val: idval,
					attachid: attachid
				},
				success( data ) {
					if ( data ) {
						jQuery('.wpss-sortable').append('<div class="alert alert-success" role="alert">'+data.data+'</div>');
						location.reload();
					}
				},
			} );
		}
		else{
			return false;
		}
	});
});