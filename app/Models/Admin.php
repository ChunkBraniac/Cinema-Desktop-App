<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'admin_name',
        'admin_email',
        'admin_password',
        'role'
    ];

    public function getAuthPassword()
    {
        return $this->admin_password; // Change to your custom password column name
    }

}
