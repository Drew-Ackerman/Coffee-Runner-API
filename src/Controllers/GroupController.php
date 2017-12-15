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
use CoffeeRunner\Models\GroupUser;
use CoffeeRunner\Models\User as User;
use CoffeeRunner\Models\Token as Token;

#TODO: do validation on json
#TODO: do validation on args

class GroupController
{
    #Should create a group
    public function createGroup($json){
        $group = new Group();
        $group->setGroupName($json->groupName);
        $group->setGroupRunner($json->groupRunner);
        $group->setGroupPresident($json->groupPresident);
        return $group->createGroup();
    }

    public function getGroup($groupID){
        $groupModel = new Group();
        $groupID = filter_var($groupID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $groupModel->getGroup($groupID);
    }

    #Should delete the entire group
    public function deleteGroup($groupID){
        $group = new Group();
        $group = $group->getGroup($groupID);
        $user = new User();
        $user = $user->getUser($group[0]->getGroupPresident());

        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to delete group";
        }
        $group[0]->deleteGroup();
        return "Group successfully deleted";
    }

    #Should change the president of the group
    public function changePresident($groupID, $json){
        if(empty($json->president)){
            http_response_code(400);
            return "A new president was not provided";
        }
        $group = new Group();
        $group = $group->getGroup($groupID);
        $user = new User();
        $user = $user->getUser($group[0]->getGroupPresident());

        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the president";
        }
        $newPresident = $json->president;
        $newPresident = filter_var($newPresident, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        if($group[0]->changePresident($newPresident)){
            return "Group President changed";
        }
        return "Group President not changed";
    }

    #Should change the runner of the group
    public function changeRunner($groupID, $json){
        if(empty($json->runner)){
            http_response_code(400);
            return "A new Runner was not provided";
        }
        $group = new Group();
        $group = $group->getGroup($groupID);
        $user = new User();
        $user = $user->getUser($group[0]->getGroupPresident());

        if($user[0]->getUserName() != Token::getUsernameFromToken()){
            http_response_code(401);
            return "Unauthorized user trying to change presidents
                    Only the current president of the group can change the runner";
        }
        $newRunner = $json->runner;
        $newRunner = filter_var($newRunner, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        if($group[0]->changeRunner($newRunner)){
            return "Runner change successful";
        }
        return "Runner change not successful";
    }

    #Should remove a user from a group
    public function removeUserFromGroup($userID, $groupID){
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
        $groupUser = new GroupUser();

        $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $groupID = filter_var($groupID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        if($groupUser->verifyUserInGroup($groupID, $username) == 1){
            return $group->getAllUsersInGroup($groupID);
        }
        else{
            http_response_code(401);
            Return "User not a part of requested group";
        }


    }

}