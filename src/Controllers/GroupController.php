<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:36 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\Group as Group;
use CoffeeRunner\Models\GroupUser as GroupUse;
use CoffeeRunner\Models\Invite as Invite;
use CoffeeRunner\Models\Token as Token;

#TODO: do validation on json
#TODO: do validation on args


class GroupController
{
    #Should create a group
    public function createGroup($json) : Group{
        $group = new Group();
        $group->setGroupName($json->groupName);
        $group->setGroupRunner($json->groupRunner);
        $group->setGroupPresident($json->groupPresident);
        return $group->createGroup();
    }

    #Should delete the entire group
    public function deleteGroup($groupID) : String{
        $group = new Group();
        $group->getGroup($groupID);

        if($group->getGroupPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to delete group";
        }
        $group->deleteGroup();
        return "Group successfully deleted";
    }

    #Should change the president of the group
    public function changePresident($groupID, $json){
        $group = new Group();
        $group->getGroup($groupID);
        $newPresident = $json->president;

        if($group->getGroupPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the president";
        }
        return $group->changePresident($newPresident);
    }

    #Should change the runner of the group
    public function changeRunner($groupID, $json){
        $group = new Group();
        $group->getGroup($groupID);
        $newRunner = $json->runner;

        if($group->getPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the runner";
        }
        return $group->changeRunner($newRunner);
    }

    #Should remove a user from a group
    public function removeUserFromGroup($userID, $groupID) : String{
        $group = new Group();
        $group->getGroup($groupID);

        if($group->getPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to remove user from group
                    Only the group president can remove users from the group";
        }
        $groupUserController = new GroupUserController();
        return $groupUserController->deleteGroupUser($userID, $groupID);
    }

}