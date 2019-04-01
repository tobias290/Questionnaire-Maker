import {Component, EventEmitter, Input, Output} from "@angular/core";
import {User} from "../../../../models/user";
import {faAt, faLock} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";


@Component({
    selector: "app-change-password-form",
    templateUrl: "./change-password.component.html",
    styleUrls: ["./change-password.component.css"]
})
export class ChangePasswordComponent {
    @Input() user: User;

    @Output() cancel = new EventEmitter();
    @Output() reload = new EventEmitter();

    icons = {
        password: faLock,
    };

    passwordMatchingError: boolean = false;
    isServerError: boolean = false;
    serverErrorMessage: string;

    changePasswordForm = new FormGroup({
        newPassword: new FormControl("", Validators.required),
        confirmPassword: new FormControl("", Validators.required),
        currentPassword: new FormControl("", Validators.required)
    });

    get newPasswordInput() {
        return this.changePasswordForm.get("newPassword");
    }

    get confirmPasswordInput() {
        return this.changePasswordForm.get("confirmPassword");
    }

    get currentPasswordInput() {
        return this.changePasswordForm.get("currentPassword");
    }

    public constructor(private apiService: ApiService) {
    }

    /**
     * Called when the form is submitted.
     */
    onSubmit() {
        this.isServerError = false;
        this.passwordMatchingError = false;

        // Form is not valid so do not submit
        if (!this.changePasswordForm.valid) return;

        // If the emails do not match show error message and return without submitting
        if (this.changePasswordForm.value.newPassword !== this.changePasswordForm.value.confirmPassword) {
            this.passwordMatchingError = true;
            return;
        }

        this.apiService
            .post(URLS.POST.USER.edit, {
                password: this.changePasswordForm.value.newPassword,
                current_password: this.changePasswordForm.value.currentPassword,
            }, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => this.reload.emit(), error => {
                this.isServerError = true;
                this.serverErrorMessage = error.error.message;
            });
    }
}

