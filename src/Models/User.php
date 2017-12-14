<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


use Scholarship\Utilities\DatabaseConnection;

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


    public function deleteUser($arg)
    {
        try
        {

            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("DELETE FROM 'User' WHERE 'username' = :username");
            $stmtHandle->bindValue(":", $arg);
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
    }

    public function updateFirstName($username,$updFirst)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'firstName' = :firstName WHERE username = :username");
        $stmtHandle->bindValue(":firstName", $updFirst);
        $stmtHandle->bindValue(":username", $username);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE username = :username");
        $rtnHandle -> bindValue(":username",$username);

        $success = $rtnHandle->execute();
        if (!success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }
    }

    public function updateLast($username,$updLast)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'lastName' = :lastName");
        $stmtHandle->bindValue(":lastName", $updLast);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }


        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE username = :username");
        $rtnHandle -> bindValue(":username",$username);

        $success = $rtnHandle->execute();
        if (!success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }

    }

    public function updateFood($username,$updFood)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'foodPreference' = :foodPreference");
        $stmtHandle->bindValue(":foodPreference", $updFood);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }

        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE username = :username");
        $rtnHandle -> bindValue(":username",$username);

        $success = $rtnHandle->execute();
        if (!success)
        {
            throw new \PDOException("error: failed to execute sql query");
        }
        else
        {
            return $user = $rtnHandle->fetchAll(\PDO::FETCH_CLASS);
        }
    }

    public function updateDrink($username,$updDrink)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'drinkPreference' = :drinkPreference");
        $stmtHandle->bindValue(":drinkPreference", $updDrink);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }


        $rtnHandle = $dbh->prepare("SELECT * FROM 'user' WHERE username = :username");
        $rtnHandle -> bindValue(":username",$username);

        $success = $rtnHandle->execute();
        if (!success)
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
        $this->userName = $userName;
    }


    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }


    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    public function setFoodPreference($foodPreference)
    {
        $this->foodPreference = $foodPreference;
    }


    public function setDrinkPreference($drinkPreference)
    {
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