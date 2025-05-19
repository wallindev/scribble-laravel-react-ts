<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
  /** @use HasFactory<\Database\Factories\UserFactory> */

  // Traits
  use HasApiTokens, HasFactory, Notifiable;

  // Access with $user->fullName
  protected function fullName(): Attribute {
    return Attribute::make(
      get: fn () => "$this->firstname $this->lastname",
      // get: fn ($_, $attributes) => "{$attributes['firstname']} {$attributes['lastname']}",
      set: function ($value) {
        $nameParts = explode(' ', $value);
        return [
          'firstname' => $nameParts[0] ?? null,
          'lastname' => $nameParts[1] ?? null,
        ];
      },
    );
  }

  // Access with $user->fullName()
  /* public function fullName(): string {
    return "$this->firstname $this->lastname";
  } */

  /**
   *
  // Default values for model attributes in the $attributes property.
  // These will be applied when a new model instance is created but
  // hasn't been saved to the database yet.
   *
   * @var list<string>
   */
  public $attributes = [
    'email_verified' => false,
    'is_admin' => false,
  ];

  /**
   * Relations
   */
  public function articles()
  {
    return $this->hasMany(Article::class);
  }

  /**
   *
   // Specifies the attributes that
   // are allowed to be mass assignable.
   // Think of it as a whitelist.
   *
   * @var list<string>
   */
  protected $fillable = [
    'firstname',
    'lastname',
    'email',
    'password',
    'email_verified',
    'is_admin',
  ];

  /**
   *
   // Specifies the attributes that
   // should not be mass assignable.
   // Think of it as a blacklist.
   *
   * @var list<string>
   */
  protected $guarded = [
    'id',
    'remember_token',
    'created_at',
    'updated_at',
  ];

  /**
   *
   // The attributes that should be hidden for serialization.
   // Controls the privacy and structure of your data when
   // it's being presented or shared.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array {
    return [
      'password'          => 'hashed',
      'email_verified'    => 'boolean',
      'is_admin'          => 'boolean',
    ];
  }
}
