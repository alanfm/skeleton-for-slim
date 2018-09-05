<?php

namespace System;

/**
 * Routes
 * 
 * Lista os os arquivos de routes
 * 
 * @author Alan Freire <alan.freire@ifce.edu.br>
 */
class Routes
{
    /**
     * @method get
     * 
     * Inclue os arquivos de routes
     *
     * @return void
     */
    public static function get($app)
    {
        $dir = str_replace('/', DIRECTORY_SEPARATOR, ROOT_DIR.getenv('DIR_ROUTES'));

        foreach (static::parse($dir) as $route) {
            include $dir.$route;
        }
    }

    /**
     * @method parse
     *
     * Analisa os arquivos e retira o (.) ponto e (..) dois pontos
     *
     * @param $dir
     * @return array
     */
    private static function parse($dir)
    {
        $files = scandir($dir);
        unset($files[array_search('.', $files)]);
        unset($files[array_search('..', $files)]);

        return $files;
    }
}