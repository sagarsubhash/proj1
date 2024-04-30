<?php
namespace Drupal\about_us\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class AboutUsController extends ControllerBase {
  public function aboutUs() {
    return [
      '#markup' => '
       
        <p> This is the book review project. In this we can see the various books of different categories and we 
        
            can see the summary , author name , book ratings and various things of the books. In this it contain 

            home menu ,about us , recommendation page and two taxonomy which are book types and book releases. 

            The book types taxonomy contains various books genre like thriller, romance, horror, fiction , classics 

            etc. and new releases contains newly publish books and upcoming books. The viewers can see various types 

            of books which they like can read the summary and check the ratings of the books.

        
            Here the authenticated users can add comment to the books which will be display to the admin part . Here 

            we have created a workflow by which we permissions to the authenticated users, content editor . And we can 

            recommend any books if want to by the recommendation part . We have created that with the help of webform by

            which the user can his or her name , email address then can add book name and book author name to recommend a book . </p>

            
        <h2>Our Mission</h2>
        <p>Our mission is to make a book review platform where we see can different types of books which we like 
           and we can give our reviews on that according to the other user can see the book and can read them
           by the good review or bad review of the others.</p>
      
      ',
    ];
  }
}