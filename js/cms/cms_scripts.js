





			

(function( $ ){
	/*
	 * element - class of elements for pagination
	 * from - from what element start - page of pagination
	 * amount - how much elements to show
	 * 
	 */
   $.fn.paginationList = function(className, buttonNumber, amount) 
   {
   	buttonNumberText = buttonNumber.text();

   			if(buttonNumberText == 1)
   				{startFrom = 0; }
   			else
   				{startFrom = (buttonNumberText * amount) - amount; amount = buttonNumberText * amount}
   				
   			$('.pagination-buttons span').removeClass('active')	;
   			//$('.pagination-buttons span:contains("'+ buttonNumber +'")').addClass('active')	;
   			buttonNumber.addClass('active')	;
   			$(className).css('display', 'none');
			$(className).slice(startFrom, amount).fadeIn('slow');
   },
/*
 *  Count Characters In Inputs And show In Span --------------------------------------------------------------------------------
 */   
    $.fn.countOneInput = function (it)
    {
        it.parent().find('.count-it-span').text(it.val().length);
    },
    $.fn.countAllInputs = function(it)
    {
    	it.parent().find('.count-it-span').remove();
        it.after('<span class="count-it-span">'+ it.val().length +'</span>');
    } ;
/*
 *  Hide gpositive communicate --------------------------------------------------------------------------------
 */      
    $.fn.passComunicateHide = function(it)
    {
	    setTimeout(function(){ 
	    	$('.show-pass').slideUp('fast');
	    }, 5000);
    } ; 
 
})( jQuery );


$( document ).ready(function() {  
		
    //Count Characters In Inputs And show In Span
    $(".count-it").each(function() {
    	$(this).countAllInputs($(this));
    });    
    // Pagination
    var paginationItems = $('.pagination-one-list').length
    if(paginationItems > 15){
   		$(".pagination-one-list").paginationList(".pagination-one-list", $('.pagination-buttons span:first'), 15);
    }
    
    // Hide pass communicate
	$('.show-pass').passComunicateHide();
    
           
}); // document ready

// Count Characters In Inputs And show In Span
$(".count-it").on('input', function() {
    $(this).countOneInput($(this));
});
    
/*
 *  Question Mark Info ---------------------------------------------------------------------------------------------------------
 */
$(".div_mark").on({
    
    "click": function(event) { $(this).find(".div_note").css("bottom", '35px').css("right", '35px'); 
                                    $(this).find(".div_note").show('fast'), $(this).animate({opacity:1}, "fast")},
    "mouseleave":  function(event) { $(this).find(".div_note").animate({opacity:1}, "fast") ;  $(this).find(".div_note").hide('fast');}
});

/*
 *  Pagination ---------------------------------------------------------------------------------------------------------
 */

$('.pagination-buttons span').click(function(){
	$(this).paginationList(".pagination-one-list", $(this), 15 );
});

























//universal confirm
function conf() {
    var r = confirm("Na pewno?");
    if (r == true) {
        return true;
    } else {
        
        return false;
    }
}
//clear thumb
$('#dis_mini').click(function(){
		$('#fieldID').val('');
});

//close info1

	$('#closer1').click(function(){
			$('#info1').css('display', 'none');
	});

//pagination
(function( $ ){
   $.fn.pagination = function() {
   		  	var pag = $(this).text();
			var min = (pag * 15) - 14;
			var max = (pag * 15) + 1;
			$('.content_list').css('display', 'none');
			$('.content_list').first().fadeIn('slow');
			$('.content_list').slice(min,max).fadeIn('slow');
   }; 
})( jQuery );

