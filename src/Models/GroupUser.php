<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;
use CoffeeRunner\Utilities\DatabaseConnection;


#TODO: deleteGroupUser should check both groupID and userID

class GroupUser implements \JsonSerializable
{
    private $groupUserID;
    private $groupID;
    private $userID;

    public function __construct()
    {


    }

    function jsonSerialize()
    {
        $rtn= array(
            'groupUserID' => $this->groupID,
            '$groupID' => $this->groupID,
            'userID' => $this->userID,
        );
        return $rtn;
    }
//---------------------------Check this again---------------------------------
    public function createGroupUser()
    {
        //TODO: creates an entry into the db, use groupUserID, groupID, userID
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO 'groupUser'(
                'groupID',
                'userID')
                VALUES (:groupID,:userID)");
            $stmtHandle->bindValue(":groupID",$this->groupID);
            $stmtHandle->bindValue(":userID",$this->userID);

            $success = $stmtHandle->execute();

            if(!$success)
            {
                throw new \PDOException("sql query execution failed");
            }
            $id = $dbh->lastInsertId();
            return $this->getGroupUser($id);
        }
        catch(\Exception $e)
        {
            throw $e;
        }

    }
    public function getGroupUser()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM 'groupUser' WHERE 'groupUserID'= :groupUserID");
            $stmtHandle->bindValue(":groupUserID", $this->groupUserID);
            $success = $stmtHandle->execute();
            if(!$success){
                throw new \PDOException("sql query execution failed");
            }
            $groupUser = $stmtHandle->fetch(\PDO::FETCH_CLASS,"CoffeeRunner/Models/GroupUser");
            return $groupUser;
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
//---------------------------Check this again---------------------------------
    public function deleteGroupUser()
    {
        try
        {
            if (empty($this->groupUserID))
            {
                die("error: the groupUserID is not provided");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("DELETE FROM `groupUser` WHERE `groupUserID` = :groupUserID AND 'userID' = :userID");
                $stmtHandle->bindValue(":groupUserID", $this->groupUserID);
                $stmtHandle->bindValue(":userID", $this->userID);
                $success = $stmtHandle->execute();

                if (!$success) {
                    throw new \PDOException("user full delete unsuccessful.");
                }
            }
        }
        catch (\PDOException $e)
        {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getGroupUserID()
    {
        return $this->groupUserID;
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

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $userID = filter_var($userID,FILTER_SANITIZE_STRING);
        $this->userID = $userID;
    }
}