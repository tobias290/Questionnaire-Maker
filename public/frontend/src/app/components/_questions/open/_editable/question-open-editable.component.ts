import {Component, EventEmitter, Input, OnChanges, Output} from "@angular/core";
import {QuestionOpen} from "../../../../models/question-open";
import {faBan, faCopy, faEdit, faSave, faTrashAlt} from "@fortawesome/free-solid-svg-icons";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";
import {FormControl, Validators} from "@angular/forms";

@Component({
    selector: "app-question-open-editable",
    templateUrl: "./question-open-editable.component.html",
    styleUrls: ["./question-open-editable.component.css"],
    providers: [ApiService],
})
export class QuestionOpenEditableComponent implements OnChanges {
    @Input() question: QuestionOpen;
    @Input() lastPosition: number;
    
    @Output() refresh = new EventEmitter();
    
    icons = {
        edit: faEdit,
        duplicate: faCopy,
        delete: faTrashAlt,
        save: faSave,
        cancel: faBan,
    };
    
    inEditableForm: boolean = false;

    questionName = new FormControl("", Validators.required);
    isRequired: boolean;
    
    public constructor(private apiService: ApiService) {
    }
    
    ngOnChanges() {
        this.questionName.setValue(this.question.name);
        this.isRequired = this.question.isRequired;
    }

    /**
     * Duplicates the question.
     */
    public duplicateQuestion() {
        this.apiService
            .post(
                URLS.POST.QUESTION.duplicateOpen,
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
                `${URLS.DELETE.QUESTION.deleteOpen}/${this.question.id}`,
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

        this.apiService
            .patch(
                `${URLS.PATCH.QUESTION.editOpen}/${this.question.id}`,
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
        this.isRequired = this.question.isRequired;
        
        this.inEditableForm = false;
    }
}
