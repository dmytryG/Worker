<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'database/MySQL.php';
    include_once 'entity/Task.php';
    include_once 'entity/User.php';
    include_once 'utils/Constants.php';

    $blocks = array();
    $db = new MySQL();

    $best_employees = $db->get_best_employees();

    $blocks[] = new CustomBlock("Топові виконавці");

    foreach ($best_employees as $employee) {
        $blocks[] = new CustomBlock("id: ".$employee['id']."<br/>Ім’я користувача: ".$employee['login']."<br/>Виконано задач: ".$employee['finished']);
    }
?>


<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>


<?php include_once 'footer.php'; ?>