import {Component, OnInit} from "@angular/core";
import {ApiService} from "../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../urls";
import {User} from "../../models/user";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons";
import {Questionnaire} from "../../models/questionnaire";

interface DataMetadata {
    user: User,
    questionnaires: Questionnaire[],
}

@Component({
    selector: "app-dashboard",
    templateUrl: "./dashboard.component.html",
    styleUrls: ["./dashboard.component.css"],
    providers: [ApiService]
})
export class DashboardComponent implements OnInit {
    title = "Dashboard";

    loading = {
        user: true,
        questionnaires: true,
    };

    showCreateQuestionnairePopup: boolean = false;
    showSendQuestionnairePopup: boolean = false;
    sendQuestionnaireId: number;
    
    icons = {
        downCaret: faCaretDown,
    };
    
    data: DataMetadata = {
        user: null,
        questionnaires: null,
    };
    
    searchQuery: string = "";
    
    sortTypes = {
        AZ: 0,
        CREATED_AT: 1,
        LAST_MODIFIED: 2,
        RESPONSES: 3,
    };
    
    currentSort = this.sortTypes.AZ;
    ascending: boolean = true;
    
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

                this.loading.user = false;
            }, error => console.log(error));

        this.apiService
            .get(URLS.GET.QUESTIONNAIRE.all, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.questionnaires = [];

                // @ts-ignore
                for (let questionnaire of res) {
                    this.data.questionnaires.push(new Questionnaire(questionnaire));
                }

                this.loading.questionnaires = false;
            }, error => console.log(error));
    }

    /**
     * Reloads the questionnaire list as the data may have changed.
     */
    public reload() {
        this.loading.questionnaires = true;
        
        this.apiService
            .get(URLS.GET.QUESTIONNAIRE.all, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.questionnaires = [];

                // @ts-ignore
                for (let questionnaire of res) {
                    this.data.questionnaires.push(new Questionnaire(questionnaire));
                }

                this.loading.questionnaires = false;
            }, error => console.log(error));
    }

    /**
     * Returns either all the questionnaires or a filter of search query is used then returned the filtered questionnaires.
     * 
     * @returns {Questionnaire[]} - Returns list of questionnaires.
     */
    public getQuestionnaires() {
        let questionnaires = (
            this.searchQuery !== "" ?
            this.data.questionnaires.filter(q => q.title.toLowerCase().includes(this.searchQuery.toLowerCase())) : 
            this.data.questionnaires
            // @ts-ignore
        ).sort( (questionA, questionB) => this.getSortFunction()(questionA, questionB));
        
        return this.ascending ? questionnaires : questionnaires.reverse();
    }

    /**
     * Called when a new questionnaire is created.
     * 
     * @param questionnaireId
     */
    public questionnaireCreated(questionnaireId) {
        this.showCreateQuestionnairePopup = false;
        this.router.navigate(["edit", questionnaireId]);
    }

    /**
     * Returns the correct function to sort the questionnaires.
     */
    private getSortFunction() {
        switch (this.currentSort) {
            case this.sortTypes.AZ:
                return (questionA, questionB) => questionA.title < questionB.title ? -1 : questionA.title > questionB.title ? 1 : 0;
            case this.sortTypes.CREATED_AT:
                // @ts-ignore
                return (questionA, questionB) => new Date(questionA.createdAt) - new Date(questionB.createdAt);
            case this.sortTypes.LAST_MODIFIED:
                // @ts-ignore
                return (questionA, questionB) => new Date(questionA.lastModified) - new Date(questionB.lastModified);
            case this.sortTypes.RESPONSES:
                return (questionA, questionB) => questionA.responses - questionB.responses;
        }
    }
}

