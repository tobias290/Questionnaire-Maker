import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges, ViewChild} from "@angular/core";
import {faFont, faThLarge, faCalendarAlt} from "@fortawesome/free-solid-svg-icons";
import {URLS} from "../../../../urls";
import {ApiService} from "../../../../api.service";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {Questionnaire} from "../../../../models/questionnaire";
import {lintSyntaxError} from "tslint/lib/verify/lintError";
import {ToggleSwitchComponent} from "../../../_controls/toggle-switch/toggle-switch.component";

@Component({
    selector: "app-create-questionnaire-form",
    templateUrl: "./create-questionnaire.component.html",
    styleUrls: ["./create-questionnaire.component.css"],
    providers: [ApiService]
})
export class CreateQuestionnaireFormComponent implements OnInit, OnChanges {
    @Input() questionnaire: Questionnaire = null;
    
    @Output() onCreate = new EventEmitter<number>();
    
    icons = {
        title: faFont,
        category: faThLarge,
        expiry: faCalendarAlt,
    };

    isEditing: boolean = false;
    
    questionnaireCategories = null;
    
    showExpiryInput = false;
    showExpiryInputStartState = false;
    
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
            .get(URLS.GET.PUBLIC.categories)
            .subscribe(res => {
                this.questionnaireCategories = res;
            });
    }

    /**
     * Called when any of the inputs are changed.
     * 
     * @param changes
     */
    public ngOnChanges(changes: SimpleChanges) {
        // Needed this here as the questionnaire loads asynchronously, therefore it is updated after creation. 
        this.isEditing = this.questionnaire !== null;

        // If the questionnaire is now editable update the form to include the current details.
        if (this.isEditing) {
            // Only run if the questionnaire expires
            if (this.questionnaire.expiryDate !== null) {
                this.showExpiryInput = true;
                this.showExpiryInputStartState = true;

                // Format the date so the HTML input element can parse it correctly.
                // Changing it from dd/mm/yy to yyyy-mm-dd
                let dateSplit = this.questionnaire.expiryDate.split("/");
                this.createQuestionnaireForm.get("expiry").setValue(`${dateSplit[2]}-${dateSplit[1]}-${dateSplit[0]}`);
            }
            
            this.createQuestionnaireForm.get("title").setValue(this.questionnaire.title);
            this.createQuestionnaireForm.get("category").setValue(this.questionnaire.categoryId);
            this.createQuestionnaireForm.get("description").setValue(this.questionnaire.description);
        }
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
        if (!this.createQuestionnaireForm.valid) {
            // if the user disables the expiry box the form will still pick it up as invalid because it is set to be required
            // There this check that and continues anyway.
            if (!(this.showExpiryInput == false && this.createQuestionnaireForm.get("expiry").errors.required)) return;
        }

        // Convert data to comply with API's format.
        let data = {
            title: this.createQuestionnaireForm.value.title,
            questionnaire_category_id: this.createQuestionnaireForm.value.category,
            expiry_date: this.showExpiryInput ? this.createQuestionnaireForm.value.expiry : null,
            description: this.createQuestionnaireForm.value.description,
        };
        
        if (this.isEditing)
            this.editQuestionnaireSubmit(data);
        else 
            this.createQuestionnaireSubmit(data);
    }

    /**
     * Called when the form is submitted and a new questionnaire is to be created.
     */
    public createQuestionnaireSubmit(data) {
        this.apiService.post(
            URLS.POST.QUESTIONNAIRE.create, 
            data,
            ApiService.createTokenHeader(sessionStorage.getItem("token"))
        ).subscribe(success => {
            this.success(success);
        }, (err) => console.log(err));
    }


    /**
     * Called when the form is submitted and a questionnaire is to be edited.
     */
    public editQuestionnaireSubmit(data) {
        this.apiService.patch(
            `${URLS.PATCH.QUESTIONNAIRE.edit}/${this.questionnaire.id}`,
            data,
            ApiService.createTokenHeader(sessionStorage.getItem("token"))
        ).subscribe(success => {
            this.success(success);
        }, (err) => console.log(err));
    }

    /**
     * Called when the creation was successfull
     * 
     * @param success
     */
    private success(success) {
        this.onCreate.emit(success.success.questionnaire_id);
    }
}

