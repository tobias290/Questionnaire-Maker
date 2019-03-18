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
        "is_public", "is_complete", "is_reported", "is_locked",
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
        "is_public" => "boolean",
        "is_complete" => "boolean",
        "is_reported" => "boolean",
        "is_locked" => "boolean",
    ];

    /**
     * Get the user that owns the questionnaire.
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }

    /**
     * Get the category this questionnaire belongs to.
     */
    public function category() {
        return $this->belongsTo("App\Models\QuestionnaireCategory");
    }

    /**
     * Gets the closed questions that belongs to this questionnaire.
     */
    public function closedQuestions() {
        return $this->hasMany("App\Models\QuestionClosed");
    }

    /**
     * Gets the open questions that belongs to this questionnaire.
     */
    public function openQuestions() {
        return $this->hasMany("App\Models\QuestionOpen");
    }

    /**
     * Gets the scaled questions that belongs to this questionnaire.
     */
    public function scaledQuestions() {
        return $this->hasMany("App\Models\QuestionScaled");
    }
}
