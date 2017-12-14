<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:37 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\User;
use CoffeeRunner\Models\Token as Token;

#TODO: do validation on json
#TODO: do validation on args

class UserController
{
    public function createUser($json){
        $newUser = new User();
        
        $newUser->setFirstName($json->firstName);
        $newUser->setLastName($json->lastName);
        $newUser->setUserName($json->username);
        $newUser->setDrinkPreference($json->drinkPreference);
        $newUser->setFoodPreference($json->foodPreference);
        return $newUser->createUser();
    }

    public function deleteUser($userID){
        $userModel = new User();
        $user = $userModel->getUser($userID);
        if($user->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized deletion of user";
        }
        return $userModel->deleteUser(); #TODO
    }

    public function changeFoodPreference($userID, $json){
        $newFoodPref = $json->foodPreference;
        $user = new User();
        $user->getUser($userID);

        if(empty($newFoodPref)) {
            http_response_code(400);
            return "Supplied food preference is not valid.";
        }
        if($user->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newFoodPref = filter_var($newFoodPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        return $user->updateFood();
    }

    public function changeDrinkPreference($userID, $json){
        $newDrinkPref = $json->drinkPreference;
        $user = new User();
        $user->getUser($userID);

        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied drink preference is not valid.";
        }
        if($user->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newDrinkPref = filter_var($newDrinkPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $user->updateDrink();
    }

    public function changeFirstName($userID, $json){
        $newFirstName = $json->firstName;
        $user = new User();
        $user->getUser($userID);

        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied first name is not valid.";
        }
        if($user->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $user->updateFirstName();
    }

    public function changeLastName($userID, $json)
    {
        $newLastName = $json->lastName;
        $user = new User();
        $user->getUser($userID);

        if (empty($newFirstName)) {
            http_response_code(400);
            return "Supplied last name is not valid.";
        }
        if ($user->getUserName() != Token::getUsernameFromToken()) {
            http_response_code(401);
            return "Unauthorized user";
        }

        $newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $user->updateLastName();
    }
}