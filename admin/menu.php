<?php
	$menu = array (
  0 => 
  array (
    'name' => 'Города',
    'icon' => 'globe',
    'link' => 'cities.php',
    'roles' => 'admin,coordinator',
    'visible' => 1,
  ),
  1 => 
  array (
    'name' => 'Координаторы',
    'icon' => 'user',
    'link' => 'coordinators.php',
    'roles' => 'admin',
    'visible' => 1,
  ),
  2 => 
  array (
    'name' => 'Комментарии',
    'icon' => '',
    'link' => 'comments.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  3 => 
  array (
    'name' => 'Документы',
    'icon' => 'passport',
    'link' => 'documents.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  4 => 
  array (
    'name' => 'Фотографии',
    'icon' => '',
    'link' => 'photos.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  5 => 
  array (
    'name' => 'Анкеты краткие',
    'icon' => 'users',
    'link' => 'index.php',
    'roles' => 'admin,coordinator',
    'visible' => 1,
  ),
  6 => 
  array (
    'name' => 'Без свиданий',
    'icon' => 'users',
    'link' => 'users_without_dates.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  7 => 
  array (
    'name' => 'Анкеты полные',
    'icon' => 'users',
    'link' => 'users.php',
    'roles' => 'admin,coordinator',
    'visible' => 1,
  ),
  8 => 
  array (
    'name' => 'Ждут звонка',
    'icon' => 'users',
    'link' => 'users_call.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  9 => 
  array (
    'name' => 'Свидания',
    'icon' => 'calendar',
    'link' => 'dates.php',
    'roles' => 'admin,coordinator',
    'visible' => 1,
  ),
  10 => 
  array (
    'name' => 'Прошедшие свидания',
    'icon' => 'calendar',
    'link' => 'dates_old.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
  11 => 
  array (
    'name' => 'Подтверждение документов',
    'icon' => 'users',
    'link' => 'users_check.php',
    'roles' => 'admin,coordinator',
    'visible' => 0,
  ),
);
	$project_name = 'Шидух'; 

	$project_wireframe = '0'; 

	$mysql_user_table = 'coordinators'; 

	$mysql_user_login = 'login'; 

	$mysql_user_pass = 'pass'; 

	$mysql_user_role = 'role'; 

	$auth_bg = 'http://storage.alef.im/uploads/1542285979_2a5fcccffe12e7ab23287906796259bd'; 

	$auth_bg_block = 'http://storage.alef.im/uploads/1542285974_26380bcc269f8bde177d0d87089046f8'; 

	$logo = 'http://storage.alef.im/uploads/1540756755_2d312e8fb4657d233bc696e9fb29d428'; 

	$login_validation = ''; 

	$project_tint = '#1DA1F2'; 
