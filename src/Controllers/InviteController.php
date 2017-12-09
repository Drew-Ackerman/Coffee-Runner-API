<?php
/**
 * Created by PhpStorm.
 * User: Drew
 * Date: 12/2/2017
 * Time: 3:47 PM
 */

namespace CoffeeRunner\Controllers;

# TODO: Ask about best practice for the status field, set in databse or pass in on creation
use CoffeeRunner\Models\Invite;

class InviteController
{

//    const STATUS_DECLINED = "Declined";
//    const STATUS_ACEEPTED = "Accepted";
//
//    private $groupID;
//    private $fromUserID;
//    private $toUserID;
//    private $status = "Pending";

    public static function sendInvite($args){
        $invite = new Invite();
        #TODO: Send INVITE
    }


    public function patchStatus($args){
        $invite = new Invite();
        #TODO: Update invite status
    }

    #This is just a method to delete/cancel a sent invite.
    public function deleteInvite($inviteID){
        $invite = new Invite();
        #TODO: Delete invite request
    }
}