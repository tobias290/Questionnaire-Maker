export class QuestionClosedOption {
    private readonly _id: number;
    private readonly _option: number;
    private readonly _questionClosedId: number;
    
    public constructor(questionClosedOption) {
        this._id = questionClosedOption.id;
        this._option = questionClosedOption.option;
        this._questionClosedId = questionClosedOption.question_closed_id;
    }

    get id() {
        return this._id;
    }
    
    get option() {
        return this._option;
    }

    get questionClosedId() {
        return this._questionClosedId;
    }
}
