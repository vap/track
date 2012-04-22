<?php

include_once('mysql.inc');

include_once('utils.inc');



function store_rec() {

  $rec = array();

  $id = mysql_real_escape_string(param('id'));

  $rec['id'] = (int) $id;

  $rec['name'] = trim(mysql_real_escape_string(param('name')));

  $rec['email_id'] = trim(mysql_real_escape_string(param('email_id')));

  $rec['role'] = trim(mysql_real_escape_string(param('role')));

  $rec['active'] = trim(mysql_real_escape_string(param('active')));

  $rec['password'] = trim(mysql_real_escape_string(param('password')));

  if ($rec['name'] == '') {

      echo('The name cannot be blank.');

      return;

  }

  return store_user($rec);

}



$op = param('op');

$id = param('id');

if (($op == 'store') || ($op == 'del') || ($op == 'candel')) {

  $link = connect();

  if ($op == 'store') {

    store_rec();

  } elseif ($op == 'del') {

    do_del('users', $id);

  } else {

    $res = is_deletable_js('users', $id);

    disconnect($link);

    echo($res);

    return;

  }

  disconnect($link);

  header('Location: user.php');

}

?>

<?php

include_once('head.inc');



function active($active) {

  return (isset($active) && ($active == 1)) ? "live" : "unlive";

}



function render_table() {

  echo('<p><button id="newcat"> New User </button></p>');

  $cats = list_users_all_cols();

  if (count($cats) == 0) {

    echo('No users defined yet.');

  } else {

    $hs = array('#', 'Name', 'Email id', 'Role');

    echo('<table id="data-grid" border="1">' . mkrow(mkhcols($hs)));

    for($c = 0, $n = count($cats); $c < $n; $c++) {

      $cat = $cats[$c];

      $del = '<a class="xdel" rel="' . $cat['id'] . '" href="#" title="Click to delete this item">' . ($c+1) . '</a>';

      $name = '<a style="color:inherit" href="' . $_SERVER['PHP_SELF'] . '?op=edit&id=' . $cat['id'] . '">' . $cat['name'] . '</a>';

      $class = active($cat['active']);

      $cols = array($del, ($name . '==>>' . $class), $cat['email_id'], $cat['role']);

      echo(mkrow(mkcols($cols)));

    }

    echo('</table>');

  }

}



function render_form($rec) {

  $id = $rec['id'];

  $roles = array('Engineer', 'Client', 'Admin');

  echo('<div class="ht6em"></div>

<form method="post" action="' . $_SERVER['PHP_SELF'] .'">

<fieldset class="rounded box" style="padding:1em; margin: 4px auto; width:420px; border:1px solid sandybrown">

<legend>&nbsp; ' . (($id <= 0) ? 'New' : 'Edit') . ' User &nbsp;</legend>

<table cellpadding="4">

  <tr>

    <td class="ralign"><label for="name">Name</label></td>

    <td><input id="name" name="name" type="text" size="40" maxlength="40" value="'.$rec['name'].'" placeholder="User name." title="User name."/></td>

  </tr>

  <tr>

    <td><label for="email_id">Email ID</label></td>

    <td><input id="email_id" name="email_id" type="text" size="40" value="'.$rec['email_id'].'" placeholder="Email ID." title="Email ID."/></td>

  </tr>

  <tr>

    <td class="ralign"><label for="pwd">Password</label></td>

    <td><input id="password" name="password" type="text" size="40" value="" placeholder="User\'s password." title="User\'s password, is to this value if defined." autocomplete="off"/></td>

  </tr>

  <tr>

    <td class="ralign"><label for="active">Active?</label></td>

    <td><input id="active" name="active" type="checkbox" value="1" title="Can this user access this application?"

    ' .  (($rec['active'] == 1) ? "checked" : "") . '/></td>

  </tr>

  <tr>

    <td class="ralign"><label for="role">Role</label></td>

    <td><select id="role" name="role">');

        foreach ($roles as $role) {

          $cur_role = strtolower($role);

          echo('<option value="' . $cur_role . '" ');

          if ($cur_role == $rec['role']) {

            echo(' selected ');

          }

          echo('>' .$role  . '</option>');

        }

    echo('</select>

    </td>

  </tr>

  <tr>

    <td></td>

    <td><input id="submit" type="submit" value=" OK "/>

        <input id="cancel" type="button" value=" Cancel "/></td>

  </tr>

</table>

</fieldset>

<input type="hidden" id="editop" value="'.(($id <= 0) ? 'new' : 'edit').'"/>

<input type="hidden" name="op" value="store"/>

<input type="hidden" name="id" value="' . $rec['id'] . '"/>

</form>

');

}



function new_rec() {

  $r = array();

  $r['id'] = 0;

  $r['name'] = '';

  $r['email_id'] = '';

  $r['role'] = '';

  $r['password'] = '';

  $r['active'] = '1';

  render_form($r);

}



function edit_rec() {

  $r = find_user_by_id(param('id'));

  if (count($r) > 0) {

    render_form($r[0]);

  } else {

    echo('<br/>Unknown user reference.<br/>');

    render_table();

  }

}



function user() {

  $op = param('op');

  switch ($op) {

    case 'new'    : new_rec(); break;

    case 'edit'   : edit_rec(); break;

    /*

    case 'store'  : store_rec();

                    header('Location: user.php');

                    break;

    */

    case ''       : render_table(); break;

    default       : render_table(); break;

  }

}



function play() {

  $link = connect();

  render_menu('user');

  user();

  disconnect($link);

}



play();



?>

<script type="text/javascript">

$(function() {

  $('#name').focus();

  $("#data-grid tr:nth-child(even)").addClass("odd");

  $('.xdel').click(function() {

      var id = $(this).attr('rel');

      if (canBeDeleted(id)) {

        document.location.replace("user.php?op=del&id=" + id);

      }

      return false;

    });

  $('#newcat').click(function () {

      document.location.replace('user.php?op=new');

    });

  $('#cancel').click(function () {

      document.location.replace('user.php');

    });

  $('#submit').click(function() {

      var name = $.trim($('#name').val());

      if (name.length == 0) {

        $('#name').focus();

        alert('Name is required.');

        return false;

      }

      if ($('#editop').val() == 'new') {

        name = $.trim($('#password').val());

        if (name.length == 0) {

          $('#password').focus();

          alert('Password is required.');

          return false;

        }

      }

      return true;

    });

});

function canBeDeleted(id) {

  var res = false;

  $.ajax({

    type: "GET",

    url: "user.php?op=candel&id=" + id,

    dataType: "json",

    async: false,

    success: function(json) {

      var count = json[0].count;

      res = (count == 0);

      if (res) {

        res = confirm('Are you sure you wish to delete this user record ?');

      } else {

        var phrase = (count == 1) ? " is one reference " : (" are " + count + " references ");

        alert("There" + phrase + "to this value in the task list.\n\n" +

              "You cannot delete it now.");

      }

    }

  });

  return res;

}

</script>



<?php

include_once('foot.inc');

?>

