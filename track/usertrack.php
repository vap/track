<?php
include_once('mysql.inc');
include_once('utils.inc');

$op = param('op');
$id = param('id');
if (($op == 'tforu') || ($op == 'deltu') || ($op == 'mktu')) {
  if ($op == 'tforu') {
    $link = connect();
      echo(tracks_for_user_js($id));
    disconnect($link);
    return;
  } elseif ($op == 'mktu') {
    $uid = param('uid');
    $tid = param('tid');
    $link = connect();
      mk_user_track_assoc(mysql_real_escape_string($uid), mysql_real_escape_string($tid));
    disconnect($link);
    header('Location: usertrack.php?op=sel&id=' . $uid);
    return;
  } else {
    $link = connect();
      $userid = user_in_mapping($id);
      do_del('usertrack', $id);
    disconnect($link);
    header('Location: usertrack.php?op=sel&id=' . $userid);
    return;
  }
  header('Location: usertrack.php');
  return;
}
?>
<?php
include_once('head.inc');
include_once('mysql.inc');
include_once('utils.inc');

function list_jsoned_tracks() {
  echo('
<script type="text/javascript">
var tracks = ' . list_primetracks_js() . ';
</script>');
}

function usertrack() {
  list_jsoned_tracks();
  $tracks = list_primetracks();
  $users = list_of_active_users();
  $cur_user = params('id', 0);
echo('
<div style="width:650px; margin: 2em auto; border: 1px solid lightgray; padding: 2em; background: lightyellow"
     class="rounded box">
  <table cellpadding="4">
  <tr id="user-sel-tr">
    <td  class="ralign">User</td>
    <td>' . mkselect("user_id", $users, $cur_user) .'</td>
  </tr>
  <tr id="avail-tracks-tr">
    <td><label for="track-sel"> Available Tracks </label></td>
    <td id="track-container">' . mk_track_select($tracks) . '</td>
  </tr>
  <tr id="add-track-ctr">
    <td></td>
    <td><button id="add-track"> Add Track </button></td>
  </tr>
  </table>
</div>
');
}

function mk_track_select($tracks) {
  $s = '<select id="track-sel">
           <option value="0">-- Select --</option>';
  for($c = 0, $n = count($tracks); $c < $n; $c++) {
    $s .= '<option value="'.$tracks[$c]['id'].'">'.$tracks[$c]['name'].'</option>';
  }
  $s .= '</select>';
  return $s;
}

function play() {
  $link = connect();
  render_menu('usertrack');
  usertrack();
  disconnect($link);
}

play();

?>
<script type="text/javascript" src="/js/utils.js"></script>
<script type="text/javascript">
$(function() {
  $("#user_id").change(function() {
      $('.track-info').remove();
      var userid = $("#user_id option:selected").val();
      if (userid == 0) {
        $("#avail-tracks-tr").after(no_match_msg(0));
      } else {
        // alert("Fetching data for user with id: " + userid);
        $.getJSON("usertrack.php?op=tforu", { id: userid },
          function(json) {
            $("#avail-tracks-tr").after((json.length == 0) ? no_match_msg(userid) : show_track_grid(json));
          });
      }
      // add_btn_accessibility();
    });
  $("#user_id").trigger("change");
  $('.del-tr').live("click", function() {
      // alert("We will delete track #: " + $(this).attr('rel'));
      document.location.replace("usertrack.php?op=deltu&id=" + $(this).attr('rel'));
    });
  $('#add-track').click(function() {      
      var tid = $("#track-sel option:selected").val(),
          uid = $("#user_id option:selected").val();
      // alert("We will map track: " + tid + " with user: " + uid);
      if (uid == 0) {
        alert('Do select a user to map selected track with.');
        $("#user_id").focus();
        return false;
      }
      if (tid == 0) {
        alert('Do select a track to map selected user with.');
        $("#track-sel").focus();
        return false;
      }
      document.location.replace("usertrack.php?op=mktu&uid=" + uid + "&tid=" + tid);
      return true;
    });
  if ($.browser.msie) {
    alert("\nThis feature may not work on this browser.\n\nConsider using a *real* browser to get the job done.\n\nWe recommend any of these browsers: Firefox, Chrome, Opera or Safari.\n\nWe also recommend that you do not take our recommendations lightly.\n\n");
  }
});

function add_btn_accessibility() {
  var tid = $("#track-sel option:selected").val();
  var uid = $("#user_id option:selected").val();
  var addbtn = $('#add-track');
  if (tid == 0 || uid == 0) {
    addbtn.disabled = true;
  } else {
    addbtn.disabled = false;
  }
}

function show_track_grid (json) {
  var s = "";
  var ts = []; // new Array();
  $(json).each(function(i, js) {
      s += tr(td((i+1), {'class':'del-tr ralign bold',
                          "style" : "color:crimson; padding-right:1em",
                          "title":"To remove this track from this user, click here.",
                          "rel" : js.id}) +
              td(js.trackname), {"class" : "track-info"});
      ts.push(js.track_id);
    });
  all_tracks_in_selector(ts);
  return s;
}

function no_match_msg(userid){
  all_tracks_in_selector();
  return tr(td('') + td((userid != 0)
                          ? "No tracks have been defined for this user yet."
                          : "Select a user from above.",
                        { "class":"no-selection" }), { "class" : "track-info bold" });
}

function all_tracks_in_selector() {
  var s = '',
      first = '',
      ts = arguments[0] || [],
      opt = 0;
  $(tracks).each(function(i, track) {
      // if (ts.indexOf(track.id) == -1) {
      if ($.inArray(track.id, ts) == -1) {
        s += "<option value='" + track.id + "'>" + track.name + "</option>";
        opt = 1;
      }
    });
  s += "</select>";
  $('#track-sel').remove();
  if (opt == 0) {
    first = "<select id='track-sel'><option value='0'>-- All tracks have been assigned to this user --</option>";
  } else {
    first = "<select id='track-sel'><option value='0'>-- Select --</option>";
  }
  $("#track-container").append(first + s);
}
</script>
</body>
</html>