export class QuestionResponse {
    private readonly _id: number;
    private readonly _questionId: number;

    public constructor(id, questionId) {
        this._id = id;
        this._questionId = questionId;
    }

    get id() {
        return this._id
    }

    get questionId() {
        return this._questionId;
    }
}
