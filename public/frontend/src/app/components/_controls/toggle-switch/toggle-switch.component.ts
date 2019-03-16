import {Component, EventEmitter, Input, OnInit, Output} from "@angular/core";


@Component({
    selector: "app-toggle-switch",
    templateUrl: "./toggle-switch.component.html",
    styleUrls: ["./toggle-switch.component.css"],
})
export class ToggleSwitchComponent implements OnInit {
    @Input() state = false;
    
    @Output() onChange = new EventEmitter<boolean>();
    
    startState: boolean;

    /**
     * Set start state in a separate variable so it doesnt change when 'toggle()' is called.
     */
    public ngOnInit() {
        this.startState = this.state;
    }

    /**
     * Called when the switch is toggled.
     */
    public toggle() {
        this.state = !this.state;
        this.onChange.emit(this.state);
    }
}

