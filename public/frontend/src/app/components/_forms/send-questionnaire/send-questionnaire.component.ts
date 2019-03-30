import {Component, Input} from "@angular/core";
import {faCopy} from "@fortawesome/free-solid-svg-icons";


@Component({
    selector: "app-send-questionnaire",
    templateUrl: "./send-questionnaire.component.html",
    styleUrls: ["./send-questionnaire.component.css"],
})
export class SendQuestionnaireComponent {
    @Input() questionnaireId: number;
    
    copyIcon = faCopy;
    
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

