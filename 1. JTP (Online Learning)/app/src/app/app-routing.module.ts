import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { Error404Component } from './components/error404/error404.component';
import { HomeComponent } from './components/home/home.component';
import { CourseComponent } from './components/course/course.component';
import { ContentComponent } from './components/content/content.component';
import { ContactusComponent } from './components/contactus/contactus.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'course/:sid', component: CourseComponent, children: [
    { path: 'content/:cid', component: ContentComponent},
    { path: '**', component: Error404Component }
  ]},
  { path: 'contactus', component: ContactusComponent},
  { path: '**', component: Error404Component }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
