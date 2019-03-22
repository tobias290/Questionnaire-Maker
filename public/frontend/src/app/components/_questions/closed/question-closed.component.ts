import {Component, EventEmitter, Input, Output} from "@angular/core";
import {faBan, faCaretSquareDown, faCheckSquare, faCopy, faEdit, faListAlt, faSave, faTrashAlt} from "@fortawesome/free-solid-svg-icons";
import {QuestionClosed} from "../../../models/question-closed";
import {URLS} from "../../../urls";
import {ApiService} from "../../../api.service";
import {FormControl, Validators} from "@angular/forms";


@Component({
    selector: "app-question-closed",
    templateUrl: "./question-closed.component.html",
    styleUrls: ["./question-closed.component.css"],
    providers: [ApiService],
})
export class QuestionClosedComponent {
    @Input() question: QuestionClosed;
    
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
    
    /**
     * Deletes the question from the questionnaire.
     */
    public deleteQuestion() {
        this.apiService
            .delete(
                `${URLS.DELETE.QUESTION.deleteClosed}/${this.question.id}`,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit());
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
                `${URLS.PATCH.QUESTION.editClosed}/${this.question.id}`,
                data,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit());
    }
}

