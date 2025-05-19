<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface {
  public function getAllUsers(): Collection {
    return User::all();

    // For API
    // return User::all()->toArray();
  }

  public function getUserById(int $id): ?User {
    return User::findOrFail($id);
  }

  public function createUser(array $data): User {
    return User::create($data);
  }

  public function updateUser(int $id, array $data): bool {
    $user = $this->getUserById($id);
    return $user ? $user->update($data) : false;
  }

  public function deleteUser(int $id): bool {
    $user = $this->getUserById($id);
    return $user ? $user->delete() : false;
  }

  // For API
  // public function getAllUsers(): array
}
