<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:36 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\Group;

class GroupController
{
    public static function createGroup($args){
        $group = new Group();
        $group->setGroupName();
        $group->setGroupRunner();
        $group->setGroupPresident();
    }

    public function deleteGroup(){
        #TODO call delete method, pass in Id
    }

    public function changePresident(){
        #TODO call change President method
    }

    public function changeRunner(){
        #TODO call change runner method
    }

    public function inviteUser(){
        #TODO call invite user method
    }

    public function deleteUser(){
        #TODO remove user from group
    }
}