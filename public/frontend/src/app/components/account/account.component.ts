import {Component, OnInit} from "@angular/core";
import {ApiService} from "../../api.service";
import {User} from "../../models/user";
import {URLS} from "../../urls";
import {Router} from "@angular/router";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons";
import {Settings} from "../../models/settings";


@Component({
    selector: "app-account",
    templateUrl: "./account.component.html",
    styleUrls: ["./account.component.css"],
    providers: [ApiService],
})
export class AccountComponent implements OnInit {
    title = "Account";
    
    loading = true;
    
    icons = {
        downCaret: faCaretDown,
    };
    
    forms = {
        showChangeNameForm: false,
        showChangEmailForm: false,
        showChangePasswordForm: false,
        showDeleteAccountForm: false,
    };
    
    user: User;
    settings: Settings;
    
    appToggleSwitchStartState: boolean = false;
    emailToggleSwitchState: boolean = false;
    
    public constructor(private apiService: ApiService, private router: Router) {
    }

    ngOnInit() {
       this.getUserDetails();
    }

    /**
     * Gets the user's details
     */
    getUserDetails() {
        this.loading = true;
        
        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.user = new User(success);
                
                this.getUserSettings();
            }, error => console.log(error));
    }
    
    getUserSettings() {
        this.apiService
            .get(URLS.GET.USER.settings, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.settings = new Settings(success);
                
                this.appToggleSwitchStartState = this.settings.enableInAppNotifications;
                this.emailToggleSwitchState = this.settings.enableEmailNotifications;
                
                this.loading = false;
            }, error => console.log(error));
    }
    
    changeSettings(setting) {
        this.apiService
            .patch(URLS.PATCH.USER.editSettings, setting, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => this.getUserDetails(), error => console.log(error));
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

