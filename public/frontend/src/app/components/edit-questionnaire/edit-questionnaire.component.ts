import {Component, OnInit} from "@angular/core";
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
    faTrashAlt
} from "@fortawesome/free-solid-svg-icons";
import {User} from "../../models/user";

interface DataMetadata {
    user: User,
    questionnaire: Questionnaire
}

@Component({
    selector: "app-edit-questionnaire",
    templateUrl: "./edit-questionnaire.component.html",
    styleUrls: ["./edit-questionnaire.component.css"],
    providers: [ApiService],
})
export class EditQuestionnaireComponent implements OnInit {
    public constructor(private apiService: ApiService, private router: Router, private route: ActivatedRoute) {
    }
    
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
            sliders: faSlidersH,
        },
        delete: faTrashAlt,
    };
    
    loading = {
        user: true,
        questionnaire: true,
    };
    
    data: DataMetadata = {
        user: null,
        questionnaire: null
    };
    
    showEditQuestionnairePopup: boolean = true;
    
    ngOnInit() {
        if (!sessionStorage.getItem("token")) {
            this.router.navigateByUrl("/login");
            return;
        }

        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.data.user = new User(res);

                this.loading.user = false;
            });
        
        this.getQuestionnaire();
    }

    /**
     * Gets the questionnaire based of the ID parsed via the URL.
     */
    public getQuestionnaire() {
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
                    }
                )
        });
        
        this.showEditQuestionnairePopup = false;
    }
}

