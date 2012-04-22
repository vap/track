<?php
function mkhcol($string) {
  return '<th>' . $string . "</th>\n";
}
function mkhcols($hs) {
  $s = '';
  foreach($hs as $h) {
    $s .= mkhcol($h);
  }
  return $s;
}
function mkcol($string, $class = '') {
  return '<td'. ((isset($class) && $class != '') ? ' class="'.$class.'">' : '>') . $string . "</td>\n";
}
function mkcols($cols) {
  $s = "";
  foreach($cols as $c) {
    $parts = explode("==>>", $c);
    if (count($parts) > 1) {
      $s .= mkcol($parts[0], $parts[1]);
    } else {
      $s .= mkcol($c);
    }
  }
  return $s;
}
function mkrow($string) {
  return "<tr>\n" . $string . "</tr>\n";
}
function mkselect($name, $rows, $curval) {
  $s = '<select id="' . $name . '" name="' . $name . '">
  <option value="0">-- Select --</option>';
    foreach ($rows as $row) {
      $val = $row['id'];
      $s .= '<option value="' . $val . '" ';
      if ($val == $curval) {
        $s .= ' selected ';
      }
      $s .= '>' . $row['name']  . '</option>';
    }
    $s .= '</select>';
    return $s;
}
function params($name, $default='') {
  if (isset($_REQUEST[$name])) {
    return trim($_REQUEST[$name]);
  }
  return (isset($default)) ? $default : "";
  // die("Default not defined in params()!!!");
}
function param($name) {
  return (isset($_REQUEST[$name])) ? trim($_REQUEST[$name]) : '';
}
function cookie($name) {
  return isset($_COOKIE[$name]) ? $_COOKIE[$name] : '';
}

/*
$as = array('col 1', 'col 2', "col 3");
echo 'The header cols are:', "\n", mkrow(mkhcols($as));

$as = array("col 1", "col 2", "col 3");
echo 'The data cols are:', "\n", mkrow(mkcols($as));
*/
?>
