$( document ).ready(function() {
	var numItems = $('.col').length; 
	var bodyWidth = numItems * 562;
	$('body').width( bodyWidth );
    console.log( numItems+ " " + bodyWidth );
});

$(function() {
   $("#container").mousewheel(function(event, delta) {
      this.scrollLeft -= (delta * 30);
      event.preventDefault();
   });
});