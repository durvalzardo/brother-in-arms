<main class="o-main">

	<ul class="c-list-share">
		<li class="c-list-share__item c-list-share__item--facebook">
			<a href="https://www.facebook.com/sharer/sharer.php?u={{ get_the_permalink() }}" target="_blank">
				<svg><use xlink:href="#share-face"/></svg>
			</a>
		</li>
		<li class="c-list-share__item c-list-share__item--twitter">
			<a href="https://twitter.com/intent/tweet?url={{ get_the_permalink() }}&text={{ get_the_title() }}" target="_blank">
				<svg><use xlink:href="#share-twitter"/></svg>
			</a>
		</li>
		<li class="c-list-share__item c-list-share__item--linkedin">
			<a href="http://www.linkedin.com/shareArticle?mini=true&url={{ get_the_permalink() }}&title={{ get_the_title() }}" target="_blank">
				<svg><use xlink:href="#share-linkedin"/></svg>
			</a>
		</li>
	</ul>

	<article class="c-article" @php post_class() @endphp>
		<div class="o-wrapper o-wrapper--900">
			<header>
				<h1 class="c-article__ttl">{!! get_the_title() !!}</h1>

				@if(has_excerpt())
					<h2 class="c-article__sbttl">{{ get_the_excerpt() }}</h2>
				@endif

				@include('partials/entry-meta')

				@if(has_post_thumbnail())
					<figure class="c-article__main-img">
						<img src="{{ get_the_post_thumbnail_url() }}" alt="">
						<figcaption>{{ get_the_post_thumbnail_caption() }}</figcaption>
					</figure>
				@endif
			</header>

			<div class="c-article__content c-article__content--first-letter">
				{!! the_content() !!}
			</div>

			@if(has_tag())
				<div class="c-article__footer">
					<ul class="c-article__footer-tags">
						@foreach(get_the_tags() as $tag)
							{{-- {{ var_dump($tag) }} --}}
							<li><a href="{{ get_term_link($tag->term_id) }}">{{ $tag->name }}</a></li>
						@endforeach
					</ul>
				</div>
			@endif

		</div>
	</article>

</main>
