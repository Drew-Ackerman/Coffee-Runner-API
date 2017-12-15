<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;
use CoffeeRunner\Utilities\DatabaseConnection;

class Group implements \JsonSerializable
{
    private $groupID;
    private $groupName;
    private $groupPresident;
    private $groupRunner;

    public function __construct()
    {


    }

    function jsonSerialize()
    {
        $rtn= array(
            'groupID' => $this->groupID,
            '$groupName' => $this->groupName,
            'groupPresident' => $this->groupPresident,
            'groupRunner' => $this->groupRunner
        );
        return $rtn;
    }



    public function getGroup($groupID)
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM '[group]' WHERE 'groupID'= :groupID");
            $stmtHandle->bindValue(":groupID", $this->getGroupID());
            $success = $stmtHandle->execute();
            if(!$success){
                throw new \PDOException("sql query execution failed");
            }
            $user = $stmtHandle->fetch(\PDO::FETCH_CLASS,"CoffeeRunner/Models/Group");
            return $user;
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

    public function createGroup()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO '[group]'(
                'groupName',
                'groupPresident',
                'groupRunner')
                VALUES (:groupName,:groupPresident,:groupRunner)");
            $stmtHandle->bindValue(":groupName",$this->groupName);
            $stmtHandle->bindValue(":groupPresident",$this->groupPresident);
            $stmtHandle->bindValue("groupRunner",$this->groupRunner);

            $success = $stmtHandle->execute();

            if(!$success)
            {
                throw new \PDOException("sql query execution failed");
            }
            $id = $dbh->lastInsertId();
            return $this->getGroup($id);
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

//SELECT * From groupUser Join user ON groupUser.userID = user.userID
// WHERE groupUser.groupID = 2 AND userName = 'Kyle'
    public function getUserByUsername ($groupID,$username)
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM `coffeerunner`.`groupUser` 
                          JOIN user ON groupUser.userID = user.userID
                          WHERE groupUser.groupID = :groupID AND username = :username");
            $stmtHandle->bindValue(":groupID", $groupID);
            $stmtHandle->bindValue(":username", $username);
            $success = $stmtHandle->execute();
            if(!$success){
                throw new \PDOException("sql query execution failed");
            }
            $groupUser = $stmtHandle->fetchAll(\PDO::FETCH_CLASS,"CoffeeRunner/Models/Group");
            return $groupUser;
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

    public function deleteGroup()
    {
        try {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("DELETE FROM `coffeerunner`.`[Group]` WHERE groupID = :groupID");
            $stmtHandle -> bindValue(":groupID", $this->getGroupID());
            $success = $stmtHandle->execute();
            if(!$success) {
                throw new \PDOException("Group delete failed");
            }
            return $success;
        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    public function changePresident($newPresident)
    {


        try {
            if(empty($this->groupID)){
                die("error: groupID was not provided");
            }
            else {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare(
                    "UPDATE `coffeerunner`.`[Group]` SET groupPresident = :groupPresident
                    WHERE groupID = :groupID");
                $stmtHandle->bindValue(":groupPresident", $newPresident);
                $stmtHandle->bindValue(":groupID",$this->getGroupID());

                $success = $stmtHandle->execute();

                if(!$success) {
                    throw new \PDOException("Group President update failed");
                }
                return $success;
            }

        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * change the runner of the group
     */

    public function changeRunner($updateRunner)
    {
        try {
            if(empty($this->groupID)){
                die("error: groupID was not provided");
            }
            else {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare(
                    "UPDATE `coffeerunner`.`[Group]`
                    SET groupRunner= :groupRunner
                    WHERE groupID = :groupID");
                $stmtHandle->bindValue(":groupRunner", $updateRunner);
                $stmtHandle->bindValue(":groupID",$this->groupID);

                $success = $stmtHandle->execute();

                if(!$success) {
                    throw new \PDOException("Group Runner update failed");
                }
                return $success;
            }

        }
        catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * invites members to the group
     */


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
        $groupName = filter_var($groupName,FILTER_SANITIZE_STRING);
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getGroupPresident()
    {

        return $this->groupPresident;
    }

    /**
     * @param mixed $groupPresident
     */
    public function setGroupPresident($groupPresident)
    {
        $groupPresident = filter_var($groupPresident,FILTER_SANITIZE_STRING);
        $this->groupPresident = $groupPresident;
    }

    /**
     * @return mixed
     */
    public function getGroupRunner()
    {
        return $this->groupRunner;
    }

    /**
     * @param mixed $groupRunner
     */
    public function setGroupRunner($groupRunner)
    {
        $groupRunner = filter_var($groupRunner,FILTER_SANITIZE_STRING);
        $this->groupRunner = $groupRunner;
    }

    /**
     * @return mixed
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

}