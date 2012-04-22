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

  return store_category($rec);

}



$op = param('op');

if (($op == 'store') || ($op == 'del') || ($op == 'candel')) {

  $link = connect();

  if ($op == 'store') {

    store_rec();

  } elseif ($op == 'del') {

    do_del('category', param('id'));

  } else {

    $res = is_deletable_js('category', param('id'));

    disconnect($link);

    echo($res);

    return;

  }

  disconnect($link);

  header('Location: category.php');

}

?>

<?php

include_once('head.inc');



function render_table() {

  echo('<p><button id="newcat"> New Category </button></p>');

  $cats = list_categories();

  if (count($cats) == 0) {

    echo('No categories defined yet.');

  } else {

    $hs = array('#', 'Category', 'Notes');

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

<legend>&nbsp; ' . (($id <= 0) ? 'New' : 'Edit') . ' Category &nbsp;</legend>

<table cellpadding="4">

  <tr>

    <td class="ralign"><label for="name">Name</label></td>

    <td><input id="name" name="name" type="text" size="40" value="' . $rec['name'] . '" placeholder="Category name." title="Category name."/></td>

  </tr>

  <tr>

    <td><label for="notes">Notes</label></td>

    <td><input id="notes" name="notes" type="text" size="40" value="' . $rec['notes'] . '" placeholder="Category description." title="Category description."/></td>

  </tr>

  <tr>

    <td></td>

    <td><input id="submit" type="submit" value=" OK "/>

        <input id="cancel" type="button" value=" Cancel "/></td>

  </tr>

</table>

</fieldset>

<input type="hidden" name="op" value="store"/>

<input type="hidden" name="id" value="'.$rec['id'].'"/>

</form>

');

}



function new_cat() {

  $r = array();

  $r['id'] = 0;

  $r['name'] = '';

  $r['notes'] = '';

  render_form($r);

}



function edit_cat() {

  $r = find_category(param('id'));

  if (count($r) > 0) {

    render_form($r[0]);

  } else {

    echo('<br/>Unknown category reference.<br/>');

    render_table();

  }

}

/*

function store_cat() {

  $rec = array();

  $id = mysql_real_escape_string(param('id'));

  $rec['id'] = (int) $id;

  $rec['name'] = mysql_real_escape_string(param('name'));

  $rec['notes'] = mysql_real_escape_string(param('notes'));

  if ($rec['name'] == '') {

      echo('The name cannot be blank.');

      return;

  }

  return store_category($rec);

}

*/

function category() {

  $op = param('op');

  switch ($op) {

    case 'new'    : new_cat(); break;

    case 'edit'   : edit_cat(); break;

    /*

    case 'store'  : store_cat();

                    header('Location: category.php');

                    break;

    */

    case ''       : render_table(); break;

    default       : render_table(); break;

  }

}



function play() {

  $link = connect();

  render_menu('category');

  category();

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

        document.location.replace("category.php?op=del&id=" + id);

      }

      return false;

    });

  $('#newcat').click(function () {

      document.location.replace('category.php?op=new');

    });

  $('#cancel').click(function () {

      document.location.replace('category.php');

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

    url: "category.php?op=candel&id=" + id,

    dataType: "json",

    async: false,

    success: function(json) {

      var count = json[0].count;

      res = (count == 0);

      if (res) {

        res = confirm('Are you sure you wish to delete this category record ?');

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

