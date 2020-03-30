<div class="c-article__meta">
	<span class="c-article__meta-item">
		<svg class="c-article__meta-svg">
			<use xlink:href="#pencil"/>
		</svg>
		<a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="autor" title="autor" class="c-article__meta-author">
			{{ get_the_author() }}
		</a>
	</span>
	<span class="c-article__meta-item">
		<svg class="c-article__meta-svg">
			<use xlink:href="#calendar"/>
		</svg>
		<time rel="Data" title="Data" datetime="{{ get_post_time('c', true) }}">
			{{ get_the_date() }}
		</time>
	</span>

	@if($category)
		<span class="c-article__meta-item">
			<a href="{{ get_category_link($category) }}" class="c-article__meta-category c-article__meta-category--saude">{{ $category->name }}</a>
		</span>
	@endif
</div>
