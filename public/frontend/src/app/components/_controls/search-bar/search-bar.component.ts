import {Component, ElementRef, EventEmitter, Output, ViewChild} from "@angular/core";
import {faSearch, faTimesCircle} from "@fortawesome/free-solid-svg-icons";


@Component({
    selector: "app-search-bar",
    templateUrl: "./search-bar.component.html",
    styleUrls: ["./search-bar.component.css"],
})
export class SearchBarComponent {
    @ViewChild("search") searchInput: ElementRef;
    
    @Output("onSearch") searching = new EventEmitter<string>();
    
    icons = {
        search: faSearch,
        clear: faTimesCircle,
    };

    /**
     * Called as text is inputted into the search input.
     * 
     * @param event - Event with the text value.
     */
    public onSearch(event) {
        this.searching.emit(event.target.value);
    }

    /**
     * Clears the input.
     */
    public clear() {
        this.searchInput.nativeElement.value = "";
        this.searching.emit("");
    }
}

