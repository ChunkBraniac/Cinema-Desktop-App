<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['admin_name', 'admin_email', 'admin_password', 'email_verified_at', 'remember_token', 'status'];
}
