@php
	$post_categories = get_post_primary_category($post, 'category');
	$category = (isset($post_categories['primary_category'])) ? $post_categories['primary_category'] : false;
@endphp
<li class="c-list-news__item">
	<a href="{{ get_the_permalink($post) }}" class="c-list-news__link">
		<div class="c-list-news__img-wrapper">
			<img src="{{ get_the_post_thumbnail_url($post) }}" alt="{{ $post->post_title }}" class="c-list-news__img">
		</div>
		<div class="c-list-news__content c-list-news__content--{{ get_field('color', $category) }}">
			<h3 class="c-list-news__ttl">{{ $post->post_title }}</h3>
		</div>
	</a>
</li>
