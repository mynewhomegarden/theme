jQuery(document).ready(function($){
	"use strict";
	
	/* BUTTON TO TOP */
	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){		
		if( $(window).scrollTop() > 200 ){
			$('.to_top').fadeIn(100);
		}
		else{
			$('.to_top').fadeOut(100);
		}
	});
	
	$(document).on('click', '#navigation a', function(e){
		if( $(window).width() < 768 && e.target.nodeName == 'I' ){
			return false;
		}
		else if( $(this).attr( 'href' ).indexOf( 'http' ) > -1 && !$(this).attr('target') && !e.ctrlKey ){
			window.location.href = $(this).attr('href');
		}
	});

	$(document).on('click', '.to_top', function(e){
		e.preventDefault();
		$("html, body").stop().animate(
			{
				scrollTop: 0
			}, 
			{
				duration: 1200
			}
		);		
	});

	$(document).on( 'click', '.submit_form',function(){
		$(this).parents('form').submit();
	});
	
	/* RESPONSIVE SLIDES FOR THE GALLERY POST TYPE */
	function start_review_slider(){
		$('.review-slider').owlCarousel({
			items: 1,
			animateOut: 'fadeOut',
			rtl: $('body').hasClass('rtl') ? true : false,
			nav: $('.review-slider li').length > 1 ? true : false,
			autoHeight : true,
			navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
		});	
	}
	$(document).on('reviews-images-loaded', function(){
		start_review_slider();
		$(document).on( 'click', '.slider-pager .owl-item', function(){
			$('.review-slider').trigger('to.owl.carousel', $(this).index());
		});
	});


	$('.review-slider li').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery:{enabled:true},
	});

	/* OWL PAGER */
	$('.slider-pager').owlCarousel({
		items: 10,
		rtl: $('body').hasClass('rtl') ? true : false,
		responsiveClass: true,
		margin: 5,
		responsive: {
			0: {
				items: 3
			},
			200: {
				items: 4
			},
			400: {
				items: 6
			},
			600: {
				items: 8,
				margin: 3
			},
			736: {
				margin: 4
			},
			800: {
				items: 10
			}
		},
		nav: false,
		dots: false
	});		

	/* RESPONSIVE SLIDES FOR THE GALLERY POST TYPE */
	$('.gallery-slider').responsiveSlides({
		speed: 500,
		auto: false,
		pager: false,
		nav: true,
		prevText: '<i class="fa fa-angle-left"></i>',
		nextText: '<i class="fa fa-angle-right"></i>',
	});

	/* HOME SEARCHS SLIDER */
	$('.big-search-slider').responsiveSlides({
		speed: 800,
		auto: true,
		pager: false,
		nav: false,
	});
	
	/* NAVIGATION */
	function handle_navigation(){
		if ($(window).width() >= 767) {
			$(document).on( 'mouseenter', 'ul.nav li.dropdown, ul.nav li.dropdown-submenu', function () {
				var $this = $(this);
				if( !$this.hasClass('open') ){
					$(this).addClass('open').find(' > .dropdown-menu').show();
				}
			}); 
			$(document).on( 'mouseleave', 'ul.nav li.dropdown, ul.nav li.dropdown-submenu', function () {
				var $this = $(this);
				setTimeout(function(){
					if(  !$this.is(":hover") ){
						if( $this.hasClass('open') ){
							$this.removeClass('open').find(' > .dropdown-menu').hide();
						}
					}
				},200);
	
			});
		}
		else{
			$('.dropdown-toggle').removeAttr('data-toggle');
			$(document).on( 'click', 'li.dropdown a', function(e){
				e.preventDefault();
				if( !$(this).parent().hasClass('open') ){
					$(this).parent().addClass('open').find(' > .dropdown-menu').show();
					$(this).parents('.dropdown').addClass('open').find(' > .dropdown-menu').show();
				}
				else{
					$(this).parent().removeClass('open').find(' > .dropdown-menu').hide();
					$(this).parent().find('.dropdown').removeClass('open').find(' > .dropdown-menu').hide();
				}
			});		
		}
	}
	
	
	$(window).resize(function(){
		setTimeout(function(){
			handle_navigation();
		}, 200);
	});		
	
	//GALERY SLIDER
	function start_slider(){
		$('.post-slider').responsiveSlides({
			speed: 500,
			auto: false,
			pager: false,
			nav: true,
			prevText: '<i class="fa fa-angle-left"></i>',
			nextText: '<i class="fa fa-angle-right"></i>',
		});	
	}
	start_slider();

	/* SUBMIT FORMS */
	$(document).on('click', '.submit-live-form', function(){
		$(this).parents('form').submit();
	});

	$(document).on('click', '.submit-form', function(){
		var $this = $(this);
		var $form = $this.parents( 'form' );
		var $result = $form.find('.send_result');
		if( $this.find( 'i' ).length == 0 ){
			var $html = $this.html();
			$this.html( $html+' <i class="fa fa-spin fa-spinner"></i>' );
			$.ajax({
				url: ajaxurl,
				data: $form.serialize(),
				method: $form.attr('method'),
				dataType: "JSON",
				success: function(response){
					if( response.message ){
						$result.html( response.message );
					}
					if( response.url ){
						window.location.href = response.url;
					}
				},
				complete: function(){
					$this.html( $html );
				}
			});
		}
	});	
	
	
	/* SUBSCRIBE */
	$(document).on('click', '.subscribe', function(e){
		e.preventDefault();
		var $this = $(this);
		var $parent = $this.parents('.subscribe-form');		
		
		$.ajax({
			url: ajaxurl,
			method: "POST",
			data: {
				action: 'subscribe',
				email: $parent.find( '.email' ).val()
			},
			dataType: "JSON",
			success: function( response ){
				if( !response.error ){
					$parent.find('.sub_result').html( '<div class="alert alert-success" role="alert"><span class="fa fa-check-circle"></span> '+response.success+'</div>' );
				}
				else{
					$parent.find( '.sub_result' ).html( '<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>' );
				}
			}
		})
	} );
		
		
	/* contact script */
	$(document).on('click', '.send-contact', function(e){
		e.preventDefault();
		var $this = $(this);
		var $html = $this.html();
		$this.append( ' <i class="fa fa-spin fa-spinner"></i>' );		
		$.ajax({
			url: ajaxurl,
			method: "POST",
			data: {
				action: 'contact',
				name: $('.name').val(),
				email: $('.email').val(),
				subject: $('.subject').val(),
				message: $('.message').val(),
				phone: $('.phone').val()
			},
			dataType: "JSON",
			success: function( response ){
				if( !response.error ){
					$('.send_result').html( '<div class="alert alert-success" role="alert"><span class="fa fa-check-circle"></span> '+response.success+'</div>' );
				}
				else{
					$('.send_result').html( '<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>' );
				}
			},
			complete: function(){
				$this.html( $html );
			}
		})
	});
	
	/* MAGNIFIC POPUP FOR THE GALLERY */
	$('.gallery').each(function(){
		var $this = $(this);
		$this.magnificPopup({
			type:'image',
			delegate: 'a',
			gallery:{enabled:true},
		});
	});

	/* STICKY NAVIGATION */
	function sticky_nav(){
		var $admin = $('#wpadminbar');
		if( $admin.length > 0 && $admin.css( 'position' ) == 'fixed' ){
			$sticky_nav.css( 'top', $admin.height() );
		}
		else{
			$sticky_nav.css( 'top', '0' );
		}
	}
	if( reviews_data.enable_sticky == 'yes' ){
		var $navigation_bar = $('.navigation-bar');
		var $sticky_nav = $navigation_bar.clone().addClass('sticky_nav');
		if( $sticky_nav.find( 'a[data-toggle="tab"]' ).length > 0 ){
			$sticky_nav.find( 'a[data-toggle="tab"]' ).each(function(){
				$(this).attr( 'href', $(this).attr('href')+'_sticky' );
			});

			$sticky_nav.find( '.tab-pane' ).each(function(){
				$(this).attr( 'id', $(this).attr('id')+'_sticky' );
			});
		}
		$('body').append( $sticky_nav );

		$(window).on('scroll', function(){
			if( $(window).scrollTop() > 0 && $(window).scrollTop() >= $navigation_bar.position().top && $(window).width() > 769 ){
				$sticky_nav.show();
			}
			else{
				$sticky_nav.hide();
			}
		});	
		sticky_nav();

		$(window).resize(function(){
			sticky_nav();
		});
	}

	handle_navigation();

	/* SORTING */
	$('#sort, #review-category').change(function(){
		$(this).parents('form').submit();
	});

	/* MASONRY ITEMS */
	var $container = $('.masonry');
	var has_masonry = false;
	// initialize
	function start_masonry(){
		if( $(window).width() < 768 && has_masonry ){
			$container.masonry('destroy');
			has_masonry = false;			
		}
		else if( $(window).width() >= 768 && !has_masonry ){
			$container.imagesLoaded(function() {
				$container.masonry({
					itemSelector: '.masonry-item',
					columnWidth: '.masonry-item',
				});
				has_masonry = true;
			});	
		}
	}
	start_masonry();
	$(window).resize(function(){
		setTimeout( function(){
			start_masonry();
		}, 500);
	});	

	/* REVIEWS */
	$(document).on( 'mouseenter', '#commentform .ordered-list .fa', function(){
		var pos = $(this).index();
		var $parent = $(this).parents('.user-ratings');
		var icon, is_clicked;
		for( var i=0; i<=pos; i++ ){
			icon = $parent.find('.fa:eq('+i+')');
			is_clicked = icon.hasClass('clicked') ? 'clicked' : '';
			icon.attr('class', 'fa fa-star '+is_clicked );
		}
	});
	$(document).on( 'mouseleave', '#commentform .ordered-list .fa', function(){
		$(this).parents('.user-ratings').find('.fa').each(function(){
			if( !$(this).hasClass('clicked') ){
				$(this).attr('class', 'fa fa-star-o');
			}
		});
	});

	$(document).on('click', '#commentform .ordered-list .fa', function(){
		var value = $(this).index();
		var $parent = $(this).parents('.user-ratings');
		$parent.find('.fa').removeClass('clicked').attr('class', 'fa fa-star-o');
		for( var i=0; i<=value; i++ ){
			$parent.find('.fa:eq('+i+')').attr('class', 'fa fa-star').addClass('clicked');
		}

		update_ratings();
	});

	function update_ratings(){
		var review_value = [];
		var counter = 0;
		var value_criteria;
		$('#commentform .ordered-list .user-ratings').each(function(){
			var $this = $(this);
			counter++;
			if( $this.find('.clicked').length > 0 ){
				value_criteria = $this.find('.clicked').length;
				review_value.push( counter+'|'+value_criteria );
			}
		});

		$('#review').val( review_value.join(',') );
	}

	/* MEGA MENU POSITION */
	$('.mega_menu_dropdown').parents().each(function(){
		var $this = $(this);
		if( !$this.hasClass('navigation-bar') ){
			$this.css('position', 'static');	
		}
		else if( !$this.hasClass( 'sticky_nav' ) ){
			$this.css('position', 'relative')
		}
		
	});	

	/* SLIDERS FOR DISPLAYING REVIEWS */
	$('.reviews-slider').each(function(){
		var $this = $(this);
		$this.owlCarousel({
			margin: 30,
			rtl: $('body').hasClass('rtl') ? true : false,
			responsive:{
				900:{
					items: $this.data('items')
				},
				600: {
					items: $this.data('items') == '2' ? 1: 2
				},
				300:{
					items: 1
				}
			},
			nav: true,
			navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
			dots: false
		});
	});

	/* IMAGE LAZY LOAD */
	var lazy_images_loaded = 0;
	var lazy_images = $('.reviews-lazy-load:not(.image-loaded)').length;	

	function lazy_load_images(){
		$('.reviews-lazy-load:not(.image-loaded)').each(function(){
			var $this = $(this);
			var imgPreload = new Image();
			var $imgPreload = $(imgPreload);
			$imgPreload.attr({
			    src: $this.data( 'src' )
			});

		    if (imgPreload.complete || imgPreload.readyState === 4) {
		    	$this.attr( 'src', $imgPreload.attr('src') );
		    	check_lazy_finish();

		    } else {
		        //go fetch the image:
		        $imgPreload.load(function (response, status, xhr) {
		            if (status == 'error') {
		            	check_lazy_finish();
		            } else {
		            	$this.attr( 'src', $imgPreload.attr('src') );
		            	check_lazy_finish();
		            }
		        });
		    }
		});
	}

	function check_lazy_finish(){
		lazy_images_loaded++;
		if( lazy_images_loaded == lazy_images ){
			$(document).trigger('reviews-images-loaded');
		}
	}
	lazy_load_images();

	$(window).load(function(){
		if( lazy_images_loaded < lazy_images ){
			$(document).trigger('reviews-images-loaded');
		}
	});

	/* QUICK SEARCH */
	function open_quick_search(){
		$('.quick_search_result').show();
	}

	function close_quick_search(){
		$('.quick_search_result').hide();
	}	
	$(document).on( 'keyup', '.quick-search input', function(){
		var $this = $(this);
		var val = $this.val();
		var timeout;


		if( $this.parents('.big-search').length == 0 || ($this.parents('.big-search').length > 0 && $(window).width() > 667) ){
			if( val !== '' && val.length >= 3 ){
				timeout = setTimeout(function(){
					$('.quick-search').append('<i class="fa fa-spin fa-circle-o-notch"></i>');
					$.ajax({
						url: ajaxurl,
						type: "POST",
						data: {
							action: 'quick_search',
							val: val
						},
						success: function( response ){
							$('.quick_search_result').html( response );
							open_quick_search();
						},
						complete: function(){
							if( $this.val() == '' ){
								close_quick_search();
							}
							$('.quick-search .fa').remove();
						}
					});
				},200);
			}
			else{
				clearTimeout( timeout );
				close_quick_search();
			}
		}	
	});

	$(document).on( 'focus', '.quick-search input', function(){
		var $this = $(this);
		if( $this.val() !== '' ){
			open_quick_search();
		}
	});

	$(document).on( 'blur', '.quick-search input', function(){
		if( !$('.quick_search_result').is(':hover') ){
			close_quick_search();
		}
	});

	/* CHECK IF COMMENT IS EMPTY */
	$(document).on( 'submit', '#commentform', function(e){
		var $this = $(this);
		var $submit = $this.find('.submit');
		$this.find('.alert').remove();

		var valid = true;
		$this.find('input:not([type="file"]),textarea').each(function(){
			var $this = $(this);
			if( $this.attr('name') == 'comment' && reviews_data.allow_empty_review == 'yes' && !$(this).val() ){
				valid = true;
			}
			else if( !$(this).val() ){
				valid = false;
			}
		});

		if( $this.find('#email').length > 0 ){
			if( !/\S+@\S+\.\S+/.test( $this.find('#email').val() ) ){
				valid = false;
			}
		}

		if( $this.find('#review').length > 0 ){
			var val_length = $('#review').val().split(',').length;
			if( val_length !== $this.find('.ordered-list li').length ){
				valid = false;
			}
		}

		if( !valid ){
			e.preventDefault();
			$submit.after( '<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+reviews_data.comment_error+'</div>' );
		}
		else{
			$this.val('[empty_review_'+Math.random()+']');
		}
	});

	$(window).load(function(){
		if( window.location.hash ){
			var $target = $(window.location.hash);
			if( $target.length == 1 ){
				var scroll = $target.offset().top;
				var $admin = $('#wpadminbar');
				var $sticky = $('.sticky_nav');
				if( $admin.length > 0 && $admin.css( 'position' ) == 'fixed' ){
					scroll -= $admin.height();
				}
				if( $sticky.length > 0 ){
					scroll -= $sticky.outerHeight(true);
				}

				scroll -= 20;

				window.scrollTo( 0, scroll );
			}
		}		
	});

	/* SHOW HIDE MORE */
	var moreText = $('.show-more:first').text();
	$(document).on( 'click', '.show-more', function(){
		var $this = $(this);
		var $parent = $this.parent();
		var $less = $parent.find('.display-less');
		var $more = $parent.find('.display-more');

		if( $this.hasClass('open') ){
			$this.text( moreText );
			$less.show();
			$more.hide();
			$this.removeClass('open');
		}
		else{
			$this.text( $this.data('less') );
			$less.hide();
			$more.show();
			$this.addClass('open');
		}
	});
});