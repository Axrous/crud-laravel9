<?php

namespace App\Repository;

use App\Models\Users;

class UsersRepository {

    protected $user;

    public function __construct(Users $user)
    {
        $this->user = $user;
    }

    
    public function save($data) {

        $user = $this->user;
        // $user->name  = $data['name'];
        // $user->birth_date  = $data['birth_date'];
        // $user->region  = $data['region'];
        // $user->save();
        
        $user = $user->create($data);
        return $user->fresh();
    }


    public function getAll() {
        return $this->user->all(['name', 'birth_date', 'region']);
    }

    public function getById($id) {
        return $this->user->select('name', 'birth_date', 'region')->where('id', $id)->get();
    }

    public function deleteAll() {
        $this->user->truncate();
    }

    public function deleteByID($id) {
        // $this->user->where('id', $id)->delete();
        // $user = $this->user->find($id);
        // $user->delete();

        $user  = $this->user->where('id', $id);
        $user->delete();
    }

    public function update($data, $id) 
    {

        $user = $this->user->find($id);

        $user->name = $data['name'];
        $user->birth_date = $data['birth_date'];
        $user->region = $data['region'];

        $user->update();

        return $user;

    }
}