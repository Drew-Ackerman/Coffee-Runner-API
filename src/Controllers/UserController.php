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
        $json
        $newUser = new User();
        $newUser->create();
    }

    public function deleteUser(){

    }

    public function changeFoodPreference(){

    }

    public function changeDrinkPreference(){

    }

    public function changeFirstName(){

    }

    public function changeLastName(){

    }
}