<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateClipping extends Controller
{

  public function vehicles()
  {
    $arrVehicles = [
  		'impresso' => [
  			'title' => 'Impresso',
  			'ico'   => '<svg width="36" height="37"><use xlink:href="#newspaper"/></svg>'
  		],
  		'radio' => [
  			'title' => 'Rádio',
  			'ico'   => '<svg width="26" height="38"><use xlink:href="#mic"/></svg>'
  		],
  		'televisao' => [
  			'title' => 'Televisão',
  			'ico'   => '<svg width="49" height="49"><use xlink:href="#tv"/></svg>'
  		],
  		'web' => [
  			'title' => 'Web',
  			'ico'   => '<svg width="55" height="37"><use xlink:href="#laptop"/></svg>'
  		],
  	];

    return $arrVehicles;
  }

  public function posts()
  {
    return self::_getFilteredPosts($_GET['subject'], $_GET['vehicle'], $_GET['date_after'], $_GET['date_before'], 2);
  }

  /**
   * Get clippings posts by filters
   *
   * @param string $subject
   * @param string $vehicle
   * @param string $dateAfter
   * @param string $dateBefore
   * @param int $ppp
   * @param int $pageNumber
   *
   * @return object
   */
  public static function _getFilteredPosts($subject = '', $vehicle = '', $dateAfter = '', $dateBefore = '', $ppp = 12, $pageNumber = 0)
  {
    // Get posts init args
    $args = [
      'post_type' 	   => 'clippings',
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'posts_per_page' => $ppp,
      'paged'          => $pageNumber,
      'date_query' => array(
          array(
              'after'     => null,
              'before'    => null,
              'inclusive' => true,
          ),
      ),
    ];

    // SUBJECT FILTER
    // ----------------------------------------------------------------------
    if($subject != "")
    {
      $args['s'] = sanitize_text_field($subject);
    }

    // CUSTOM FIELDS FILTERS
    // ----------------------------------------------------------------------
    // Array to add meta_query query items
    $arrFilter = array();

    // Filter vehicle
    if($vehicle != "")
    {
      $arrFilter[] = array(
        'key'		  => 'tipo',
        'value'		=> sanitize_text_field($vehicle),
        'compare'	=> '='
      );
    }

    // Marge filter arrays into meta_query
    $args['meta_query'] = array_merge(array('relation' => 'AND'), $arrFilter);

    // DATE FILTERS
    // ----------------------------------------------------------------------
    // Filter after date
    if($dateAfter != "")
    {
      $arrDate = explode('/', $dateAfter);

      $args['date_query'][0]['after'] = [
        'year'  => (int) $arrDate[2],
        'month' => (int) $arrDate[1],
        'day'   => (int) $arrDate[0]
      ];
    }

    // Filter before date
    if($dateBefore != "")
    {
      $arrDate = explode('/', $_GET['date_before']);

      $args['date_query'][0]['before'] = [
        'year'  => (int) $arrDate[2],
        'month' => (int) $arrDate[1],
        'day'   => (int) $arrDate[0]
      ];
    }

    return get_posts($args);
  }

}
