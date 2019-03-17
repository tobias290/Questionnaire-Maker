import {Component, Input, OnInit} from "@angular/core";
import {ApiService} from "../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../urls";
import {User} from "../../models/user";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons";
import {Questionnaire} from "../../models/questionnaire";


@Component({
    selector: "app-dashboard",
    templateUrl: "./dashboard.component.html",
    styleUrls: ["./dashboard.component.css"],
    providers: [ApiService]
})
export class DashboardComponent implements OnInit {
    title = "Dashboard";

    userLoading: boolean = true;
    questionnairesLoading: boolean = true;

    showCreateQuestionnairePopup: boolean = false;
    
    icons = {
        downCaret: faCaretDown,
    };
    
    data = {
        user: null,
        questionnaires: null,
    };
    
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
                this.data.user = new User(res);

                this.userLoading = false;
            });

        this.apiService
            .get(URLS.GET.QUESTIONNAIRE.all, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.questionnaires = [];

                // @ts-ignore
                for (let questionnaire of res) {
                    this.data.questionnaires.push(new Questionnaire(questionnaire));
                }

                this.questionnairesLoading = false;
            });
    }

    /**
     * Reloads the questionnaire list as the data may have changed.
     */
    public reload() {
        this.questionnairesLoading = true;
        
        this.apiService
            .get(URLS.GET.QUESTIONNAIRE.all, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.questionnaires = [];

                // @ts-ignore
                for (let questionnaire of res) {
                    this.data.questionnaires.push(new Questionnaire(questionnaire));
                }

                this.questionnairesLoading = false;
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
    
    public questionnaireCreated(questionnaireId) {
        this.showCreateQuestionnairePopup = false;
        
        this.router.navigateByUrl("edit-questionnaire");
    }
}

