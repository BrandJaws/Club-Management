<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Gate;


class AdminPolicy
{
    use HandlesAuthorization;

    protected $permissions;

    /**
     *
     * @param User $user
     * @param unknown $ability            
     * @return boolean
     */
    public function before(User $user, $ability)
    {

        if (is_null($user->permissions)) {
            return true;
        } else {
            $this->permissions = json_decode($user->permissions, true);
        }
    }

    /**
     * check if current user can manage reservations
     *
     * @param User $employee
     * @return boolean
     */
    public function reservations(User $employee)
    {
        return $this->permissions === null || in_array('reservations',$this->permissions)  ? true : false;
    }

    /**
     * check if current user can manage reports
     *
     * @param User $employee
     * @return boolean
     */
    public function reports(User $employee)
    {
        return $this->permissions === null || in_array('reports',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage members
     *
     * @param User $employee
     * @return boolean
     */
    public function members(User $employee)
    {
        return $this->permissions === null || in_array('members',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage employees
     *
     * @param User $employee
     * @return boolean
     */
    public function employees(User $employee)
    {
        return $this->permissions === null || in_array('employees',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage beacons
     *
     * @param User $employee
     * @return boolean
     */
    public function beacons(User $employee)
    {
        return $this->permissions === null ||in_array('beacons',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage courts
     *
     * @param User $employee
     * @return boolean
     */
    public function courts(User $employee)
    {
        return $this->permissions === null || in_array('courts',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage coaches
     *
     * @param User $employee
     * @return boolean
     */
    public function coaches(User $employee)
    {
        return $this->permissions === null || in_array('coaches',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage trainings
     *
     * @param User $employee
     * @return boolean
     */
    public function trainings(User $employee)
    {
        return $this->permissions === null || in_array('trainings',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage photoGallery
     *
     * @param User $employee
     * @return boolean
     */
    public function photoGallery(User $employee)
    {
        return $this->permissions === null || in_array('photoGallery',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage news
     *
     * @param User $employee
     * @return boolean
     */
    public function news(User $employee)
    {
        return $this->permissions === null || in_array('news',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage clubWall
     *
     * @param User $employee
     * @return boolean
     */
    public function clubWall(User $employee)
    {
        return $this->permissions === null || in_array('clubWall',$this->permissions) ? true : false;

    }


    /**
     * check if current user can manage communication
     *
     * @param User $employee
     * @return boolean
     */
    public function communication(User $employee)
    {
        return $this->permissions === null || in_array('communication',$this->permissions) ? true : false;

    }

    /**
     * check if current user can manage leagues
     *
     * @param User $employee
     * @return boolean
     */
    public function leagues(User $employee)
    {
        return $this->permissions === null || in_array('leagues',$this->permissions) ? true : false;

    }


}
