// JavaScript Document

$(document).ready(function(){
   $('.project').hover(function(){
	   //$(this).find('.descr').fadeIn('slow');
	   $(this).find('.descr').animate({
			marginBottom: "0px"
		  }, 500 );
   },
   function(){
	   //$(this).find('.descr').fadeOut('slow');
	   $(this).find('.descr').delay(500).animate({
			marginBottom: "-254px"
		  }, 1000 );
   });
   
   $('.thumbs').hover(function(){
	  	$('.thumbs').removeClass('sel');
		$(this).addClass('sel');
		var url = $(this).attr('href'); 
		var title = $(this).children('img').attr('title');
		var href = $(this).attr('href');
		var filename = href.substring(href.lastIndexOf('/')+1).replace(/-(\d{2,3})x(\d{2,3})\.([jpg|png])/, ".$3");
		href = href.substring(0, href.lastIndexOf('/')+1) + filename;
		//alert(href);
		//.replace(/-(.*?)\.([jpg|png])/, ".$2"); 
		//alert(href);
		$('.largeImg img').attr('src',url);
		$('.largeImg').attr('href',href);
		$('.largeImg').attr('title',title);
		return false;
   }).click(function(){
	   $(".largeImg").click();
	   return false;
   });
   
   $(".thumbs,.largeImg").colorbox();
   var sideMenuTop = $('#side-menu').offset().top - 20;
   $(window).scroll(function(){
	  var scrolled = $(window).scrollTop();
	  //console.log("Scroll: " + $(window).scrollTop() + "   Side-menu: "+ $('#side-menu').offset().top); 
	  
	  if(sideMenuTop - scrolled < 0){
			$('#side-menu').addClass('float');  
	  }else{
			$('#side-menu').removeClass('float');
	  }
   });
});

