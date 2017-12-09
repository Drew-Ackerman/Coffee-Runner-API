<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


use Scholarship\Utilities\DatabaseConnection;

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
    /**
     * deletes a user
     */

    public function create()
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

        }
        catch (\PDOException $e)
        {
            throw $e;
        }
    }

    public function updateFirst($userName,$updFirst)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'firstName' = :firstName");
        $stmtHandle->bindValue(":firstName", $updFirst);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }


    }

    public function updateLast($userName,$updLast)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'lastName' = :lastName");
        $stmtHandle->bindValue(":lastName", $updLast);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }
    }

    public function updateFood($userName,$updFood)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'foodPreference' = :foodPreference");
        $stmtHandle->bindValue(":foodPreference", $updFood);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }
    }

    public function updateDrink($userName,$updDrink)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("UPDATE 'user' SET 'drinkPreference' = :drinkPreference");
        $stmtHandle->bindValue(":drinkPreference", $updDrink);
        $success = $stmtHandle->execute();

        if (!$success)
        {
            throw new \PDOException("Something went wrong with the update.");
        }
    }

    public function getUser()
    {
        //TODO: get user function
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $foodPreference
     */
    public function setFoodPreference($foodPreference)
    {
        $this->foodPreference = $foodPreference;
    }

    /**
     * @param mixed $drinkPreference
     */
    public function setDrinkPreference($drinkPreference)
    {
        $this->drinkPreference = $drinkPreference;
    }


    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getFoodPreference()
    {
        return $this->foodPreference;
    }

    /**
     * @return mixed
     */
    public function getDrinkPreference()
    {
        return $this->drinkPreference;
    }


}