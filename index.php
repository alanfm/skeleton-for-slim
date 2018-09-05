<?php

/**
 * Define o diretório root da aplicação
 */
if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', __DIR__.DIRECTORY_SEPARATOR);
}

/**
 * Verifica se foi instalado os pacotes de terceiros
 */
if (!file_exists(ROOT_DIR.'vendor/autoload.php')) {
    die('<p>Por favor instalar as depedências do projeto: <code>$ composer install</code></p>');
}

/**
 * Inclue o autoload dos pacotes de terceiros
 */
require ROOT_DIR.'vendor/autoload.php';

/**
 * Carrega as variáveis de configuração
 */
(new Symfony\Component\Dotenv\Dotenv())->load(ROOT_DIR.'src/configs/.env');

/**
 * Inclue a configurações do Microframework Slim
 */
require ROOT_DIR.'src/configs/configs.php';

/**
 * Instancia o Microframework Slim
 */
$app = new Slim\App(['settings'=>$configs]);

/**
 * Inclue a injeção dependências
 */
require ROOT_DIR.'src/configs/containers.php';

/**
 * Adiciona a ferramenta de seguraça CSRF
 */
$app->add($container->get('csrf'));

/**
 * Adiciona as rotas do sistema
 */
System\Routes::get($app);

/**
 * Adiciona a ferramenta de seguração para Sessões
 */
$app->add($container->get('sessionMiddleware'));

/**
 * Executa o Microframework Slim
 */
$app->run();