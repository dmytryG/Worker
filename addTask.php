<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'entity/User.php';
    include_once 'database/MySQL.php';
    include_once 'utils/Constants.php';

    global $EMPLOYER_USER_STATUS, $EMPLOYEE_USER_STATUS, $COOKIE_TEMPORY_TIME;
    $db = new MySQL();
    $blocks = array();
    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);

    if (!$isLoggedIn) {
        $blocks[] = new ContentBlock("Увійдіть у систему", "Для подальшої роботи та перегляду ваших робіт,
        будь ласка, увійдіть у систему", true);
    } else {
        if ($_COOKIE["user_status"] === $EMPLOYER_USER_STATUS) {
            if(!empty($_GET) && isset($_GET["caption"]) && $_GET["caption"] != ""
                && isset($_GET["employee"])
                && isset($_GET["description"]) && $_GET["description"] != "") {
                //setcookie("tmp_is_task_just_created", true, time() + $COOKIE_TEMPORY_TIME);

                $employer = $db->get_user($_COOKIE["login"]);
                $task = new Task(Null, $_GET["employee"], $employer->getId(), $_GET["caption"], $_GET["description"], Null, 1);
                $_GET["caption"]="";
                $_GET["description"]="";
                try{
                    $db->create_task($task);
                    $blocks[] = new CustomBlock("Задачу " . $task->getHeader() . " успішно додано", "contentBlock blue color-black");

                } catch (Exception $ex) {
                    $blocks[] = new CustomBlock("Вибачте, під час додавання задачі сталася помилка,
                    будь ласка, спробуйте знову\n" . $ex , "contentBlock pink");
                    var_dump($_GET);
                }
            }
            else {
                if (!empty($_GET)) {
                    $blocks[] = new CustomBlock("Вибачте, одне або більше поле форми було незаповнено,
                    будь ласка, спробуйте знову", "contentBlock pink");
                }
            }


            try {
                $employees = $db->get_users_by_status($EMPLOYEE_USER_STATUS);
                include_once 'forms/addTaskForm.php';
            } catch (Exception $ex) {
                $blocks[] = new CustomBlock("Вибачте, під час отримання списку користувачів,
                    будь ласка, спробуйте знову\n" . $ex , "contentBlock pink");
            }
        }
        else {
            $blocks[] = new CustomBlock("Вибачте, тільки замовники можуть додавати нові завдання", "contentBlock pink");
        }
    }



?>


<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>






<?php include_once 'footer.php'; ?>