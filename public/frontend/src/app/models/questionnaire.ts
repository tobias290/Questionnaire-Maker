export class Questionnaire {
    private readonly _id: number;
    private readonly _title: string;
    private readonly _description: string;
    private readonly _isPublic: boolean;
    private readonly _isComplete: boolean;
    private readonly _isReported: boolean;
    private readonly _isLocked: boolean;
    private readonly _responses: number;
    private readonly _expiryDate: string;
    private readonly _createdAt: string;
    private readonly _updatedAt: string;
    private readonly _userId: number;
    private readonly _categoryId: number;
    
    public constructor(questionnaire) {
        this._id = questionnaire.id;
        this._title = questionnaire.title;
        this._description = questionnaire.description;
        this._isPublic = questionnaire.is_public;
        this._isComplete = questionnaire.is_complete;
        this._isReported = questionnaire.is_reported;
        this._isLocked = questionnaire.is_locked;
        this._responses = questionnaire.responses;
        this._expiryDate = questionnaire.expiry_date;
        this._createdAt = questionnaire.created_at;
        this._updatedAt = questionnaire.updated_at;
        this._userId = questionnaire.user_id;
        this._categoryId = questionnaire.questionnaire_category_id;
    }
    
    get id() {
        return this._id;
    }
    
    get title() {
        return this._title;
    }

    get description() {
        return this._description;
    }

    get isPublic() {
        return this._isPublic;
    }

    get isComplete() {
        return this._isComplete;
    }

    get isReported() {
        return this._isReported;
    }
    
    get isLocked() {
        return this._isLocked;
    }
    
    get responses() {
        return this._responses;
    }
    
    get expiryDate() {
        return this._expiryDate;
    }
    
    get createdAt() {
        return this._createdAt;
    }
    
    get updatedAt() {
        return this._updatedAt;
    }

    get userId() {
        return this._userId;
    }
    
    get categoryId() {
        return this._categoryId;
    }
}
