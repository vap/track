<?php
include_once('head.inc');
include_once('utils.inc');

do_login(params('e'));

function do_login($warnMsg) {
  if (isset($_SESSION['user'])) {
    echo('You may <a href="logout.php"> Logout </a> or go to the <a href="focus.php"> Focus page </a>.');
    exit;
  }
  echo('<div class="ht6em"></div>
<form method="post" action="check.php">
<fieldset class="rounded box" style="padding:1em; margin: 4px auto; width:400px; border:1px solid sandybrown">
<legend>&nbsp;Sign in&nbsp;</legend>
<table cellpadding="4">
  <tr>
    <td class="ralign"><label for="name">Email id</label></td>
    <td><input id="name" name="name" type="text" size="40" value="" placeholder="Your email id." title="Your email id."/></td>
  </tr>
  <tr>
    <td><label for="pwd">Password</label></td>
    <td><input id="pwd" name="pwd" type="password" size="40" value="" placeholder="Must be at least 3 characters." title="Must be at least 3 characters."/></td>
  </tr>
  <tr>
    <td></td>
    <td><input id="submit" type="submit" value=" Login "/></td>
  </tr>
</table>
</fieldset>
</form>
');
  if ($warnMsg != '') {
    echo('<div class="warn rounded">' . $warnMsg . '</div>');
  }
}
?>
<script type="text/javascript">
$(function() {
  $('#name').focus();
  $('#submit').click(function() {
    var f = $.trim($('#name').val());
    if (f.length == 0) {
      $('#name').focus();
      alert('Email id is required.');
      return false;
    }
    f = $.trim($('#pwd').val());
    if (f.length == 0) {
      $('#pwd').focus();
      alert('Password is required.');
      return false;
    }
    if (f.length < 3) {
      $('#pwd').focus();
      alert('The password length must be at least 3 characters.');
      return false;
    }
    return true;
  });
});
</script>
</body>
</html>