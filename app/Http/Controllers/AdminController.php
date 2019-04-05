<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    /**
     * Logs in an admin user/shows the admin login form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request) {
        if ($request->isMethod("get"))
            return view("admin.login", ["error" => false]);
        else if ($request->isMethod("post")) {
            $username = $request->input("username");
            $password = $request->input("password");

            if(Auth::guard("admin")->attempt(["username" => $username, "password" => $password]))
                return redirect("admin/dashboard");
            else
                return view("admin.login", ["error" => true]);
        }
    }

    /**
     * Signs out the admin user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signOut() {
        Auth::logout();
        return redirect("admin/login");
    }

    /**
     * Shows the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard() {
        // Show reports and unlocked questionnaires
        $reportedQuestionnaires = Questionnaire::where("is_reported", true)->where("is_locked", false)->get();

        return view("admin.dashboard", [
            "reportedQuestionnaires" => $reportedQuestionnaires
        ]);
    }

    /**
     * Locks the given questionnaire.
     *
     * @param $questionnaireId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function lockQuestionnaire($questionnaireId) {
        $questionnaire = Questionnaire::find($questionnaireId);
        $questionnaire->is_locked = true;
        $questionnaire->save();

        return redirect("admin/dashboard");
    }

    /**
     * Un-reports the given questionnaire.
     *
     * @param $questionnaireId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unReportQuestionnaire($questionnaireId) {
        $questionnaire = Questionnaire::find($questionnaireId);
        $questionnaire->is_reported = false;
        $questionnaire->save();

        return redirect("admin/dashboard");
    }
}
