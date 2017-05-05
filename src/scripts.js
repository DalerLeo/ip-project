$(function(){
	$('.carousel').carousel({
		interval: 2000
	});

	$('.search').on('click', function(){
		$('.main-menu .navbar-form').slideToggle();
	});
});