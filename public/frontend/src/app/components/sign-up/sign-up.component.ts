import {Component} from "@angular/core";
import {faUser, faAt, faLock, faCheckCircle, faTimesCircle} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../api.service";
import {URLS} from "../../urls";

import {Router} from '@angular/router';


@Component({
    selector: "app-sign-up",
    templateUrl: "./sign-up.component.html",
    styleUrls: ["./sign-up.component.css"],
    providers: [ApiService]
})
export class SignUpComponent {
    title = "Questionnaire Maker";

    icons = {
        email: faAt,
        name: faUser,
        password: faLock,
        passwordMatch: faCheckCircle,
        passwordNoMatch: faTimesCircle,
    };
    
    passwordMatchingError: boolean = false;
    
    signUpForm = new FormGroup({
        email: new FormControl("", [
            Validators.required,
            Validators.email,
        ]),
        firstName: new FormControl("", Validators.required),
        surname: new FormControl("", Validators.required),
        password: new FormControl("", Validators.required),
        confirmPassword: new FormControl("", Validators.required),
    });

    public constructor(private apiService: ApiService, private router: Router) {
    }


    /**
     * Returns a form control from the form group.
     * 
     * @param {string} name - Name of form control
     * 
     * @returns {FormControl} - Form group
     */
    public input(name: string) {
        return this.signUpForm.get(name);
    }

    /**
     * Tells the UI when to tell the user if the confirm password and password box match.
     * Once both fields have data in then this will return true.
     * 
     * @returns {boolean} - Returns true if both passwords fields have data in.
     */
    public showPasswordMatchingIcon() {
        return this.input("password").value != "" && this.input("confirmPassword").value != "";
    }

    /**
     * @returns {boolean} - Returns true if password and confirm password match.
     */
    public doPasswordsMatch() {
        return this.input("password").value == this.input("confirmPassword").value;
    }

    /**
     * Called when the sign up form is submitted
     */
    public onSubmit() {
        // Form is not valid so do not submit
        if (!this.signUpForm.valid) return;
        
        // If passwords do not match show error message and return without submitting
        if (this.input("password").value != this.input("confirmPassword").value) {
            this.passwordMatchingError = true;
            return;
        }
        
        // Convert data to comply with API's format.
        let data = {
            email: this.signUpForm.value.email,
            first_name: this.signUpForm.value.firstName,
            surname: this.signUpForm.value.surname,
            password: this.signUpForm.value.password,
            confirm_password: this.signUpForm.value.confirmPassword,
        };
        
        this.apiService.post(URLS.USER.signUp, data).subscribe(success => {
            this.success(success);
        });
    }

    private success(success) {
        if (success.hasOwnProperty("success")) {
            sessionStorage.setItem("token", success.success.token);
            
            this.router.navigateByUrl("/dashboard");
        }
    }
}

