export class Settings {
    private readonly _enableInAppNotifications: boolean;
    private readonly _enableEmailNotifications: boolean;
    private readonly _questionnaireExpirationNotification: string;
    
    public constructor(settings) {
        this._enableInAppNotifications = settings.enable_in_app_notifications;
        this._enableEmailNotifications = settings.enable_email_notifications;
        this._questionnaireExpirationNotification = settings.questionnaire_expiration_notification;
    }
    
    get enableInAppNotifications() {
        return this._enableInAppNotifications;
    }

    get enableEmailNotifications() {
        return this._enableEmailNotifications;
    }

    get questionnaireExpirationNotification() {
        return this._questionnaireExpirationNotification;
    }
}
