			$(document).on('click', '#arts', function(){
				
				
				$('input[name=fundamental_name]').val('Artykuły');
				$('input[name=fundamental_url]').val('artykuly');
				$('input[name=cms_menu]').val('Artykuły');
				
				
				$('input[name=cms_url]').val('kategorie');
				$('input[name=cms_model]').val('kategorie');
				$('input[name=cms_table]').val('kategorie');
				$('input[name=cms_prefix]').val('kategoria');
				$('input[name=cms_folder]').val('kategorie');
				$('input[name=cms_config]').val('kategorie');
				
				$('input[name=view_name]').val('Kategorie');
				$('input[name=view_name_sing]').val('Kategoria');
				$('input[name=view_add]').val('Dodaj kategorię');
				$('input[name=view_new]').val('Nowa kategoria');
				$('input[name=view_edition]').val('Edycja Kategorii');
				$('input[name=view_edit]').val('Edytuj stronę Kategorie');
				
				// own columns
				$('.own_mysql_name').eq(0).val('big_content');
				$('.own_type').eq(0).val('text');
				$('.own_cms_name').eq(0).val('Duża treść');
				$('.own_mysql_name').eq(1).val('small_content');
				$('.own_type').eq(1).val('varchar');
				$('.own_length').eq(1).val('125');
				$('.own_cms_name').eq(1).val('Mała treść');
				
								
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
				
				// ---------------------------------------------------------------------------------- child1 below
				
				$('input[name=cms_url_child1]').val('artykuly');
				$('input[name=cms_model_child1]').val('artykuly');
				$('input[name=cms_table_child1]').val('artykuly');
				$('input[name=cms_prefix_child1]').val('artykul');
				$('input[name=cms_folder_child1]').val('artykuly');
				$('input[name=cms_config_child1]').val('artykuly');
				
				$('input[name=view_name_child1]').val('Artykuły');
				$('input[name=view_name_sing_child1]').val('Artykuł');
				$('input[name=view_add_child1]').val('Dodaj artykuł');
				$('input[name=view_new_child1]').val('Nowy artykuł');
				$('input[name=view_edition_child1]').val('Edycja artykułu');
				$('input[name=view_edit_child1]').val('Edytuj artykuł');
				
				// own columns
				$('.own_mysql_name_child1').eq(0).val('big_content');
				$('.own_type_child1').eq(0).val('text');
				$('.own_cms_name_child1').eq(0).val('Duża treść');
				$('.own_mysql_name_child1').eq(1).val('small_content');
				$('.own_type_child1').eq(1).val('varchar');
				$('.own_length_child1').eq(1).val('125');
				$('.own_cms_name_child1').eq(1).val('Mała treść');
				
								
				$('#meta_tags_child1').prop('checked', true);
				// Image 1 - 2 Thumbs
				$('.image_name_child1').eq(0).val('Zdjęcie');
				$('.image_maxkb_child1').eq(0).val('1000');
				$('.image_maxwidth_child1').eq(0).val('1920');
				$('.image_maxheight_child1').eq(0).val('1080');
				$('.image_reqwidth_child1').eq(0).val('1200');
				$('.image_reqheight_child1').eq(0).val('1000');
				$('.image1_thumbwidth_child1').eq(0).val('800');
				$('.image1_thumbheight_child1').eq(0).val('600');
				$('.image1_thumbwidth_child1').eq(1).val('600');
				$('.image1_thumbheight_child1').eq(1).val('500');
				// Image 2 - 0 Thumbs
				$('.image_name_child1').eq(1).val('Rysunek techniczny');
				$('.image_maxkb_child1').eq(1).val('1000');
				$('.image_maxwidth_child1').eq(1).val('1920');
				$('.image_maxheight_child1').eq(1).val('1080');
				$('.image_reqwidth_child1').eq(1).val('1200');
				$('.image_reqheight_child1').eq(1).val('1000');
				// Image 3 - 1 Thumbs
				$('.image_name_child1').eq(2).val('Rysunek techniczny');
				$('.image_maxkb_child1').eq(2).val('1000');
				$('.image_maxwidth_child1').eq(2).val('1920');
				$('.image_maxheight_child1').eq(2).val('1080');
				$('.image_reqwidth_child1').eq(2).val('1200');
				$('.image_reqheight_child1').eq(2).val('1000');
				$('.image3_thumbwidth_child1').eq(0).val('100');
				$('.image3_thumbheight_child1').eq(0).val('50');				
				// Gallery - 2 Thumbs
				$('#gallery_child1').prop('checked', true);	
				$('input[name=gal_maxkb_child1]').val('1000');
				$('input[name=gal_max_width_child1]').val('1920');
				$('input[name=gal_max_height_child1]').val('1080');
				$('input[name=gal_req_width_child1]').val('1000');
				$('input[name=gal_req_height_child1]').val('800');
				$('.gal_thumb_width_child1').eq(0).val('200');
				$('.gal_thumb_height_child1').eq(0).val('100');
				$('.gal_thumb_width_child1').eq(1).val('80');
				$('.gal_thumb_height_child1').eq(1).val('40');
				
				// ---------------------------------------------------------------------------------- 
				$('input[name=page_url]').val('kontakt');
				$('#homepage_r').prop('checked', false);

			});			