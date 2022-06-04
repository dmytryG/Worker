<?php include_once 'header.php'; ?>

<?php
    include_once 'entity/Block.php';
    include_once 'database/MySQL.php';
    $blocks = array();
    $db = new MySQL();
    if (isset($_POST["email"])) {
        if (strlen($_POST["email"]) > 5) {
            if (isset($_POST["comment"]) && strlen($_POST["comment"]) > 5) {
                try {
                    $db->add_feedback($_POST["email"], $_POST["comment"]);
                } catch (Exception $ex) {
                    $blocks[] = new CustomBlock("Вибачте, ми не можемо додати відгук,
                будь ласка, спробуйте пізніше: " . $ex, "contentBlock pink");
                }
            } else {
                $blocks[] = new CustomBlock("Вибачте, ми не можемо додати відгук, поле відгуку повинно містити щонайменьше 5 символів
                будь ласка, спробуйте знову", "contentBlock pink");
            }
        } else {
            $blocks[] = new CustomBlock("Вибачте, ми не можемо додати відгук, будь ласка вкажіть свій e-mail та спробуйте знову"
                , "contentBlock pink");
        }
    }

    try {
        $feedbacks = $db->get_feedback();
        foreach ($feedbacks as $feedback) {
            $blocks[] = new ContentBlock($feedback->getEmail(), $feedback->getFeedback() . "<br />
            <div class='righten'>".$feedback->getDatetime()."</div>");
        }
    } catch (Exception $ex ) {
        $blocks[] = new CustomBlock("Вибачте, ми не можемо отримати відгуки,
                будь ласка, спробуйте пізніше: " . $ex, "contentBlock pink");
    }

?>

<?php include_once 'forms/feedbackForm.php'; ?>

<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>



<?php include_once 'footer.php'; ?>