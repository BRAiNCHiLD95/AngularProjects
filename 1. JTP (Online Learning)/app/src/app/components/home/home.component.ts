import { Component, OnInit, Inject, HostListener } from '@angular/core';
import { TutorialsService } from 'src/app/tutorials.service';
import { DOCUMENT } from '@angular/platform-browser';
import { WINDOW } from '../../window.service';
declare var $: any;

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})

export class HomeComponent implements OnInit {
  public tutorials = [];
  errMsg;
  public dateConverter = new Date();
  constructor (private tutorialService: TutorialsService,
    @Inject(DOCUMENT) private document: Document,
    @Inject(WINDOW) private window
    ) { }

  ngOnInit() {
    this.tutorialService.getUpdates()
        .subscribe(
          data => {
            console.log(data);
            this.tutorials = data;
          },
          error => {
            console.error(error);
            this.errMsg = error;
          }
        );
  }

  // To fire on scroll things
  @HostListener('window:scroll', [])
  onWindowScroll() {
    const offset = this.window.pageYOffset || this.document.documentElement.scrollTop || this.document.body.scrollTop || 0;
    const limit = Math.max(
      document.body.scrollHeight, document.body.offsetHeight,
      document.documentElement.clientHeight, document.documentElement.scrollHeight,
      document.documentElement.offsetHeight) - window.innerHeight;
    if ( offset > 50) {
      // console.log(offset);
      $('#logo_nav').hide('fast', 'swing');
    } else if ( offset < 50 ) {
      $('#logo_nav').show(10, 'swing');
    }
  }
}
