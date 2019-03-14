import {Component} from "@angular/core";
import {faAt, faLock} from "@fortawesome/free-solid-svg-icons";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../api.service";
import {URLS} from "../../urls";

import {Router} from '@angular/router';


@Component({
    selector: "app-login",
    templateUrl: "./login.component.html",
    styleUrls: ["./login.component.css"],
    providers: [ApiService]
})
export class LoginComponent {
    title = "Questionnaire Maker";

    icons = {
        email: faAt,
        password: faLock,
    };
    
    isServerError: boolean = false;
    serverErrorMessage: string;
    
    loginForm = new FormGroup({
        email: new FormControl("", Validators.required),
        password: new FormControl("", Validators.required),
    });

    constructor(private apiService: ApiService, private router: Router) {
    }


    /**
     * Returns a form control from the form group.
     * 
     * @param {string} name - Name of form control
     * 
     * @returns {FormControl} - Form group
     */
    input(name: string) {
        return this.loginForm.get(name);
    }

    /**
     * Called when the sign up form is submitted
     */
    onSubmit() {
        // Reset server errors
        this.isServerError = false;
        this.serverErrorMessage = null;
        
        // Form is not valid so do not submit
        if (!this.loginForm.valid) return;
        
        // Convert data to comply with API's format.
        let data = {
            email: this.loginForm.value.email,
            password: this.loginForm.value.password,
        };
        
        this.apiService.post(URLS.login, data).subscribe(success => {
            this.success(success);
        }, (err) => {
            this.error(err)
        });
    }

    /**
     * Called if the request was successful.
     * 
     * @param success - Success data returned by the response.
     */
    success(success) {
        if (success.hasOwnProperty("success")) {
            this.router.navigateByUrl("/dashboard");
        }
    }

    /**
     * Called if an error occurred.
     * 
     * @param error
     */
    error(error) {
        this.isServerError = true;
        this.serverErrorMessage = error.error.message;
    }
}

