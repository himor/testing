Сервис тестирования для внутренних нужд CityAds. :octocat:

## Разворачивание проекта

1. Для Production Environment создать файл .env.php в корневой папке.
Файл должен содержать настройки соединения с БД.
Пример файла:

	<?php
	/**
	 * Configuration for the database
	 */
	return array (
		'DB_HOST' => '10.10.1.1',
		'DB_NAME' => 'dbname',
		'DB_USER' => 'username',
		'DB_PASW' => 'password'
	);
	?>

Аналогичный файл требуется создать для Local Environment с именем .env.local.php
Окружение настраивается в файле bootstrap\start.php

2. Запустить composer, при этом будут установлены все вендоры и настроены autoload

	composer.phar install

3. Сгенерировать БД с помощью команды (не делать на бою!)

	php artisan migrate

4. Первичные данные в девелоперскую базу можно внести с помощью команды (не делать на бою!)

	php artisan db:seed