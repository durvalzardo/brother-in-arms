<li class="c-list-search__item">

  @if (has_post_thumbnail($post))
    <div class="c-list-search__img">
      <a href="{{ get_the_permalink($post) }}">
        <img src="{{ get_the_post_thumbnail_url($post) }}" alt="{{ $post->post_title }}" class="c-list-news__img">
      </a>
    </div>
  @endif

  <div class="c-list-search__content">
    <h2 class="c-list-search__ttl">
      <a href="{{ get_the_permalink($post) }}">{{ $post->post_title }}</a>
    </h2>

    {{-- @if (get_post_type() === 'post') --}}
    <span class="c-list-search__date">
      <svg class="c-list-search__date-svg">
        <use xlink:href="#calendar"/>
      </svg>
      <time rel="Data" title="Data" datetime="{{ get_post_time('c', true) }}">
        {{ get_the_date('', $post) }}
      </time>
    </span>
    {{-- @endif --}}

    <p>{{ $post->post_excerpt }}</p>
  </div>

</li>
