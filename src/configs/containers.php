<?php
/**
 * Injeção de Dependência
 */
$container = $app->getContainer();

/**
 * @return \Slim\Middleware\Session
 */
$container['sessionMiddleware'] = function () {
    return new \Slim\Middleware\Session([
        'name' => getenv('APP_PREFIX').'_session',
        'lifetime' => getenv('APP_SESSION_EXPIRE'),
        'autorefresh' => true
    ]);
};

/**
 * @return \SlimSession\Helper
 */
$container['session'] = function () {
    return new \SlimSession\Helper();
};

/**
 * @param $container
 * @return \App\Middleware\Auth
 */
$container['auth'] = function ($container) {
    return new \App\Middleware\Auth($container);
};

/**
 * @param $container
 * @return \Slim\Views\Twig
 */
$container['view'] = function ($container) {
    $view = new Slim\Views\Twig(ROOT_DIR.getenv('DIR_VIEW'));

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new System\CsrfExtension($container->get('csrf')));

    return $view;
};

/**
 * @param $container
 * @return \Illuminate\Database\Capsule\Manager
 */
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager();
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

/**
 * @return \Slim\Csrf\Guard
 */
$container['csrf'] = function() {
    $guard = new \Slim\Csrf\Guard;

    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });

    return $guard;
};
