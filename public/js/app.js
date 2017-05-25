/* slick slider (product page)
$(document).ready(function(){
  $('.product-images').slick({
	  infinite: true,
	  slidesToShow: 3,
	  slidesToScroll: 1
  });
});*/

/* Add more images fields (add & edit product pages) 
$('.add-images').click(function(e){
	e.preventDefault();
	$(this).before("<input name='image[]' type='file'><a class='remove btn btn-danger btn-block' href='#'><i class='fa fa-times-circle'></i></a>");
});

$('.form-control').click(function(e){
	e.preventDefault();
	$(this).prev("input,.btn").remove();	
});*/

$(function(){
	$( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+6M", dateFormat: "yy-mm-dd" });
});
