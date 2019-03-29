import {Component, OnInit, ViewChild} from "@angular/core";
import {ApiService} from "../../api.service";
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {URLS} from "../../urls";
import {Questionnaire} from "../../models/questionnaire";
import {
    faEdit,
    faPaperPlane,
    faEye,
    faCaretDown,
    faListAlt,
    faCheckSquare,
    faCaretSquareDown,
    faParagraph,
    faStar,
    faSlidersH,
    faICursor,
    faTrashAlt, faCopy
} from "@fortawesome/free-solid-svg-icons";
import {User} from "../../models/user";
import {Question} from "../../models/question";
import {QuestionOpen} from "../../models/question-open";
import {QuestionClosed} from "../../models/question-closed";
import {QuestionScaled} from "../../models/question-scaled";

interface DataMetadata {
    user: User,
    questionnaire: Questionnaire,
    questions: Question[],
}

@Component({
    selector: "app-edit-questionnaire",
    templateUrl: "./edit-questionnaire.component.html",
    styleUrls: ["./edit-questionnaire.component.css"],
    providers: [ApiService],
})
export class EditQuestionnaireComponent implements OnInit {
    title = "Edit Questionnaire";
    
    icons = {
        downCaret: faCaretDown,
        edit: faEdit,
        send: faPaperPlane,
        preview: faEye,
        questionTypes: {
            multipleChoice: faListAlt,
            checkBox: faCheckSquare,
            dropDown: faCaretSquareDown,
            singleLine: faICursor,
            paragraph: faParagraph,
            starRating: faStar,
            slider: faSlidersH,
        },
        delete: faTrashAlt,
        copy: faCopy,
    };
    
    loading = {
        user: true,
        questionnaire: true,
        questions: true,
    };
    
    data: DataMetadata = {
        user: null,
        questionnaire: null,
        questions: [],
    };
    
    showEditQuestionnairePopup: boolean = false;
    showSendQuestionnairePopup: boolean = false;

    public constructor(private apiService: ApiService, private router: Router, private route: ActivatedRoute) {
    }
    
    ngOnInit() {
        if (!sessionStorage.getItem("token")) {
            this.router.navigateByUrl("/login");
            return;
        }

        // Get the user's data
        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.user = new User(res);

                this.loading.user = false;
            }, error => console.log(error));
        
        this.getQuestionnaire();
    }

    /**
     * Gets the questionnaire based of the ID parsed via the URL.
     */
    public getQuestionnaire() {
        this.loading.questionnaire = true;
        
        // Get the questionnaire ID param from the route and get the requested questionnaire
        this.route.paramMap.subscribe((params: ParamMap) =>  {
            this.apiService
                .get(
                    `${URLS.GET.QUESTIONNAIRE.get}/${params.get("id")}`,
                    ApiService.createTokenHeader(sessionStorage.getItem("token"))
                )
                .subscribe(
                    success => {
                        this.data.questionnaire = new Questionnaire(success);
                        this.loading.questionnaire = false;

                        this.getQuestions();
                    },
                    error => console.log(error)
                )
        });
        
        this.showEditQuestionnairePopup = false;
    }

    /**
     * Gets the questions for the given questionnaire.
     */
    public getQuestions() {
        this.loading.questions = true;
        this.data.questions = [];
        
        this.apiService
            .get(
                URLS.GET.QUESTION.questionnaireQuestions(this.data.questionnaire.id), 
                ApiService.createTokenHeader(sessionStorage.getItem("token"))
            )
            .subscribe(
                success => {
                    // @ts-ignore
                    for (let openQuestion of success.success.open || []) {
                        this.data.questions.push(new QuestionOpen(openQuestion));
                    }
                    
                    // @ts-ignore
                    for (let closedQuestion of success.success.closed || []) {
                        this.data.questions.push(new QuestionClosed(closedQuestion));
                    }

                    // @ts-ignore
                    for (let scaledQuestion of success.success.scaled || []) {
                        this.data.questions.push(new QuestionScaled(scaledQuestion));
                    }
                    
                    // Sort questions into the order they should be in the questionnaire.
                    this.data.questions.sort((a, b) => a.position - b.position);
                    this.loading.questions = false;
                },
                error => console.log(error)
            );
    }

    /**
     * Deletes the questionnaire.
     */
    public delete() {
        this.apiService
            .delete(
                `${URLS.DELETE.QUESTIONNAIRE.delete}/${this.data.questionnaire.id}`,
                ApiService.createTokenHeader(sessionStorage.getItem("token"))
            )
            .subscribe(
                success => this.router.navigateByUrl("dashboard"),
                error => console.log(error),
            );
    }

    /**
     * Adds a question to the questionnaire.
     * 
     * @param {string} type - Question type (open, closed, scaled)
     * @param {string} subType - Question sub type.
     */
    public addQuestion(type, subType) {
        let url;
        let data;
        
        if (type === "open") {
            url = URLS.POST.QUESTION.addOpen;
            
            data = {
                position: this.data.questions.length + 1,
                is_long: subType === "long",
                questionnaire_id: this.data.questionnaire.id
            };
        } else if (type === "closed" || type === "scaled") {
            url = type === "closed" ? URLS.POST.QUESTION.addClosed : URLS.POST.QUESTION.addScaled;

            data = {
                position: this.data.questions.length + 1,
                type: subType,
                questionnaire_id: this.data.questionnaire.id
            };
        }
        
        this.apiService
            .post(url, data, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                // If a closed question was added, automatically give it one option
                if (type == "closed") {
                    this.apiService
                        .post(`${URLS.POST.QUESTION_OPTION.addOption}`,
                            // @ts-ignore
                            {option: "Option 1", question_closed_id: success.success.id},
                            ApiService.createTokenHeader(sessionStorage.getItem("token")))
                        .subscribe(success => this.getQuestions());
                } else {
                    this.getQuestions()
                }
            }, error => console.log(error));
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

    /**
     * Copies the link to answer the current questionnaire.
     * 
     * @param copyLinkInput - Element to get the link from.
     */
    public copyLink(copyLinkInput) {
        copyLinkInput.select();
        document.execCommand("copy");
    }
}

