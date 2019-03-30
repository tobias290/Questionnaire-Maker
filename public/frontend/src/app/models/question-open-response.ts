import {QuestionResponse} from "./question-response";

export class QuestionOpenResponse extends QuestionResponse {
    private readonly _response: string;

    public constructor(response) {
       super(response.id, response.question_scaled_id);
        this._response = response.response;
    }
    get response() {
        return this._response
    }
}
