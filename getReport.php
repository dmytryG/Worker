<?php include_once 'header.php'; ?>

    <div class="contentBlock important">
        <div class="contentHeader">
            Будьте обережні
        </div>
        <div class="contentContent">
            Завантажені файли можуть завдати школи вашому ком’ютеру, будь ласка, перевірте, що отриманий від виконавця звіт не містить вірусів
        </div>
    </div>

<?php
    include_once 'utils/Constants.php';
    include_once 'entity/Block.php';
    global $FILE_SAVE_PATH;
    $isLoggedIn = isset($_COOKIE["login"]) && isset($_COOKIE["user_status"]);
    $is_file_required = isset($_GET["filename"]);
    $blocks = array();

    if ($is_file_required && is_readable($FILE_SAVE_PATH . $_GET["filename"])) {
        $blocks[] = new CustomBlock("
                    <a href = \"" . $FILE_SAVE_PATH . $_GET["filename"] . "\" download>Завантажити файл</a>
                    <a href = \"" . $FILE_SAVE_PATH . $_GET["filename"] . "\" target=\"_blank\">Переглянути файл у новій вкладці</a>
                    ", "contentBlock bigButton");

    } else {
        $blocks[] = new CustomBlock("Вибачте, ми не можемо знайти звіт,
            будь ласка, спробуйте пізніше: ", "contentBlock pink");
    }

?>

<?php foreach ($blocks as $block) : ?>
    <?= $block ?>
<?php endforeach ?>



<?php include_once 'footer.php'; ?>