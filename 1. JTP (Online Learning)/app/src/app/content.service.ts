import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Content } from './models/Content';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ContentService {
  private apiUrl = 'http://localhost:80/api/fetchSingle.php';
  private cid: string;

  constructor(private http: HttpClient) { }

  public setCID(cid: string) {
    this.cid = cid;
  }

  getContent(): Observable<Content[]> {
    return this.http.get<Content[]>(this.apiUrl,
                         { params: new HttpParams().set('cid', this.cid) })
                    .pipe(catchError(this.errorHandler));
  }

  errorHandler(error: HttpErrorResponse) {
    return throwError(error.message || 'Server Error! ');
  }
}
