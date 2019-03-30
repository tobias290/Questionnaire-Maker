import {Component, Input} from "@angular/core";
import {QuestionOpen} from "../../../../models/question-open";
import {QuestionOpenResponse} from "../../../../models/question-open-response";

@Component({
    selector: "app-question-open-responses",
    templateUrl: "./question-open-responses.component.html",
    styleUrls: ["./question-open-responses.component.css"],
})
export class QuestionOpenResponsesComponent {
    @Input() question: QuestionOpen;
    @Input() responses: QuestionOpenResponse[];
}

