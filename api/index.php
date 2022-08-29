<?php


// change name 
$theme_name = 'sage';




// load wordpress functions
require_once '../wp-load.php';




// check theme
if (wp_get_theme()->name != $theme_name) {
    header('Location: ' . home_url());
    exit();
}




// get request uri 
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('/', $request_uri);
$request_uri = array_filter($request_uri);
$request_uri = array_values($request_uri);
foreach ($request_uri as $key => $uri) {
    unset($request_uri[$key]);
    if ($uri == 'api') {
        break;
    }
}
$request_uri = array_values($request_uri);




// set controller name
$controller_name = $request_uri[0] ?: '';
unset($request_uri[0]);




// set method name
if (strpos($request_uri[1], '?') !== false) {
    $request_uri[1] = explode('?', $request_uri[1]);
}

if (is_array($request_uri[1])) {
    $controller_method = $request_uri[1][0] ?: '';
}

if (!is_array($request_uri[1])) {
    $controller_method = $request_uri[1] ?: '';
}

unset($request_uri[1]);




// set parameters
$request_uri = array_values($request_uri);
foreach ($request_uri as $key => $uri) {

    if (strpos($uri, '?') !== false) {
        $_uri = explode('?', $uri);
        $request_uri[$key] = $_uri[0];
    }
}
$controller_parameters = $request_uri;




// load sage controller
$sage_controller = new $controller_name;
$sage_controller->$controller_method(...$controller_parameters);
