import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Tutorials } from './models/Tutorials';
import { Observable, throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})

export class TutorialsService {
  private apiUrl = 'http://localhost:80/api/fetchTutorials.php';

  constructor(private http: HttpClient) { }

  getUpdates(): Observable<Tutorials[]> {
    return this.http.get<Tutorials[]>(this.apiUrl).pipe(
      catchError(this.errorHandler)
    );
  }

  errorHandler(error: HttpErrorResponse) {
    return throwError(error.message || 'Server Error!');
  }
}
