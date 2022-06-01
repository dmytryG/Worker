<div class="centred contentBlock">

    <div class="half-sized grid-vertical">
        <form action="/addTask.php">
            <div class="grid-vertical-item from-fields">
                <label for="caption">Заголовок задачі:</label><br>
                <input type="text" id="caption" name="caption" value="<?php
                    if(isset($_GET["caption"])) {echo ($_GET["caption"]);}
                ?>">
            </div>

            <div class="grid-vertical-item from-fields">
                <label for="employee">Виконавець:</label><br>
                <select name="employee" id="employee">
                    <?php foreach ($employees as $emloyee) : ?>
                    <option value="<?= $emloyee->getId() ?>"><?= $emloyee->getUsername() ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="grid-vertical-item from-fields">
                <label for="description">Опис задачі:</label><br>
                <textarea id="description" name="description"><?php
                        if(isset($_GET["description"])) {echo ($_GET["description"]);}
                    ?></textarea>
            </div>

            <div class="grid-vertical-item from-fields">
                <input type="submit" value="Додати задачу">
            </div>
        </form>
    </div>
</div>


