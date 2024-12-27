<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository{
   public function create(array $data)
   {
      return User::create($data);
   }
   public function findById($id)
   {
      return  User::find($id);
   }

   public function delete(User $user)
   {
      return $user->delete();
   }
   public function update (User $user, array $data)
   {
      return $user ->update($data);
   }
   public function findByEmail($email)
   {
       return User::where('email', $email)->first();
   }
}

