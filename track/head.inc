<?php session_start();?><!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<meta name="author" content="Vijay A. Patil [vijay.a.patil@gmail.com]">

<title>Stercks System Projects</title>

<link type="text/css" rel="stylesheet" href="/styles/track-style.css" />

<script type="text/javascript" src="/js/jquery.min.js"></script>

<!-- http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js -->

</head>

<body>

<div id="header">Sterck Systems Projects</div>

<div id="flash" style='display:none;' title='Click on this message to hide it.'></div>

<div id="trace" style='display:none;'></div>

<script type="text/javascript">

$(function() {

  $("#flash").click(function() {

      $(this).hide();

    });

  $("#trace").click(function() {

      $(this).hide();

    });

  $('.menuitem').hover(

      function() {

        $(this).addClass('hover')

      },

      function() {

        $(this).removeClass('hover')

      });

});

function flash(hmsg) {

  if ((typeof(hmsg) == "string") && hmsg.length == 0) {

    $("#flash").hide("slow");

  } else {

    $("#flash").show("slow", function() {

        $(this).html(hmsg);

      });

  }

}

function trace(hmsg) {

  if ((typeof(hmsg) == "string") && hmsg.length == 0) {

    $("#trace").hide("slow");

  } else {

    $("#trace").show("slow", function() {

        $(this).html(hmsg);

      });

  }

}

function select_in_menu(menuid) {

  $('.menuitem').removeClass('menuselect');

  $('#' + menuid).addClass('menuselect');

}

</script>

<?php

include_once("mysql.inc");

include_once("menus.inc");

?>

