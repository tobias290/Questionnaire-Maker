import {Component, Input} from "@angular/core";


@Component({
    selector: "app-dashboard",
    templateUrl: "./dashboard.component.html",
    styleUrls: ["./dashboard.component.css"]
})
export class DashboardComponent {
    title = "Dashboard"
    
    // NOTE: Dummy component to allow tests to navigate to this page.
}

