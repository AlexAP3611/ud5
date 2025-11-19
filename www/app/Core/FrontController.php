<?php

namespace Com\Daw2\Core;
use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\TrabajadoresController;
use Steampixel\Route;

class FrontController
{
    public static function main(): void
    {
        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
        );
        Route::add(
            '/trabajadores1',
            function () {
                $controlador = new \Com\Daw2\Controllers\TrabajadoresController();
                $controlador->trabajadores1();
            },
            'get'
        );
        Route::add(
            '/trabajadores2',
            function () {
                $controlador = new \Com\Daw2\Controllers\TrabajadoresController();
                $controlador->trabajadores2();
            },
            'get'
        );
        Route::add(
            '/trabajadores3',
            function () {
                $controlador = new \Com\Daw2\Controllers\TrabajadoresController();
                $controlador->trabajadores3();
            },
            'get'
        );
        Route::add(
            '/trabajadores4',
            function () {
                $controlador = new \Com\Daw2\Controllers\TrabajadoresController();
                $controlador->trabajadores4();
            },
            'get'
        );
        Route::add(
            '/trabajadores5',
            function () {
                $controlador = new \Com\Daw2\Controllers\TrabajadoresController();
                $controlador->getByFilters();
            },
            'get'
        );
        Route::add(
            '/trabajadores6',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores6();
            },
            'get'
        );
        Route::add(
            '/trabajadores6',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->doTrabajadores6();
            },
            'post'
        );
        Route::pathNotFound(
            function () {
                $controller = new ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new ErroresController();
                $controller->error405();
            }
        );
        Route::run($_ENV['host.folder']);
    }
}
