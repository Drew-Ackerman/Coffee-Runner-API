<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:29
 */

namespace CoffeeRunner\Models;


class Invite
{
    private $inviteID;
    private $groupID;
    private $fromUserID;
    private $toUserID;
    private $status;

    public function __construct()
    {


    }

    /**
     * send Invite
     */
    public function sendInvite()
    {

    }

    /**
     * delete or cancel the invite
     */
    public function cancelInvite()
    {

    }

    /**
     * @return mixed
     */
    public function getInviteID()
    {
        return $this->inviteID;
    }

    /**
     * @param mixed $inviteID
     */
    public function setInviteID($inviteID)
    {
        $this->inviteID = $inviteID;
    }

    /**
     * @return mixed
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * @param mixed $groupID
     */
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;
    }

    /**
     * @return mixed
     */
    public function getFromUserID()
    {
        return $this->fromUserID;
    }

    /**
     * @param mixed $fromUserID
     */
    public function setFromUserID($fromUserID)
    {
        $this->fromUserID = $fromUserID;
    }

    /**
     * @return mixed
     */
    public function getToUserID()
    {
        return $this->toUserID;
    }

    /**
     * @param mixed $toUserID
     */
    public function setToUserID($toUserID)
    {
        $this->toUserID = $toUserID;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}