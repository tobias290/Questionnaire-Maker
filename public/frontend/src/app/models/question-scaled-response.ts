import {QuestionResponse} from "./question-response";

export class QuestionScaledResponse extends  QuestionResponse {
    private readonly _response: number;
    
    public constructor(response) {
        super(response.id, response.question_scaled_id);
        this._response = response.response;
    }
    
    get response() {
        return this._response
    }
}
