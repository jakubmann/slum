<?php
include 'router.php';
include 'lib/db.php';

Db::connect('localhost', 'slum', 'slumpoetry', 'slum');

$router = new Router();