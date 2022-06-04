<div class="centred contentBlock">

    <div class="half-sized grid-vertical">
        <form action="/addTask.php">
            <div class="grid-vertical-item from-fields">
                <label for="email">E-mail:</label><br>
                <input type="text" id="email" name="email" value="<?php
                    if(isset($_GET["email"])) {echo ($_GET["email"]);}
                ?>">
            </div>

            <div class="grid-vertical-item from-fields">
                <label for="comment">Ваше питання/побажання:</label><br>
                <textarea id="comment" name="comment"></textarea>
            </div>

            <div class="grid-vertical-item from-fields">
                <input type="submit" value="Відправити форму">
            </div>
        </form>
    </div>
</div>


