<?php
include 'router.php';
include 'lib/db.php';

Db::connect('localhost', 'slum', 'slumpoetry', 'slum');

session_start();
$router = new Router();