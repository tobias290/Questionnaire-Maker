<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {
    protected $table = "settings";

    /**
     * Specifies the name of the primary key
     *
     * @var string
     */
    protected $primaryKey = "user_id";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Manage timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "enable_in_app_notifications" => "boolean",
        "enable_email_notifications" => "boolean",
    ];

    /**
     * User that these settings belong to.
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }
}
