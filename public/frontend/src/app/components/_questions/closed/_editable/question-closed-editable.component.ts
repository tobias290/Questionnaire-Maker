import {Component, EventEmitter, Input, OnChanges, Output} from "@angular/core";
import {
    faBan,
    faCopy,
    faEdit,
    faSave,
    faTrashAlt,
    faMinusCircle, faPlusCircle
} from "@fortawesome/free-solid-svg-icons";
import {QuestionClosed} from "../../../../models/question-closed";
import {URLS} from "../../../../urls";
import {ApiService} from "../../../../api.service";
import {FormControl, Validators} from "@angular/forms";
import {QuestionClosedOption} from "../../../../models/question-closed-option";


interface OptionMeta {
    id: number|null,
    option: string,
}

@Component({
    selector: "app-question-closed-editable",
    templateUrl: "./question-closed-editable.component.html",
    styleUrls: ["./question-closed-editable.component.css"],
    providers: [ApiService],
})
export class QuestionClosedEditableComponent implements OnChanges {
    @Input() question: QuestionClosed;
    @Input() lastPosition: number;
    
    @Output() refresh = new EventEmitter();
    
    icons = {
        edit: faEdit,
        duplicate: faCopy,
        delete: faTrashAlt,
        save: faSave,
        cancel: faBan,
        addOption: faPlusCircle,
        deleteOption: faMinusCircle,
    };

    inEditableForm: boolean = false;

    existingOptions: QuestionClosedOption[] = [];
    options: OptionMeta[] = [];
    deleteOptions: number[] = [];
    
    questionName = new FormControl("", Validators.required);
    isRequired: boolean;

    public constructor(private apiService: ApiService) {
    }

    ngOnChanges() {
        this.questionName.setValue(this.question.name);
        
        this.apiService.get(
            URLS.GET.QUESTION_OPTION.questionClosedOptions(this.question.id),
            ApiService.createTokenHeader(sessionStorage.getItem("token"))
        )
        .subscribe(success => {
            // @ts-ignore
            for (let option of success.success.options) {
                this.existingOptions.push(new QuestionClosedOption(option));
                this.options.push({id: option.id, option: option.option});
            }
        }, error => console.log(error))
    }

    /**
     * Duplicates the question.
     */
    public duplicateQuestion() {
        this.apiService
            .post(
                URLS.POST.QUESTION.duplicateClosed,
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
                `${URLS.DELETE.QUESTION.deleteClosed}/${this.question.id}`,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(success => this.refresh.emit(), error => console.log(error));
    }

    /**
     * Adds a new option.
     */
    public addOption() {
        this.options.push({id: null, option: "Untitled"});
    }

    /**
     * Deletes an existing option.
     * 
     * @param index - Index of option to delete.
     */
    public deleteOption(index: number) {
        this.deleteOptions.push(this.options[index].id);
        this.options.splice(index, 1);
    }

    /**
     * Saves the changed made to the question.
     */
    public save() {
        /**
         * Deletes an options that are to be deleted.
         * Once complete it refreshes the view.
         */
        let deleteOptions = () => this.deleteOptions.forEach((optionId, i) => {
            this.apiService
                .delete(
                    `${URLS.DELETE.QUESTION_OPTION.deleteOption}/${optionId}`,
                    ApiService.createTokenHeader(sessionStorage.getItem("token")),
                ).subscribe(success => {
                    if (this.options.length - 1 === i)
                        this.refresh.emit();
                }, error => console.log(error));
        });

        /**
         * Adds new options.
         * Once complete it calls the calls function to delete any options.
         */
        let addAndEditNewOptions = () => this.options.forEach((option, i) => {
            option.id !== null ?
                // Edit option as it already has an id
                this.apiService
                    .patch(
                        `${URLS.PATCH.QUESTION_OPTION.editOption}/${option.id}`,
                        {...option, question_closed_id: this.question.id},
                        ApiService.createTokenHeader(sessionStorage.getItem("token")),
                    ).subscribe(success => {
                        if (this.options.length - 1 === i)
                            this.deleteOptions.length !== 0 ? deleteOptions() : this.refresh.emit();
                    }, error => console.log(error))
            :
                // Add new option as it has no id
                this.apiService
                    .post(
                        `${URLS.POST.QUESTION_OPTION.addOption}`,
                        {...option, question_closed_id: this.question.id},
                        ApiService.createTokenHeader(sessionStorage.getItem("token")),
                    ).subscribe(success =>  {
                        if (this.options.length - 1 === i) 
                            this.deleteOptions.length !== 0 ? deleteOptions() : this.refresh.emit();
                    }, error => console.log(error))
        });
        
        let data = {};

        // Only send data if changed are made

        if (this.questionName.value !== this.question.name)
            data["name"] = this.questionName.value;

        if (this.isRequired !== this.question.isRequired)
            data["is_required"] = this.isRequired;

        // Makes any changes to the question
        // Once complete it calls the function to add any new options ot the question
        this.apiService
            .patch(`${URLS.PATCH.QUESTION.editClosed}/${this.question.id}`,
                data,
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            ).subscribe(success => {
                if (this.options.length !== 0)
                    addAndEditNewOptions();
                else if (this.deleteOptions.length !== 0)
                    deleteOptions();
                else
                    this.refresh.emit();
            }, error => console.log(error));
    }

    /**
     * Cancels editing the question and removes any changes made.
     */
    public cancel() {
        this.questionName.setValue(this.question.name);
        this.existingOptions = [];
        this.options = [];
        this.deleteOptions = [];
        
        this.apiService.get(
                URLS.GET.QUESTION_OPTION.questionClosedOptions(this.question.id),
                ApiService.createTokenHeader(sessionStorage.getItem("token"))
            )
            .subscribe(success => {
                // @ts-ignore
                for (let option of success.success.options) {
                    this.existingOptions.push(new QuestionClosedOption(option));
                    this.options.push({id: option.id, option: option.option});
                }
            }, error => console.log(error));
        
        this.inEditableForm = false;
    }
}

