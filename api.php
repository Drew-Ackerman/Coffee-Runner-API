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
use CoffeeRunner\Controllers\UserController as UserController;
use CoffeeRunner\Controllers\GroupController as GroupController;
use CoffeeRunner\Controllers\InviteController as InviteController;

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
            $json = (object)json_decode(file_get_contents('php://input'));
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

    $handleCreateUser = function ($args) {
        $userController = new UserController();
        $json = (object) json_decode(file_get_contents('php://input'), true);
        $userController::createUser($json);
    };

    $handleDeleteUser = function ($args) {
        $userController = new UserController();
    };

    $updateUserFoodPreference = function ($args) {
        $userController = new UserController();
    };

    $updateUserDrinkPreference = function ($args) {
        $userController = new UserController();
    };

    $updateUserFirstName = function ($args) {
        $userController = new UserController();
    };

    $updateUserLastName = function ($args) {
        $userController = new UserController();
    };

    $updateGroupPresident = function ($args) {
        $groupController = new GroupController();
    };

    $updateGroupRunner = function ($args) {
        $groupController = new GroupController();
    };

    $createGroup = function ($args) {
        $groupController = new GroupController();
    };

    $deleteGroup = function ($args) {
        $groupController = new GroupController();
    };

    $createInvite = function ($args) {
        $inviteController = new InviteController();
    };

    $updateInviteStatus = function ($args) {
        $inviteController = new InviteController();
    };

    $deleteInvite = function ($args) {
        $inviteController = new InviteController();
    };

    /******User Routes******/
    $r->addRoute(Methods::POST, $baseURI . "/user", $handleCreateUser);
    $r->addRoute(Methods::DELETE, $baseURI . "/user", $handleDeleteUser);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/foodpreference", $updateUserFoodPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/drinkpreference", $updateUserDrinkPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/firstname", $updateUserFirstName);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/lastname", $updateUserLastName);

    /******Group Routes******/
    $r->addRoute(Methods::PATCH, $baseURI . "/group/president", $updateGroupPresident);
    $r->addRoute(Methods::PATCH, $baseURI . "/group/runner", $updateGroupRunner);
    $r->addRoute(Methods::POST, $baseURI . "/group", $createGroup);
    $r->addRoute(Methods::DELETE, $baseURI . "/group", $deleteGroup);
    $r->addRoute(Methods::POST, $baseURI . "/group/invite", $createInvite);
    $r->addRoute(Methods::PATCH, $baseURI . "/group/invite/status", $updateInviteStatus);

    /******Invite Routes******/
    $r->addRoute(Methods::POST, $baseURI . "/invite", $deleteInvite);

});


    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    $pos = strpos($uri, '?');
    if ($pos !== false) {
        $uri = substr($uri, 0, $pos);
    }

    $uri = rawurldecode($uri);

    $routeInfo = $dispatcher->dispatch($method, $uri);

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(StatusCodes::NOT_FOUND);
            //Handle 404
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(StatusCodes::METHOD_NOT_ALLOWED);
            //Handle 403
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            $response = $handler($vars);
            echo json_encode($response);
            break;
    }