<div class="centred contentBlock">

    <div class="half-sized grid-vertical">
        <form enctype="multipart/form-data" action="/showTask.php?id=<?= $task_id?> ", method="post">
            <div class="grid-vertical-item from-fields">
                <label for="report">Додати файл звіту:</label><br>
                <input type="file" name="report" id="report">
            </div>

            <div class="grid-vertical-item from-fields">
                <input type="submit" value="Відправити звіт">
            </div>
        </form>
    </div>
</div>


