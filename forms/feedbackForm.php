<div class="centred contentBlock">

    <div class="half-sized grid-vertical">
        <form action="/feedback.php" method="post">
            <div class="grid-vertical-item from-fields">
                <label for="email">E-mail:</label><br>
                <input type="text" id="email" name="email" value="<?php
                    if(isset($_POST["email"])) {echo ($_POST["email"]);}
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


