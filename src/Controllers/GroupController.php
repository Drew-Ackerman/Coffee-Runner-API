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

    public function getGroup($groupID) : Group{
        $groupModel = new Group();
        $groupID = filter_var($groupID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $groupModel->getGroup($groupID);
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
        if(empty($json->president)){
            http_response_code(400);
            return "A new Last Name was not provided";
        }
        $group = new Group();
        $group->getGroup($groupID);
        $newPresident = $json->president;

        if($group->getGroupPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the president";
        }
        $newPresident = filter_var($newPresident, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $group->changePresident($newPresident);
    }

    #Should change the runner of the group
    public function changeRunner($groupID, $json){
        if(empty($json->runner)){
            http_response_code(400);
            return "A new Last Name was not provided";
        }
        $group = new Group();
        $group->getGroup($groupID);
        $newRunner = $json->runner;

        if($group->getGroupPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the runner";
        }
        $newRunner = filter_var($newRunner, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $group->changeRunner($newRunner);
    }

    #Should remove a user from a group
    public function removeUserFromGroup($userID, $groupID) : String{
        if(empty($userID) || empty($groupID)){
            http_response_code(400);
            return "UserID or GroupID was not provided";
        }
        $group = new Group();
        $group->getGroup($groupID);

        if($group->getGroupPresident() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to remove user from group
                    Only the group president can remove users from the group";
        }
        $groupUserController = new GroupUserController();
        return $groupUserController->deleteGroupUser($userID, $groupID);
    }

    public function getAllUsersFromGroup($groupID){
        if(empty($groupID)){
            http_response_code(400);
            return "UserID or GroupID was not provided";
        }
        $username = Token::getUsernameFromToken();
        $group = new Group();
        $groupID = filter_var($groupID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $group->getAllUsersFromGroup($groupID, $username);
    }

}