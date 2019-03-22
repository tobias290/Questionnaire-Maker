export abstract class Question {
    private readonly _id: number;
    private readonly _name: string;
    private readonly _position: number;
    private readonly _isRequired: boolean;
    private readonly _questionnaireId: number;
    
    protected constructor(question) {
        this._id = question.id;
        this._name = question.name;
        this._position = question.position;
        this._isRequired = question.is_required;
        this._questionnaireId = question.questionnaire_id;
    }

    get id() {
        return this._id;
    }

    get name() {
        return this._name;
    }

    get position() {
        return this._position;
    }

    get isRequired() {
        return this._isRequired;
    }

    get questionnaireId() {
        return this._questionnaireId;
    }
}
