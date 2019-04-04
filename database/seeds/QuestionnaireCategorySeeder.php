<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireCategorySeeder extends Seeder {
    private $categories = [
        "Business",
        "Community",
        "Customer Feedback",
        "Customer Satisfaction",
        "Education",
        "Events",
        "Healthcare",
        "Human Resources",
        "Just For Fun",
        "Marketing",
        "Non Profit",
        "Political",

        "Other",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach ($this->categories as $i => $category) {
            DB::table("questionnaire_category")->insert([
                "id" => $i + 1,
                "name" => $category,
            ]);
        }
    }
}
