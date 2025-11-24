<?php
declare(strict_types=1);
namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Steampixel\Route;
use Com\Daw2\Controllers\TrabajadoresController;

class FrontController
{
    public static function main(): void
    {
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new InicioController();
                $controlador->demo();
            },
            'get'
        );
        Route::add(
            '/trabajadores1',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores1();
            },
            'get'
        );
        Route::add(
            '/trabajadores2',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores2();
            },
            'get'
        );
        Route::add(
            '/trabajadores3',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores3();
            },
            'get'
        );
        Route::add(
            '/trabajadores4',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores4();
            },
            'get'
        );
        Route::add(
            '/trabajadores',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadores();
            },
            'get'
        );
        Route::add(
            '/trabajadores/new',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->trabajadoresNew();
            },
            'get'
        );
        Route::add(
            '/trabajadores/new',
            function () {
                $controlador = new TrabajadoresController();
                $controlador->doTrabajadoresNew();
            },
            'post'
        );
        Route::add(
            '/trabajadores/edit/(\w{4,50})',
            function ($username) {
                $controlador = new TrabajadoresController();
                $controlador->trabajadoresEdit($username);
            },
            'get'
        );
        Route::add(
            '/trabajadores/edit/(\w{4,50})',
            function ($username) {
                $controlador = new TrabajadoresController();
                $controlador->doTrabajadoresEdit($username);
            },
            'post'
        );
        Route::add(
            '/trabajadores/delete/(\w{4,50})',
            function ($username) {
                $controlador = new TrabajadoresController();
                $controlador->trabajadoresDelete($username);
            },
            'get'
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
        //CAMBIO DE: Route::run($_ENV['host.folder']);
        //A Route::run();
        Route::run($_ENV['host.folder']);

    }
}
