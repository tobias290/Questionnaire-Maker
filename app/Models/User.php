<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
    use Notifiable, HasApiTokens;

    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "first_name", "surname", "email", "password", "date_joined"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password", "remember_token",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "date_joined" => "date:d/m/Y",
    ];

    /**
     * Manage timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the questionnaires that belong to the specific user
     */
    public function questionnaires() {
        return $this->hasMany("App\Models\Questionnaire");
    }

    /**
     * Gets the user's settings
     */
    public function settings(){
        return $this->hasOne("App\Models\Settings");
    }
}
