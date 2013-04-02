$(document).ready(function(){
	$('#home_page_slideshow').bjqs({
		animtype : 'slide',
		height : 250,
        width : 750,
        responsive : true,
	});
});

$(function(){
  $('#masonry-container').masonry({
    // options
    itemSelector : '.attachment-masonry',
    columnWidth : 150,
    isAnimated: true
  });
});