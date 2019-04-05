import {Component} from "@angular/core";
import {faAt} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../../urls";

@Component({
    selector: "app-forgotten-password",
    templateUrl: "./forgotten-password.component.html",
    styleUrls: ["./forgotten-password.component.scss"],
    providers: [ApiService],
})
export class ForgottenPasswordComponent {
    title = "Questionnaire Maker";

    icons = {
        email: faAt,
    };

    linkSent: boolean = false;
    
    isServerError: boolean = false;
    serverErrorMessage: string;

    forgottenPasswordForm = new FormGroup({
        email: new FormControl("", Validators.required),
    });

    get emailInput() {
        return this.forgottenPasswordForm.get("email");
    }
    
    public constructor(private apiService: ApiService, private router: Router) {
    }

    public ngOnInit() {
        // Automatically take the user to their dashboard if they are already logged in
        if (sessionStorage.getItem("token"))
            this.router.navigateByUrl("dashboard");
    }
    
    /**
     * Called when the sign up form is submitted
     */
    public onSubmit() {
        // Reset server errors & messages
        this.linkSent = false;
        this.isServerError = false;
        this.serverErrorMessage = null;

        // Form is not valid so do not submit
        if (!this.forgottenPasswordForm.valid) return;

        this.apiService
            .post(URLS.POST.USER.sendPasswordResetLink, {email: this.forgottenPasswordForm.value.email})
            .subscribe(success => this.linkSent = true, err => this.error(err));
    }

    /**
     * Called if an error occurred.
     *
     * @param error
     */
    private error(error) {
        this.isServerError = true;

        this.serverErrorMessage = error.error === undefined ? "Cannot connect to server" : error.error.message;
    }
}
