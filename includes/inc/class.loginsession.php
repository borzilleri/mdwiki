<?php
/**
 * $Id$
 */
class LoginSession {
  protected $auth_result = null;

  public function __construct() {
    global $action;
    if( 'logout' == $action ) {
      $this->logout();
    }
    else {
      $this->authenticate('login' == $action);
    }
  }
  
  public function authenticate($form_login = false) {
    global $config;
    $username = "";
    $password = "";
    if( $form_login && !empty($_POST['username']) ) {
      $username = $_POST['username'];
      $password = $_POST['password'];
    }
    elseif( !empty($_SESSION['username']) ) {
      $username = $_SESSION['username'];
      $password = $_SESSION['password'];
      $form_login = false;
    }
    
    if( !empty($username) ) {
      if( $username == $config['user'] ) {
        if( $password == $config['pass'] ) {
          // Successful login
          $this->auth_result = true;
          $this->login($username, $password);
        }
        else {
          // Incorrect password
          $this->auth_result = false;
        }
      }
      else {
        // Incorrect username
        $this->auth_result = false;
      }
    }
    else {
      // No Login attempt.
      $this->auth_result = null;
    }
    
    return $this->auth_result;
  }
  
  protected function login($username, $password) {
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
  }
  
  protected function logout() {
    $this->auth_result = null;
    $_SESSION = array();
    if( isset($_COOKIE[session_name()]) ) {
      setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();  
  }
  
  public function isLoggedIn() {
    return (bool)$this->auth_result;
  }
  
}
