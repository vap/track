<?php



function connect() {

  $link = @mysql_connect("localhost", "root", "vap");

  if (! is_resource($link)) {

    die("Could not connect to mysql: " . mysql_error());

  }

  if (! mysql_select_db("track", $link)) {

    die("Could not select db. " . mysql_error());

  }

  return $link;

}



/*

function connect() {

  $link = @mysql_connect("localhost", "xxxx", "yyy");

  if (! is_resource($link)) {

    die("Could not connect to mysql: " . mysql_error());

  }

  if (! mysql_select_db("trackdb", $link)) {

    die("Could not access database.");

  }

  return $link;

}

*/



function disconnect($link) {

  mysql_close($link);

}



function do_select($sql) {

  $result = mysql_query($sql) or die('Bad query: ' . $sql . ' : ' . mysql_error());

  $recs = array();

  while ($row = mysql_fetch_assoc($result)) {

     $recs[] = $row;

  }

  mysql_free_result($result);

  return $recs;

}



/* Category */



function list_categories() {

  return do_select("select * from category order by name");

}



function find_category($id) {

  return do_select("select * from category where id=" . $id);

}



function store_category($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into category (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update category set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Severity */



function list_severities() {

  return do_select("select * from severity order by name");

}



function find_severity($id) {

  return do_select("select * from severity where id=" . $id);

}



function store_severity($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into severity (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update severity set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Status */



function list_statuses() {

  return do_select("select * from status order by name");

}



function find_status($id) {

  return do_select("select * from status where id=" . $id);

}



function store_status($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into status (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update status set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Priorities */



/*

function list_priorities() {

  return do_select("select * from priority order by name");

}



function find_priority($id) {

  return do_select("select * from priority where id=" . $id);

}



function store_priority($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into priority (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update priority set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}

*/



/* Resolutions */



function list_resolutions() {

  return do_select("select * from resolution order by name");

}



function find_resolution($id) {

  return do_select("select * from resolution where id=" . $id);

}



function store_resolution($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into resolution (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update resolution set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Primary Tracks */



function list_accessible_primetracks($userid) {

  $tracks = tracks_for_given_user($userid);

  return do_select("select pt.* from primetrack pt, usertrack ut where ut.track_id in (".$tracks.") and ut.user_id=".$userid." and pt.id=ut.track_id order by pt.name");

}



function list_primetracks() {

  return do_select("select * from primetrack order by name");

}



function list_primetracks_js() {

  return json_encode(list_primetracks());

}



function find_primetrack($id) {

  return do_select("select * from primetrack where id=" . $id);

}



function store_primetrack($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into primetrack (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update primetrack set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Components */



function list_components() {

  return do_select("select * from component order by name");

}



function find_component($id) {

  return do_select("select * from component where id=" . $id);

}



function store_component($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf('insert into component (name, notes) values ("%s", "%s")', $r['name'], $r['notes']);

  } else {

    $sql = sprintf('update component set name="%s", notes="%s" where id=%d', $r['name'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql);

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Users */



function list_users() {

  return do_select('select * from users order by name');

}



function list_of_active_users() {

  return do_select('select * from users where active=1 order by name');

}



function list_users_all_cols() {

  return do_select('select * from users order by name');

}



function find_user_pwd($emailid, $pwd) {

  $sql = sprintf("select * from users where email_id='%s' and password=md5('%s')",

                  trim(mysql_real_escape_string($emailid)), trim(mysql_real_escape_string($pwd)));

  return do_select($sql);

}



function find_user_by_id ($id) {

  return do_select("select * from users where id=" . $id);

}



function store_user($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  $active = (isset($r['active']) && ($r['active'] == 1)) ? 1 : 0;

  // In case when someone's being stupid -- while being an admin - and trying to disable onself.

  if (($r['role'] == 'admin') && ($r['email_id'] == $_SESSION['user']['email_id'])) {

    $active = 1;

  }

  if ($new) {

    $sql = sprintf('insert into users (name, email_id, role, password, active) values ("%s","%s","%s","%s",%d)',

                   trim($r['name']),trim($r['email_id']),trim($r['role']),md5(trim($r['password'])), $active);

  } else {

    if (isset($r['password']) && ($r['password'] != '')) {

      $sql = sprintf('update users set name="%s", email_id="%s", role="%s", password="%s", active=%d where id=%d',

                      $r['name'], $r['email_id'], $r['role'], md5($r['password']), $active, $r['id']);

    } else {

      $sql = sprintf('update users set name="%s", email_id="%s", role="%s", active=%d where id=%d',

                     $r['name'], $r['email_id'], $r['role'], $active, $r['id']);

    }

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql . ' ' . mysql_error());

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



/* Focus */

function list_tasks() {

  $sql =

'select ' .

    't.id, t.title, t.category_id, t.severity_id, t.status_id, t.detected_by_id, t.assigned_to_id, t.component_id, ' .

    't.prime_track_id, t.planned_close_date, t.resolution_id, ' .

    'sev.name as sevname, comp.name as compname, detuser.name as duname,  ' .

    'assuser.name as asname, pt.name as ptname, status.name as statname, ' .

    'cat.name as catname, reso.name as resoname ' .

'from  ' .

    'tasklist t, severity sev, component comp, primetrack pt, ' .

    'users detuser, users assuser, category cat, resolution reso, status  ' .

'where  ' .

    'cat.id = t.category_id and  ' .

    'sev.id = t.severity_id and  ' .

    'status.id = t.status_id and ' .

    'detuser.id = t.detected_by_id and  ' .

    'assuser.id = t.assigned_to_id and  ' .

    'reso.id = t.resolution_id and  ' .

    'comp.id = t.component_id and ' .

    'pt.id = t.prime_track_id ' .

'order ' .

    'by t.id';

  return do_select($sql);

}



function tracks_for_given_user($userid) {

  $recs = do_select('select distinct track_id from usertrack where user_id='.$userid);

  $ts = array();

  $tracks = '0';

  if (count($recs) > 0) {

    foreach ($recs as $r) {

      $ts[] = $r['track_id'];

    }

    $tracks = implode(',', $ts);

  }

  return $tracks;

}



function list_tasks_accessible_by_given_user($userid) {

  $tracks = tracks_for_given_user($userid);

  $sql =

'select ' .

    't.id, t.title, t.category_id, t.severity_id, t.status_id, t.detected_by_id, t.assigned_to_id, t.component_id, ' .

    't.prime_track_id, t.planned_close_date, t.resolution_id, ' .

    'sev.name as sevname, comp.name as compname, detuser.name as duname,  ' .

    'assuser.name as asname, pt.name as ptname, status.name as statname, ' .

    'cat.name as catname, reso.name as resoname ' .

'from  ' .

    'tasklist t, severity sev, component comp, primetrack pt, ' .

    'users detuser, users assuser, category cat, resolution reso, status  ' .

'where  ' .

    'cat.id = t.category_id and  ' .

    'sev.id = t.severity_id and  ' .

    'status.id = t.status_id and ' .

    'detuser.id = t.detected_by_id and  ' .

    'assuser.id = t.assigned_to_id and  ' .

    'reso.id = t.resolution_id and  ' .

    'comp.id = t.component_id and ' .

    'pt.id = t.prime_track_id and ' .

    't.prime_track_id in ('.$tracks.') '.

'order ' .

    'by t.id';

  return do_select($sql);

}



/* Focus */



function find_focus($id) {

  return do_select("select * from tasklist where id=" . $id);

}



function store_focus($r) {

  $new = ($r['id'] <= 0);

  $sql = '';

  if ($new) {

    $sql = sprintf("insert into tasklist (category_id, severity_id, status_id, detected_by_id," .

                   "assigned_to_id, component_id, prime_track_id, resolution_id, planned_close_date, title, notes) ".

                   "values (%d, %d, %d, %d, %d, %d, %d, %d,'%s','%s','%s')",

                   // The "integer values" to be set.

                   $r['category_id'], $r['severity_id'], $r['status_id'], $r['detected_by_id'],

                   $r['assigned_to_id'], $r['component_id'], $r['prime_track_id'], $r['resolution_id'],

                   // The "string values" to be set.

                   $r['planned_close_date'], $r['title'], $r['notes']);

  } else {

    $sql = sprintf("update tasklist set category_id=%d, severity_id=%d, status_id=%d, detected_by_id=%d,".

                     "assigned_to_id=%d, component_id=%d, prime_track_id=%d, resolution_id=%d, planned_close_date='%s', title='%s', notes='%s' where id=%d",

                     $r['category_id'], $r['severity_id'], $r['status_id'], $r['detected_by_id'], $r['assigned_to_id'], $r['component_id'], $r['prime_track_id'], $r['resolution_id'], $r['planned_close_date'], $r['title'], $r['notes'], $r['id']);

  }

  $res = mysql_query($sql) or die('Bad query: ' . $sql . ' : ' . mysql_error());

  if ($new && $res) {

    $r['id'] = mysql_insert_id();

  }

  return $r;

}



function do_del($table_name, $id) {

  $sql = 'delete from '.$table_name.' where id='.$id;

  return mysql_query($sql) or die('Bad query: ' . $sql);

}



function mk_phrase($count, $target) {

  if ($count == 0) {

    return '';

  }

  $phrase = (count == 1) ? " is one reference " : (" are " + count + " references ");

  return "There" . $phrase  . 'to this value in the ' . $target . ".\n\nYou cannot delete it now.";

}



function is_user_deletable($id) {

  $sql = 'select count(*) as count from tasklist where assigned_to_id='.$id.' or detected_by_id='.$id;

  $recs = do_select($sql);

  $recs[0]['msg'] = '';

  if ($recs[0]['count'] > 0) {

    $recs[0]['msg'] = mk_phrase($recs[0]['count'], "task list");

  } else {

    $sql = 'select count(*) as count from usertrack where user_id='.$id;

    $recs = do_select($sql);

    $recs[0]['msg'] = mk_phrase($recs[0]['count'], "user/primary-track list");

  }

  return $recs;

}



function is_primetrack_deletable($id) {

  $sql = 'select count(*) as count from usertrack where track_id='.$id;

  $recs = do_select($sql);

  $recs[0]['msg'] = mk_phrase($recs[0]['count'], "user/primary-track list");

  return $recs;

}



function is_deletable($table_name, $id) {

  $recs = do_select('select count(*) as count from tasklist where '.$table_name.'_id=' . $id);

  $recs[0]['msg'] = mk_phrase($recs[0]['count'], "task list");

  if (($recs[0]['count'] == 0)) {

    if ($table_name == 'primetrack') {

      $recs = is_primetrack_deletable($id);

    } elseif ($table_name == 'users') {

      $recs = is_user_deletable($id);

    }

  }

  return $recs;

}



function is_deletable_js($table_name, $id) {

  return json_encode(is_deletable($table_name, $id));

}



/* For user-track mapping. */



function tracks_for_user_js($userid) {

  $recs = do_select('select ut.id as id, u.name as username, t.name as trackname, ut.track_id, ut.user_id from usertrack ut, users u, primetrack t where ut.user_id='.$userid.' and t.id=ut.track_id and u.id=user_id');

  return json_encode($recs);

}



function mk_user_track_assoc($uid, $tid) {

  $sql = sprintf("insert into usertrack (user_id, track_id) values (%d, %d)", $uid, $tid);

  return mysql_query($sql) or die('Bad query: ' . $sql . ' : ' . mysql_error());

}



function user_in_mapping($id) {

  $recs = do_select("select user_id from usertrack where id=".$id);

  return (count($recs) > 0) ? $recs[0]['user_id'] : 0;

}

?>

