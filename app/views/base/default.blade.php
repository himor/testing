<!doctype html>
<html class="no-js" lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <base href="<?php echo URL::to('/'); ?>">
        <title>Схема офиса CityAds</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <?php echo Assets::css(); ?>
    </head>
    <body>
    	<header>
    		<div class="logotype"></div>
    		@if ($add)
            <p></p>
            @else
            <p>THE MAP</p>
            @endif
            <div id="autocomplete" class="autocomplete">
                <input type="text" placeholder="Поиск сотрудника" />
            </div>
    	</header>

        @if ($edit)
        <div id="settings">
            <div class="info"></div>
            <button class="rotate">Повернуть</button>
            <hr />
            <ul>
                <li>Чтобы сбросить все текущие изменения, <a href="javascript:history.go(0)">обновите страницу</a>.</li>
                <li>Чтобы сохранить расположение текущего сотрудника нажмите «сохранить».</li>
                <li>Чтобы сохранить расположение всех сотрудников нажмите «сохранить всех».</li>
            </ul>
            <hr />
            <button class="save">Сохранить</button><hr />
            <button class="saveall" style="color: #f00">Сохранить всех</button> 
        </div>
        @endif

        <div id="user" class="user">
            <table>
                <tbody>
                    <tr>
                        <td width="180" valign="top">
                            <div class="user__photo"></div>
                            <div class="user__contacts"></div>
                        </td>
                        <td valign="top">
                            <div class="user__name"></div>
                            <div class="user__info"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer>
            <div class="wrap">
                <div class="list">
                    <h3 data-location="F"><span class="icon icon-red">F</span> Департамент по операциям и финансам</h3>
                    <ul>
                        <li data-location="F02">Юридический отдел</li>
                        <li data-location="F01">Финансовый отдел</li>
                        <li data-location="F03">Бухгалтерия</li>
                        <li data-location="F04">Отдел по управлению персоналом</li>
                        <li data-location="F05">Административно-хозяйственный отдел</li>
                    </ul>
                    <h3 data-location="I"><span class="icon icon-blue">i</span> Департамент производства</h3>
                    <ul>
                        <li data-location="I01">Отдел технической интеграции</li>
                        <li data-location="I02">Отдел дизайна</li>
                    </ul>
                </div>
                <div class="list">
                    <h3 data-location="P"><span class="icon icon-yellow">P</span> Департамент по развитию партнерской сети</h3>
                    <ul>
                        <li data-location="P01">Отдел по развитию партнерской сети</li>
                        <li data-location="P02">Отдел технической поддержки</li>
                    </ul>
                    <h3 data-location="IT"><span class="icon icon-darkblue">IT</span> Департамент IT</h3>
                    <ul>
                        <li data-location="IT01">Отдел тестирования</li>
                        <li data-location="IT02">Отдел эксплуатации</li>
                        <li data-location="IT03">Отдел разработки</li>
                    </ul>
                </div>
                <div class="list">
                    <h3 data-location="S"><span class="icon icon-green">S</span> Департамент продаж</h3>
                    <h3 data-location="AC"><span class="icon icon-purple">Ac</span> Департамент аккаунтинга</h3>
                    <h3 data-location="AR"><span class="icon icon-pink">Ar</span> ART Директор</h3>
                    <h3 data-location="PJ"><span class="icon icon-grey">Pj</span> Проектный департамент</h3>
                    <h3 data-location="PR"><span class="icon icon-tomato">PR</span> PR директор</h3>
                </div>
                <div class="list">
                    <h3 data-location="MR"><span class="icon icon-rooms">MR</span> Переговорные комнаты</h3>
                    <div class="list-rooms">
                        <h3 data-location="MR02"><span class="icon icon-rooms icon-light">2</span> Сан-Пауло</h3>
                        <h3 data-location="MR03"><span class="icon icon-rooms icon-light">3</span> Москва</h3>
                        <h3 data-location="MR04"><span class="icon icon-rooms icon-light">4</span> Киев</h3>
                        <h3 data-location="MR05"><span class="icon icon-rooms icon-light">5</span> Алматы</h3>
                        <h3 data-location="MR06"><span class="icon icon-rooms icon-light">6</span> Гонконг</h3>
                    </div>
                </div>
            </div>
        </footer>

        <script type="text/javascript">
        var url = "{{ URL::route('employees.update') }}";

        var config = {
            data: {
                staff: {{ $employees }},
                specialties: {{ $specialties }},
                departments: {{ $departments }},
                groups: {{ $groups }}
            },
            @if ($edit)
            edit: true,
            @else
            edit: false,
            @endif
            @if ($add)
            addNew: true,
            @else
            addNew: false,
            @endif
            floorColor: 0xdddddd,
            floorDoubleSide: false,
            cameraZoom: {
                min: @if ($edit) 0 @else 800 @endif,
                max: 2500
            },
            startCameraPosition: {
                x: 0,
                y: -2500,
                z: 2500
            },
            helper: false, // Отобразить оси и сетку
            debug: false, // Выводить данные для дебага,
            showUser: @if ($user) {{ $user }} @else false @endif
        };

        window.onload = function () {
            loadMap();
        }
        </script>

        <?php echo Assets::js(); ?>
    </body>
</html>