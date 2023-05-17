<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'user_id', 'logo', 'company', 'location', 'website', 'email', 'description', 'tags'];

  public function scopeFilter($query, array $filters) {
    if ($filters['tag'] ?? false) {
      $query->where('tags', 'like', '%' . request('tag') . '%');
    }

    if ($filters['search'] ?? false) {
      $query->where('title', 'like', '%' . request('search') . '%')
        ->orWHere('description', 'like', '%' . request('search') . '%')
        ->orWHere('tags', 'like', '%' . request('search') . '%');
    }
  }

  // Relashionship to User
  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }
}
