<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Article extends Model {
  /** @use HasFactory<\Database\Factories\ArticleFactory> */

  // Traits
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * Relations
   */
  public function user() {
    return $this->belongsTo(User::class);
  }

  /**
   * @var list<string>
   */
  protected $fillable = [
    'title',
    'content',
    'user_id',
  ];

  /**
   * @var list<string>
   */
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];
}
