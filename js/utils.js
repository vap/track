function td() {
  var s = arguments[0] || '';
  var p = '';
  var map = (arguments.length) ? arguments[1] : undefined;
  if (map != undefined) {
    for (var k in map) {
      if (k != '' && map[k] != '') {
        p += ' ' + k + '="' + map[k] + '"';
      }
    }
  }
  return '<td' + p + '>' + s + '</td>';
}

function th() {
  var s = arguments[0] || '';
  var p = '';
  var map = (arguments.length) ? arguments[1] : undefined;
  if (map != undefined) {
    for (var k in map) {
      if (k != '' && map[k] != '') {
        p += ' ' + k + '="' + map[k] + '"';
      }
    }
  }
  return '<th' + p + '>' + s + '</th>';
}

function tr() {
  var s = arguments[0] || '';
  var p = '';
  var map = (arguments.length) ? arguments[1] : undefined;
  if (map != undefined) {
    for (var k in map) {
      if (k != '' && map[k] != '') {
        p += ' ' + k + '="' + map[k] + '"';
      }
    }
  }
  return '<tr' + p + '>' + s + '</tr>';
}

function br() {
  return '<br/>';
}

function bq(s) {
  return '<blockquote>' + s + '</blockquote>';
}

function q(s) {
  return '"' + s + '"';
}

function error(s) {
  alert(s);
}

function flash(msg) {
  $('#flash').html(msg).fadeIn(250).fadeOut(1500);
}

function isNumber (value) {
  return typeof value === 'number' && isFinite(value);
}
