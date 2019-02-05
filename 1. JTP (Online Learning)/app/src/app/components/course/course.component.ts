import { Component, OnInit, Inject, HostListener } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { SubtopicsService } from 'src/app/subtopics.service';
import { Location } from '@angular/common';
import { DOCUMENT } from '@angular/platform-browser';
import { WINDOW } from '../../window.service';
declare var $: any;

@Component({
  selector: 'app-course',
  templateUrl: './course.component.html',
  styleUrls: ['./course.component.css']
})

export class CourseComponent implements OnInit {
  public subtopics = [];
  subjectID;
  firstData;
  isMobile = false;
  constructor(public activeRoute: ActivatedRoute,
    public router: Router,
    public subtopicsService: SubtopicsService,
    public location: Location,
    @Inject(DOCUMENT) private document: Document,
    @Inject(WINDOW) private window,
    ) { }

  ngOnInit() {
    this.activeRoute.params.subscribe(
      params => {
        this.subjectID = params['sid'];
        this.subtopicsService.setID(this.subjectID);
        this.getData();
      }
    );
    // this.subjectID = this.activeRoute.snapshot.params.sid as string;
  }

  public getData() {
    this.subtopicsService.getUpdates()
        .subscribe(
          data => this.subtopics = data,
          error => console.error(error),
          () => {
            this.firstData = this.subtopics[0].content_id;
            this.pageRedirect();
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
    if ( offset > 50 && offset < (limit - 70)) {
      console.log(offset);
      $('.openBtn span').fadeOut();
      $('#course-aside').css( { 'top': '47px', 'bottom': '0px' });
      $('#logo_nav').hide('fast', 'swing');
    } else if ( offset < 50 ) {
      $('.openBtn span').fadeIn();
      $('#logo_nav').show('fast', 'swing');
      $('#course-aside').css( { 'top': '112px', 'bottom': '0px' });
    } else if ( offset > (limit - 70) ) {
      $('#course-aside').css('bottom', '55px');
    } else {
      $('#course-aside').css('bottom', '0px');
    }
  }
  openNav() {
    if ($('aside#course-aside').css('max-width') === '75%') {
      this.isMobile = true;
    } else {
      this.isMobile = false;
    }
    if (this.isMobile === true) {
      document.getElementById('course-aside').style.width = '75%';
    } else {
      document.getElementById('course-aside').style.width = '25%';
      document.getElementById('course-main').style.marginLeft = '25%';
    }
  }

  pageRedirect() {
    if (!(this.router.url).includes('/content/')) {
      this.router.navigate(['content', this.firstData], { relativeTo: this.activeRoute });
    }
  }

  closeNav() {
    if ($('aside#course-aside').css('max-width') === '25%') {
        document.getElementById('course-aside').style.width = '0%';
        document.getElementById('course-main').style.marginLeft = '0%';
    } else {
      document.getElementById('course-aside').style.width = '0%';
      document.getElementById('course-main').style.marginLeft = '0%';
    }
  }
}
