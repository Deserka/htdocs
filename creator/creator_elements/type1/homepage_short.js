			$(document).on('click', '#home', function(){
				$('input[name=cms_url]').val('strona_glowna');
				$('input[name=cms_menu]').val('Strona główna');
				$('input[name=cms_model]').val('homepage');
				$('input[name=cms_table]').val('homepage');
				$('input[name=cms_folder]').val('homepage');
				$('input[name=cms_config]').val('homepage');
				
				$('input[name=view_name]').val('Strona główna');
				$('input[name=view_name_sing]').val('Strona główna');
				$('input[name=view_edition]').val('Edycja strony głównej');
				$('input[name=view_edit]').val('Edytuj stronę główną');
								
				$('#meta_tags').prop('checked', true);
				
				$('input[name=page_url]').val('/');
				$('#homepage_r').prop('checked', true);
				
				$('.image_name').eq(0).val('Zdjęcie');
				$('.image_maxkb').eq(0).val('1000000');
				$('.image_maxwidth').eq(0).val('1920');
				$('.image_maxheight').eq(0).val('1080');
				$('.image_reqwidth').eq(0).val('1200');
				$('.image_reqheight').eq(0).val('1000');
				$('.image_thumb1width').eq(0).val('800');
				$('.image_thumb1height').eq(0).val('600');
				$('.image_thumb2width').eq(0).val('600');
				$('.image_thumb2height').eq(0).val('500');
				$('.image_thumb3width').eq(0).val('234');
				$('.image_thumb3height').eq(0).val('206');
				$('.image_thumb4width').eq(0).val('123');
				$('.image_thumb4height').eq(0).val('65');
				
				$('.image_name').eq(1).val('Rysunek techniczny');
				$('.image_maxkb').eq(1).val('1000000');
				$('.image_maxwidth').eq(1).val('1920');
				$('.image_maxheight').eq(1).val('1080');
				$('.image_reqwidth').eq(1).val('1200');
				$('.image_reqheight').eq(1).val('1000');
				$('.image_thumb1width').eq(1).val('800');
				$('.image_thumb1height').eq(1).val('600');
				$('.image_thumb2width').eq(1).val('600');
				$('.image_thumb2height').eq(1).val('500');
				$('.image_thumb3width').eq(1).val('234');
				$('.image_thumb3height').eq(1).val('206');
				$('.image_thumb4width').eq(1).val('123');
				$('.image_thumb4height').eq(1).val('65');
				
				$('.image_name').eq(2).val('Rysunek techniczny');
				$('.image_maxkb').eq(2).val('1000000');
				$('.image_maxwidth').eq(2).val('1920');
				$('.image_maxheight').eq(2).val('1080');
				$('.image_reqwidth').eq(2).val('1200');
				$('.image_reqheight').eq(2).val('1000');
				$('.image_thumb1width').eq(2).val('800');
				$('.image_thumb1height').eq(2).val('600');
				$('.image_thumb2width').eq(2).val('600');
				$('.image_thumb2height').eq(2).val('500');
				$('.image_thumb3width').eq(2).val('234');
				$('.image_thumb3height').eq(2).val('206');
				$('.image_thumb4width').eq(2).val('123');
				$('.image_thumb4height').eq(2).val('65');				


			});