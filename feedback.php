<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    $blocks = array();


?>

<?php include_once 'forms/feedbackForm.php'; ?>

<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>



<?php include_once 'footer.php'; ?>