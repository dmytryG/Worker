<?php include_once 'header.php'; ?>

<div class="contentBlock">
    <div class="contentHeader">
        Про проект
    </div>
    <div class="contentContent">
        Цей проект розробив Дмитро Голуб у рамках курсового проекту з технологій комп’ютерного проектування.
        Веб-додаток реалізує функціонал розподілу задач між виконавцями, а саме:
        Керівник видає роботу виконавцям, про що у кожного виконавця в особовому кабінеті
        з’являється персональне завдання. Виконавець виконує роботу та відправляє звіт
        до цієї роботи. Керівник приймає або відхиляє звіт. Якщо звіт відхилено робітник
        зобов'язаний виправити недоліки, та відправити звіт знову.
    </div>
</div>

<div class="contentBlock important">
    <div class="contentHeader">
        Перелік функцій, що були реалізовані
    </div>
    <div class="contentContent">
    <ul>
        <li>Функції усіх користувачів
            <ul>
                <li>Вхід у систему (заглушка)</li>
                <li>Форма зворотнього зв'язку</li>
                <li>Перегляд загальної інформації</li>
            </ul>
        </li>
        <li>Функції керівника
            <ul>
                <li>Створювати завдання та вказувати виконавця</li>
                <li>Переглядат надісланих виконавцем звітів</li>
                <li>Прийняття або відхилиння звітів</li>
                <li>Коментування звітів</li>
            </ul>
        </li>
        <li>Функції виконавця
            <ul>
                <li>Перегляд отриманих завдань</li>
                <li>Надсилання звіту про виконане завдання</li>
                <li>Перегляд коментарів керівника</li>
            </ul>
        </li>
    </ul>
    </div>
</div>




<?php include_once 'footer.php'; ?>