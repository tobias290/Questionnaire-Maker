import {Component, OnInit, QueryList, ViewChildren} from "@angular/core";
import {ApiService} from "../../../api.service";
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {URLS} from "../../../urls";
import {Questionnaire} from "../../../models/questionnaire";
import {Question} from "../../../models/question";
import {QuestionOpen} from "../../../models/question-open";
import {QuestionClosed} from "../../../models/question-closed";
import {QuestionScaled} from "../../../models/question-scaled";
import {QuestionClosedOption} from "../../../models/question-closed-option";
import {QuestionOpenAnswerableComponent} from "../../_questions/open/_answerable/question-open-answerable.component";
import {QuestionClosedAnswerableComponent} from "../../_questions/closed/_answerable/question-closed-answerable.component";
import {QuestionScaledAnswerableComponent} from "../../_questions/scaled/_answerable/question-scaled-answerable.component";

interface DataMetadata {
    questionnaire: Questionnaire,
    questions: Question[],
    questionClosedOptions: Object,
}

@Component({
    selector: "app-public-questionnaire",
    templateUrl: "./questionnaire.component.html",
    styleUrls: ["./questionnaire.component.css"],
    providers: [ApiService],
})
export class QuestionnaireComponent implements OnInit {
    @ViewChildren(QuestionOpenAnswerableComponent) openQuestionComponents: QueryList<QuestionOpenAnswerableComponent>;
    @ViewChildren(QuestionClosedAnswerableComponent) closedQuestionComponents: QueryList<QuestionClosedAnswerableComponent>;
    @ViewChildren(QuestionScaledAnswerableComponent) scaledQuestionComponents: QueryList<QuestionScaledAnswerableComponent>;
   
    loading = {
        questionnaire: true,
        questions: true,
    };

    preview: boolean = false;

    lockedError: boolean = false;
    accessError: boolean = false;
    expireError: boolean = false;
    
    data: DataMetadata = {
        questionnaire: null,
        questions: [],
        questionClosedOptions: {},
    };
    
    public constructor(private apiService: ApiService, private router: Router, private route: ActivatedRoute) {
    }

    public ngOnInit() {
        // @ts-ignore
        this.preview = this.route.data.value.preview;
        this.lockedError = false;
        this.accessError = false;
        this.expireError = false;
        
        this.route.paramMap.subscribe((params: ParamMap) =>  {
            this.apiService
                .get(
                    this.preview ? URLS.GET.QUESTIONNAIRE.preview(params.get("id")) : URLS.GET.PUBLIC.answerQuestionnaire(params.get("id")),
                    this.preview ? ApiService.createTokenHeader(sessionStorage.getItem("token")) : {},
                )
                .subscribe(
                    success => {
                        // @ts-ignore
                        // Add the questionnaire
                        this.data.questionnaire = new Questionnaire(success.success.questionnaire);
                        this.loading.questionnaire = false;

                        // @ts-ignore
                        // Add all the open questions
                        for (let openQuestion of success.success.questionnaire.open_questions || [])
                            this.data.questions.push(new QuestionOpen(openQuestion));

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
                        for (let scaledQuestion of success.success.questionnaire.scaled_questions || [])
                            this.data.questions.push(new QuestionScaled(scaledQuestion));

                        // Sort questions into the order they should be in the questionnaire.
                        this.data.questions.sort((a, b) => a.position - b.position);
                        this.loading.questions = false;
                    },
                    error => {
                        if (!this.preview && error.error.error.message === "This questionnaire has been locked") {
                            this.loading.questionnaire = false;
                            this.loading.questions = false;
                            this.lockedError = true;
                        } else if (!this.preview && error.error.error.message === "You cannot access that questionnaire") {
                            this.loading.questionnaire = false;
                            this.loading.questions = false;
                            this.accessError = true;
                        } else if (!this.preview && error.error.error.message === "This questionnaire has expired") {
                            this.loading.questionnaire = false;
                            this.loading.questions = false;
                            this.expireError = true;
                        }
                    });
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
    
    public back() {
        window.history.back();
    }
    
    public submit() {
        let isError = false;
        let openAnswers = [];
        let closedAnswers = [];
        let scaledAnswers = [];
        
        this.openQuestionComponents.forEach(question => {
            // Check to see if the current question is invalid
            if (question.isInvalid()) {
                isError = true;
                return;
            }

            // If there are no errors and the question is valid add it to the responses
            if (!isError && !question.hasNoAnswer()) 
                openAnswers.push(question.getAnswer());
        });

        this.closedQuestionComponents.forEach(question => {
            // Check to see if the current question is invalid
            if (question.isInvalid()) {
                isError = true;
                return;
            }
            
            // If there are no errors and the question is valid add it to the responses
            if (!isError && !question.hasNoAnswer())
                closedAnswers.push(question.getAnswer());
        });

        this.scaledQuestionComponents.forEach(question => {
            // Check to see if the current question is invalid
            if (question.isInvalid()) {
                isError = true;
                return;
            }

            // If there are no errors and the question is valid add it to the responses
            if (!isError && !question.hasNoAnswer()) 
                scaledAnswers.push(question.getAnswer());
        });
        
        if (!isError) {
            this.apiService
                .post(
                    URLS.POST.PUBLIC.submitQuestionnaire(this.data.questionnaire.id), 
                    {open: openAnswers, closed: closedAnswers, scaled: scaledAnswers}
                )
                .subscribe(success => this.router.navigateByUrl("public/thank-you"), error => console.log(error));
        }
    }

    /**
     * Cancel answering the questionnaire.
     * Redirect to the public questionnaire page
     */
    public cancel() {
        this.router.navigateByUrl("public/questionnaires");
    }
}

