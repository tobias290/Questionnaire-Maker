<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model {
    protected $table = "questionnaire";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "title", "description", "expiry_date", "questionnaire_category_id",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "created_at" => "date:d/m/Y",
        "updated_at" => "date:d/m/Y",
        "expiry_date" => "date:d/m/Y",
    ];

    /**
     * Get the user that owns the questionnaire.
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }

    public function category() {
        return $this->belongsTo("App\Models\QuestionnaireCategory");
    }
}
