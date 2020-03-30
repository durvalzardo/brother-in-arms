@extends('layouts.app')

@section('content')

<main class="o-main">

  <section class="c-search-results">
		<div class="o-wrapper">

      @if($posts)

        {{-- Search Results header --}}
        <div class="c-search-results__header u-py-30">
          <h2 class="o-ttl u-mb-20">
            <svg class="o-ttl__icon o-ttl__icon--size-20">
              <use xlink:href="#magnifier"/>
            </svg>
            <span>Resultado(s) da busca: {!! get_search_query() !!}</span>
          </h2>
          <span class="c-search-results__amount">
              Mostrando {{ count( $posts ) }} resultado(s).
          </span>
        </div>
        {{-- End Search Results header --}}

        <ul class="c-list-search js-list-search">
          @foreach($posts as $post)
            @include('partials._card-search-news', ['post' => $post])
          @endforeach
        </ul>

        <div class="u-text-center u-mb-80">
  				<button type="button" title="Carregar mais" class="o-btn o-btn--primary js-load-search" data-search="{{ get_search_query() }}">Carregar mais</button>
  			</div>
      @else
        <div class="u-py-140 u-text-center">
          <h2 class="o-ttl u-mb-20" style="justify-content: center">Não encontramos resultado para sua busca: {{ get_search_query() }} :(</h2>
          <a href="{{ get_site_url(null, '/') }}" class="o-btn o-btn--primary u-mt-80">Ir para home</a>
        </div>
      @endif

    </div>
  </section>


</main>

@endsection
