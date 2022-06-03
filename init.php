<?php

    include_once 'database/MySQL.php';

    $mySql = new MySQL();
    $mySql->create_tables();

//
//    try {
//        $mySql->create_user_raw("Alexey", "employee");
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $mySql->create_user_raw("Alexey", "employee");
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $mySql->create_user_raw("Alexey", "not_exist");
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//
//    try {
//        $user = $mySql->login("Alexey", "123");
//        my_log("User logged in: " . $user);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $user = $mySql->login("Alexey123", "123");
//        my_log("User logged in: " . $user);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $index = $mySql->create_task_raw(1, 1, "Шапокляк ебучая", "Ебать ту хуйню, що я сделал");
//        my_log("Task created with index: " . $index);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $index = $mySql->create_task_raw(1, 10, "Шапокляк ебучая", "Ебать ту хуйню, що я сделал");
//        my_log("Task created with index: " . $index);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $task = $mySql->get_task(4);
//        my_log("Task with id 4: " . $task);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }
//
//    try {
//        $task = $mySql->get_task(3);
//        my_log("Task with id 3: " . $task);
//    } catch (Exception $ex) {
//        my_log("Exception: " . $ex->getMessage());
//    }






?>