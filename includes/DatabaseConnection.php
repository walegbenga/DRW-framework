<?php
$pdo = new PDO('mysql:host=localhost;dbname=bookstore;charset=utf8', 'root', 'arsenal1234go');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);