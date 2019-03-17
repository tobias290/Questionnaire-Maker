import {Component, EventEmitter, Input, Output} from "@angular/core";
import {Questionnaire} from "../../models/questionnaire";
import {ApiService} from "../../api.service";
import {faEdit, faChartBar, faPaperPlane, faGlobeEurope, faCheck, faTrashAlt, faLock} from "@fortawesome/free-solid-svg-icons"
import {URLS} from "../../urls";

@Component({
    selector: "app-questionnaire-list-item",
    templateUrl: "./questionnaire-list-item.component.html",
    styleUrls: ["./questionnaire-list-item.component.css"],
    providers: [ApiService],
})
export class QuestionnaireListItemComponent {
    @Input() canEdit: boolean;
    @Input() questionnaire: Questionnaire;
    
    @Output() reload = new EventEmitter<boolean>();
    
    icons = {
        edit: faEdit,
        responses: faChartBar,
        send: faPaperPlane,
        public: faGlobeEurope,
        private: faLock,
        complete: faCheck,
        delete: faTrashAlt,
    };
    
    isMouseOver = false;
    
    public constructor(private apiService: ApiService) {
    }

    /**
     * Deletes the questionnaire.
     */
    public delete() {
        this.apiService
            .delete(
                `${URLS.DELETE.QUESTIONNAIRE.delete}/${this.questionnaire.id}`, 
                ApiService.createTokenHeader(sessionStorage.getItem("token"))
            )
            .subscribe(
                success => this.reload.emit(true),
                error => console.log(error),
            );
    }

    /**
     * Change the state of the questionnaire's visibility.
     */
    public toggleQuestionnaireVisibility() {
        this.apiService
            .patch(
                `${URLS.PATCH.QUESTIONNAIRE.edit}/${this.questionnaire.id}`,
                {"is_public": !this.questionnaire.isPublic},
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(
                success => this.reload.emit(true),
                error => console.log(error),
            );
    }

    /**
     * Change the state of the questionnaire's completeness.
     */
    public toggleQuestionnaireCompleteness() {
        this.apiService
            .patch(
                `${URLS.PATCH.QUESTIONNAIRE.edit}/${this.questionnaire.id}`,
                {"is_complete": !this.questionnaire.isComplete},
                ApiService.createTokenHeader(sessionStorage.getItem("token")),
            )
            .subscribe(
                success => this.reload.emit(true),
                error => console.log(error),
            );
    }
}

