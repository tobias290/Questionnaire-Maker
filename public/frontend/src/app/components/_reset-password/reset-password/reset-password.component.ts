import {Component} from "@angular/core";
import {faCheckCircle, faLock, faTimesCircle} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../api.service";
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {URLS} from "../../../urls";

@Component({
    selector: "app-reset-password",
    templateUrl: "./reset-password.component.html",
    styleUrls: ["./reset-password.component.scss"],
    providers: [ApiService],
})
export class ResetPasswordComponent {
    title = "Questionnaire Maker";

    icons = {
        password: faLock,
        passwordMatch: faCheckCircle,
        passwordNoMatch: faTimesCircle,
    };

    loading = true;
    
    token: string;
    
    passwordMatchingError: boolean = false;
    
    isServerError: boolean = false;
    serverErrorMessage: string;

    resetPasswordForm = new FormGroup({
        newPassword: new FormControl("", Validators.required),
        confirmPassword: new FormControl("", Validators.required),
    });

    get newPasswordInput() {
        return this.resetPasswordForm.get("newPassword");
    }
    
    get confirmPasswordInput() {
        return this.resetPasswordForm.get("confirmPassword");
    }

    public constructor(private apiService: ApiService, private router: Router, private route: ActivatedRoute) {
    }

    public ngOnInit() {
        // Automatically take the user to their dashboard if they are already logged in
        if (sessionStorage.getItem("token"))
            this.router.navigateByUrl("dashboard");

        this.loading = true;
        
        this.route.paramMap.subscribe((params: ParamMap) =>  {
            this.token = params.get("token");
            
            this.apiService
                .get(`${URLS.GET.USER.hasValidPasswordResetToken}/${this.token}`)
                .subscribe(success => this.loading = false, error => this.router.navigateByUrl("login"));
        });
    }

    /**
     * Tells the UI when to tell the user if the confirm password and password box match.
     * Once both fields have data in then this will return true.
     *
     * @returns {boolean} - Returns true if both passwords fields have data in.
     */
    public showPasswordMatchingIcon() {
        return this.newPasswordInput.value != "" && this.confirmPasswordInput.value != "";
    }

    /**
     * @returns {boolean} - Returns true if password and confirm password match.
     */
    public doPasswordsMatch() {
        return this.newPasswordInput.value == this.confirmPasswordInput.value;
    }

    /**
     * Called when the sign up form is submitted
     */
    public onSubmit() {
        // Reset server errors & messages
        this.isServerError = false;
        this.serverErrorMessage = null;

        // Form is not valid so do not submit
        if (!this.resetPasswordForm.valid) return;

        // If the passwords do not match show error message and return without submitting
        if (this.newPasswordInput.value != this.confirmPasswordInput.value) {
            this.passwordMatchingError = true;
            return;
        }
        
        let data = {
            token: this.token,
            password: this.resetPasswordForm.value.newPassword
        };
        
        this.apiService
            .post(URLS.POST.USER.resetPassword, data)
            .subscribe(success => this.router.navigateByUrl("login"), err => this.error(err));
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
