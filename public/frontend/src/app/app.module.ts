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
import {CreateQuestionnaireFormComponent} from "./components/_forms/create-questionnaire/create-questionnaire.component";
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

const appRoutes: Routes = [
    { path: "", component: LandingComponent },
    { path: "public/questionnaires", component: PublicQuestionnaireListComponent },
    { path: "public/questionnaires/:id/answer", component: QuestionnaireComponent },
    { path: "sign-up", component: SignUpComponent },
    { path: "login", component: LoginComponent },
    { path: "dashboard", component: DashboardComponent },
    { path: "edit/:id", component: EditQuestionnaireComponent },
];

@NgModule({
    declarations: [
        AppComponent,
        PopupComponent,
        ToggleSwitchComponent,
        TopBarComponent,
        LoadingComponent,
        LandingComponent,
        SignUpComponent,
        LoginComponent,
        DashboardComponent,
        CreateQuestionnaireFormComponent,
        EditQuestionnaireComponent,
        QuestionnaireListItemComponent,
        QuestionClosedEditableComponent,
        QuestionOpenEditableComponent,
        QuestionScaledEditableComponent,
        PublicQuestionnaireListComponent,
        QuestionnaireComponent,
        QuestionClosedAnswerableComponent,
        QuestionOpenAnswerableComponent,
        QuestionScaledAnswerableComponent,
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
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
