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
     * Get the user that owns the questionnaire.
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }

    public function category() {
        return $this->belongsTo("App\Models\QuestionnaireCategory");
    }
}
