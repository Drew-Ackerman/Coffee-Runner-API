<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


use CoffeeRunner\Utilities\DatabaseConnection;

#TODO: all update methods use userID instead of username now.
#TODO: discuss if deleteUser should use an instance for the userID instead of it being passed in.
#TODO: discuss if all applicable methods should use an instance for ease of accessing attributes.
#TODO: make sure all methods have a return value specified if best
#TODO: method updateLast should be updateLastName

class User implements \JsonSerializable
{

    private $userID;
    private $userName;
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
        '$userName' => $this->userName,
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
                "INSERT INTO 'User'(
                'userName',
                'firstName',
                'lastName',
                'foodPreference',
                'drinkPreference',
                ) 
                VALUES (:userName,:firstName,:lastName,:foodPreference,:drinkPreference)");

            $stmtHandle->bindValue(":userName", $this->userName);
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
            $stmtHandle = $dbh->prepare("DELETE FROM 'User' WHERE 'username' = :username");
            $stmtHandle->bindValue(":", $this->userName);
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


    public function getUser($userID) : User{
        #TODO retrieve a user object from the database using the userID
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "SELECT * FROM 'User' WHERE 'userID'= :userID");
            $stmtHandle->bindValue(":userID", $this->userID);
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

    public function updateFirstName($updFirst)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'firstName' = :firstName WHERE username = :userID");
        $stmtHandle->bindValue(":firstName", $updFirst);
        $stmtHandle->bindValue(":userID", $this->userID);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE username = :userID");
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

    public function updateLastName($updLast)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'lastName' = :lastName WHERE 'userID' = :userID");
        $stmtHandle->bindValue(":userID",$this->userID);
        $stmtHandle->bindValue(":lastName", $updLast);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }
        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE 'userID' = :userID");
        $rtnHandle->bindValue(":userID",$this->userID);
        $rtnHandle -> bindValue(":username",$this->userName);

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

    public function updateFood($updFood)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'foodPreference' = :foodPreference WHERE 'userID' = :userID");
        $stmtHandle->bindValue(":userID",$this->userID);
        $stmtHandle->bindValue(":foodPreference", $updFood);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE userID = :userID");
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

    public function updateDrink($updDrink)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'drinkPreference' = :drinkPreference WHERE 'userID' = :userID");
        $stmtHandle->bindValue(":drinkPreference", $updDrink);
        $stmtHandle -> bindValue(":userID",$this->userID);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }


        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE userID = :userID");
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


    public function setUserName($userName)
    {
        $userName = filter_var($userName,FILTER_SANITIZE_STRING);
        $this->userName = $userName;
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
        return $this->userName;
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