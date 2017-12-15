<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


use CoffeeRunner\Utilities\DatabaseConnection;


class User implements \JsonSerializable
{

    private $userID;
    private $username;
    private $firstName;
    private $lastName;
    private $foodPreference;
    private $drinkPreference;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        $rtn= array(
        'userID' => $this->userID,
        'username' => $this->username,
        'firstName' => $this->firstName,
        'lastName' => $this->lastName,
        'foodPreference' => $this->foodPreference,
        'drinkPreference' => $this->drinkPreference,
        );
        return $rtn;
    }


    public function createUser()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO `coffeerunner`.`User`(
                userName,
                firstName,
                lastName,
                foodPreference,
                drinkPreference,
                ) 
                VALUES (:username,:firstName,:lastName,:foodPreference,:drinkPreference)");

            $stmtHandle->bindValue(":username", $this->username);
            $stmtHandle->bindValue(":firstName",$this->firstName);
            $stmtHandle->bindValue(":lastName",$this->lastName);
            $stmtHandle->bindValue(":foodPreference",$this->foodPreference);
            $stmtHandle->bindValue(":drinkPreference",$this->drinkPreference);

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


    public function deleteUser()
    {
        try
        {

            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("DELETE FROM `coffeerunner`.`User` WHERE userID = :userID");
            $stmtHandle->bindValue(":userID", $this->userID);
            $success = $stmtHandle->execute();

            if (!$success) {
                throw new \PDOException("user delete failed.");
            }
            else
            {
                return $success;
            }

        }
        catch (\PDOException $e)
        {
            throw $e;
        }
    }


    public function getUser($userID) {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM `coffeerunner`.`user` WHERE userID = :userID");
            $stmtHandle->bindValue(":userID", $userID);
            $success = $stmtHandle->execute();
            if(!$success){
                throw new \PDOException("sql query execution failed");
            }
            $groupUser = $stmtHandle->FetchAll(\PDO::FETCH_CLASS, 'CoffeeRunner\Models\User');
            return $groupUser;
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }

    public function updateFirstName($updateFirst)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE `coffeerunner`.`user` SET firstName = :firstName WHERE userID = :userID");
        $stmtHandle->bindValue(":firstName", $updateFirst);
        $stmtHandle->bindValue(":userID", $this->userID);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM `coffeerunner`.`user` WHERE username = :userID");
        $rtnHandle -> bindValue(":userID",$this->userID);

        $success = $rtnHandle->execute();
        if (!$success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }
    }

    public function updateLastName($updateLast)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE `coffeerunner`.`user` SET lastName = :lastName WHERE userID = :userID");
        $stmtHandle->bindValue(":userID",$this->userID);
        $stmtHandle->bindValue(":lastName", $updateLast);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }
        $rtnHandle = $dbh->prepare("SELECT * FROM `coffeerunner`.`user` WHERE userID = :userID");
        $rtnHandle->bindValue(":userID",$this->userID);
        $rtnHandle -> bindValue(":username",$this->username);

        $success = $rtnHandle->execute();
        if (!$success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }

    }

    public function updateFood($updateFood)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE `coffeerunner`.`user` SET foodPreference = :foodPreference WHERE userID = :userID");
        $stmtHandle->bindValue(":userID",$this->userID);
        $stmtHandle->bindValue(":foodPreference", $updateFood);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM `coffeerunner`.`user WHERE userID = :userID");
        $rtnHandle -> bindValue(":userID",$this->userID);

        $success = $rtnHandle->execute();
        if (!$success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }
    }

    public function updateDrink($updateDrink)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE `coffeerunner`.user`` SET drinkPreference = :drinkPreference WHERE userID = :userID");
        $stmtHandle->bindValue(":drinkPreference", $updateDrink);
        $stmtHandle -> bindValue(":userID",$this->userID);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }


        $rtnHandle = $dbh->prepare("SELECT * FROM `coffeerunner`.`user` WHERE userID = :userID");
        $rtnHandle -> bindValue(":userID",$this->userID);

        $success = $rtnHandle->execute();
        if (!$success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }
    }


    public function setUserName($username)
    {
        $username = filter_var($username,FILTER_SANITIZE_STRING);
        $this->username = $username;
    }


    public function setFirstName($firstName)
    {
        $firstName = filter_var($firstName,FILTER_SANITIZE_STRING);
        $this->firstName = $firstName;
    }


    public function setLastName($lastName)
    {
        $lastName = filter_var($lastName,FILTER_SANITIZE_STRING);
        $this->lastName = $lastName;
    }


    public function setFoodPreference($foodPreference)
    {
        $foodPreference = filter_var($foodPreference,FILTER_SANITIZE_STRING);
        $this->foodPreference = $foodPreference;
    }


    public function setDrinkPreference($drinkPreference)
    {
        $drinkPreference = filter_var($drinkPreference,FILTER_SANITIZE_STRING);
        $this->drinkPreference = $drinkPreference;
    }


    public function getUserID()
    {
        return $this->userID;
    }


    public function getUserName()
    {
        return $this->username;
    }


    public function getFirstName()
    {
        return $this->firstName;
    }


    public function getLastName()
    {
        return $this->lastName;
    }


    public function getFoodPreference()
    {
        return $this->foodPreference;
    }


    public function getDrinkPreference()
    {
        return $this->drinkPreference;
    }


}