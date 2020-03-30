<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Search extends Controller
{

  public function posts()
  {
    $posts = get_posts([
    	'post_type'      => 'post',
    	'post_status'    => 'publish',
    	'orderby'        => 'date',
    	'order'          => 'DESC',
      's'              => sanitize_text_field($_GET['s']),
    	'posts_per_page' => 2,
    ]);

    return $posts;
  }

}
