<?php

namespace App\Custom;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: Muhammad Salman Abid
 * Date: 1/8/2018
 * Time: 5:00 PM
 */

class Authorization {

  public static function canAccess($permissionName) {

    if (Session::has('user')) {
      $user = Session::get('user');


      if ((!isset($user->club["permissions"]) || $user->club["permissions"] === NULL)) {
        if (!isset($user->permissions) || $user->permissions === NULL) {
          return TRUE;
        }
        else {
          $permissions = json_decode($user->permissions, TRUE);
          if (is_array($permissions) && in_array($permissionName, $permissions)) {
            return TRUE;
          }
        }
      } else {
        $clubPermissions = json_decode($user->club["permissions"], TRUE);
        //If the club permissions are set limit the scope of user permissions to club's permissions
        if (!isset($user->permissions) || $user->permissions === NULL) {
          if (is_array($clubPermissions) && in_array($permissionName, $clubPermissions)) {
            return TRUE;
          }else {
            return FALSE;
          }
        } else {
            $permissions = json_decode($user->permissions, TRUE);
            if (is_array($clubPermissions) && in_array($permissionName, $clubPermissions) && is_array($permissions) && in_array($permissionName, $permissions)) {
              return TRUE;
            }
            else {
              return FALSE;
            }
        }
      }

//
//      if ((!isset($user->club["permissions"]) || $user->club["permissions"] === NULL) &&  (!isset($user->permissions) || $user->permissions === NULL)) {
//        return TRUE;
//      }
//      else {
//        $permissions = json_decode($user->permissions, TRUE);
//        $clubPermissions = json_decode($user->club["permissions"], TRUE);
//        if((!isset($user->club["permissions"]) || $user->club["permissions"] === NULL)){
//          if (is_array($permissions) && in_array($permissionName, $permissions)) {
//            return TRUE;
//          }
//        }else if (is_array($clubPermissions) && in_array($permissionName, $clubPermissions) && is_array($permissions) && in_array($permissionName, $permissions)) {
//          return TRUE;
//        }
//        else {
//          return FALSE;
//        }
//
//
//      }
//    }
//

    }
    return FALSE;
  }

}