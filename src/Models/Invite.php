<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:29
 */

namespace CoffeeRunner\Models;
use CoffeeRunner\Utilities\DatabaseConnection;

class Invite implements \JsonSerializable
{
    const STATUS_DECLINED = "Declined";
    const STATUS_ACCEPTED = "Accepted";
    const STATUS_PENDING = "Pending";

    private $inviteID;
    private $groupID;
    private $fromUserID;
    private $toUserID;
    private $status;

    public function __construct()
    {


    }

    function jsonSerialize()
    {
        $rtn= array(
            'inviteID' => $this->groupID,
            'groupID' => $this->groupID,
            'fromUserID' => $this->fromUserID,
            'toUserID' => $this->toUserID,
            'status' => $this->status
        );
        return $rtn;
    }

    public function getInvite($inviteID)
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM `coffeerunner`.`invite` WHERE `inviteID` = :inviteID");

            $stmtHandle->bindValue(":inviteID", $inviteID);
            $success = $stmtHandle->execute();

            if (!$success)
            {
                throw new \PDOException("sql query execution failed");
            }
            return $success;
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * send Invite
     */

    public function createInvite()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO `coffeerunner`.`invite`(
                groupID,
                fromUserID,
                toUserID,
                status) 
                VALUES (:groupID,:fromUserID,:toUserID,:status)");

            $stmtHandle->bindValue(":groupID", $this->groupID);
            $stmtHandle->bindValue(":fromUserID", $this->fromUserID);
            $stmtHandle->bindValue(":toUserID", $this->toUserID);
            $stmtHandle->bindValue(":status",self::STATUS_PENDING);

            $success = $stmtHandle->execute();

            if (!$success)
            {
                throw new \PDOException("sql query execution failed");
            }
            else {
                $invite = $dbh->lastInsertId();
                return $invite;
            }

        }
        catch (\Exception $e)
        {
            throw $e;
        }

    }
#TODO: need a way to update the status of an invite.
    public function updateInviteStatus($inviteID,$updateStatus)
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("UPDATE `coffeerunner`.`invite` SET status = :status WHERE inviteID = :inviteID");
            $stmtHandle->bindValue(":status",$updateStatus);
            $stmtHandle->bindValue(":inviteID", $inviteID);

            $success = $stmtHandle->execute();

            if(!$success) {
                throw new\PDOException("SQL query execution failed");
            }
            return $this->getInvite($inviteID);
        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    public function deleteInvite()
    {
        try {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("DELETE FROM `coffeerunner`.`invite` WHERE inviteID = :inviteID");
            $stmtHandle -> bindValue(":inviteID", $this->inviteID);
            $success = $stmtHandle->execute();
            if(!$success) {
                throw new \PDOException("invite delete failed");
            }
            return $success;
        }
        catch(\PDOException $e){
            throw $e;
        }
    }


    public function inviteNewMembers()
    {
        try {
            if (empty($this->groupID))
            {
                die("error: The groupID was not provided");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("INSERT INTO `cofeerunner`.`invite`
                inviteID,
                groupID,
                fromUserID,
                toUserID,
                status'
                )
                VALUES(:inviteID,:groupID,:fromUserID,:toUserID,:status)");
                $stmtHandle->bindValue(":groupID",$this->groupID);
                $stmtHandle->bindValue(":fromUserID",$this->fromUserID);
                $stmtHandle->bindValue(":toUserID",$this->toUserID);
                $stmtHandle->bindValue(":status",$this->status);

                $success = $stmtHandle->execute();

                if(!$success) {
                    throw new\PDOException("SQL query execution failed");
                }
            }
        }
        catch(\PDOException $e){
            throw $e;
        }
    }


    public function sendInvite()
    {
        //This exists but we don't know what to do before we have an application
    }



    /**
     * @return mixed
     */
    public function getInviteID()
    {
        return $this->inviteID;
    }


    public function setInviteID($inviteID)
    {
        $inviteID = filter_var($inviteID,FILTER_SANITIZE_STRING);
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
        $groupID = filter_var($groupID,FILTER_SANITIZE_STRING);
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
        $fromUserID = filter_var($fromUserID,FILTER_SANITIZE_STRING);
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
        $toUserID = filter_var($toUserID,FILTER_SANITIZE_STRING);
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
        $status = filter_var($status,FILTER_SANITIZE_STRING);
        $this->status = $status;
    }

}