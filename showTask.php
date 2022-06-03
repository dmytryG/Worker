<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'database/MySQL.php';
    include_once 'entity/Task.php';
    include_once 'entity/User.php';
    include_once 'utils/Constants.php';

    global $EMPLOYER_USER_STATUS, $TASK_STATUS_COMPLETED;
    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);
    $isApproved = isset($_GET["approve"]) && $_GET["approve"] == true;
    $isChangesRequired = isset($_GET["approve"]) && $_GET["approve"] == false;
    $task_id = $_GET["id"];
    if(isset($_COOKIE["approve"])) { header('Location: /showTask.php'); }
    $isEmployer = $_COOKIE["user_status"] === $EMPLOYER_USER_STATUS;
    $blocks = array();
    $db = new MySQL();

    if (isset($_POST["comment"])) {
        try {
            $db->add_comment_raw($task_id, $_GET["reportId"], $_POST["comment"]);
        } catch (Exception $ex) {
            $blocks[] = new CustomBlock("Вибачте, неможливо додати коментар,
            будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
        }
    }

    if ($isLoggedIn) {
        try { // load task by id
            $task = $db->get_task_with_status($task_id);
            $blocks[] = new TaskBlock($task->getHeader(),
                $task->getDescription(), $task->getDatetime(), $task->getStatus(), $task->getId());

            if ($task->getStatus() != $TASK_STATUS_COMPLETED) {
                $blocks[] = new CustomBlock("
                <div class='flex_item_right'> 
                <a href = \"/showTask.php?id=".$task_id."&approve=true\">Задачу виконано</a>
                <a href = \"/showTask.php?id=".$task_id."&approve=false\">Потребує правок</a>
                </div>
                ", "contentBlock smallButton right_flex");
            } else {
                $blocks[] = new CustomBlock("Виконана задача перенесена в архів"
                    , "contentBlock inactive");
            }

            $reports = $db->get_reports($task_id);

            foreach ($reports as $report) {
                $blocks[] = new ReportBlock
                ($report, $db->get_comments_for_report($report->getId()), $task_id, $isEmployer);
            }

            // TODO: load form for adding reports


        } catch (Exception $ex){
            $blocks[] = new CustomBlock("Вибачте, мі не можемо отримати дані задачі,
            будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
        }
        // Load task from database
        // Load reports from database
            // Load comments for reports


    } else {
        $blocks[] = new ContentBlock("Увійдіть у систему", "Для подальшої роботи та перегляду ваших робіт,
        будь ласка, увійдіть у систему", true);
    }

?>


<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>






<?php include_once 'footer.php'; ?>