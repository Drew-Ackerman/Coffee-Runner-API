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


    /****** USER CLOSURES ******/
    $handleCreateUser = function () {
        #TODO: validate the json
        $json = (object) json_decode(file_get_contents('php://input'));
        $userController = new UserController();
        $userController->createUser($json);
    };


    $handleDeleteUser = function ($args) {
        $userID = $args['userID'];
        #TODO: Write validation for the $userID
        $userController = new UserController();
        return $userController->deleteUser($userID);
    };

    $updateUserFoodPreference = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $userID = $args['userID'];
        $userController = new UserController();
        $userController->changeFoodPreference($userID, $json);
    };

    #TODO: Validate the json
    $updateUserDrinkPreference = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $userID = $args['userID'];
        $userController = new UserController();
        $userController->changeDrinkPreference($userID, $json);
    };

    $updateUserFirstName = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $userID = $args['userID'];
        $userController = new UserController();
        $userController->changeFirstName($userID, $json);
    };

    $updateUserLastName = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $userID = $args['userID'];
        $userController = new UserController();
        $userController->changeLastName($userID, $json);
    };


    /****** GROUP CLOSURES ******/
    $updateGroupPresident = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $groupID = $args['groupID'];
        $groupController = new GroupController();
        $groupController->changePresident($groupID, $json);
    };

    $updateGroupRunner = function ($args) {
        $json = (object) json_decode(file_get_contents('php://input'));
        $groupID = $args['groupID'];
        $groupController = new GroupController();
        return $groupController->changePresident($groupID, $json);
    };

    $createGroup = function () {
        $json = (object) json_decode(file_get_contents('php://input'));
        $groupController = new GroupController();
        return $groupController->createGroup($json);
    };

    $deleteGroup = function ($args) {
        $groupID = $args['groupID'];
        $groupController = new GroupController();
        return $groupController->deleteGroup($groupID);
    };

    $removeUserFromGroup = function ($args){
        $groupID = $args['groupID'];
        $userID = $args['userID'];
        $groupController = new GroupController();
        return $groupController->removeUserFromGroup($groupID, $userID);
    };

    /**** INVITE CLOSURES ****/
    $createInvite = function ($args) {
        $inviteController = new InviteController();
        $json = (object) json_decode(file_get_contents('php://input'));
        $inviteController->sendInvite($json);
    };

    $updateInviteStatus = function ($args) {
        $inviteID = $args['inviteID'];
        $json = (object) json_decode(file_get_contents('php://input'));
        $inviteController = new InviteController();
        return $inviteController->updateStatus($inviteID, $json);
    };

    $deleteInvite = function ($args) {
        $inviteID = $args['inviteID'];
        $inviteController = new InviteController();
        return $inviteController->deleteInvite($inviteID);
    };

    /******User Routes******/
    $r->addRoute(Methods::POST, $baseURI . "/user", $handleCreateUser);
    $r->addRoute(Methods::DELETE, $baseURI . "/user/{userID:\d+}", $handleDeleteUser);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/{userID:\d+}/foodpreference", $updateUserFoodPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/{userID:\d+}/drinkpreference", $updateUserDrinkPreference);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/{userID:\d+}/firstname", $updateUserFirstName);
    $r->addRoute(Methods::PATCH, $baseURI . "/user/{userID:\d+}/lastname", $updateUserLastName);

    /******Group Routes******/
    $r->addRoute(Methods::PATCH, $baseURI . "/group/{groupID:\d+}/president", $updateGroupPresident);
    $r->addRoute(Methods::PATCH, $baseURI . "/group/{groupID:\d+}/runner", $updateGroupRunner);
    $r->addRoute(Methods::POST, $baseURI . "/group", $createGroup);
    $r->addRoute(Methods::DELETE, $baseURI . "/group/{groupID:\d+}", $deleteGroup);
    $r->addRoute(Methods::DELETE, $baseURI . "/group/{groupID:\d+}/remove/{userID:\d+", $removeUserFromGroup);

    /******Invite Routes******/
    $r->addRoute(Methods::POST, $baseURI . "/invite", $createInvite);
    $r->addRoute(Methods::DELETE, $baseURI . "/invite/{inviteID:\d+}", $deleteInvite);
    $r->addRoute(Methods::PATCH, $baseURI . "/invite/{inviteID:\d+}/status", $updateInviteStatus);
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