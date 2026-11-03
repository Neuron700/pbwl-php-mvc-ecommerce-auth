<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Suendri">
    <title>Project 6 Pemrograman Berbasis Web Lanjutan</title>

    <link rel="icon" href="<?php echo AST; ?>/images/favicon.ico">
    <link href="<?php echo AST; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo AST; ?>/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body>
    <?php
    require_once ROOT . "app/views/" . $view . ".php";
    session_destroy();
    ?>
</body>

<script src="<?php echo AST; ?>/bootstrap/js/bootstrap.min.js"></script>

</html>