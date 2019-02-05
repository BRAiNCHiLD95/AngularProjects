import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AngularFontAwesomeModule } from 'angular-font-awesome';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { HttpClientModule } from '@angular/common/http';
import { SubjectsService } from '../app/subjects.service';
import { ContentService } from '../app/content.service';
import { SubtopicsService } from '../app/subtopics.service';
import { TutorialsService } from '../app/tutorials.service';
import { Error404Component } from '../app/components/error404/error404.component';
import { HomeComponent } from './components/home/home.component';
import { CourseComponent } from './components/course/course.component';
import { GroupByPipe } from './group-by.pipe';
import { ContentComponent } from './components/content/content.component';
import { FooterComponent } from './components/footer/footer.component';
import { WINDOW_PROVIDERS } from './window.service';
import { RunScriptsDirective } from './run-scripts.directive';
import { SafeHtmlPipe } from './safe-html.pipe';
import { HighlightModule } from 'ngx-highlightjs';
import xml from 'highlight.js/lib/languages/xml';
import scss from 'highlight.js/lib/languages/scss';
import typescript from 'highlight.js/lib/languages/typescript';
import cpp from 'highlight.js/lib/languages/cpp';
import { AboutComponent } from './components/about/about.component';
import { ContactusComponent } from './components/contactus/contactus.component';


export function hljsLanguages() {
  return [
    {name: 'typescript', func: typescript},
    {name: 'scss', func: scss},
    {name: 'xml', func: xml},
    {name: 'cpp', func: cpp}
  ];
}

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    Error404Component,
    HomeComponent,
    CourseComponent,
    GroupByPipe,
    ContentComponent,
    FooterComponent,
    RunScriptsDirective,
    SafeHtmlPipe,
    AboutComponent,
    ContactusComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AngularFontAwesomeModule,
    NgbModule,
    HttpClientModule,
    HighlightModule.forRoot({
      languages: hljsLanguages
    })
  ],
  providers: [ SubjectsService, ContentService, SubtopicsService, TutorialsService, WINDOW_PROVIDERS ],
  bootstrap: [AppComponent]
})
export class AppModule { }
