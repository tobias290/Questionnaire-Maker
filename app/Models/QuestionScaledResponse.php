<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionScaledResponse extends Model {
    protected $table = "question_scaled_response";

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
     * Gets the question that this response belongs to.
     */
    public function question() {
        return $this->belongsTo("App\Models\QuestionScaled");
    }
}
