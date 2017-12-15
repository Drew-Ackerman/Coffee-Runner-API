<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:47 PM
 */

namespace CoffeeRunner\Controllers;

use CoffeeRunner\Models\Invite;

#TODO: do validation on json
#TODO: do validation on args

class InviteController
{
    public function createInvite($json){
        $invite = new Invite();
        $invite->setGroupID($json->groupID);
        $invite->setFromUserID($json->fromUserID);
        $invite->setToUserID($json->toUserID);
        $invite->setStatus(INVITE::STATUS_PENDING);
        return $invite->createInvite();
    }


    public function updateStatus($inviteID, $json){
        $status = $json->status;
        $invite = new Invite();
        $success = $invite->updateInviteStatus($inviteID, $status);

        if($success == True){
            return "Status of invite has been changed";
        }
        return "Invite Status Unchanged";
    }

    #This is just a method to delete/cancel a sent invite.
    public function deleteInvite($inviteID) : String{
        $invite = new Invite();
        #TODO: Delete invite request, Discuss with kyle
    }

    public function getInvite($inviteID){
        $invite = new Invite();
        $inviteID = filter_var($inviteID, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        return $invite->getInvite($inviteID);
    }
}