jQuery(document).ready( function( $){
	$('.navbar-toggler-icon').click(function(){
		var navbar = $('#navbarTogglerDemo01');
		if(navbar.hasClass('navbar-collapse')){
			navbar.addClass('navbar-collapse-mobile');
			navbar.removeClass('navbar-collapse');
		}else{
			navbar.addClass('navbar-collapse');
			navbar.removeClass('navbar-collapse-mobile');
		}
	//	alert(navbar.hasClass('navbar-collapse'));
	//	navbar.toggleClass('navbar-collapse').toggleClass('navbar-collapse-mobile');
	});
});

jQuery(document).ready(function (e) {
		if( $(window).width() <= 576){
			$('.btn-outline-secondary').val("搜索");
			$('.goods-title').css('text-align','center');
			$('.buy-now a').css('width','150');
		}
});
