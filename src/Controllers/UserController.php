<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:37 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\User;

class UserController
{
    public static function createUser($json){
        $newUser = new User();
        #TODO: create a user through setters or the construct method 
        $newUser->create();
    }

    public function deleteUser(){
        $newUser = new User();
    }

    public function changeFoodPreference(){
        $newUser = new User();
    }

    public function changeDrinkPreference(){
        $newUser = new User();
    }

    public function changeFirstName(){
        $newUser = new User();
    }

    public function changeLastName(){
        $newUser = new User();
    }
}