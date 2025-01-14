<?php
session_start();

/**
 * using mysqli_connect for database connection
 */

$databaseHost = 'localhost';
$databaseName = 'rcrafted_blangkis';
$databaseUsername = 'rcrafted_blangkis';
$databasePassword = 'blangkisdb';

$basePath = "https://blangkis.rcrafted.com/admin";

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
 