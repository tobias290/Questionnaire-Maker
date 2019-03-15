import { Injectable } from "@angular/core";
import {HttpClient, HttpErrorResponse, HttpHeaders} from "@angular/common/http";
import {catchError} from "rxjs/operators";
import {throwError} from "rxjs";

@Injectable()
export class ApiService {
    public constructor(private http: HttpClient) { }
    
    /**
     * Handles any errors returned by API.
     * 
     * @param error
     */
    private static handleError(error: HttpErrorResponse) {
        if (error.error instanceof ErrorEvent) {
            // A client-side or network error occurred. Handle it accordingly.
            console.error("A client error occurred:", error.error.message);
        } else {
            // The backend returned an unsuccessful response code.
            // The response body may contain clues as to what went wrong,
            console.error(`HTTP response ${error.status}, ` + `body was: ${JSON.stringify(error.error)}`);
        }
        // Return an observable with a user-facing error message
        return throwError(error.error);
    };

    /**
     * Add basic headers to each request.
     *
     * @param {object} options - User defines headers.
     */
    private static getHeaders(options) {
        return {
            headers: new HttpHeaders({
                "Accept": "application/json",
                "Content-Type":  "application/json",
                ...options,
            })
        };
    }
    
    public static createTokenHeader(token) {
        return {"Authorization": `Bearer ${token}`};
    }
    
    public get(url, options = {}) {
        return this.http.get(url, ApiService.getHeaders(options));
    }

    public post(url, data, options = {}) {
        return this.http
            .post(url, data, ApiService.getHeaders(options))
            .pipe(catchError(ApiService.handleError));
    }

    public put() {
        
    }

    public delete() {
        
    }
}
