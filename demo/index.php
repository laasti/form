<?php

require '../vendor/autoload.php';

$form = Laasti\Form\FormFactory::createFromConfig(require 'config.php', ['name' => ''], ['name' => ['Name is required.']]);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Form Demo</title>
        <style>
            body {font-family:sans-serif;}
        </style>
    </head>
    <body>
        <h1>Form demo</h1>
        <form action="<?= $form->getAction(); ?>" method="<?= $form->getMethod(); ?>" <?= $form->getFormAttributes(); ?>>
            <?php foreach ($form->getFields() as $field): ?>
            <?php include 'inc/form-row.php'; ?>
            <?php endforeach; ?>
            <?php foreach ($form->getGroups() as $group): ?>
            <?php include 'inc/form-group.php'; ?>
            <?php endforeach; ?>
        </form>
    </body>
</html>
