<?php

namespace App;

class Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_load_more_posts', [$this, 'loadMorePosts']);
        add_action('wp_ajax_nopriv_load_more_posts', [$this, 'loadMorePosts']);

        add_action('wp_ajax_load_more_podcasts', [$this, 'loadMorePodcasts']);
        add_action('wp_ajax_nopriv_load_more_podcasts', [$this, 'loadMorePodcasts']);

        add_action('wp_ajax_load_more_clippings', [$this, 'loadMoreClippings']);
        add_action('wp_ajax_nopriv_load_more_clippings', [$this, 'loadMoreClippings']);

        add_action('wp_ajax_load_more_search', [$this, 'loadMoreSearch']);
        add_action('wp_ajax_nopriv_load_more_search', [$this, 'loadMoreSearch']);
    }

    public function loadMorePosts()
    {
      $ppp  = (isset($_POST["ppp"])) ? $_POST["ppp"] : 2;
      $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
      $response = '';

      $posts = get_posts([
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'suppress_filters' => true,
        'posts_per_page'   => (int) $ppp,
        'cat'              => (int) $_POST['cat'],
        'paged'            => (int) $page,
      ]);

    	if($posts) : ob_start();

    		foreach($posts as $post) :

          include \App\template_path(locate_template('views/partials/_card-news.blade.php'));

          $response = ob_get_contents();

    		endforeach;

        ob_end_clean();
    	endif;

      wp_reset_postdata();
      wp_die($response);
    }

    public function loadMorePodcasts()
    {
      $ppp  = (isset($_POST["ppp"])) ? $_POST["ppp"] : 12;
      $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
      $response = '';

      $podcasts = get_posts([
        'post_type'        => 'podcast',
      	'post_status'      => 'publish',
      	'orderby'          => 'date',
      	'order'            => 'DESC',
        'suppress_filters' => true,
        'posts_per_page'   => (int) $ppp,
        'paged'            => (int) $page,
      ]);

    	if($podcasts) : ob_start();

    		foreach($podcasts as $podcast) :

          include \App\template_path(locate_template('views/partials/_card-podcast.blade.php'));

          $response = ob_get_contents();

    		endforeach;

        ob_end_clean();
    	endif;

      wp_reset_postdata();
      wp_die($response);
    }

    public function loadMoreClippings()
    {
      $response = '';

      $posts = \App\Controllers\TemplateClipping::_getFilteredPosts($_POST['subject'], $_POST['vehicle'], $_POST['dateAfter'], $_POST['dateBefore'], 2, $_POST['pageNumber']);

      if($posts) : ob_start();

    		foreach($posts as $post) :

          include \App\template_path(locate_template('views/partials/_card-clipping.blade.php'));

          $response = ob_get_contents();

    		endforeach;

        ob_end_clean();
    	endif;

      wp_reset_postdata();
      wp_die($response);
    }

    public function loadMoreSearch()
    {
      $ppp  = (isset($_POST["ppp"])) ? $_POST["ppp"] : 12;
      $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
      $response = '';

      $posts = get_posts([
        'post_type'        => 'post',
      	'post_status'      => 'publish',
      	'orderby'          => 'date',
      	'order'            => 'DESC',
        's'                => sanitize_text_field($_POST['s']),
        'tag'              => sanitize_text_field($_POST['tag']),
        'suppress_filters' => true,
        'posts_per_page'   => (int) $ppp,
        'paged'            => (int) $page,
      ]);

    	if($posts) : ob_start();

    		foreach($posts as $post) :

          include \App\template_path(locate_template('views/partials/_card-search-news.blade.php'));

          $response = ob_get_contents();

    		endforeach;

        ob_end_clean();
    	endif;

      wp_reset_postdata();
      wp_die($response);
    }

}

new Ajax();
