<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplatePodcasts extends Controller
{

  public function podcasts()
  {
    $podcasts = get_posts([
    	'post_type'      => 'podcast',
    	'post_status'    => 'publish',
    	'orderby'        => 'date',
    	'order'          => 'DESC',
    	'posts_per_page' => 12,
    ]);

    return $podcasts;
  }

}
