<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionScaled extends Model {
    protected $table = "question_scaled";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "is_required" => "boolean",
    ];

    /**
     * Manage timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the questionnaire that this question belongs to.
     */
    public function questionnaire() {
        return $this->belongsTo("App\Models\Questionnaire");
    }

    /**
     * Gets the responses for this question.
     */
    public function responses() {
        return $this->hasMany("App\Models\QuestionScaledResponse");
    }
}
