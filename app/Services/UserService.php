<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;

class UserService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data); // Correction ici
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new CustomException('Invalid credentials');
        }

        return $user;
    }

    public function updateProfile($user, array $data)
    {
        return $this->userRepository->update($user, $data);
    }
}