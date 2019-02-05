import { Component, OnInit } from '@angular/core';
import { SubjectsService } from 'src/app/subjects.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  public isCollapsed = false;
  public subjects = [];
  public errMsg;
  constructor(private subjectService: SubjectsService) { }

  ngOnInit() {
    this.subjectService.getSubjects()
        .subscribe(
          data => {
            console.log(data);
            this.subjects = data;
          },
          error => {
            console.error(error);
            this.errMsg = error;
          }
        );
  }

  toggleNavbar() {
    this.isCollapsed = !this.isCollapsed;
  }
}
