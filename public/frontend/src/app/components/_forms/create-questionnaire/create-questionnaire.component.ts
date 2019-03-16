import {Component, EventEmitter, OnInit, Output} from "@angular/core";
import {faFont, faThLarge, faCalendarAlt} from "@fortawesome/free-solid-svg-icons";
import {URLS} from "../../../urls";
import {ApiService} from "../../../api.service";
import {FormControl, FormGroup, Validators} from "@angular/forms";

@Component({
    selector: "app-create-questionnaire-form",
    templateUrl: "./create-questionnaire.component.html",
    styleUrls: ["./create-questionnaire.component.css"],
    providers: [ApiService]
})
export class CreateQuestionnaireFormComponent implements OnInit {
    @Output() onCreate = new EventEmitter<number>();

    questionnaireCategories = null;
    
    icons = {
        title: faFont,
        category: faThLarge,
        expiry: faCalendarAlt,
    };
    
    showExpiryInput = false;
    
    createQuestionnaireForm = new FormGroup({
        title: new FormControl("", Validators.required),
        category: new FormControl("Category", Validators.required),
        expiry: new FormControl("", Validators.required),
        description: new FormControl(""),
    });

    get formTitle() {
        return this.createQuestionnaireForm.get("title");
    }

    get formCategory() {
        return this.createQuestionnaireForm.get("category");
    }
    
    get formExpiryDate() {
        return this.createQuestionnaireForm.get("expiry");
    }
    
    public constructor(private apiService: ApiService) {
    }

    /**
     * On component load get all the questionnaire categories.
     */
    public ngOnInit() {
        this.apiService
            .get(URLS.GET.QUESTIONNAIRE.categories, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.questionnaireCategories = res;
            })
    }

    /**
     * Toggle whether the expiry input is required or not.
     * 
     * @param {boolean} state - New state for the expiry input.
     */
    public toggleExpiry(state) {
        this.showExpiryInput = state;
        
        if (state)
            this.formExpiryDate.enable();
        else
            this.formExpiryDate.disable();
    }

    /**
     * Called when the form is submitted.
     */
    public submit() {
        // Form is not valid so do not submit
        if (!this.createQuestionnaireForm.valid) return;

        // Convert data to comply with API's format.
        let data = {
            title: this.createQuestionnaireForm.value.title,
            questionnaire_category_id: this.createQuestionnaireForm.value.category,
            expiry_date: this.createQuestionnaireForm.value.expiry,
            description: this.createQuestionnaireForm.value.description,
        };
        
        this.apiService.post(
            URLS.POST.QUESTIONNAIRE.create, 
            data,
            ApiService.createTokenHeader(sessionStorage.getItem("token"))
        ).subscribe(success => {
            this.success(success);
        }, (err) => {
            this.error(err)
        });
    }
    
    private success(success) {
        this.onCreate.emit(success.questionnaire_id);
    }
    
    private error(err) {
        console.log(err);
    }
}

