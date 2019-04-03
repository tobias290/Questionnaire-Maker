export class Notification {
    private readonly _id: string;
    private readonly _title: string;
    private readonly _message: string;
    private readonly _isRead: boolean;
    private readonly _createdAt: string;
    
    public constructor(notification) {
        this._id = notification.id;
        this._title = notification.data.title;
        this._message = notification.data.message;
        this._isRead = notification.read_at !== null;
        this._createdAt = notification.created_at;
    }
    
    get id() {
        return this._id;
    }

    get title() {
        return this._title;
    }

    get message() {
        return this._message;
    }

    get isRead() {
        return this._isRead;
    }

    get createdAt() {
        return this._createdAt;
    }
}
