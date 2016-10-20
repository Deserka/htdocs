			$(document).on('click', '#contact', function(){
				$('input[name=cms_url]').val('kontakt');
				$('input[name=cms_menu]').val('Kontakt');
				$('input[name=cms_model]').val('contact');
				$('input[name=cms_table]').val('contact');
				$('input[name=cms_folder]').val('contact');
				$('input[name=cms_config]').val('contact');
				
				$('input[name=view_name]').val('Kontakt');
				$('input[name=view_name_sing]').val('Kontakt');
				$('input[name=view_edition]').val('Edycja strony Kontakt');
				$('input[name=view_edit]').val('Edytuj stronę Kontakt');
								
				$('#meta_tags').prop('checked', true);
				// Image 1 - 2 Thumbs
				$('.image_name').eq(0).val('Zdjęcie');
				$('.image_maxkb').eq(0).val('1000');
				$('.image_maxwidth').eq(0).val('1920');
				$('.image_maxheight').eq(0).val('1080');
				$('.image_reqwidth').eq(0).val('1200');
				$('.image_reqheight').eq(0).val('1000');
				$('.image1_thumbwidth').eq(0).val('800');
				$('.image1_thumbheight').eq(0).val('600');
				$('.image1_thumbwidth').eq(1).val('600');
				$('.image1_thumbheight').eq(1).val('500');
				// Image 2 - 0 Thumbs
				$('.image_name').eq(1).val('Rysunek techniczny');
				$('.image_maxkb').eq(1).val('1000');
				$('.image_maxwidth').eq(1).val('1920');
				$('.image_maxheight').eq(1).val('1080');
				$('.image_reqwidth').eq(1).val('1200');
				$('.image_reqheight').eq(1).val('1000');
				// Image 3 - 1 Thumbs
				$('.image_name').eq(2).val('Rysunek techniczny');
				$('.image_maxkb').eq(2).val('1000');
				$('.image_maxwidth').eq(2).val('1920');
				$('.image_maxheight').eq(2).val('1080');
				$('.image_reqwidth').eq(2).val('1200');
				$('.image_reqheight').eq(2).val('1000');
				$('.image3_thumbwidth').eq(0).val('100');
				$('.image3_thumbheight').eq(0).val('50');				
				// Gallery - 2 Thumbs
				$('#gallery').prop('checked', true);	
				$('input[name=gal_maxkb]').val('1000');
				$('input[name=gal_max_width]').val('1920');
				$('input[name=gal_max_height]').val('1080');
				$('input[name=gal_req_width]').val('1000');
				$('input[name=gal_req_height]').val('800');
				$('.gal_thumb_width').eq(0).val('200');
				$('.gal_thumb_height').eq(0).val('100');
				$('.gal_thumb_width').eq(1).val('80');
				$('.gal_thumb_height').eq(1).val('40');

				// Page
				$('.router_urls').append('<p><a class="left">URL + język np. (/de/kontakt)</a><a class="right"><input type="text" name="page_router_urls[]" value="/kontakt" /><input style="width:50px;" placeholder="lang" type="text" name="page_router_lang[]" value="pl" /></a></p>');
				
				$('input[name=page_url]').val('kontakt');
				$('#homepage_r').prop('checked', false);

			});			