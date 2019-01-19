<?php
require_once(__DIR__.'/admin/engine/sql.php');

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$gender = $_POST['sex'];
$age = $_POST['age'];

$user = q("SELECT id FROM users WHERE phone=?", [$phone]);

if(!$user){
    qi("INSERT INTO users (`name`, lastname, phone, sex, age, has_giyur, `status`) VALUES(?, ?, ?, ?, ?, ?, 'waiting_for_call')",
        [
            $name,
            $lastname,
            $phone,
            $gender,
            $age,
            0
        ]);

    echo ('{"type":"success", "text": "1"}');
} else {
    echo ('{"type":"error", "text": "Пользователь с таким номером телефона уже зарегистрирован"}');
}


?>