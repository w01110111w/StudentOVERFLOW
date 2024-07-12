<?php 
session_start();
include("INCLUDES/DatabaseConnection.php");
$title = '<STUDENT OVERFLOW>';
$currentPage = "Index.php";
ob_start();
include('templates/Home.html.php');
$output = ob_get_clean();
include('Layout.php');
