<html lang="ko-KR">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="kimhantak">
        <style>
            body {
                margin: 0;
                font-family: monospace, serif;    
                font-weight: bold;
                font-size: 24px;
            }
            .clear {
                clear: both;
            }
            .container {
                width: 80%;
                min-width: 400px;
                margin: 0 auto;
            }
            .adult {
                background-color:salmon;
            }
            .youth {
                background-color:rgb(196, 196, 22);
            }
            .kid {
                background-color:yellowgreen;
            }
            .adult,
            .youth,
            .kid {
                color: white;
            }

            .time {
                text-align: center;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                padding: 10px;
            }
            .time > .ampm div {
                color: coral;
                border: 3px solid coral;
                border-radius: 10px;
                padding: 3px;
                margin: 3px;
            }
            .time > .clock {
                letter-spacing: 5px;
            }
            .time > .ampm,
            .time > .clock {
                margin: 10px;
            }
            .ampm .opacity {
                filter: opacity(.5);
            }

            fieldset,
            legend {
                border-radius: 10px;
                border: 5px double coral;
                text-align: center;
                padding: 5px;
            }
            .pricelist {
                margin: 10px auto;
            }
            .pricelist caption,
            .pricelist th,
            .pricelist td {
                border: 3px solid coral;
                border-radius: 10px;
            }
            .pricelist caption,
            .pricelist tr {
                font-size: 24px;
            }
            .pricelist tr td p {
                text-align: right;
            }

            .orderlist {
                margin: 10px auto;
            }
            .orderlist caption {
                font-size: 24px;
                border: 3px solid coral;
                border-radius: 10px;
            }
            .orderlist select {
                padding: 5px;
                border-radius: 10px;
            }
            .orderlist select:hover {
                background-color: lightgray;
            }
            .orderlist tr td p {
                padding: 10px;
                border-radius: 10px;
                text-align: center;
                font-weight: bold;
            }

            .payment {
                margin: 10px auto;
                font-size: 24px;
            }
            .payment input {
                font-size: 20px;
            }
            .payment input[type="text"] {
                width: 100px;
                height: 30px;
            }
            .payment input[type="submit"] {
                background-color: blue;
                border-radius: 10px;
                padding: 5px;
                color: white;
                border: 2px solid lightgray;
            }
            .payment input[type="submit"]:hover {
                background-color: lightblue;
            }
            .payment .result {
                color: crimson;
            }

            .completelist {
                width: 100%;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }
            .clear {
                clear: both;
            }
            .box {
                width: 24%;
                text-align: center;
                margin: 2px 4px;
                color: lightgray;
            }
            .payclient {
                width: 100%;
                background-color: gray;
                padding: 2px 0; 
                margin: 2px 0;
                border-radius: 10px;
            }
            .ticketadult {
                width: 100%;
                padding: 2px 0; 
                margin: 2px 0;
                border-radius: 10px;
            }
            .ticketyouth {
                width: 100%;
                padding: 2px 0; 
                margin: 2px 0;
                border-radius: 10px;
            }
            .ticketkid {
                width: 100%;
                padding: 2px 0; 
                margin: 2px 0;
                border-radius: 10px;
            }
            .ticketprice {
                width: 100%;
                background-color: gray;
                padding: 2px 0; 
                margin: 2px 0;
                border-radius: 10px;
            }
            .left {
                margin-left: 30px;
                float: left;
            }
            .right {
                margin-right: 30px;
                float: right;
            }
        </style>
        <?php 
            $connect = mysqli_connect("localhost", "root", "") or die("Unable to connect to DB");

            $methods = [ 
                "create database if not exists virtuallotteworld",
                "use virtuallotteworld",
                "create table if not exists payment(
                    name varchar(50),
                    adult int,
                    youth int,
                    kid int,
                    sum int
                )"];
            
            for ($i = 0; $i < 3; $i++) {
                if (!mysqli_query($connect, $methods[$i])) {
                    die("Failed initial settings");
                }
            }

            $client = "";
            $adult_count = 0;
            $youth_count = 0;
            $kid_count = 0;
            $sum = 0;

            if (isset($_GET['client'], $_GET['adult'], $_GET['youth'], $_GET['kid'])) {
                $client = $_GET['client'];
                $adult_count = $_GET['adult'];
                $youth_count = $_GET['youth'];
                $kid_count = $_GET['kid'];

                $sum = $adult_count * 59000 + $youth_count * 52000 + $kid_count * 47000;

                $query = "insert into payment values 
                ('" . $client . "'," . $adult_count . "," . $youth_count . "," . $kid_count . "," . $sum . ")";

                if (!mysqli_query($connect, $query)) {
                    die("Failed insert");
                }
            }
        ?>
    </head>
    <body onload="startClock()">
        <div class="container">
            <header class="time">
                <div class="ampm">
                    <div class="opacity">오전</div>
                    <div class="opacity">오후</div>
                </div>
                <div class="clock"></div>
            </header>
            <article>
                <form action="virtuallotteworld.php" method="GET">
                    <fieldset>
                        <legend>놀이공원 입장료 계산기</legend>
                        <table class="pricelist">
                            <caption>가격표</caption>
                            <tr>
                                <th class="adult">성인</th>
                                <td>
                                    <p>
                                        성인 종일(종합이용권) 59,000원<br>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th class="youth">청소년</th>
                                <td>
                                    <p>
                                        청소년 종일(종합이용권) 52,000원<br>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th class="kid">어린이</th>
                                <td>
                                    <p>
                                        어린이 종일(종합이용권) 47,000원<br>
                                    </p>
                                </td>
                            </tr>
                            <div class="clear"></div>
                        </table>
                        <table class="orderlist">
                            <caption>계산하기</caption>
                            <tr>
                                <td>
                                    <p class="adult">성인</p>
                                </td>
                                <td>
                                    <select name="adult" class="adultpay" onchange="observe()">
                                        <option value="0" selected>0</option>
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
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="youth">청소년</p>
                                </td>
                                <td>
                                    <select name="youth" class="youthpay" onchange="observe()">
                                        <option value="0" selected>0</option>
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
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="kid">어린이</p>
                                </td>
                                <td>
                                    <select name="kid" class="kidpay" onchange="observe()">
                                        <option value="0" selected>0</option>
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
                                </td>
                            </tr>
                        </table>
                        <table class="payment">
                            <tr>
                                <td>
                                    <p>지불할 총 입장료:</p>
                                </td>
                                <td>
                                    <span class="result">0</span>(원)
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label for="payclient">결제자 이름 : </label>
                                    <input id="payclient" name="client" type="text" required>
                                    <input type="submit" value="결제하기">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
                <div class="completelist">
                    <script defer>
                        function reformat(value) {
                            value = "" + value;
                            var result = "" + value;
                            for (var i = value.length-3; i >= 1; i -= 3) {
                            result = value.substring(0, i) + "," + result.substring(i, result.length);
                            }
                            result = result + "원";
                            document.write(result);
                        }
                    </script>
                    <?php 
                        $query = "select * from payment";
                        $result = mysqli_query($connect, $query);

                        while ($line = mysqli_fetch_assoc($result)) {
                            echo "<div class='box'>";
                                echo "<div class='payclient'>" . $line['name'] ."</div>";
                                echo "<div class='ticketadult adult'>";
                                    echo "<div class='left'>
                                            어른
                                          </div>";
                                    echo "<div class='right'>" . 
                                            $line['adult'] .
                                         "</div>";
                                    echo "<div class='clear'></div>";
                                echo "</div>";
                                echo "<div class='ticketyouth youth'>";
                                    echo "<div class='left'>
                                            청소년
                                          </div>";
                                    echo "<div class='right'>" . 
                                            $line['youth'] .
                                         "</div>";
                                    echo "<div class='clear'></div>";
                                echo "</div>";
                                echo "<div class='ticketkid kid'>";
                                    echo "<div class='left'>
                                            어린이
                                          </div>";
                                    echo "<div class='right'>" . 
                                            $line['kid'] .
                                         "</div>";
                                    echo "<div class='clear'></div>";
                                echo "</div>";
                                echo "<div class='ticketprice'>" . "<script>" . "reformat(" . $line['sum'] . ");" . "</script>" . "</div>";
                            echo "</div>";
                        }
                    ?>
                    <!--
                    <div class="box">
                        <div class="payclient">김한탁</div>
                        <div class="ticketadult adult">
                            <div class="left">
                                어른
                            </div>
                            <div class="right">
                                1
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="ticketyouth youth">
                            <div class="left">
                                청소년
                            </div>
                            <div class="right">
                                10
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="ticketkid kid">
                            <div class="left">
                                어린이
                            </div>
                            <div class="right">
                                1
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="ticketprice">1548000</div>
                    </div> 
                    -->
                </div>
            </article>
        </div>
        <script>

            function startClock() {
                tick();
                setInterval(tick, 1000);
            }

            function tick() {
                var time = new Date();
                var element = document.querySelector(".clock");

                toggle();
                var hour = (time.getHours()-12 <= 0) ? time.getHours() : time.getHours() - 12;
                var minute = checkValid(time.getMinutes());
                var second = checkValid(time.getSeconds());

                element.innerHTML = format(hour, minute, second);

                function toggle() {
                    var elements = document.querySelector(".ampm").children;
                    var ampm = (time.getHours() < 12) ? 1 : 0;
                    if (ampm) { // am
                        elements[0].setAttribute("class", "");
                        elements[1].setAttribute("class", "opacity");
                    } else {    // pm
                        elements[0].setAttribute("class", "opacity");
                        elements[1].setAttribute("class", "");
                    }
                }
                function format(h, m, s) {
                    return h + ":" + m + ":" + s;
                }
                function checkValid(value) {
                    return (value < 10) ? "0" + value : value;
                }
            }

            function observe() {
                var adult = document.querySelector(".adultpay").value * 59000;
                var youth = document.querySelector(".youthpay").value * 52000;
                var kid = document.querySelector(".kidpay").value * 47000;

                var sum = adult + youth + kid;
                var dot = (sum > 0) ? format("" + sum) : 0;

                var element = document.querySelector(".result");
                element.textContent = dot;

                function format(value) {
                    var result = value;
                    
                    for (var i = value.length-3; i >= 1; i -= 3) {
                        result = value.substring(0, i) + "," + result.substring(i, result.length);
                    }
        
                    return result;
                }
            }
        </script>
    </body>
</html>