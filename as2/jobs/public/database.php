<?php
$pdo = new PDO('mysql:dbname=jobs;host=mysql', 'user', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
