import {Component, HostListener, Input, ViewChild} from "@angular/core";
import {User} from "../../models/user";
import {faBell, faCaretDown, faCog, faGlobeEurope, faSignOutAlt, faUser} from "@fortawesome/free-solid-svg-icons";
import {URLS} from "../../urls";
import {ApiService} from "../../api.service";
import {Router} from "@angular/router";

@Component({
    selector: "app-account-drop-down",
    templateUrl: "./account-drop-down.component.html",
    styleUrls: ["./account-drop-down.component.css"],
    providers: [ApiService],
})
export class AccountDropDownComponent {
    @Input() user: User;
    
    icons = {
        downArrow: faCaretDown,
        user: faUser,
        settings: faCog,
        notifications: faBell,
        public: faGlobeEurope,
        signOut: faSignOutAlt,
    };
    
    showDropDown: boolean = false;
    
    public constructor(private apiService: ApiService, private router: Router) {
    }

    /**
     * Navigates to the account page. (Which is also the settings page).
     */
    public account() {
        this.router.navigateByUrl("account");
    }

    /**
     * Navigates to the notifications page.
     */
    public notifications() {
        this.router.navigateByUrl("notifications");
    }

    /**
     * Navigates to the public questionnaires.
     */
    public publicQuestionnaires() {
        this.router.navigateByUrl("public/questionnaires");
    }
    
    /**
     * Sign outs the user.
     */
    public signOut() {
        this.apiService
            .get(URLS.GET.USER.signOut, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                if (res["success"]) {
                    sessionStorage.removeItem("token");
                    this.router.navigateByUrl("/login");
                }
            }, error => console.log(error));
    }
}

