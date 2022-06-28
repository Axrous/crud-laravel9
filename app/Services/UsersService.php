<?php

namespace App\Services;


interface UsersService {

    public function addUserData($data);
    public function editUserData($data, $id);
    public function showAllUserData();
    public function showUserDataById($id);
    public function deleteUserDataById($id);
}