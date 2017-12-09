<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:38 PM
 */

namespace CoffeeRunner\Controllers;


use CoffeeRunner\Models\groupUser;

class GroupUserController
{

    public function createGroupUser($user, $group){
        #TODO create groupuser
        GroupUser::createGroupUser($user, $group);
    }
    public function deleteGroupUser(){
        #TODO delete Groupuser
    }
}