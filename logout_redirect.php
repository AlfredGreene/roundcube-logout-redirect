<?php
/**
 * Redirect on logout / optionally lock login page
 *
 * @version 1.3 - 15.02.2011
 * @author Roland 'rosali' Liebl
 * @website http://myroundcube.googlecode.com
 * @licence GNU GPL
 *
 **/
 
/**
 *
 * Usage: http://mail4us.net/myroundcube/
 *
 **/ 
 
class logout_redirect extends rcube_plugin
{
  public $task = 'login|logout';
  
  function init()
  {
    if(file_exists("./plugins/logout_redirect/config/config.inc.php"))
      $this->load_config('config/config.inc.php');
    else
      $this->load_config('config/config.inc.php.dist');         
    
    $this->add_hook('authenticate', array($this, 'authenticate'));
    $this->add_hook('render_page', array($this, 'login_page'));
    $this->add_hook('login_after', array($this,'login_after'));
    $this->add_hook('login_failed', array($this,'login_failed'));
    $this->add_hook('logout_after', array($this,'logout_after'));
  }
  
  function goto_url($v) 
  { 
    $rcmail = rcmail::get_instance(); 
    setcookie ('ajax_login','',time()-3600);
    $url = $rcmail->config->get('logout_redirect_url');
    $con = '?';
    if(strpos($url, '?'))
      $con = '&';
    $rcmail->output->add_script('top.location.href="' . $url . $con . 'message=' . urlencode($v) . '";');
    $rcmail->output->send('plugin'); 
    exit; 
  }
  
  function authenticate($args)
  {
    if(!empty($_POST['ajax']) && !empty($_POST['_user']) && !empty($_POST['_pass'])){
      $rcmail = rcmail::get_instance();
      if(
        $rcmail->config->get('logout_redirect_referer', false) &&
        stristr($_SERVER['HTTP_REFERER'],$rcmail->config->get('logout_redirect_referer'))
      ){
        $args['valid'] = true;
      }
      else{
        $args['valid'] = true;
      }
    }
    return $args;
  }
     
  // ajax cookie 
  function login_after($args)  
  {  
    if(!empty($_POST['ajax']))  
      setcookie ('ajax_login',1,time()+60*60*24*365);  
    else  
      setcookie ('ajax_login','',time()-3600);  
    return $args;  
  }

  // login failed
  function login_failed($args)
  { 
    if(!empty($_POST['ajax'])){
      rcmail::get_instance()->config->set('logout_redirect_url', rcmail::get_instance()->config->get('login_failed_redirect_url'));
      $this->goto_url(rcube_label('loginfailed'));
      exit;
    }
    if(rcmail::get_instance()->config->get('logout_redirect_lock_default_login'))
      $this->goto_url(rcube_label('loginfailed'));
    return $args;  
  }  
     
  // user logout 
  function logout_after($args)  
  {        
    if($_COOKIE['ajax_login'] == 1 || rcmail::get_instance()->config->get('logout_redirect_lock_default_logout')) 
      $this->goto_url(rcube_label('loggedout')); 
    return $args; 
  } 
     
  // auto logout (session error) 
  function login_page($p)  
  {
    if(($_COOKIE['ajax_login'] == 1 || rcmail::get_instance()->config->get('logout_redirect_lock_default_login'))&& $p['template'] == 'login') 
      $this->goto_url(rcube_label('sessionerror')); 
    return $p; 
  }  
}
?>
