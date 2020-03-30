<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
    ? $container->makeWith($abstract, $parameters)
    : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
    ->map(function ($template) use ($paths_pattern) {
        /** Remove .blade.php/.blade/.php from template names */
        $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

        /** Remove partial $paths from the beginning of template names */
        if (strpos($template, '/')) {
            $template = preg_replace($paths_pattern, '', $template);
        }

        return $template;
    })
    ->flatMap(function ($template) use ($paths) {
        return collect($paths)
        ->flatMap(function ($path) use ($template) {
            return [
                "{$path}/{$template}.blade.php",
                "{$path}/{$template}.php",
            ];
        })
        ->concat([
            "{$template}.blade.php",
            "{$template}.php",
        ]);
    })
    ->filter()
    ->unique()
    ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}


/**
 * Checks if asset exist.
 *
 * @param string $asset Full file path of the asset.
 *
 * @return bool
 */
function asset_exist( $asset ) {
    if ( file_exists( asset_file( $asset ) ) )
        return true;

    return false;
}

/**
 * Retrieve full path to asset file
 *
 * @example /Users/username/Sites/test.ch/web/app/themes/themefolder/dist/styles/main.css
 *
 * @param string $asset Filename including subfolder after 'dist/' like 'styles/main.css'
 *
 * @return string
 */
function asset_file( $asset ) {
    $asset_file     = sage( 'assets' )->get( $asset );
    $asset_filepath = str_replace( 'resources', '', get_stylesheet_directory() ) . "dist/{$asset_file}";

    return $asset_filepath;
}

/**
 * Returns dynamic version, based on file modified date.
 *
 * @param string $asset Filename including subfolder like 'styles/main.css'
 *
 * @return bool|int Modified date as UNIX Timestamp. False if file not exist.
 */
function asset_version( $asset ) {
    $asset_file     = sage( 'assets' )->get( $asset );
    $asset_filepath = get_stylesheet_directory() . "/../dist/{$asset_file}";

    if ( file_exists( $asset_filepath ) )
        return filemtime( $asset_filepath );

    return false;
}