			$(document).on('click', '#discotech', function(){
				
				
				$('input[name=fundamental_name]').val('Produkty');
				$('input[name=fundamental_url]').val('produkty');
				$('input[name=cms_menu]').val('Produkty');
				
				
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
								
				$('#meta_tags').prop('checked', true);
				
				// Image 1 - 2 Thumbs
				$('.image_name').eq(0).val('Miniaturka');
				$('.image_maxkb').eq(0).val('1000');
				$('.image_maxwidth').eq(0).val('1920');
				$('.image_maxheight').eq(0).val('1080');
				$('.image_reqwidth').eq(0).val('1200');
				$('.image_reqheight').eq(0).val('1000');
				
				// ---------------------------------------------------------------------------------- child1 below
				
				$('input[name=cms_url_child1]').val('serie');
				$('input[name=cms_model_child1]').val('serie');
				$('input[name=cms_table_child1]').val('serie');
				$('input[name=cms_prefix_child1]').val('seria');
				$('input[name=cms_folder_child1]').val('serie');
				$('input[name=cms_config_child1]').val('serie');
				
				$('input[name=view_name_child1]').val('Serie');
				$('input[name=view_name_sing_child1]').val('Seria');
				$('input[name=view_add_child1]').val('Dodaj serię');
				$('input[name=view_new_child1]').val('Nowa seria');
				$('input[name=view_edition_child1]').val('Edycja serii');
				$('input[name=view_edit_child1]').val('Edytuj serię');
				
				// own columns
				$('.own_mysql_name_child1').eq(0).val('opis');
				$('.own_type_child1').eq(0).val('text');
				$('.own_cms_name_child1').eq(0).val('Opis');
				$('.own_mysql_name_child1').eq(1).val('tabela');
				$('.own_type_child1').eq(1).val('text');
				$('.own_cms_name_child1').eq(1).val('Tabela');
								
				$('#meta_tags_child1').prop('checked', true);
				
				// Image 1 - 2 Thumbs
				$('.image_name_child1').eq(0).val('Miniaturka');
				$('.image_maxkb_child1').eq(0).val('1000');
				$('.image_maxwidth_child1').eq(0).val('1920');
				$('.image_maxheight_child1').eq(0).val('1080');
				$('.image_reqwidth_child1').eq(0).val('1200');
				$('.image_reqheight_child1').eq(0).val('1000');
				// Image 2 - 0 Thumbs
				$('.image_name_child1').eq(1).val('Główne zdjęcie');
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
				// Gallery - 2 Thumbs
				$('#gallery_child1').prop('checked', true);	
				$('input[name=gal_maxkb_child1]').val('1000');
				$('input[name=gal_max_width_child1]').val('1920');
				$('input[name=gal_max_height_child1]').val('1080');
				$('input[name=gal_req_width_child1]').val('1000');
				$('input[name=gal_req_height_child1]').val('800');
				
				// ---------------------------------------------------------------------------------- 
				$('input[name=page_url]').val('kontakt');
				$('#homepage_r').prop('checked', false);

			});			