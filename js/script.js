// JavaScript Document
$(document).ready(function () {
	/* navigation */
	// $(".hamburger").click(function(){
	// 	$(this).toggleClass("is-active");
	//   });
	// document.addEventListener('click',function(e){
	// 	if(e.target.classList.contains('hamburger-toggle')){
	// 		e.target.children[0].classList.toggle('active');
	// 	}
	// });
	// $(".navbar-toggler").click(function () {
	// 	$("html").toggleClass("nav-menu-open overflow-hidden");
	// });
	// $(".close").click(function () {
	// 	$("html").toggleClass("nav-menu-open overflow-hidden");
	// });
	/* navigation */

	$(window).scroll(function () {
		if ($(this).scrollTop() > 180) {
			$('.social-icons').addClass('active');
		} else {
			$('.social-icons').removeClass('active');
		}
	});

	/*carousel */
	/* lazyload */
	var myLazyLoad = new LazyLoad();
	myLazyLoad.update();
	/* lazyload */
	/* OFI Browser */
	objectFitImages();

	$('#others').hide();

	$('.form-select').on('change', function () {
		if ($(this).val() === 'Others') {
			$('#others').show();
		} else {
			$('#others').hide();
		}
	});
});