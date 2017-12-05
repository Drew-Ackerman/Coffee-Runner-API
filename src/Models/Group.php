<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


use CoffeeRunner\Utilities\DatabaseConnection;

class group
{
    private $groupID;
    private $groupName;
    private $groupDealer;
    private $groupMule;

    public function __construct()
    {


    }

    /**
     * deletes the group
     *
     */

    public function createGroup()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO '[group]'(
                'groupName',
                'groupDealer',
                'groupMule')
                VALUES (:groupName,:groupDealer,:groupMule)");
            $stmtHandle->bindValue(":groupName",$this->groupName);
            $stmtHandle->bindValue(":groupDealer",$this->groupDealer);
            $stmtHandle->bindValue("groupMule",$this->groupMule);

            $success = $stmtHandle->execute();

            if(!$success)
            {
                throw new \PDOException("sql query execution failed");
            }
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

    public function deleteGroup()
    {
        try {
                if(empty($this->groupID))
            {
                die("error groupID was not provided");
            }
            else {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("DELETE FROM '[Group]' WHERE 'groupID' = :groupID");
                $stmtHandle -> bindValue(":groupID", $this->getGroupID());
                $success = $stmtHandle->execute();
            }

            if(!$success) {
                throw new \PDOException("Group delete failed");
            }
        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * changes the president
     *
     */

    public function changePresident()
    {
        try {
            if(empty($this->groupID)){
                die("error: groupID was not provided");
            }
            else {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare(
                    "UPDATE '[Group]'
                    SET 'groupDealer'= :groupDealer
                    WHERE 'groupID' = :groupID");
                $stmtHandle->bindValue(":groupDealer", $this->groupDealer);
                $stmtHandle->bindValue(":groupID",$this->groupID);

                $success = $stmtHandle->execute();

                if(!$success) {
                    throw new \PDOException("Group President update failed");
                }
            }

        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * change the runner of the group
     */

    public function changeRunner()
    {
        try {
            if(empty($this->groupID)){
                die("error: groupID was not provided");
            }
            else {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare(
                    "UPDATE '[Group]'
                    SET 'groupDealer'= :groupRunner
                    WHERE 'groupID' = :groupID");
                $stmtHandle->bindValue(":groupRunner", $this->groupRunner);
                $stmtHandle->bindValue(":groupID",$this->groupID);

                $success = $stmtHandle->execute();

                if(!$success) {
                    throw new \PDOException("Group Runner update failed");
                }
            }

        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * invites members to the group
     */

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

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getGroupDealer()
    {
        return $this->groupDealer;
    }

    /**
     * @param mixed $groupDealer
     */
    public function setGroupDealer($groupDealer)
    {
        $this->groupDealer = $groupDealer;
    }

    /**
     * @return mixed
     */
    public function getGroupMule()
    {
        return $this->groupMule;
    }

    /**
     * @param mixed $groupMule
     */
    public function setGroupMule($groupMule)
    {
        $this->groupMule = $groupMule;
    }

    /**
     * @return mixed
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

}