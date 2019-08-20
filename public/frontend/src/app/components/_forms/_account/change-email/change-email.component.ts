import {Component, EventEmitter, Input, Output} from "@angular/core";
import {User} from "../../../../models/user";
import {faAt, faLock, faUser} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";


@Component({
    selector: "app-change-email-form",
    templateUrl: "./change-email.component.html",
    styleUrls: ["./change-email.component.css"],
    providers: [ApiService],
})
export class ChangeEmailComponent {
    @Input() user: User;

    @Output() cancel = new EventEmitter();
    @Output() reload = new EventEmitter();

    icons = {
        email: faAt,
        password: faLock,
    };
    
    emailMatchingError: boolean = false;
    isServerError: boolean = false;
    serverErrorMessage: string;

    changeEmailForm = new FormGroup({
        newEmail: new FormControl("", [Validators.required, Validators.email]),
        confirmEmail: new FormControl("", [Validators.required, Validators.email]),
        currentPassword: new FormControl("", Validators.required)
    });

    get newEmailInput() {
        return this.changeEmailForm.get("newEmail");
    }

    get confirmEmailInput() {
        return this.changeEmailForm.get("confirmEmail");
    }

    get currentPasswordInput() {
        return this.changeEmailForm.get("currentPassword");
    }
    
    public constructor(private apiService: ApiService) {
    }

    /**
     * Called when the form is submitted.
     */
    onSubmit() {
        this.isServerError = false;
        this.emailMatchingError = false;
        
        // Form is not valid so do not submit
        if (!this.changeEmailForm.valid) return;

        // If the emails do not match show error message and return without submitting
        if (this.changeEmailForm.value.newEmail !== this.changeEmailForm.value.confirmEmail) {
            this.emailMatchingError = true;
            return;
        }
        
        this.apiService
            .patch(URLS.PATCH.USER.edit, {
                email: this.changeEmailForm.value.newEmail,
                current_password: this.changeEmailForm.value.currentPassword,
            }, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => this.reload.emit(), error => {
                this.isServerError = true;
                this.serverErrorMessage = error.error.message;
            });
    }
}

