import {Question} from "./question";

export class QuestionScaled extends Question {
    private readonly _min: number;
    private readonly _max: number;
    private readonly _interval: number;
    private readonly _type: string;
    
    public constructor(question) {
        super(question);
        
        this._min = question.min;
        this._max = question.max;
        this._interval = question.interval;
        this._type = question.type;
    }
    
    get min() {
        return this._min;
    }

    get max() {
        return this._max;
    }

    get interval() {
        return this._interval;
    }

    get type() {
        return this._type;
    }
}
