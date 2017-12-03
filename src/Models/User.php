<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


class User
{

    private $userID;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $foodPreference;
    private $drinkPreference;

    public function __construct()
    {


    }

    /**
     * deletes a user
     */

    public function deleteUser()
    {

    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public function getPassword()
    {
        return $this->password;
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