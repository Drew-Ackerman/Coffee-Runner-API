<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 12:38 PM
 */

require_once 'config.php';
require_once 'vendor/autoload.php';
use CoffeeRunner\Http\Methods as Methods;
use CoffeeRunner\Http\StatusCodes as StatusCodes;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)  use ($baseURI) {
    /** TOKENS CLOSURES */
    $handlePostToken = function ($args) {
        $tokenController = new \CoffeeRunner\Controllers\TokensController();
        //Is the data via a form?
        if (!empty($_POST['username'])) {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? "";
        } else {
            //Attempt to parse json input
            $json = (object) json_decode(file_get_contents('php://input'));
            if (count((array)$json) >= 2) {
                $username = filter_var($json->username, FILTER_SANITIZE_STRING);
                $password = $json->password;
            } else {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit();
            }
        }
        return $tokenController->buildToken($username, $password);

    };

    $handleCreateUser = function ($args){

    };


    /******User Routes******/
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::DELETE, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::PATCH, $baseURI . "/users/foodpreference/", $updateUserFoodPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/users/drinkpreference", $updateUserDrinkPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/users/firstname", $updateUserFirstName);
    $r->addRoute(Methods::PATCH, $baseURI . "/users/lastname", $updateUserLastName);

    /******Group Routes******/
    $r->addRoute(Methods::PATCH, $baseURI . "/group/president/", $updateGroupPresident);
    $r->addRoute(Methods::PATCH, $baseURI . "/group/runner/", $updateGroupRunner);
    $r->addRoute(Methods::POST, $baseURI . "/group/", $createGroup);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $deleteGroup);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);
    $r->addRoute(Methods::POST, $baseURI . "/users/", $handleCreateUser);



    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    $pos = strpos($uri, '?');
    if ($pos !== false) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rtrim($uri, "/");

    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($method, $uri);

    switch($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(Scholarship\Http\StatusCodes::NOT_FOUND);
            //Handle 404
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(Scholarship\Http\StatusCodes::METHOD_NOT_ALLOWED);
            //Handle 403
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler  = $routeInfo[1];
            $vars = $routeInfo[2];

            $response = $handler($vars);
            echo json_encode($response);
            break;
    }