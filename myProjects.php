<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'database/MySQL.php';
    include_once 'entity/Task.php';
    include_once 'entity/User.php';
    include_once 'utils/Constants.php';

    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);
    $blocks = array();
    $db = new MySQL();
    $filter = Null;
    if (isset($_POST["filter"])) {
        $filter = $_POST["filter"];
    }

    if ($isLoggedIn) {
        include_once 'forms/sortingForm.php';
        global $EMPLOYER_USER_STATUS;
        if($_COOKIE["user_status"] === $EMPLOYER_USER_STATUS) {
            $blocks[] = new CustomBlock("
            <div class='flex_item_right'>Ви можете <a href = \"addTask.php\">додати завдання</a></div>
            ", "contentBlock smallButton right_flex");
        }

        try {
            $user = $db->get_user($_COOKIE["login"]);
            $projects = $db->get_tasks($user, $filter);
            foreach ($projects as $task) {
                $blocks[] = new TaskBlock($task->getHeader(),
                    $task->getDescription(), $task->getDatetime(), $task->getStatus(), $task->getId());
            }
            if (count($projects) == 0) {
                $blocks[] = new ContentBlock("В вас немає проектів", "На даний час для вашого облікового
            запису нема жодного проекту");
            }
        }
        catch (Exception $ex) {
            $error_block = new ContentBlock("Помилка", "Нажаль, під час обробки запиту сталася помилка, 
            будь-ласка, спробуйте повторити спробу пізніше. " . $ex->getMessage());
            $error_block->setIsPink(true);
            $blocks[] = $error_block;
        }
        // add tasks to arrat
    } else {
        $blocks[] = new ContentBlock("Увійдіть у систему", "Для подальшої роботи та перегляду ваших робіт,
        будь ласка, увійдіть у систему", true);
    }

?>


<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>






<?php include_once 'footer.php'; ?>