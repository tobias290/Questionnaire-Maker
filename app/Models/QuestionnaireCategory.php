<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireCategory extends Model {
    protected $table = "questionnaire_category";

    public function questionnaires() {
        $this->hasMany("App\Models\Questionnaires");
    }
}
