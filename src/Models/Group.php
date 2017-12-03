<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 12/3/2017
 * Time: 15:28
 */

namespace CoffeeRunner\Models;


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

    public function deleteGroup()
    {


    }

    /**
     * changes the president
     *
     */

    public function changePresident()
    {

    }

    /**
     * change the runner of the group
     */

    public function changeRunner()
    {

    }

    /**
     * invites members to the group
     */

    public function inviteNewMembers()
    {

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