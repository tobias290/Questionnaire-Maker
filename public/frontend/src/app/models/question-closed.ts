import {Question} from "./question";

export class QuestionClosed extends Question {
    private readonly _type: string;
    
    public constructor(question) {
        super(question);
        
        this._type = question.type;
    }
    
    get type() {
        return this._type;
    }
}
