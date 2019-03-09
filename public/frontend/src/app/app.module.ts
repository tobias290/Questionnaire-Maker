import {BrowserModule} from "@angular/platform-browser";
import {NgModule} from "@angular/core";
import { RouterModule, Routes } from "@angular/router";

import {AppComponent} from "./components/app/app.component";
import {LandingComponent} from "./components/landing/landing.component";
import {TopBarComponent} from "./components/top-bar/top-bar.component";

const appRoutes: Routes = [
    { path: "", component: LandingComponent },
];

@NgModule({
    declarations: [
        AppComponent,
        TopBarComponent,
        LandingComponent
    ],
    imports: [
        BrowserModule,
        RouterModule.forRoot(
            appRoutes,
            { enableTracing: true } // <-- debugging purposes only
        )
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
