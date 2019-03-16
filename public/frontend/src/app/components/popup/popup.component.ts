import {Component, EventEmitter, Input, Output} from "@angular/core";
import {faTimes} from "@fortawesome/free-solid-svg-icons";

@Component({
    selector: "app-popup",
    templateUrl: "./popup.component.html",
    styleUrls: ["./popup.component.css"]
})
export class PopupComponent {
    @Input() show: boolean;
    
    @Output() close =  new EventEmitter<boolean>();
    
    closeIcon = faTimes;

    /**
     * Close the popup.
     */
    public closeClick() {
        this.close.emit(true);
    }
}

