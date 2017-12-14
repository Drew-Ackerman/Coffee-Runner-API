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
#TODO: TALK TO KYLE ABOUT THE STATUS PENDING

class InviteController
{
    public function sendInvite($json){
        $invite = new Invite();
        $invite->setGroupID($json->groupID);
        $invite->setFromUserID($json->fromUserID);
        $invite->setToUserID($json->toUserID);
        $invite->setStatus(INVITE::STATUS_PENDING);
        $invite->createInvite();
        return $invite->sendInvite(); #TODO: we need to figure this logic out, how do we 'send' and invite.
    }


    public function updateStatus($inviteID, $json) : Invite{
        $invite = new Invite();
        #TODO: Finish this method with kyle
    }

    #This is just a method to delete/cancel a sent invite.
    public function deleteInvite($inviteID) : String{
        $invite = new Invite();
        #TODO: Delete invite request, Discuss with kyle
    }
}