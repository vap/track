<?php

include_once('mysql.inc');

include_once('utils.inc');



function normalize_newlines($str) {

  $order   = array('\r\n', '\n', '\r');

  $replace = "\r\n";

  $note = trim($str);

  return str_replace($order, $replace, "$note");

}



function mk_email($user) {

  return $user['name']. ' <'.$user['email_id'].'>';

}



function mk_header($user) {

  $email = mk_email($user);

  return "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/".phpversion();

  // 'From: Vijay Patil <vijay.patil@stercksystems.com>' . "\r\n";

}



function send_mail($r) {

  $message = wordwrap(normalize_newlines($r['notes']), 70);

  $dt_user = find_user_by_id($r['detected_by_id']);

  $as_user = find_user_by_id($r['assigned_to_id']);

  $headers = mk_header($dt_user[0]);

  return mail(mk_email($as_user[0]) . ', '. mk_email($dt_user[0]),

              'Tracker: '.$r['title'],

              $message,

              $headers);

}



function store_rec() {

  $r = array();

  $id = mysql_real_escape_string(param('id'));

  $r['id'] = (int) $id;

  $r['title'] = mysql_real_escape_string(param('title'));

  $r['notes'] = mysql_real_escape_string(param('notes'));

  $r['category_id'] = mysql_real_escape_string(param('category_id'));

  $r['severity_id'] = mysql_real_escape_string(param('severity_id'));

  $r['status_id'] = mysql_real_escape_string(param('status_id'));

  $r['detected_by_id'] = mysql_real_escape_string(param('detected_by_id'));

  $r['assigned_to_id'] = mysql_real_escape_string(param('assigned_to_id'));

  $r['component_id'] = mysql_real_escape_string(param('component_id'));

  $r['prime_track_id'] = mysql_real_escape_string(param('prime_track_id'));

  $r['resolution_id'] = mysql_real_escape_string(param('resolution_id'));

  $r['planned_close_date'] = mysql_real_escape_string(param('planned_close_date'));

  if ($r['title'] == '') {

      echo('The title cannot be blank.');

      return;

  }

  send_mail($r);

  return store_focus($r);

}



$op = param('op');

if (($op == 'store') || ($op == 'del')) {

  $link = connect();

  if ($op == 'store') {

    store_rec();

  } else {

    do_del('tasklist', param('id'));

  }

  disconnect($link);

  header('Location: focus.php');

}

?>

<?php

include_once('head.inc');



function render_table() {

  echo('<div class="focus-grid"><p><button id="newcat"> New Defect / Issue </button></p>');

  $cats = list_tasks_accessible_by_given_user($_SESSION['user']['id']);

  if (count($cats) == 0) {

    echo('Either there are no defects/issues/ defined yet or there are no issues in your mapped tracks for your user id. ['.$_SESSION['user']['name'].'].');

  } else {

    $hs = array('#', 'Title', 'Category', 'Status', 'Track', 'Component','Severity',

                'Resolution','Assigned to', 'Planned<br/>close<br/>date');

    echo('<table id="focus-table" border="1">' . mkrow(mkhcols($hs)));

    for($c = 0, $n = count($cats); $c < $n; $c++) {

      $cat = $cats[$c];

      $del = '<a class="xdel" rel="' . $cat['id'] . '" href="#" title="Click to delete this item">' . $cat['id'] . '</a>';

      $title = '<a style="font-weight:bold" href="' . $_SERVER['PHP_SELF'] . '?op=edit&id=' . $cat['id'] . '" title="Click to edit this defect / issue details.">' . $cat['title'] . '</a>';

      $cols = array($del, $title, $cat['catname'], $cat['statname'], $cat['ptname'], $cat['compname'], $cat['sevname'], $cat['resoname'], $cat['asname'],$cat['planned_close_date']);

      echo(mkrow(mkcols($cols)));

    }

    echo('</table></div>');

  }

}



function mk_user_select($name, $users, $curval) {

  $s = '<select id="' . $name . '" name="' . $name . '" title="Inactive users are have an asterisk against their names.">

  <option value="0">-- Select --</option>';

    foreach ($users as $user) {

      $val = $user['id'];

      $name = $user['name'];

      $display_name = ($user['active'] == 0) ? ($name . ' (*)') : $name;

      $s .= '<option value="' . $val . '" ';

      if ($val == $curval) {

        $s .= ' selected ';

      }

      $s .= '>' . $display_name  . '</option>';

    }

    $s .= '</select>';

    return $s;

}



function render_form($rec) {

  $id = $rec['id'];

  $cats = list_categories();

  $sevs = list_severities();

  $stats =  list_statuses();

  $users = list_users(); // list_of_active_users();

  $comps = list_components();

  $pts = list_accessible_primetracks($_SESSION['user']['id']);

  $resos = list_resolutions();

  $notes_help = "Issue description. When this edit box is clicked, today's date followed by your email id is set as the first line of the text area, please put your comments after this date, so that we can maintain the set of changes that occured to it.";

  echo('<div class="ht1em"></div>

<form method="post" action="' . $_SERVER['PHP_SELF'] .'">

<fieldset class="rounded box" style="padding:1em 2em; margin: 4px auto; width:500px; border:1px solid sandybrown">

<legend>&nbsp; ' . (($id <= 0) ? 'New' : 'Edit') . ' Defect / Issue &nbsp;</legend>

<table cellpadding="4">

  <tr>

    <td class="ralign"><label for="title">Title</label></td>

    <td><input id="title" name="title" type="text" size="40" maxlength="40" value="' . $rec['title'] . '" placeholder="Short description (upto 40 chars max)." title="Short description (40 chars max)."/></td>

  </tr>

  <tr>

    <td class="ralign"><label for="notes">Notes</label></td>

    <td><textarea id="notes" name="notes" rows="5" cols="40" title="'.$notes_help.'" placeholder="Detailed description of the defect / issue.">'.$rec['notes'].'</textarea></td>

  </tr>

  <tr>

    <td class="ralign"><label for="category_id">Category</label></td>

    <td>'. mkselect("category_id", $cats, $rec['category_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="severity_id">Severity</label></td>

    <td>'. mkselect("severity_id", $sevs, $rec['severity_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="status_id">Status</label></td>

    <td>'. mkselect("status_id", $stats, $rec['status_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="resolution_id">Resolution</label></td>

    <td>'. mkselect("resolution_id", $resos, $rec['resolution_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="prime_track_id">Primary Track</label></td>

    <td>'. mkselect("prime_track_id", $pts, $rec['prime_track_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="component_id">Component</label></td>

    <td>'. mkselect("component_id", $comps, $rec['component_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="detected_by_id">Detected by</label></td>

    <td>'. mk_user_select("detected_by_id", $users, $rec['detected_by_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="assigned_to_id">Assigned to</label></td>

    <td>'. mk_user_select("assigned_to_id", $users, $rec['assigned_to_id']) .'</td>

  </tr>

  <tr>

    <td class="ralign"><label for="planned_close_date">Planned close date</label></td>

    <td><input id="planned_close_date" name="planned_close_date" type="text" value="'.$rec['planned_close_date'].'" placeholder="YYYY-MM-DD" title="YYYY-MM-DD"/></td>

  </tr>

  <tr>

    <td></td>

    <td><input id="submit" type="submit" value=" OK "/>

        <input id="cancel" type="button" value=" Cancel "/></td>

  </tr>

</table>

</fieldset>

<input type="hidden" name="op" value="store"/>

<input type="hidden" name="id" value="'.$id.'"/>

<input type="hidden" id="emid" name="emid" value="'.$_SESSION['user']['email_id'].'"/>

</form>

<script type="text/javascript">

var active_users = '.json_encode(list_of_active_users()).'

</script>

<div id="info"></div>

');

}



function date_and_user() {

  return '": ' . (@date('c') . " - " . $_SESSION['user']['email_id']) .'"';

}



function new_cat() {

  $r = array();

  $r['id'] = 0;

  $r['title'] = '';

  $r['notes'] = ''; // mark_date_and_user_in_notes('');

  $r['category_id'] = '0';

  $r['severity_id'] = '0';

  $r['status_id'] = '0';

  $r['detected_by_id'] = '0';

  $r['assigned_to_id'] = '0';

  $r['component_id'] = '0';

  $r['resolution_id'] = '0';

  $r['prime_track_id'] = '0';

  $r['planned_close_date'] = @date('Y-m-d');  // There is a warning about unset setlocale. Suppressed - for now.

  render_form($r);

}



function edit_cat() {

  $r = find_focus(param('id'));

  if (count($r) > 0) {

    // $r[0]['notes'] = mark_date_and_user_in_notes($r[0]['notes']);

    render_form($r[0]);

  } else {

    echo('<br/>Unknown issue / defect reference.<br/>');

    render_table();

  }

}



function show_debug_msg() {

  echo(param('m'));

}



function focus() {

  $op = param('op');

  switch ($op) {

    case 'new'    : new_cat(); break;

    case 'edit'   : edit_cat(); break;

    case 'debug'  : show_debug_msg(); break;

    /*

    case 'store'  : store_cat();

                    header('Location: focus.php');

                    break;

    */

    case ''       : render_table(); break;

    default       : render_table(); break;

  }

  echo(

'<script type="text/javascript">

var NOTES = {

  saved: 0,

  date_user: '.date_and_user().',

  note: ""

};

</script>

');

}



function play() {

  $link = connect();

  render_menu('focus');

  focus();

  disconnect($link);

}



play();

?>

<script type="text/javascript">

$(function() {

  $('#title').focus();

  $("#focus-table tr:nth-child(even)").addClass("odd");

  $('.xdel').click(function() {

      var id = $(this).attr('rel');

      if (confirm('Are you sure you wish to delete this defect / issue entry?')) {

         document.location.replace("focus.php?op=del&id=" + id);

         return true;

      }

      return false;

    });

  $('#detected_by_id').change(function() {

      var uid = $(this).val();

      if (inactive_user(uid)) {

        alert('This user is not active. You may not assign her/him to this defect/issue.');

        return false;

      }

    });

  $('#assigned_to_id').change(function() {

      var uid = $(this).val();

      if (inactive_user(uid)) {

        alert('This user is not active. You may not assign her/him to this defect/issue.');

        return false;

      }

    });

  $('#newcat').click(function () {

      document.location.replace('focus.php?op=new');

    });

  $('#cancel').click(function () {

      document.location.replace('focus.php');

    });

  $('.focus-grid').css('width', ($('#focus-table').css('width')));

  $('#notes').focusin(function() {

      if ( ! NOTES.saved) {

        NOTES.saved = 1;

        NOTES.note = $(this).val();

      }

    });

  $('#submit').click(function() {

      var fld = $.trim($('#title').val());

      if (fld.length == 0) {

        $('#title').focus();

        alert('The title / short description of the defect / issue is required.');

        return false;

      }

      fld = $.trim($('#planned_close_date').val());

      if (fld.length == 0) {

        $('#planned_close_date').focus();

        alert('Planned close date is required. Specify it in YYYY-MM-DD format.');

        return false;

      }

      var as = ['category_id', 'severity_id','status_id' ,'resolution_id', 'prime_track_id', 'component_id', 'detected_by_id', 'assigned_to_id'];

      var ns = ['Category', 'Severity','Status', 'Resolution', 'Primary track name', 'Component','Detected by user','Assigned to user'];

      if ( ! check_selections(as,ns)) {

        return false;

      }



      var uid = $("#detected_by_id option:selected").val();

      if (inactive_user(uid)) {

        alert('The Detected By user is not active. Please select a currently active user.');

        $("#detected_by_id").focus();

        return false;

      }



      uid = $("#assigned_to_id option:selected").val();

      if (inactive_user(uid)) {

        alert('The "Assigned To" user is not active. Please select a currently active user.');

        $("#assigned_to_id").focus();

        return false;

      }



      if (NOTES.saved == 1) {

        var curnote = $.trim($('#notes').val());

        if (curnote != NOTES.note && curnote[0] != ':') {

          $('#notes').val(NOTES.date_user + "\r\n\r\n" + curnote);

        }

      }



      return true;

    });

});



function check_selections(as, ns) {

  var res = true;

  $.each(as, function(i, a) {

    if ($('#'+ a + " option:selected'").val() == 0) {

      $('#'+a).focus();

      alert(ns[i] + ' is required.');

      res = false;

      return false;

    }

  });

  return res;

}



function inactive_user(uid) {

  var nf = true; // not found!

  $.each(active_users, function(i, user) {

      if (user.id == uid) {

        nf = false;

      }

    });

  return nf;

}

</script>

</body>

</html>

