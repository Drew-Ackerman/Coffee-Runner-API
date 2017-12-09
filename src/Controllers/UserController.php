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

class UserController
{
    public static function createUser($json){
        $newUser = new User();
        $newUser->setFirstName();
        $newUser->setLastName();
        $newUser->setUserName();
        $newUser->setDrinkPreference();
        $newUser->setFoodPreference();
        $newUser->create();
    }

    public function deleteUser(){
        $userName = Token::getUsernameFromToken();
        $newUser = User::deleteUser($userName);
        return $newUser;
    }

    public function changeFoodPreference($newFoodPref){
        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied first name is not valid.";
        }
        $userName = Token::getUsernameFromToken();
        $newFoodPref = filter_var($newFoodPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $user = User::changeFoodPreference($userName, $newFoodPref);
        return $user();
    }

    public function changeDrinkPreference($newDrinkPref){
        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied first name is not valid.";
        }
        $userName = Token::getUsernameFromToken();
        $newDrinkPref = filter_var($newDrinkPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $user = User::changeDrinkPreference($userName, $newDrinkPref);
        return $user;
    }

    public function changeFirstName($newFirstName){
        if(empty($newFirstName)){
         http_response_code(400);
         return "Supplied first name is not valid.";
        }
        $newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $userName = Token::getUsernameFromToken();
        $user = User::changeFirstname($userName, $newFirstName);
        return $user;
    }

    public function changeLastName($newLastName){
        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied first name is not valid.";
        }
        $userName = Token::getUsernameFromToken();
        $newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $user = User::changeLastname($userName, $newLastName);
        return $user;
    }
}