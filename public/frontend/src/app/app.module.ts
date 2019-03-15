import {BrowserModule} from "@angular/platform-browser";
import {NgModule} from "@angular/core";
import { RouterModule, Routes } from "@angular/router";

import {AppComponent} from "./components/app/app.component";
import {LandingComponent} from "./components/landing/landing.component";
import {TopBarComponent} from "./components/top-bar/top-bar.component";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {SignUpComponent} from "./components/sign-up/sign-up.component";
import {ReactiveFormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";
import {DashboardComponent} from "./components/dashboard/dashboard.component";
import {LoginComponent} from "./components/login/login.component";
import {LoadingComponent} from "./components/loading/loading.component";

const appRoutes: Routes = [
    { path: "", component: LandingComponent },
    { path: "sign-up", component: SignUpComponent },
    { path: "login", component: LoginComponent },
    { path: "dashboard", component: DashboardComponent },
];

@NgModule({
    declarations: [
        AppComponent,
        TopBarComponent,
        LoadingComponent,
        LandingComponent,
        SignUpComponent,
        LoginComponent,
        DashboardComponent,
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
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
