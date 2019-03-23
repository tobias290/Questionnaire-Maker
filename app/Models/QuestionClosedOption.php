<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionClosedOption extends Model {
    protected $table = "question_closed_option";

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
     * Get the question that these options belong to.
     */
    public function questionClosed() {
        return $this->belongsTo("App\Models\QuestionClosed");
    }
}
