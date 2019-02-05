import { Component, OnInit, Inject } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ContentService } from 'src/app/content.service';
import { DomSanitizer } from '@angular/platform-browser';
declare var $: any;
@Component({
  selector: 'app-content',
  templateUrl: './content.component.html',
  styleUrls: ['./content.component.css']
})
export class ContentComponent implements OnInit {
  public content = [];
  contentID;
  errMsg;
  constructor(public activeRoute: ActivatedRoute,
    public contentService: ContentService,
    @Inject(DomSanitizer) private _sanitize: DomSanitizer
    ) { }

  ngOnInit() {
    this.activeRoute.params.subscribe(
      params => {
        this.contentID = params['cid'];
        this.contentService.setCID(this.contentID);
        this.getData(); 
      }
    );
  }

  public getData() {
    this.contentService.getContent()
        .subscribe(
          data => this.content = data,
          error => console.log(error),
        );
  }
}
