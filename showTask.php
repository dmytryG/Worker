<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'database/MySQL.php';
    include_once 'entity/Task.php';
    include_once 'entity/User.php';
    include_once 'utils/Constants.php';

    global $EMPLOYER_USER_STATUS, $TASK_STATUS_COMPLETED, $FILE_SAVE_PATH, $TASK_STATUS_COMPLETED, $TASK_STATUS_REVIEW;
    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);
    $isApproved = isset($_GET["approve"]) && $_GET["approve"] === "true";
    $isChangesRequired = isset($_GET["approve"]) && $_GET["approve"] === "false";
    $task_id = $_GET["id"];
    if(isset($_COOKIE["approve"])) { header('Location: /showTask.php'); }
    $isEmployer = $_COOKIE["user_status"] === $EMPLOYER_USER_STATUS;
    $blocks = array();
    $db = new MySQL();
    $isTaskActive = false;

    if (isset($_POST["comment"])) {
        try {
            $db->add_comment_raw($task_id, $_GET["reportId"], $_POST["comment"]);

        } catch (Exception $ex) {
            $blocks[] = new CustomBlock("Вибачте, неможливо додати коментар,
            будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
        }
    }

    if ($isApproved) {
        try {
            $db->set_task_status($task_id, $TASK_STATUS_COMPLETED);
            $blocks[] = new CustomBlock("Статус завдання змінено на ". $TASK_STATUS_COMPLETED, "contentBlock blue");
        } catch (Exception $ex) {
            $blocks[] = new CustomBlock("Вибачте, неможливо оновити статус задачі,
            будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
        }
    }

    if ($isChangesRequired) {
        try {
            $db->set_task_status($task_id, $TASK_STATUS_REVIEW);
            $blocks[] = new CustomBlock("Статус завдання змінено на ". $TASK_STATUS_REVIEW, "contentBlock blue");
        } catch (Exception $ex) {
            $blocks[] = new CustomBlock("Вибачте, неможливо оновити статус задачі,
                будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
        }
    }

    try{
        if (isset($_FILES["report"])) {
            // Add file
            $filename_postfix = substr($_FILES["report"]["name"], -4);
            $filename_prefix = substr($_FILES["report"]["name"], 0, strlen($_FILES["report"]["name"])-4);
            $file_current_location = $_FILES["report"]["tmp_name"];
            if ($_FILES["report"]["error"] != 0 || $_FILES["report"]["size"] == 0) {
                throw new Exception("File getting error");
            }
            $file_new_name = $filename_prefix . "-" . time() . $filename_postfix;
            if (move_uploaded_file($file_current_location, $FILE_SAVE_PATH . $file_new_name)) {

                $db->add_report_raw($task_id, $file_new_name);
                $blocks[] = new CustomBlock("Звіт ". $file_new_name .
                    " успішно додано", "contentBlock blue");
                $db->set_task_status($task_id, $TASK_STATUS_REVIEW);
            } else {
                throw new Exception("Cannot save file");
            }

        }
    } catch (Exception $ex) {
        $blocks[] = new CustomBlock("Вибачте, ми не можемо додати звіт,
            будь ласка, спробуйте пізніше: ". $ex->getMessage(), "contentBlock pink");
    }




    if ($isLoggedIn) {
        try { // load task by id
            $task = $db->get_task_with_status($task_id);

            if ($task->getStatus() != $TASK_STATUS_COMPLETED) {
                $isTaskActive = true;
            }

            $blocks[] = new TaskBlock($task->getHeader(),
                $task->getDescription(), $task->getDatetime(), $task->getStatus(), $task->getId());

            if ($task->getStatus() != $TASK_STATUS_COMPLETED) {
                if ($isEmployer) {
                    $blocks[] = new CustomBlock("
                    <div class='flex_item_right'> 
                    <a href = \"/showTask.php?id=".$task_id."&approve=true\">Задачу виконано</a>
                    <a href = \"/showTask.php?id=".$task_id."&approve=false\">Потребує правок</a>
                    </div>
                    ", "contentBlock smallButton right_flex");
                }

            } else {
                $blocks[] = new CustomBlock("Виконана задача перенесена в архів"
                    , "contentBlock inactive");
            }

            $reports = $db->get_reports($task_id);

            foreach ($reports as $report) {
                $blocks[] = new ReportBlock
                ($report, $db->get_comments_for_report($report->getId()), $task_id, $isEmployer && $isTaskActive);
            }


            // TODO: load form for adding reports


        } catch (Exception $ex){
            $blocks[] = new CustomBlock("Вибачте, ми не можемо отримати дані задачі,
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

<?php
 if($isLoggedIn && !$isEmployer && $isTaskActive) {
     include_once 'forms/addReport.php';
 }
?>





<?php include_once 'footer.php'; ?>