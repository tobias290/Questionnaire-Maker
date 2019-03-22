import {Question} from "./question";

export class QuestionOpen extends Question {
    private readonly _isLong: boolean;
    
    public constructor(question) {
        super(question);
        
        this._isLong = question.is_long;
    }

    get isLong() {
        return this._isLong;
    }
}
