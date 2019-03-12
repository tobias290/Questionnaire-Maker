import {Component, Input} from "@angular/core";
import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";

@Component({
    selector: "app-top-bar",
    templateUrl: "./top-bar.component.html",
    styleUrls: ["./top-bar.component.css"]
})
export class TopBarComponent {
    @Input() hasBackButton: boolean;
    @Input() title: string;

    faArrowLeft = faArrowLeft;

    /**
     * Calls the browser back button.
     */
    back() {
        window.history.back();
    }
}

