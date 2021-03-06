import {AppComponent} from "./components/app/app.component";
import {LandingComponent} from "./components/landing/landing.component";
import {TopBarComponent} from "./components/top-bar/top-bar.component";
import {SignUpComponent} from "./components/sign-up/sign-up.component";
import {LoginComponent} from "./components/login/login.component";
import {LoadingComponent} from "./components/loading/loading.component";
import {PopupComponent} from "./components/popup/popup.component";
import {BrowserModule} from "@angular/platform-browser";
import {DashboardComponent} from "./components/dashboard/dashboard.component";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {HttpClientModule} from "@angular/common/http";
import {ReactiveFormsModule} from "@angular/forms";
import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {ToggleSwitchComponent} from "./components/_controls/toggle-switch/toggle-switch.component";
import {CreateQuestionnaireFormComponent} from "./components/_forms/_questionnaire/create-questionnaire/create-questionnaire.component";
import {EditQuestionnaireComponent} from "./components/edit-questionnaire/edit-questionnaire.component";
import {QuestionnaireListItemComponent} from "./components/questionnaire-list-item/questionnaire-list-item.component";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import {QuestionClosedEditableComponent} from "./components/_questions/closed/_editable/question-closed-editable.component";
import {QuestionOpenEditableComponent} from "./components/_questions/open/_editable/question-open-editable.component";
import {QuestionScaledEditableComponent} from "./components/_questions/scaled/_editable/question-scaled-editable.component";
import {PublicQuestionnaireListComponent} from "./components/_public/questionnaire-list/questionnaire-list.component";
import {QuestionnaireComponent} from "./components/_public/questionnaire/questionnaire.component";
import {QuestionClosedAnswerableComponent} from "./components/_questions/closed/_answerable/question-closed-answerable.component";
import {QuestionOpenAnswerableComponent} from "./components/_questions/open/_answerable/question-open-answerable.component";
import {QuestionScaledAnswerableComponent} from "./components/_questions/scaled/_answerable/question-scaled-answerable.component";
import {ThankYouComponent} from "./components/_public/post-questionnaire-thank-you/thank-you.component";
import {QuestionnaireResponsesComponent} from "./components/questionnaire-responses/questionnaire-responses.component";
import {QuestionOpenResponsesComponent} from "./components/_questions/open/_responses/question-open-responses.component";
import {QuestionClosedResponsesComponent} from "./components/_questions/closed/_responses/question-closed-responses.component";
import {QuestionScaledResponsesComponent} from "./components/_questions/scaled/_responses/question-scaled-responses.component";
import {ChartsModule} from "ng2-charts";
import {SendQuestionnaireComponent} from "./components/_forms/_questionnaire/send-questionnaire/send-questionnaire.component";
import {SearchBarComponent} from "./components/_controls/search-bar/search-bar.component";
import {AccountComponent} from "./components/account/account.component";
import {ChangeNameComponent} from "./components/_forms/_account/change-name/change-name.component";
import {ChangeEmailComponent} from "./components/_forms/_account/change-email/change-email.component";
import {ChangePasswordComponent} from "./components/_forms/_account/change-password/change-password.component";
import {DeleteAccountComponent} from "./components/_forms/_account/delete-account/delete-account.component";
import {AccountDropDownComponent} from "./components/account-drop-down/account-drop-down.component";
import {NotificationsComponent} from "./components/notifications/notifications.component";
import {ForgottenPasswordComponent} from "./components/_reset-password/forgotten-password/forgotten-password.component";
import {ResetPasswordComponent} from "./components/_reset-password/reset-password/reset-password.component";

const appRoutes: Routes = [
    { path: "", component: LandingComponent },
    { path: "public/questionnaires", component: PublicQuestionnaireListComponent },
    { path: "public/questionnaires/:id/answer", component: QuestionnaireComponent },
    { path: "public/thank-you", component: ThankYouComponent },
    { path: "sign-up", component: SignUpComponent },
    { path: "login", component: LoginComponent },
    { path: "forgotten-password", component: ForgottenPasswordComponent },
    { path: "reset-password/:token", component: ResetPasswordComponent },
    { path: "dashboard", component: DashboardComponent },
    { path: "edit/:id", component: EditQuestionnaireComponent },
    { path: "edit/:id/preview", component: QuestionnaireComponent, data: { preview: true } },
    { path: "responses/:id", component: QuestionnaireResponsesComponent },
    { path: "account", component: AccountComponent },
    { path: "notifications", component: NotificationsComponent },
];

@NgModule({
    declarations: [
        AppComponent,
        PopupComponent,
        ToggleSwitchComponent,
        TopBarComponent,
        AccountDropDownComponent,
        LoadingComponent,
        LandingComponent,
        SignUpComponent,
        LoginComponent,
        ForgottenPasswordComponent,
        ResetPasswordComponent,
        DashboardComponent,
        CreateQuestionnaireFormComponent,
        EditQuestionnaireComponent,
        QuestionnaireListItemComponent,
        QuestionClosedEditableComponent,
        QuestionOpenEditableComponent,
        QuestionScaledEditableComponent,
        QuestionnaireResponsesComponent,
        PublicQuestionnaireListComponent,
        QuestionnaireComponent,
        QuestionClosedAnswerableComponent,
        QuestionOpenAnswerableComponent,
        QuestionScaledAnswerableComponent,
        ThankYouComponent,
        QuestionOpenResponsesComponent,
        QuestionClosedResponsesComponent,
        QuestionScaledResponsesComponent,
        SendQuestionnaireComponent,
        SearchBarComponent,
        AccountComponent,
        ChangeNameComponent,
        ChangeEmailComponent,
        ChangePasswordComponent,
        DeleteAccountComponent,
        NotificationsComponent,
    ],
    imports: [
        BrowserModule,
        RouterModule.forRoot(
            appRoutes,
            {useHash:true}
            // { enableTracing: true } // <-- debugging purposes only
        ),
        FontAwesomeModule,
        ReactiveFormsModule,
        HttpClientModule,
        BrowserAnimationsModule,
        ChartsModule
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
