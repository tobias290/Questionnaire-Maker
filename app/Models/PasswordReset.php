<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
    protected $table = "password_resets";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "email", "token", "created_at",
    ];

    /**
     * Manage timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

}
