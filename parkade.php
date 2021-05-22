<html lang="ko-KR">
    <head>
        <meta charset="utf-8">
        <title>주차장 관리 시스템</title>
        <meta name="author" content="kimhantak">
        <meta name="description" content="parkade simulator">
        <style>
            * {
                font-family: monospace;
                font-weight: bold;
            }
            html {
                background-color: #2af3a6;
            }
            body {
                margin: 0;
            }
            .container {
                margin: 0 auto;
                max-width: 1000px;
                min-width: 1000px;
            }
            .modal-content {
                position: relative;
                width: 50px;
                height: 50px;
                padding: 5px;
                top: 10px;
                text-align: center;
                font-size: 18px;
                border-radius: 10px;
                background-color: lightcoral;
            }
            .modal-content:hover .modal-box {
                display: block;
            }
            .modal-box {
                display: none;
                position: fixed;
                text-align: left;
                background-color: white;
                border-radius: 10px;
                border: 2px dotted black;
                padding: 15px;
                font-size: 18px;
                line-height: 28px;
            }
            .modal-box span {
                color: red;
                text-decoration: underline;
            }
            fieldset,
            legend {
                border: 8px double rgb(139, 139, 139);
                border-radius: 10px;
                text-align: center;
            }
            legend {
                font-size: 32px;
                text-align: center;
            }
            input[type="submit"] {
                background-color: green;
                border: 1px solid black;
                border-radius: 10px;
                padding: 0px 5px;
                height: 40px;
                color: white;
            }
            input:hover,
            select:hover {
                background-color: lightgreen;
            }
            label {
                font-size: 12px;
            }
            input,
            select {
                background-color: rgb(196, 196, 196);
                padding: 5px;
                border-radius: 5px;
            }

            table {
                width: 100%;
                margin: 30px 0;
            }
            caption {
                font-size: 32px;
            }

            .customer-list th {
                width: 20%;
            }
            td.area {
                width: 20%;
                height: 200px;
                text-align: center;
            }
            th,
            td {
                padding: 5px;
            }


            footer {
                padding: 20px;
                background-color:rgb(139, 139, 139);
                text-align: center;
                font-size: 20px;
                color: white;
            }
        </style>
        <?php 
            /**
             * connect to localhost.
             * initial settings (create database, tables, ....)
             */
            $connect = mysqli_connect("localhost", "root", "") or die("Unable to connect to DB");
            $methods = [
                'create database if not exists parkade',
                'use parkade',
                'create table if not exists parking(
                    name varchar(30),
                    car_number int,
                    area_number int,
                    parking_time int,
                    parking_price int,
                    primary key(area_number)
                )',
                'create table if not exists parking_history(
                    name varchar(30),
                    car_number int,
                    area_number int,
                    parking_time int
                )'
            ];
            for ($i = 0; $i < 4; $i++) {
                if (!mysqli_query($connect, $methods[$i])) {
                    die("Failed initial settings");
                }
            }
            //---------------------------------------------------------------------------------------------
            
            /*
            *   parameter check 
            */
            $name = '';
            $number = 0;
            $parking = 0;
            $time = 0;
            $method = '';
            if (isset($_GET['name'], $_GET['number'], $_GET['parking'], $_GET['time'], $_GET['method'])) {
                $name = $_GET['name'];
                $number = $_GET['number'];
                $parking = $_GET['parking'];
                $time = $_GET['time'];
                $method = $_GET['method'];
            }
        ?>
    </head>
    <body>
        <div class="container">
            <div class="modal-content">
                <p>Tip!</p>
                <div class="modal-box">
                    <p>
                        <span>
                            이 시스템은 모든 사용자가 차가 
                            있음을 가정하며 주차 시간당 1,000원을 기준으로 한다.<br>
                            또한, 웹페이지는 1920x1080 해상도에 최적화 되어있다.
                        </span> 
                        <br>
                        사용법: <br>
                        입차시 <br>
                        - 우선, 성명과 차 번호 뒷자리(4자리),
                        주차한 자리 번호, 시간을 선택한다. <br>
                        - '<span>입력완료</span>'를 눌러 결과를 확인한다. <br>
                        출차시 <br>
                        - 성명과 시간은 제외하고 차 번호 뒷자리(4자리)와
                        주차한 자리 번호를 선택한다. <br>
                        - '<span>정산하기</span>'를 눌러 결과를 확인한다.
                    </p>
                </div>
            </div>
            <form action="parkade.php" method="GET">
                <fieldset>
                    <legend>무인 주차 관리 시스템</legend>
                    <label for="name">성명</label>
                    <input id="name" name="name">
                    <label for="number">차 번호(뒷자리 4개)</label>
                    <input id="number" name="number">
                    <label for="parking">주차 자리 번호</label>
                    <select id="parking" name="parking">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <label for="time">주차 시간</label>
                    <select id="time" name="time">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <br><br>
                    <input type="submit" name="method" value="입력완료">
                    <input type="submit" name="method" value="정산하기">
                </fieldset>
            </form>

            <table class="customer-list" border="1" cellspacing="0">
                <caption>주차 고객 리스트</caption>
                <tr>
                    <th>성명</th><th>차 번호(뒷자리)</th><th>자리 번호</th><th>주차 시간</th><th>주차 요금</th>
                </tr>
                <?php 
                    function park_customer_list($connect) {
                        $query = "select * from parking order by area_number";
                        $result = mysqli_query($connect, $query);
                        while ($line = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            foreach ($line as $column) {
                                echo "<td>" . $column . "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    if ($method == "입력완료") {
                        $price = 1000 * $time;
                        $query = "insert into parking values ('". $name ."',". $number .",". $parking .",". $time .",". $price .")";
                        mysqli_query($connect, $query);
                        park_customer_list($connect);
                    } else if ($method == "정산하기") {
                        $query = "select name, car_number, area_number, parking_time from parking where car_number = " . $number . " and area_number = " . $parking;
                        $result = mysqli_query($connect, $query);
                        $result = mysqli_fetch_assoc($result);
                        $query = "insert into parking_history values ('" . $result['name'] . "'," . $result['car_number'] . "," . $result['area_number'] . "," . $result['parking_time'] . ")";
                        mysqli_query($connect, $query);
                        $query = "delete from parking where car_number = " . $number . " and area_number = " . $parking;
                        mysqli_query($connect, $query);
                        park_customer_list($connect);
                    } else {
                        park_customer_list($connect);
                    }
                ?>
            </table>

            <table class="parkade-list" border="1" cellspacing="0">
                <caption>주차장 자리 탐색</caption>
                <!--TODO php code here-->
                <tr>
                    <?php 
                        $parking_array = [];
                        $query = "select * from parking order by area_number";
                        $result = mysqli_query($connect, $query);
                        while ($line = mysqli_fetch_assoc($result)) {
                            $parking_array[$line['area_number']] = $line;
                        }
                        for ($i = 1; $i <= 5; $i++) {
                            if (!empty($parking_array[$i])) {
                                echo "<td class='area'>" . 
                                    nl2br($i . "\n" . $parking_array[$i]['name'] . " (" . $parking_array[$i]['car_number'] . ")\n" . $parking_array[$i]['parking_price'] . " \\") 
                                    . "</td>";
                            } else {
                                echo "<td class='area'>" . ($i) . "</td>";
                            }
                        }
                    ?>
                </tr>
                <tr>
                    <td colspan="5" class="area"></td>
                </tr>
                </tr>
                <tr>
                    <?php 
                        for ($i = 6; $i <= 10; $i++) {
                            if (!empty($parking_array[$i])) {
                                echo "<td class='area'>" . 
                                nl2br($i . "\n" . $parking_array[$i]['name'] . " (" . $parking_array[$i]['car_number'] . ")\n" . $parking_array[$i]['parking_price'] . " \\")
                                    . "</td>";
                            } else {
                                echo "<td class='area'>" . ($i) . "</td>";
                            }
                        }
                    ?>
                </tr>
            </table>

            <table class="history-list" border="1" cellspacing="0">
                <caption>주차 기록 리스트</caption>
                <tr>
                    <th>성명</th><th>차 번호(뒷자리)</th><th>자리 번호</th><th>주차 시간</th>
                </tr>
                <?php 
                    $query = "select * from parking_history";
                    $result = mysqli_query($connect, $query);
                    while ($line = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        foreach ($line as $column) {
                            echo "<td>" . $column . "</td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </table>

            <footer>
                <p>&copy; Kim hantak</p>
            </footer>
        </div>
    </body>
</html>