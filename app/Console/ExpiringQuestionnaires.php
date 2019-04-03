<?php


namespace App\Console;


use App\Models\Questionnaire;
use App\Models\User;
use App\Notifications\ExpiringQuestionnaire;
use Illuminate\Support\Carbon;

class ExpiringQuestionnaires {
    public function __invoke() {
        $this->checkForExpired();
        $this->checkForExpiring();
    }

    /**
     * Checks for questionnaires that has expired.
     */
    private function checkForExpired() {
        $questionnaires = Questionnaire::whereDate("expiry_date", "<=", Carbon::now()->format("Y-m-d"))->get();

        /** @var Questionnaire $questionnaire */
        foreach ($questionnaires as $questionnaire) {
            // The user has already been notified
            if ($questionnaire->expiry_date_notified)
                continue;

            $this->sendNotification(true, $questionnaire->user, $questionnaire);
        }
    }

    /**
     * Checks for questionnaires that are expiring and sees if/when to notify the user.
     */
    private function checkForExpiring() {
        $questionnaires = Questionnaire::all();

        /** @var Questionnaire $questionnaire */
        foreach ($questionnaires as $questionnaire) {
            // The user has already been notified
            if ($questionnaire->expiry_date_advanced_notified)
                continue;

            // Get how long will it expires
            $notifyAt = $questionnaire->user->settings->questionnaire_expiration_notification;

            // Check depending on how long
            if ($notifyAt == "day") {
                if ($this->isDayAway($questionnaire->expiry_date))
                    $this->sendNotification(false, $questionnaire->user, $questionnaire, "day");
            } elseif ($notifyAt == "week") {
                if ($this->isWeekAway($questionnaire->expiry_date))
                    $this->sendNotification(false, $questionnaire->user, $questionnaire, "week");
            } elseif ($notifyAt == "month") {
                if ($this->isMonthAway($questionnaire->expiry_date))
                    $this->sendNotification(false, $questionnaire->user, $questionnaire, "month");
            }
        }
    }

    /**
     * Checks whether the questionnaire will expire in one day.
     *
     * @param $questionnaireExpiration - Expiring date of the questionnaire.
     * @return bool - Returns true if the questionnaire will expire in one day.
     */
    private function isDayAway($questionnaireExpiration) {
        $questionnaireExpiration = Carbon::parse($questionnaireExpiration);
        $checkAgainst = Carbon::now()->addDay()->format("Y-m-d");

        return $checkAgainst >= $questionnaireExpiration;
    }

    /**
     * Checks whether the questionnaire will expire in one week.
     *
     * @param $questionnaireExpiration - Expiring date of the questionnaire.
     * @return bool - Returns true if the questionnaire will expire in one week.
     */
    private function isWeekAway($questionnaireExpiration) {
        $questionnaireExpiration = Carbon::parse($questionnaireExpiration);
        $checkAgainst = Carbon::now()->addWeek()->format("Y-m-d");

        return $checkAgainst >= $questionnaireExpiration;
    }

    /**
     * Checks whether the questionnaire will expire in one month.
     *
     * @param $questionnaireExpiration - Expiring date of the questionnaire.
     * @return bool - Returns true if the questionnaire will expire in one month.
     */
    private function isMonthAway($questionnaireExpiration) {
        $questionnaireExpiration = Carbon::parse($questionnaireExpiration);
        $checkAgainst = Carbon::now()->addMonth()->format("Y-m-d");

        return $checkAgainst >= $questionnaireExpiration;
    }

    /**
     * @param boolean $hasExpired
     * @param User $user
     * @param Questionnaire $questionnaire
     * @param string $expiringIn
     */
    private function sendNotification($hasExpired, $user, $questionnaire, $expiringIn="") {
        if ($hasExpired) {
            $user->notify(new ExpiringQuestionnaire(true, $questionnaire->title));
            $questionnaire->expiry_date_notified = true;
            $questionnaire->expiry_date_advanced_notified = true;
            $questionnaire->save();
        } else {
            $user->notify(new ExpiringQuestionnaire(false, $questionnaire->title, $expiringIn));
            $questionnaire->expiry_date_advanced_notified = true;
            $questionnaire->save();
        }
    }
}