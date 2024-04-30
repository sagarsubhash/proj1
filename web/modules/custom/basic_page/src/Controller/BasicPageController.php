<?php
namespace Drupal\basic_page\Controller;

use Drupal\Core\Controller\ControllerBase;

class BasicPageController extends ControllerBase {
  public function basicPage() {
    return [
      '#markup' => '
        <h1>About Us</h1>
        <p>We are a team of passionate individuals dedicated to providing the best service possible.</p>
        <h2>Our Mission</h2>
        <p>Our mission is to make the world a better place through our services.</p>
        <h2>Our Team</h2>
        <p>Our team consists of professionals from various fields, all working together to achieve our mission.</p>
      ',
    ];
  }
}





