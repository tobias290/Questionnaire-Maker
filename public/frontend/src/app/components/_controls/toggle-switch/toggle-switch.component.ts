import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from "@angular/core";


@Component({
    selector: "app-toggle-switch",
    templateUrl: "./toggle-switch.component.html",
    styleUrls: ["./toggle-switch.component.css"],
})
export class ToggleSwitchComponent implements OnInit, OnChanges {
    @Input("state") startState = false;
    
    @Output() onChange = new EventEmitter<boolean>();
    
    state: boolean;

    /**
     * Set start state in a separate variable so it doesnt change when 'toggle()' is called.
     */
    public ngOnInit() {
        this.state = this.startState;
    }
    
    public ngOnChanges(changes: SimpleChanges) {
        this.state = this.startState;
    }

    /**
     * Called when the switch is toggled.
     */
    public toggle() {
        this.state = !this.state;
        this.onChange.emit(this.state);
    }
}

