<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Category extends Controller
{
  public function title()
  {
	   return single_cat_title('', false);
  }

  public function color()
  {
    return get_field('color', get_category( get_query_var( 'cat' ) ));
  }

  public function categoryId()
  {
    return get_query_var( 'cat' );
  }

  public function posts()
  {
    $posts = get_posts([
      'post_type' 	   => 'post',
      'post_status'    => 'publish',
      'category__and'  => [get_query_var( 'cat' )],
      'orderby'        => 'date',
      'order'          => 'DESC',
      'posts_per_page' => 2
    ]);

    return $posts;
  }

  public function podcasts()
  {
    $podcasts = get_posts([
    	'post_type'      => 'podcast',
    	'post_status'    => 'publish',
      'category'       => [get_query_var( 'cat' )],
    	'orderby'        => 'date',
    	'order'          => 'DESC',
    	'posts_per_page' => 12,
    ]);

    return $podcasts;
  }
}
