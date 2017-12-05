<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


class groupUser
{
    private $groupUserID;
    private $groupID;
    private $userID;

    public function __construct()
    {


    }

    /**
     *Delete user
     */

    public function deletegroupUser()
    {
        try
        {
            if (empty($this->groupUserID))
            {
                die("error: the wnumber is not provided");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("DELETE FROM `groupUser` WHERE `groupUserID` = :groupUserID");
                $stmtHandle->bindValue(":groupUserID", $this->getGroupUserID());
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
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;
    }

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
        $this->userID = $userID;
    }
}