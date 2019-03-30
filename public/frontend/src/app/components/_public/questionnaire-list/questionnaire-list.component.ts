import {Component, OnInit} from "@angular/core";
import {ApiService} from "../../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../../urls";
import {Questionnaire} from "../../../models/questionnaire";


@Component({
    selector: "app-public-questionnaire-list",
    templateUrl: "./questionnaire-list.component.html",
    styleUrls: ["./questionnaire-list.component.css"],
    providers: [ApiService],
})
export class PublicQuestionnaireListComponent implements OnInit {
    title = "Public Questionnaires";

    loading: boolean = true;
    
    categories: [];
    questionnaires: Questionnaire[] = [];
    
    showPopupQuestionnaire: boolean = false;
    popupQuestionnaire: Questionnaire;
    
    searchQuery: string = "";

    sortTypes = {
        AZ: 0,
        CATEGORY: 1,
        DATE_CREATED: 2,
    };

    currentSort = this.sortTypes.AZ;
    ascending: boolean = true;


    public constructor(private apiService: ApiService, private router: Router) {
    }
    
    public ngOnInit(){
        this.apiService
            .get(URLS.GET.PUBLIC.categories)
            .subscribe(res => {
                // @ts-ignore
                this.categories = res;

                this.apiService.get(URLS.GET.PUBLIC.questionnaires).subscribe(success => {

                    // @ts-ignore
                    for (let questionnaire of success)
                        this.questionnaires.push(new Questionnaire(questionnaire));

                    this.loading = false;
                }, error => console.log(error));
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
                this.questionnaires.filter(q => q.title.toLowerCase().includes(this.searchQuery.toLowerCase())) :
                this.questionnaires
            // @ts-ignore
        ).sort( (questionA, questionB) => this.getSortFunction()(questionA, questionB));

        return this.ascending ? questionnaires : questionnaires.reverse();
    }

    /**
     * Gets the category name based of the category id.
     * 
     * @param categoryId - Id of category.
     * @returns {string} - Category name.
     */
    public getCategory(categoryId) {
        // @ts-ignore
        return this.categories.find((element) => element.id == categoryId).name
    }

    /**
     * Displays a popup showing details of a questionnaire that the user could answer.
     * 
     * @param questionnaire - Questionnaire to display
     */
    public showQuestionnairePopup(questionnaire: Questionnaire) {
        this.popupQuestionnaire = questionnaire;
        this.showPopupQuestionnaire = true;
    }

    /**
     * Shows the questionnaire.
     */
    public showQuestionnaire() {
        this.showPopupQuestionnaire = false;
        this.router.navigateByUrl(`public/questionnaires/${this.popupQuestionnaire.id}/answer`);
    }

    /**
     * Returns the correct function to sort the questionnaires.
     */
    private getSortFunction() {
        switch (this.currentSort) {
            case this.sortTypes.AZ:
                return (questionA, questionB) => questionA.title < questionB.title ? -1 : questionA.title > questionB.title ? 1 : 0;
            case this.sortTypes.CATEGORY:
                // @ts-ignore
                return (questionA, questionB) => this.getCategory(questionA.categoryId) < this.getCategory(questionB.categoryId) ? -1 : this.getCategory(questionA.categoryId) > this.getCategory(questionB.categoryId) ? 1 : 0;
            case this.sortTypes.DATE_CREATED:
                // @ts-ignore
                return (questionA, questionB) => new Date(questionA.createdAt) - new Date(questionB.createdAt);
        }
    }
}

