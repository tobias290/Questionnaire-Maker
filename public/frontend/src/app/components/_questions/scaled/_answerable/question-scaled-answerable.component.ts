import {Component, ElementRef, Input, ViewChild} from "@angular/core";
import {QuestionScaled} from "../../../../models/question-scaled";
import {faStar} from "@fortawesome/free-solid-svg-icons";

@Component({
    selector: "app-question-scaled-answerable",
    templateUrl: "./question-scaled-answerable.component.html",
    styleUrls: ["./question-scaled-answerable.component.css"],
})
export class QuestionScaledAnswerableComponent {
    @Input() question: QuestionScaled;

    @ViewChild("slider") sliderInput: ElementRef;

    starIcon = faStar;

    Arr = Array;

    isError: boolean = false;

    currentStarRating: number = 0;
    
    /**
     * Check to see whether the question is required and has no answer. Therefore it is invalid.
     *
     * @returns {boolean} - Return true if the question is invalid, false if valid.
     */
    public isInvalid() {
        return this.isError = this.question.isRequired && (
            this.question.type === "star" ?
            this.currentStarRating === null :
            this.sliderInput.nativeElement.value === "" || this.sliderInput.nativeElement.value.match(/^ *$/) !== null
        );
    }

    /**
     * Returns true if this question has no answer
     */
    public hasNoAnswer() {
        return (
            this.question.type === "star" ?
            this.currentStarRating === null :
            this.sliderInput.nativeElement.value === ""
        );
    }

    /**
     * Gets the answer for the question.
     *
     * @returns {Object} - Returns the answer is JSON format.
     */
    public getAnswer() {
        return {
            id: this.question.id,
            response: this.question.type == "star" ? this.currentStarRating : this.sliderInput.nativeElement.value
        };
    }
}
