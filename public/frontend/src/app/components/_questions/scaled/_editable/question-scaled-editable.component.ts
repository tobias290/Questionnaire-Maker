import {Component, EventEmitter, Input, OnChanges, Output} from "@angular/core";
import {QuestionScaled} from "../../../../models/question-scaled";
import {faCopy, faSlidersH, faStar, faTrashAlt, faSortNumericDown, faEdit, faSave, faBan} from "@fortawesome/free-solid-svg-icons";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";
import {FormControl, Validators} from "@angular/forms";


@Component({
    selector: "app-question-scaled-editable",
    templateUrl: "./question-scaled-editable.component.html",
    styleUrls: ["./question-scaled-editable.component.css"],
    providers: [ApiService],
})
export class QuestionScaledEditableComponent implements OnChanges {
    @Input() question: QuestionScaled;
    @Input() lastPosition: number;
    
    @Output() refresh = new EventEmitter();

    icons = {
        edit: faEdit,
        duplicate: faCopy,
        delete: faTrashAlt,
        save: faSave,
        cancel: faBan,
        starRating: faStar,
        slider: faSlidersH,
        numbers: faSortNumericDown,
    };

    Arr = Array;

    inEditableForm: boolean = false;

    questionName = new FormControl("", Validators.required);
    questionMin = new FormControl("", Validators.required);
    questionMax = new FormControl("", Validators.required);
    questionInterval = new FormControl("", Validators.required);
    isRequired: boolean;
    
    public constructor(private apiService: ApiService) {
    }

    ngOnChanges() {
        this.questionName.setValue(this.question.name);
        this.questionMin.setValue(this.question.min);
        this.questionMax.setValue(this.question.max);
        this.questionInterval.setValue(this.question.interval);
        this.isRequired = this.question.isRequired;
    }

    /**
     * Duplicates the question.
     */
    public duplicateQuestion() {
        this.apiService
            .post(
                URLS.POST.QUESTION.duplicateScaled,
                {question_id: this.question.id, position: this.lastPosition + 1},
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit(), error => console.log(error));
    }
    
    /**
     * Deletes the question from the questionnaire.
     */
    public deleteQuestion() {
        this.apiService
            .delete(
                `${URLS.DELETE.QUESTION.deleteScaled}/${this.question.id}`,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit(), error => console.log(error));
    }


    /**
     * Saves the changed made to the question.
     */
    public save() {
        let data = {};

        // Only send data is changed are made
        
        if (this.questionName.value !== this.question.name)
            data["name"] = this.questionName.value;
        
        if (this.isRequired !== this.question.isRequired)
            data["is_required"] = this.isRequired;
        
        if (this.questionMin.value !== this.question.min)
            data["min"] = this.questionMin.value;
        
        if (this.questionMax.value !== this.question.max)
            data["max"] = this.questionMax.value;
        
        if (this.questionInterval.value !== this.question.interval)
            data["interval"] = this.questionInterval.value;

        this.apiService
            .patch(
                `${URLS.PATCH.QUESTION.editScaled}/${this.question.id}`,
                data,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit(), error => console.log(error));
    }

    /**
     * Cancels editing the question and removes any changes made.
     */
    public cancel() {
        this.questionName.setValue(this.question.name);
        this.questionMin.setValue(this.question.min);
        this.questionMax.setValue(this.question.max);
        this.questionInterval.setValue(this.question.interval);
        this.isRequired = this.question.isRequired;

        this.inEditableForm = false;
    }
}
