import {Component, OnInit} from "@angular/core";
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
export class LoginComponent implements OnInit {
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

    public constructor(private apiService: ApiService, private router: Router) {
    }

    public ngOnInit() {
        // Automatically take the user to their dashboard if they are already logged in
        if (sessionStorage.getItem("token"))
            this.router.navigateByUrl("dashboard");
    }

    /**
     * Returns a form control from the form group.
     * 
     * @param {string} name - Name of form control
     * 
     * @returns {FormControl} - Form group
     */
    public input(name: string) {
        return this.loginForm.get(name);
    }

    /**
     * Called when the sign up form is submitted
     */
    public onSubmit() {
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
        
        this.apiService.post(URLS.POST.USER.login, data).subscribe(success => {
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
    private success(success) {
        if (success.hasOwnProperty("success")) {
            sessionStorage.setItem("token", success.success.token);
            
            this.router.navigateByUrl("/dashboard");
        }
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

