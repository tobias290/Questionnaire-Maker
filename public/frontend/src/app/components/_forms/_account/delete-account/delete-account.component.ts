import {Component, EventEmitter, Input, Output} from "@angular/core";
import {User} from "../../../../models/user";
import {faLock} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";
import {Router} from "@angular/router";


@Component({
    selector: "app-delete-account-form",
    templateUrl: "./delete-account.component.html",
    styleUrls: ["./delete-account.component.css"]
})
export class DeleteAccountComponent {
    @Input() user: User;

    @Output() cancel = new EventEmitter();

    icons = {
        password: faLock,
    };
    
    isServerError: boolean = false;
    serverErrorMessage: string;

    changePasswordForm = new FormGroup({
        currentPassword: new FormControl("", Validators.required)
    });

    get currentPasswordInput() {
        return this.changePasswordForm.get("currentPassword");
    }

    public constructor(private apiService: ApiService, private router: Router) {
    }

    /**
     * Called when the form is submitted.
     */
    onSubmit() {
        this.isServerError = false;

        // Form is not valid so do not submit
        if (!this.changePasswordForm.valid) return;

        this.apiService
            .post(URLS.DELETE.USER.delete, {
                current_password: this.changePasswordForm.value.currentPassword,
            }, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => this.router.navigateByUrl("/"), error => {
                this.isServerError = true;
                this.serverErrorMessage = error.error.message;
            });
    }
}

