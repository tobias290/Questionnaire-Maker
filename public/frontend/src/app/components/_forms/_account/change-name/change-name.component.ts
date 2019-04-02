import {Component, EventEmitter, Input, OnInit, Output} from "@angular/core";
import {faUser} from "@fortawesome/free-solid-svg-icons";
import {User} from "../../../../models/user";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ApiService} from "../../../../api.service";
import {URLS} from "../../../../urls";


@Component({
    selector: "app-change-name-form",
    templateUrl: "./change-name.component.html",
    styleUrls: ["./change-name.component.css"],
    providers: [ApiService]
})
export class ChangeNameComponent implements OnInit {
    @Input() user: User;
    
    @Output() cancel = new EventEmitter();
    @Output() reload = new EventEmitter();
    
    icons = {
        user: faUser,
    };

    changeNameForm = new FormGroup({
        firstName: new FormControl("", Validators.required),
        surname: new FormControl("", Validators.required)
    });
    
    get firstNameInput() {
        return this.changeNameForm.get("firstName");
    }
    
    get surnameInput() {
        return this.changeNameForm.get("surname");
    }
    
    public constructor(private apiService: ApiService) {
    }
    
    ngOnInit() {
        this.changeNameForm.get("firstName").setValue(this.user.firstName);
        this.changeNameForm.get("surname").setValue(this.user.surname);
    }

    /**
     * Called when the form is submitted.
     */
    onSubmit() {
        // Form is not valid so do not submit
        if (!this.changeNameForm.valid) return;
        
        this.apiService
            .patch(URLS.PATCH.USER.edit, {
                first_name: this.changeNameForm.value.firstName,
                surname: this.changeNameForm.value.surname,
            }, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => this.reload.emit(), error => console.log(error));
    }
}

