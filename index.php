<?php
/**
 * Step 1: Require the Slim PHP 5 Framework
 *
 * If using the default file layout, the `Slim/` directory
 * will already be on your include path. If you move the `Slim/`
 * directory elsewhere, ensure that it is added to your include path
 * or update this file path as needed.
 */
require 'slim/Slim.php';
include_once 'markdown.php';
require 'MustacheView.php';
MustacheView::$mustacheDirectory = 'mustache/';

/**
 * Step 2: Instantiate the Slim application
 *
 * Here we instantiate the Slim application with its default settings.
 * However, we could also pass a key-value array of settings.
 * Refer to the online documentation for available settings.
 */
$app = new Slim(array(
    'view' => 'MustacheView'
));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function. If you are using PHP < 5.3, the
 * second argument should be any variable that returns `true` for
 * `is_callable()`. An example GET route for PHP < 5.3 is:
 *
 * $app = new Slim();
 * $app->get('/hello/:name', 'myFunction');
 * function myFunction($name) { echo "Hello, $name"; }
 *
 * The routes below work with PHP >= 5.3.
 */

// ob_start();
// require 'templates/body.mustache';
// $body = ob_get_clean();

//GET route
$app->get('/', function () use ($app) {

    ob_start();
    require 'templates/body.md';
    $md = ob_get_clean();
    $body = Markdown($md);

    $app->render('index.mustache', array(
        'title' => 'Upright Netizen',
        'description' => 'We break things',
        'author' => 'Nathan and Jared Stilwell',
        // 'body' => '<h1>hello</h1>'
        'body' => $body
    ));
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This is responsible for executing
 * the Slim application using the settings and routes defined above.
 */
$app->run();
