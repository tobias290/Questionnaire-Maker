import {Component, OnInit} from "@angular/core";
import {URLS} from "../../urls";
import {ApiService} from "../../api.service";
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {Questionnaire} from "../../models/questionnaire";
import {Question} from "../../models/question";
import {QuestionOpen} from "../../models/question-open";
import {QuestionClosed} from "../../models/question-closed";
import {QuestionClosedOption} from "../../models/question-closed-option";
import {QuestionScaled} from "../../models/question-scaled";
import {QuestionOpenResponse} from "../../models/question-open-response";
import {QuestionScaledResponse} from "../../models/question-scaled-response";
import {User} from "../../models/user";
import {faCaretDown, faFileCsv} from "@fortawesome/free-solid-svg-icons";
import {DomSanitizer} from "@angular/platform-browser";

interface DataMetadata {
    user: User,
    questionnaire: Questionnaire,
    questions: Question[],
    questionClosedOptions: Object,
    openQuestionResponses: Object,
    scaledQuestionResponses: Object,
}

@Component({
    selector: "app-questionnaire-responses",
    templateUrl: "./questionnaire-responses.component.html",
    styleUrls: ["./questionnaire-responses.component.css"],
    providers: [ApiService],
})
export class QuestionnaireResponsesComponent implements OnInit {
    loading = {
        user: true,
        responses: true,
    };
    
    icons = {
        downCaret: faCaretDown,
        csv: faFileCsv
    };
    
    data: DataMetadata = {
        user: null,
        questionnaire: null,
        questions: [],
        questionClosedOptions: [],
        openQuestionResponses: [],
        scaledQuestionResponses: [],
    };

    public constructor(private apiService: ApiService, private router: Router, private route: ActivatedRoute, private sanitizer: DomSanitizer) {
    }
    
    public ngOnInit() {
        if (!sessionStorage.getItem("token")) {
            this.router.navigateByUrl("/login");
            return;
        }

        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.user = new User(res);

                this.loading.user = false;
            }, error => console.log(error));

        this.route.paramMap.subscribe((params: ParamMap) =>  {
            this.apiService
                .get(URLS.GET.RESPONSES.questionnaireResponses(params.get("id")), ApiService.createTokenHeader(sessionStorage.getItem("token")))
                .subscribe(success => {
                    // @ts-ignore
                    this.data.questionnaire = new Questionnaire(success.success.questionnaire);

                    // @ts-ignore
                    // Add all the open questions
                    for (let openQuestion of success.success.questionnaire.open_questions || []) {
                        this.data.questions.push(new QuestionOpen(openQuestion));

                        // Empty array for the question responses
                        let responses: QuestionOpenResponse[] = [];
                        
                        // Push each response to the options array after instantiating the correct model
                        openQuestion.responses.forEach(response => responses.push(new QuestionOpenResponse(response)));

                        // Add the list of responses with the key being the question ID
                        this.data.openQuestionResponses[openQuestion.id] = responses;
                    }

                    // @ts-ignore
                    // Add all the closed questions
                    for (let closedQuestion of success.success.questionnaire.closed_questions || []) {
                        this.data.questions.push(new QuestionClosed(closedQuestion));

                        // Empty array for the question options
                        let options: QuestionClosedOption[] = [];

                        // Push each option to the options array after instantiating the correct model
                        closedQuestion.options.forEach(option => options.push(new QuestionClosedOption(option)));

                        // Add the list of options with the key being the question ID
                        this.data.questionClosedOptions[closedQuestion.id] = options;
                    }

                    // @ts-ignore
                    // Add all the scaled questions
                    for (let scaledQuestion of success.success.questionnaire.scaled_questions || []) {
                        this.data.questions.push(new QuestionScaled(scaledQuestion));

                        // Empty array for the question responses
                        let responses: QuestionScaledResponse[] = [];

                        // Push each response to the options array after instantiating the correct model
                        scaledQuestion.responses.forEach(response => responses.push(new QuestionScaledResponse(response)));

                        // Add the list of responses with the key being the question ID
                        this.data.scaledQuestionResponses[scaledQuestion.id] = responses;
                    }

                    // Sort questions into the order they should be in the questionnaire.
                    this.data.questions.sort((a, b) => a.position - b.position);
                    
                    this.loading.responses = false;
                }, error => console.log(error))
        });
    }

    /**
     * Determines whether the given question is an instance of the given type.
     *
     * @param {QuestionOpen|QuestionClosed|QuestionScaled} instance - Instance of question.
     * @param {string} type - Type to check instance against.
     */
    public isQuestionType(instance, type) {
        switch (type) {
            case "open":
                return instance instanceof QuestionOpen;
            case "closed":
                return instance instanceof QuestionClosed;
            case "scaled":
                return instance instanceof QuestionScaled;
            default:
                return false;
        }
    }
}

