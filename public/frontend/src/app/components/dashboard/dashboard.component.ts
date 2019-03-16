import {Component, Input, OnInit} from "@angular/core";
import {ApiService} from "../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../urls";
import {User} from "../../models/user";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons";


@Component({
    selector: "app-dashboard",
    templateUrl: "./dashboard.component.html",
    styleUrls: ["./dashboard.component.css"],
    providers: [ApiService]
})
export class DashboardComponent implements OnInit {
    title = "Dashboard";

    icons = {
        downCaret: faCaretDown,
    };
    
    loading: boolean = true;
    
    user: User;
    
    showCreateQuestionnairePopup: boolean = false;
    
    public constructor(private apiService: ApiService, private router: Router) {
    }

    /**
     * Called when components loads.
     */
    public ngOnInit() {
        if (!sessionStorage.getItem("token")) {
            this.router.navigateByUrl("/login");
            return;
        }
        
        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.user = new User(res);
                
                this.loading = false;
            });
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
            });
    }
    
    public questionnaireCreated() {
        this.showCreateQuestionnairePopup = false;
        
        this.router.navigateByUrl("edit-questionnaire");
    }
}

