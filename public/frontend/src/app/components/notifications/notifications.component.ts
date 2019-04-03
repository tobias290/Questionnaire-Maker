import {Component, OnInit} from "@angular/core";
import {ApiService} from "../../api.service";
import {Router} from "@angular/router";
import {URLS} from "../../urls";
import {User} from "../../models/user";
import {Notification} from "../../models/notification";


@Component({
    selector: "app-notifications",
    templateUrl: "./notifications.component.html",
    styleUrls: ["./notifications.component.css"],
    providers: [ApiService]
})
export class NotificationsComponent implements OnInit {
    title = "Notifications";
    
    loading = {
        user: true,
        notifications: false,
    };
    
    user: User;
    notifications: Notification[] = [];
    
    public constructor(private apiService: ApiService, private router: Router) {
    }


    ngOnInit() {
        if (!sessionStorage.getItem("token")) {
            this.router.navigateByUrl("/login");
            return;
        }

        this.getUserData();
        this.getNotificationData();
    }

    /**
     * Gets the users' data.
     */
    getUserData() {
        this.loading.user = true;
        
        this.apiService
            .get(URLS.GET.USER.details, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(res => {
                this.user = new User(res);

                this.loading.user = false;
            }, error => console.log(error));

    }

    /**
     * Gets the user's notifications.
     */
    getNotificationData() {
        this.loading.notifications = true;
        this.notifications = [];
        
        this.apiService
            .get(URLS.GET.USER.notifications, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                // @ts-ignore
                for (let notification of success)
                    this.notifications.push(new Notification(notification));
                
                this.loading.notifications = false;
            }, error => console.log(error));
    }
    
    getNumberOfUnreadNotifications() {
        return this.notifications.filter(notification => !notification.isRead).length;
    }

    /**
     * Marks a notification as read.
     * 
     * @param {string} id - Notification's ID.
     */
    readNotification(id) {
        this.apiService
            .patch(`${URLS.PATCH.USER.readNotification}/${id}`, {}, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.getUserData();
                this.getNotificationData();
            }, error => console.log(error));
    }

    /**
     * Reads all of the notifications.
     */
    readAllNotifications() {
        this.apiService
            .patch(URLS.PATCH.USER.readAllNotifications, {}, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.getUserData();
                this.getNotificationData();
            }, error => console.log(error));
    }

    /**
     * Deletes a notification.
     *
     * @param {string} id - Notification's ID.
     */
    deleteNotification(id) {
        this.apiService
            .delete(`${URLS.DELETE.USER.deleteNotification}/${id}`, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.getUserData();
                this.getNotificationData();
            }, error => console.log(error));
    }

    /**
     * Deletes all of the notifications.
     */
    deleteAllNotifications() {
        this.apiService
            .delete(URLS.DELETE.USER.deleteAllNotifications, ApiService.createTokenHeader(sessionStorage.getItem("token")))
            .subscribe(success => {
                this.getUserData();
                this.getNotificationData();
            }, error => console.log(error));
    }
}

