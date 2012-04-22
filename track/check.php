<?php

// include_once('head.inc');

include_once('mysql.inc');

include_once('utils.inc');



function check_credentials() {

  $user = param('name');

  $pwd = param('pwd');

  $user_recs = array();

  if (!empty($user) && !empty($pwd)) {

    $user_recs = find_user_pwd($user, $pwd);

    if (count($user_recs) == 0) {

      header('Location: login.php?e=' . urlencode('Authorization unsuccessful. Retry.'));

    } elseif ($user_recs[0]['active'] == 0) {

      header('Location: login.php?e=' . urlencode('User: '.$user_recs[0]['name'].' is disabled.'));

    } else {

      @session_start();

      @session_regenerate_id();

      $username = $user_recs[0]['name'];

      $_SESSION['user'] = $user_recs[0];

      unset($user_recs);

      @header('Location: track.php');

    }

  } else {

    @header('Location: login.php?e=' . urlencode('Email id and password are required.'));

  }

}



function play() {

  $link = connect();

  check_credentials();

  disconnect($link);

}



play();



?>

</body>

</html>