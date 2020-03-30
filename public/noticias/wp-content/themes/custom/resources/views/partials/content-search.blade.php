{{-- <article @php post_class() @endphp>
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>
    @if (get_post_type() === 'post')
      @include('partials/entry-meta')
    @endif
  </header>
  <div class="entry-summary">
    @php the_excerpt() @endphp
  </div>
</article> --}}

<li class="c-list-search__item">

  @if (has_post_thumbnail())
    <div class="c-list-search__img">
      <a href="{{ get_permalink() }}">
        @php the_post_thumbnail( 'medium' ) @endphp
      </a>
    </div>
  @endif

  <div class="c-list-search__content">
    <h2 class="c-list-search__ttl">
      <a href="{{ get_permalink() }}">
        {!! get_the_title() !!}
      </a>
    </h2>

    @if (get_post_type() === 'post')
      <span class="c-list-search__date">
        <svg class="c-list-search__date-svg">
          <use xlink:href="#calendar"/>
        </svg>
        <time rel="Data" title="Data" datetime="{{ get_post_time('c', true) }}">
          {{ get_the_date() }}
        </time>
      </span>
    @endif

    @php the_excerpt() @endphp
  </div>

</li>
