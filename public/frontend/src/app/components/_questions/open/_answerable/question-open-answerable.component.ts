import {Component, ElementRef, Input, ViewChild} from "@angular/core";
import {QuestionOpen} from "../../../../models/question-open";

@Component({
    selector: "app-question-open-answerable",
    templateUrl: "./question-open-answerable.component.html",
    styleUrls: ["./question-open-answerable.component.css"],
})
export class QuestionOpenAnswerableComponent {
    @Input() question: QuestionOpen;

    @ViewChild("singleLine") singleLineInput: ElementRef;
    @ViewChild("paragraph") paragraphInput: ElementRef;
    
    isError: boolean = false;

    /**
     * Check to see whether the question is required and has no answer. Therefore it is invalid.
     * 
     * @returns {boolean} - Return true if the question is invalid, false if valid.
     */
    public isInvalid() {
        return this.isError = this.question.isRequired && (
            this.question.isLong ? 
            this.paragraphInput.nativeElement.value === "" || this.paragraphInput.nativeElement.value.match(/^ *$/) !== null : 
            this.singleLineInput.nativeElement.value === "" || this.singleLineInput.nativeElement.value.match(/^ *$/) !== null
        );
    }

    /**
     * Returns true if this question has no answer
     */
    public hasNoAnswer() {
        return this.question.isLong ?  this.paragraphInput.nativeElement.value === "" : this.singleLineInput.nativeElement.value === "";
    }

    /**
     * Gets the answer for the question.
     * 
     * @returns {Object} - Returns the answer is JSON format.
     */
    public getAnswer() {
        return {
            id: this.question.id,
            response: this.question.isLong ? this.paragraphInput.nativeElement.value : this.singleLineInput.nativeElement.value
        };
    }
}
