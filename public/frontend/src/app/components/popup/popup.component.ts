import {Component, EventEmitter, Input, Output} from "@angular/core";
import {faTimes} from "@fortawesome/free-solid-svg-icons";
import {trigger, state, style, transition, animate} from "@angular/animations";

@Component({
    selector: "app-popup",
    templateUrl: "./popup.component.html",
    styleUrls: ["./popup.component.css"],
    animations: [
        // trigger("openClose", [
        //     state("open", style({
        //         transform: "scale(1)"
        //     })),
        //     state("closed", style({
        //         transform: "scale(0)"
        //     })),
        //     transition("open => closed", [
        //         animate(".1s"),
        //     ]),
        //     transition("closed => open", [
        //         animate(".3s"),
        //     ])
        // ])
    ]
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

