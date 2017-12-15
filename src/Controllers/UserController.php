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

    public function getUser($userID){
        $userModel = new User();
        $userID = filter_var($userID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $userModel->getUser($userID);
    }

    #Should delete the user
    public function deleteUser($userID){
        $userModel = new User();
        $user = $userModel->getUser($userID);
        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized deletion of user";
        }
        If($user[0]->deleteUser()){
            return "Deletion of user was successful";
        }
        return "Deletion of user was not successful";
    }

    #Should change the food preference for a user
    public function changeFoodPreference($userID, $json){
        if(empty($json->foodPreference)){
            http_response_code(400);
            return "A new Food Preference was not provided";
        }
        $newFoodPref = $json->foodPreference;
        $user = new User();
        $user = $user->getUser($userID);

        if(empty($newFoodPref)) {
            http_response_code(400);
            return "Supplied food preference is not valid.";
        }
        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newFoodPref = filter_var($newFoodPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        if($user[0]->updateFood($newFoodPref)){
            return "Food change was successful";
        }
        return "Food change was not successful";
    }

    #Should change the drink preference for a user
    public function changeDrinkPreference($userID, $json){
        if(empty($json->drinkPreference)){
            http_response_code(400);
            return "A new Drink Preference was not provided";
        }
        $newDrinkPref = $json->drinkPreference;
        $user = new User();
        $user = $user->getUser($userID);

        if(empty($newDrinkPref)){
            http_response_code(400);
            return "Supplied drink preference is not valid.";
        }
        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newDrinkPref = filter_var($newDrinkPref, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        if($user[0]->updateDrink($newDrinkPref)){
            return "Drink change successful";
        }
        return "Drink change not successful";
    }

    #Should change the first name for a user
    public function changeFirstName($userID, $json)
    {
        if(empty($json->firstName)){
            http_response_code(400);
            return "A new First Name was not provided";
        }
        $newFirstName = $json->firstName;
        $user = new User();
        $user = $user->getUser($userID);

        if(empty($newFirstName)){
            http_response_code(400);
            return "Supplied first name is not valid.";
        }
        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user";
        }
        $newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        if($user[0]->updateFirstName($newFirstName)){
            return "First Name change successful";
        }
        return "First name change not successful";
    }

    #Should change the last name for a user
    public function changeLastName($userID, $json)
    {
        if(empty($json->lastName)){
            http_response_code(400);
            return "A new Last Name was not provided";
        }
        $newLastName = $json->lastName;
        $user = new User();
        $user = $user->getUser($userID);

        if (empty($newLastName)) {
            http_response_code(400);
            return "Supplied last name is not valid.";
        }
        if ($user[0]->getUserName() != Token::getUsernameFromToken()) {
            http_response_code(401);
            return "Unauthorized user";
        }

        $newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        if($user[0]->updateLastName($newLastName)){
            return "Last name change successful";
        }
        return "Last name change not successful";
    }
}