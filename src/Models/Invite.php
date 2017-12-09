<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:29
 */

namespace CoffeeRunner\Models;


use Scholarship\Utilities\DatabaseConnection;

class Invite implements \JsonSerializable
{
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
            '$groupID' => $this->groupID,
            'fromUserID' => $this->fromUserID,
            'toUserID' => $this->toUserID,
            'status' => $this->status
        );
        return $rtn;
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
                "INSERT INTO 'User'(
                'groupID',
                'fromUserID',
                'toUserID',
                'status') 
                VALUES (:groupID, :fromUserID, :toUserID,:status)");

            $stmtHandle->bindValue(":groupID", $this->groupID);
            $stmtHandle->bindValue(":fromUserID", $this->fromUserID);
            $stmtHandle->bindValue(":toUserID", $this->toUserID);
            $stmtHandle->bindValue(":status", $this->status);

            $success = $stmtHandle->execute();

            if (!$success)
            {
                throw new \PDOException("sql query execution failed");
            }

        }
        catch (\Exception $e)
        {
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
                $stmtHandle = $dbh->prepare("INSERT INTO 'invite'(
                'inviteID',
                'groupID',
                'fromUserID',
                'toUserID',
                'status'
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
        //TODO: create logic to send invite
    }

    /**
     * delete or cancel the invite
     */
    public function deleteInvite()
    {
        //TODO: create logic to cancel invite
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