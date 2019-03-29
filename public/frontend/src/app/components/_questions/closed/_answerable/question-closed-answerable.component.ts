import {Component, ElementRef, Input, OnChanges, OnInit, ViewChild} from "@angular/core";
import {QuestionClosed} from "../../../../models/question-closed";
import {URLS} from "../../../../urls";
import {ApiService} from "../../../../api.service";
import {QuestionClosedOption} from "../../../../models/question-closed-option";

@Component({
    selector: "app-question-closed-answerable",
    templateUrl: "./question-closed-answerable.component.html",
    styleUrls: ["./question-closed-answerable.component.css"],
})
export class QuestionClosedAnswerableComponent implements OnInit {
    @Input() question: QuestionClosed;
    @Input() options: QuestionClosedOption[];
    
    @ViewChild('dropDown') dropDownInput: ElementRef;
    
    isError: boolean = false;
    
    multipleChoice: Object = {};
    radioOption: QuestionClosedOption = null;
    
    ngOnInit() {
        if (this.question.type === "check") {
            this.options.forEach(option => {
                this.multipleChoice[option.id] = false;
            });
        }
    }

    /**
     * Checks/Uncheck the given option (For multiple choice/radio questions only).
     * 
     * @param id - Option id.
     */
    public checkMultipleChoice(id) {
        this.multipleChoice[id] = !this.multipleChoice[id];
    }

    /**
     * Check to see whether the question is required and has no answer. Therefore it is invalid.
     *
     * @returns {boolean} - Return true if the question is invalid, false if valid.
     */
    public isInvalid() {
        if (this.question.type === "drop_down") {
            return this.isError = this.question.isRequired && this.dropDownInput.nativeElement.value === "Choose";
        } else if (this.question.type === "check") {
            return this.isError = this.question.isRequired && !Object.keys(this.multipleChoice).some(key => this.multipleChoice[key] === true);
        } else if (this.question.type === "radio") {
            return this.isError = this.question.isRequired && this.radioOption === null;
        }
    }

    /**
     * Returns true if this question has no answer 
     */
    public hasNoAnswer() {
        if (this.question.type === "drop_down") {
            return this.dropDownInput.nativeElement.value === "Choose";
        } else if (this.question.type === "check") {
            return !Object.keys(this.multipleChoice).some(key => this.multipleChoice[key] === true);
        } else if (this.question.type === "radio") {
            return this.radioOption === null;
        }
    }

    /**
     * Gets the answer for the question.
     *
     * @returns {Object} - Returns the answer is JSON format.
     */
    public getAnswer() {
        let getChecksOptions = () => {
            let options = [];

            // Loop over all the check boxes, only add to list if it's checked
            Object.keys(this.multipleChoice).forEach((key) => {
                if (this.multipleChoice[key])
                    options.push(key);
            });
            
            return options;
        };
        
        if (this.question.type === "drop_down") {
            return {
                id: this.question.id,
                options: this.dropDownInput.nativeElement.value === "Choose" ? null : [this.dropDownInput.nativeElement.value]
            };
        } else if (this.question.type === "check") {
            return {
                id: this.question.id,
                options: getChecksOptions(),
            };
        } else if (this.question.type === "radio") {
            return {
                id: this.question.id,
                options: [this.radioOption.id]
            };
        }
    }
}
