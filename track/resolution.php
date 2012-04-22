<?php

include_once('mysql.inc');

include_once('utils.inc');



function store_rec() {

  $rec = array();

  $id = mysql_real_escape_string(param('id'));

  $rec['id'] = (int) $id;

  $rec['name'] = mysql_real_escape_string(param('name'));

  $rec['notes'] = mysql_real_escape_string(param('notes'));

  if ($rec['name'] == '') {

      echo('The name cannot be blank.');

      return;

  }

  return store_resolution($rec);

}



$op = param('op');

$id = param('id');

if (($op == 'store') || ($op == 'del') || ($op == 'candel')) {

  $link = connect();

  if ($op == 'store') {

    store_rec();

  } elseif ($op == 'del') {

    do_del('resolution', $id);

  } else {

    $res = is_deletable_js('resolution', $id);

    disconnect($link);

    echo($res);

    return;

  }

  disconnect($link);

  header('Location: resolution.php');

}

?>

<?php

include_once('head.inc');



function render_table() {

  echo('<p><button id="newcat"> New Resolution </button></p>');

  $cats = list_resolutions();

  if (count($cats) == 0) {

    echo('No resolutions defined yet.');

  } else {

    $hs = array('#', 'Resolution', 'Notes');

    echo('<table id="data-grid" border="1">' . mkrow(mkhcols($hs)));

    for($c = 0, $n = count($cats); $c < $n; $c++) {

      $cat = $cats[$c];

      $del = '<a class="xdel" rel="' . $cat['id'] . '" href="#" title="Click to delete this item">' . ($c+1) . '</a>';

      $name = '<a href="' . $_SERVER['PHP_SELF'] . '?op=edit&id=' . $cat['id'] . '">' . $cat['name'] . '</a>';

      $cols = array($del, $name, $cat['notes']);

      echo(mkrow(mkcols($cols)));

    }

    echo('</table>');

  }

}



function render_form($rec) {

  $id = $rec['id'];

  echo('<div class="ht6em"></div>

<form method="post" action="' . $_SERVER['PHP_SELF'] .'">

<fieldset class="rounded box" style="padding:1em; margin: 4px auto; width:400px; border:1px solid sandybrown">

<legend>&nbsp; ' . (($id <= 0) ? 'New' : 'Edit') . ' Resolution &nbsp;</legend>

<table cellpadding="4">

  <tr>

    <td class="ralign"><label for="name">Name</label></td>

    <td><input id="name" name="name" type="text" size="40" value="'.$rec['name'].'" placeholder="Resolution name." title="Resolution name."/></td>

  </tr>

  <tr>

    <td><label for="notes">Notes</label></td>

    <td><input id="notes" name="notes" type="text" size="40" value="'.$rec['notes'].'" placeholder="Resolution description." title="Resolution description."/></td>

  </tr>

  <tr>

    <td></td>

    <td><input id="submit" type="submit" value=" OK "/>

        <input id="cancel" type="button" value=" Cancel "/></td>

  </tr>

</table>

</fieldset>

<input type="hidden" name="op" value="store"/>

<input type="hidden" name="id" value="' . $rec['id'] . '"/>

</form>

');

}



function new_rec() {

  $r = array();

  $r['id'] = 0;

  $r['name'] = '';

  $r['notes'] = '';

  render_form($r);

}



function edit_rec() {

  $r = find_resolution(param('id'));

  if (count($r) > 0) {

    render_form($r[0]);

  } else {

    echo('<br/>Unknown resolution reference.<br/>');

    render_table();

  }

}

/*

function store_rec() {

  $rec = array();

  $id = mysql_real_escape_string(param('id'));

  $rec['id'] = (int) $id;

  $rec['name'] = mysql_real_escape_string(param('name'));

  $rec['notes'] = mysql_real_escape_string(param('notes'));

  if ($rec['name'] == '') {

      echo('The name cannot be blank.');

      return;

  }

  return store_resolution($rec);

}

*/

function resolution() {

  $op = param('op');

  switch ($op) {

    case 'new'    : new_rec(); break;

    case 'edit'   : edit_rec(); break;

    /*

    case 'store'  : store_rec();

                    header('Location: resolution.php');

                    break;

    */

    case ''       : render_table(); break;

    default       : render_table(); break;

  }

}



function play() {

  $link = connect();

  render_menu('resolution');

  resolution();

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

        document.location.replace("resolution.php?op=del&id=" + id);

      }

      return false;

    });

  $('#newcat').click(function () {

      document.location.replace('resolution.php?op=new');

    });

  $('#cancel').click(function () {

      document.location.replace('resolution.php');

    });

  $('#submit').click(function() {

      var name = $.trim($('#name').val());

      if (name.length == 0) {

        $('#name').focus();

        alert('Name is required.');

        return false;

      }

      return true;

    });

});

function canBeDeleted(id) {

  var res = false;

  $.ajax({

    type: "GET",

    url: "resolution.php?op=candel&id=" + id,

    dataType: "json",

    async: false,

    success: function(json) {

      var count = json[0].count;

      res = (count == 0);

      if (res) {

        res = confirm('Are you sure you wish to delete this resolution record ?');

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

