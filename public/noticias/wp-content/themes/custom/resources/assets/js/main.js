'use strict';

import trackErrors from './track-js-errors';
import $ from 'jquery';
import 'slick-carousel';
import 'jquery-mask-plugin';
import moment from 'moment';
import 'moment/locale/pt-br';
import _ from 'underscore';
import clndr from 'clndr';

window.$ = $;

moment.locale('pt-br');

document.documentElement.className += ' js';

trackErrors();


const 	$prevArrow 	= '<span class="o-slick-arrow o-slick-arrow--prev" aria-label="anterior"></span>',
$nextArrow 	= '<span class="o-slick-arrow o-slick-arrow--next" aria-label="próximo"></span>',
$body 		= $('body'),
$document 	= $(document),
$htmlBody 	= $("html, body"),
$window 	= $(window);




// open and close menu mobile
const $menuTrigger = $('.js-menu-trigger');

$menuTrigger.on('click', function(){
	$body.toggleClass('menu-opened');
});



// Detect scroll Down and Scroll Top
var lastScrollTop = 0;
$document.on('scroll', function(){

	var st = window.pageYOffset || document.documentElement.scrollTop;

	if ( st > lastScrollTop ){
		//down
		$body.addClass('scroll-down');
	}
	else{
		//up
		$body.removeClass('scroll-down');
	}
	lastScrollTop = st <= 0 ? 0 : st;
});



// Header Search
const $searchOpen 	= $('.js-search-open'),
      $searchClose 	= $('.js-search-close');

$searchOpen.on('click', function(){
  $body.addClass('search-opened');
  $('#s').focus();
});

$searchClose.on('click', function(){
  $body.removeClass('search-opened');
  $('#s').blur();
});



// footer go to top
$('.js-goto-top').on('click', function() {
	$htmlBody.animate({scrollTop: 0}, 'slow');
});


//Slick Banner
$('.js-banner-slider').slick({
	arrows: false,
	dots: true
});


//Quick Access Slider
initQuickAccessSlider();

function initQuickAccessSlider(){
	$('.js-podcasts-slider').not('.slick-initialized').slick({
		dots: false,
		slidesToShow: 5,
		slidesToScroll: 1,
		infinite: false,
		prevArrow: '<span class="o-slick-arrow o-slick-arrow--prev" aria-label="anterior"></span>',
		nextArrow: '<span class="o-slick-arrow o-slick-arrow--next" aria-label="próximo"></span>',
		responsive: [
		{
			breakpoint: 1024,
			settings: 'unslick'
		}
		]
	});
}

$window.on('resize', function(){
	if($window.width() >= 1024){
		initQuickAccessSlider();
	}
});


// Internal Post Slider
// let $gallery 	= $('.js-gallery'),
let $gallery 	= $('.blocks-gallery-grid'),
	$navGallery = $('.js-nav-gallery');

$gallery.slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: true,
	fade: true,
	mobileFirst: true,
	prevArrow: '<span class="o-slick-arrow o-slick-arrow--prev" aria-label="anterior"></span>',
	nextArrow: '<span class="o-slick-arrow o-slick-arrow--next" aria-label="próximo"></span>',
	// asNavFor: '.js-nav-gallery',
	infinite: true
});

$navGallery.slick({
	slidesToShow: 5,
	slidesToScroll: 1,
	asNavFor: '.js-gallery',
	prevArrow: '<span class="o-slick-arrow o-slick-arrow--prev" aria-label="anterior"></span>',
	nextArrow: '<span class="o-slick-arrow o-slick-arrow--next" aria-label="próximo"></span>',
	infinite: false,
	mobileFirst: true,
	responsive: [
	{
		breakpoint: 1024,
		settings: {
			slidesToShow: 6,
		}
	}
	]
});

$navGallery.find('.slick-slide').on('click', function () {
	$gallery.slick( 'slickGoTo', $(this).data('slickIndex') );
});




// Press Slider
let $pressGallery 	= $('.js-press-slider'),
	$pressNavGallery = $('.js-press-slider-nav');

$pressGallery.slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: true,
	prevArrow: '<span class="o-slick-arrow o-slick-arrow--secondary o-slick-arrow--prev" aria-label="anterior"></span>',
	nextArrow: '<span class="o-slick-arrow o-slick-arrow--secondary o-slick-arrow--next" aria-label="próximo"></span>',
	asNavFor: '.js-press-slider-nav',
	infinite: true,
	centerMode: true,
	centerPadding: '15%',
	mobileFirst: true,
	responsive: [
	{
		breakpoint: 1024,
		settings: {
			centerPadding: '30%',
		}
	}
	]
});

$pressNavGallery.slick({
	slidesToShow: 3,
	slidesToScroll: 1,
	asNavFor: '.js-press-slider',
	prevArrow: '<span class="o-slick-arrow o-slick-arrow--secondary o-slick-arrow--prev" aria-label="anterior"></span>',
	nextArrow: '<span class="o-slick-arrow o-slick-arrow--secondary o-slick-arrow--next" aria-label="próximo"></span>',
	infinite: true,
	mobileFirst: true,
	centerMode: true,
	centerPadding: '0',
	responsive: [
	{
		breakpoint: 1024,
		settings: {
			slidesToShow: 7,
		}
	}
	]
});

$pressNavGallery.find('.slick-slide').on('click', function () {
	$pressGallery.slick( 'slickGoTo', $(this).data('slickIndex') );
});


// Button element load more posts
const $btnLoadPosts = $('.js-load-posts');

// Button load more posts action
$btnLoadPosts.on('click', function() { Posts.loadMore(); });

// Posts object
var Posts = {
	pageNumber: 1,
	perPage: 2,
	categoy: null,
	list: $('.js-list-news'),
	loadMore: function() {
		$btnLoadPosts.text('Carregando...');
		$btnLoadPosts.prop('disabled', true);

		this.pageNumber++;

		$.ajax({
			url: wpadmin.ajaxURL,
			method: 'POST',
			data: {
				cat: this.categoy,
				pageNumber: this.pageNumber,
				ppp: this.perPage,
			  action: 'load_more_posts'
			}
	  }).done(function(data) {

			if(data) {
				Posts.list.append(data);
				$btnLoadPosts.text('Carregar mais');
				$btnLoadPosts.prop('disabled', false);
				return true;
			}

			$btnLoadPosts.fadeOut(500, function() { $(this).remove(); });

	  });
	}
}


// Button element load more podcasts
const $btnLoadPodcasts = $('.js-load-podcasts');

// Button load more podcasts action
$btnLoadPodcasts.on('click', function() { Podcasts.loadMore(); });

// Podcasts object
var Podcasts = {
	pageNumber: 1,
	perPage: 12,
	list: $('.js-list-podcasts'),
	loadMore: function() {
		$btnLoadPodcasts.text('Carregando...');
		$btnLoadPodcasts.prop('disabled', true);

		this.pageNumber++;

		$.ajax({
			url: wpadmin.ajaxURL,
			method: 'POST',
			data: {
				pageNumber: this.pageNumber,
				ppp: this.perPage,
			  action: 'load_more_podcasts'
			}
	  }).done(function(data) {

			if(data) {
				Podcasts.list.append(data);
				$btnLoadPodcasts.text('Carregar mais');
				$btnLoadPodcasts.prop('disabled', false);
				return true;
			}

			$btnLoadPodcasts.fadeOut(500, function() { $(this).remove(); });

	  });
	}
}


// Button element load more podcasts
const $btnLoadClippings = $('.js-load-clippings');

// Button load more podcasts action
$btnLoadClippings.on('click', function() { Clippings.loadMore(); });

// Clippings object
var Clippings = {
	pageNumber: 1,
	perPage: 12,
	subject : $('#subject').val(),
	vehicle : $('#vehicle').val(),
	dateAfter : $('#range-init').val(),
	dateBefore : $('#range-end').val(),
	list: $('.js-list-clippings'),
	loadMore: function() {
		$btnLoadClippings.text('Carregando...');
		$btnLoadClippings.prop('disabled', true);

		this.pageNumber++;

		$.ajax({
			url: wpadmin.ajaxURL,
			method: 'POST',
			data: {
				pageNumber: this.pageNumber,
				ppp: this.perPage,
				subject: this.subject,
				vehicle: this.vehicle,
				dateAfter: this.dateAfter,
				dateBefore: this.dateBefore,
			  action: 'load_more_clippings'
			}
	  }).done(function(data) {

			if(data) {
				Clippings.list.append(data);
				$btnLoadClippings.text('Carregar mais');
				$btnLoadClippings.prop('disabled', false);

				var total = $('.c-list-media .c-list-media__item').length;

				$('.c-search-results__amount').text('Mostrando ' + total + ' resultado(s).');

				return true;
			}

			$btnLoadClippings.fadeOut(500, function() { $(this).remove(); });

	  });
	}
}


// Button element load more podcasts
const $btnLoadSearch = $('.js-load-search');

// Button load more podcasts action
$btnLoadSearch.on('click', function() { Search.loadMore(); });

// Search object
var Search = {
	pageNumber: 1,
	perPage: 2,
	list: $('.js-list-search'),
	loadMore: function() {
		$btnLoadSearch.text('Carregando...');
		$btnLoadSearch.prop('disabled', true);

		this.pageNumber++;

		$.ajax({
			url: wpadmin.ajaxURL,
			method: 'POST',
			data: {
				pageNumber: this.pageNumber,
				ppp: this.perPage,
				s: $btnLoadSearch.data('search'),
				tag: $btnLoadSearch.data('tag'),
			  action: 'load_more_search'
			}
	  }).done(function(data) {

			if(data) {
				Search.list.append(data);
				$btnLoadSearch.text('Carregar mais');
				$btnLoadSearch.prop('disabled', false);

				var total = $('.c-list-search .c-list-search__item').length;

				$('.c-search-results__amount').text('Mostrando ' + total + ' resultado(s).');

				return true;
			}

			$btnLoadSearch.fadeOut(500, function() { $(this).remove(); });

	  });
	}
}


// Events Calendar
/*$('#calendar').clndr({
	template: $('#cldr-template').html(),
	daysOfTheWeek: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
	targets: {
		previousButton: 'c-clndr-controls__prev',
		nextButton: 'c-clndr-controls__next'
	}
});
*/



  /*
  ** Ajax call sample

  $.ajax({
	url: wpadmin.ajaxURL,
	method: 'POST',
	data: {
	  action: 'my_method',
	  custom_data: 'custom_data_content'
	}
  }).done(function(data) {
	console.log(data);
  });

  */
