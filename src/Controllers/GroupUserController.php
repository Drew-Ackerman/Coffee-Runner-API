<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:38 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\Group;
use CoffeeRunner\Models\groupUser;

class GroupUserController
{
    public function createGroupUser($userID, $groupID){
        #This methods will create a user for a group
        $groupUser = new GroupUser();
        $groupUser->setGroupID($groupID);
        $groupUser->setUserID($userID);
        return $groupUser->createGroupUser();
    }

    public function deleteGroupUser($userID, $groupID){
        #This method should delete a given user from a given group.
        $groupUser = new GroupUser();
        $groupUser->setGroupID($groupID);
        $groupUser->setUserID($userID);
        return $groupUser->deleteGroupUser();
    }
}