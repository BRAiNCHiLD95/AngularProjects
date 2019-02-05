import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Subtopic } from './models/Subtopic';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})

export class SubtopicsService {
  private apiUrl = 'http://localhost:80/api/fetchSubtopics.php?';
  private sid: string;

  constructor(private http: HttpClient) { }

  public setID(sid: string) {
    this.sid = sid;
  }

  getUpdates(): Observable<Subtopic[]> {
    return this.http.get<Subtopic[]>(this.apiUrl,
                                    { params: new HttpParams().set('sid', this.sid) })
                    .pipe(catchError(this.errorHandler)
    );
  }

  errorHandler(error: HttpErrorResponse) {
    return throwError(error.message || 'Server Error!');
  }
}
