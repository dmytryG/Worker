<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'entity/User.php';
    include_once 'database/MySQL.php';
    include_once 'utils/Constants.php';

    $db = new MySQL();
    $blocks = array();
    $is_just_logged_id = false;
    global $COOKIE_LOGIN_TIME;

    if(isset($_GET["login_as"])) {
        try{
            $user = $db->login($_GET["login_as"], "");
            $user = $db->set_user_statuses(array($user))[0];
            setcookie("login", $user->getUsername(), time() + $COOKIE_LOGIN_TIME);
            setcookie("user_status", $user->getStatus(), time() + $COOKIE_LOGIN_TIME);
            $is_just_logged_id = true;
            header("Refresh: 0; url=".$_SERVER['PHP_SELF']);
        } catch (Exception $ex) {
            $blocks[] = new ContentBlock("Помилка",
                "Нажаль, сталась помилка під час отримання користувачів системи, 
                буль-ласка, спробуйте пізніше: " . $ex->getMessage());
        }
    }
    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);

    if ($isLoggedIn || $is_just_logged_id) {
        $blocks[] = new ContentBlock("Оберіть обліковий запис",
            "Ви вже увійшли у систему як " . $_COOKIE["login"] . ". Тип вашого облікового запису: "
            .$_COOKIE["user_status"].". Ви можете увійти у систему під іншим ім’ям");
    } else {
        $blocks[] = new ContentBlock("Увійдіть у систему", "Для подальшої роботи та перегляду ваших робіт,
        будь ласка, увійдіть у систему", true);
    }

    try {
        $user_arr = $db->get_all_users();
        $user_arr = $db->set_user_statuses($user_arr);
        foreach ($user_arr as $user) {
            $blocks[] = new CustomBlock(
                "<a href=\"?login_as=".$user->getUsername()."\">
                Увійти як " . $user->getUsername() . " зі статусом " . $user->getStatus()
                . "</a>", "bigButton"
            );
        }
    } catch (Exception $e) {
        $blocks[] = new ContentBlock("Помилка",
            "Нажаль, сталась помилка під час отримання користувачів системи, буль-ласка, спробуйте пізніше");
    }


?>


<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>






<?php include_once 'footer.php'; ?>