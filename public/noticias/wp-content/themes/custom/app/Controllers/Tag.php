<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Tag extends Controller
{

  public function title()
  {
	   return single_tag_title('', false);
  }

  public function tagSlug()
  {
    return get_query_var( 'tag' );
  }

  public function posts()
  {
    $posts = get_posts([
    	'post_type'      => 'post',
    	'post_status'    => 'publish',
    	'orderby'        => 'date',
    	'order'          => 'DESC',
      'tag'            => get_query_var( 'tag' ),
    	'posts_per_page' => 2,
    ]);

    return $posts;
  }

}
