<?php

/* lougout_redirect plugin */

/*
There are three modes:
#1 - Ajax login
     See example in ajax_login folder.
     Set login / logout to false.
     It will detect if you logged in
     from an outside form and the force
     the redirect to the given URL.
     Login and logout page are accessible.
     
#2 - Lock login page
     Set login to true.
     It will redirect the login page
     to the given URL in any case.
     
#3 - Lock logout page
     Set logout to true.
     It will redirect the logout page
     to the given URL in any case.
*/

/*
  f.e. http://mail4us.net/logout.php 
*/
$rcmail_config['logout_redirect_url'] = '/';
$rcmail_config['login_failed_redirect_url'] = '/?fail=1';

/* HTTP Referer
   null -> no check
   Url -> check */
$rcmail_config['logout_redirect_referer'] = null;//'http://control.roland-liebl.de/webmail';

/* lock default login page */
$rcmail_config['logout_redirect_lock_default_login'] = true;

/* lock default logout page */
$rcmail_config['logout_redirect_lock_default_logout'] = true;

?>
