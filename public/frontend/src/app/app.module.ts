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

const appRoutes: Routes = [
    { path: "", component: LandingComponent },
    { path: "sign-up", component: SignUpComponent },
    { path: "dashboard", component: DashboardComponent },
];

@NgModule({
    declarations: [
        AppComponent,
        TopBarComponent,
        LandingComponent,
        SignUpComponent,
        DashboardComponent,
    ],
    imports: [
        BrowserModule,
        RouterModule.forRoot(
            appRoutes,
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
