<?php
session_start();
require_once 'src/User.php';
$deconnection = new User();
$deconnection->deconnect();