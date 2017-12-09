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
        $group->createGroup();
    }

    public function deleteGroup($president){
        #TODO call delete method, pass in Id
        $group = new Group();
        $group->getGroup();

        if($group->getGroupPresident() != $president){
            http_response_code(401);
            return "Unauthorized user trying to delete group";
        }
        $group->deleteGroup();
        return "Group successfully deleted";
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