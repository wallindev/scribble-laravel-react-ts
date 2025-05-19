<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends AdminController {
  protected $userRepository;

  public function __construct(UserRepositoryInterface $userRepository) {
    // To call the parent class constructor (AdminController)
    // parent::__construct();
    $this->userRepository = $userRepository;
  }

  public function index(Request $request) {
    $users = $this->userRepository->getAllUsers();

    $title = 'Users';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/users' => 'Users'
    ];
    return view('admin.users.index', compact('users', 'title', 'breadcrumbs'));

    // For API
    // return response()->json($users);
    // if ($request->wantsJson()) {
    //   return UserResource::collection($users);
    // }
  }

  public function show($id) {
    $user = $this->userRepository->getUserById($id);

    $title = 'Show User';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/users' => 'Users',
      "/admin/users/$id" => "User $id"
    ];
    return view('admin.users.show', compact('user', 'title', 'breadcrumbs'));

    // For API
    // return $user ? response()->json($user) : response()->json(['message' => 'User not found'], 404);
  }

  public function edit($id) {
    $user = $this->userRepository->getUserById($id);

    $title = 'Edit User';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/users' => 'Users',
      "/admin/users/$id" => "User $id",
      "/admin/users/$id/edit" => "Edit User $id"
    ];
    return view('admin.users.edit', compact('user', 'title', 'breadcrumbs'));
  }

  public function update(UserRequest $request, $id) {
    $data = $request->validated();

    if (array_key_exists('password', $data))
      $data = [...$data, 'password' => Hash::make($data['password'])];
    if (!array_key_exists('email_verified', $data))
      $data = [...$data, 'email_verified' => false];
    if (!array_key_exists('is_admin', $data))
      $data = [...$data, 'is_admin' => false];

    try {
      $this->userRepository->updateUser($id, $data);
      return redirect()->route('users.show', $id)->with('success', 'User updated successfully!');
    } catch (Exception $e) {
      Log::error('Error updating user: ' . $e->getMessage());
      return back()->withErrors(['update' => 'Failed to update the user. Please try again.']);
    }

    // For API
    // return $updated ?
    // response()->json(['message' => 'User updated successfully']) :
    // response()->json(['message' => 'User not found'], 404);
  }

  public function create() {
    $title = 'Create User';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/users' => 'Users',
      "/admin/users/new" => 'Create User'
    ];
    return view('admin.users.create', compact('title', 'breadcrumbs'));
  }

  public function store(UserRequest $request) {
    $data = $request->validated();

    try {
      $this->userRepository->createUser([...$data, 'password' => Hash::make($data['password'])]);
      return redirect()->route('users.index')->with('success', 'User created successfully.');
    } catch (Exception $e) {
      Log::error('Error creating user: ' . $e->getMessage());
      return back()->withErrors(['create' => 'Failed to create the user. Please try again.']);
    }

    // For API
    // return response()->json($user, 201);
  }

  public function destroy($id) {
    try {
      $this->userRepository->deleteUser($id);
      return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    } catch (Exception $e) {
      Log::error('Error deleting user: ' . $e->getMessage());
      return back()->withErrors(['delete' => 'Failed to delete the user. Please try again.']);
    }

    // For API
    // return $deleted ?
    // response()->json(['message' => 'User deleted successfully']) :
    // response()->json(['message' => 'User not found'], 404);
  }
}
