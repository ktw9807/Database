<!DOCTYPE html>
<html lang="en">
<head>
<title>Layout</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

@font-face {
    font-family: 'LeferiPoint-WhiteObliqueA';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2201-2@1.0/LeferiPoint-WhiteObliqueA.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}

body {
  font-family: 'LeferiPoint-WhiteObliqueA';
}

header {
  background-color:  cornflowerblue;
  padding: 20px;
  text-align: center;
  font-size: 35px;
  color: white;
}

nav {
  float: left;
  width: 20%;
  height: 1000px; 
  background: rgb(220, 220, 220);
  padding: 50px;
}

nav ul {
  list-style-type: none;
  padding: 0;
}

article {
  float: left;
  padding: 50px;
  width: 80%;
  background-color: whitesmoke;
  height: 1000px;
}

section:after {
  content: "";
  display: table;
  clear: both;
}

footer {
  background-color: white;
  padding: 10px;
  text-align: center;
  color: white;
}

/* 반응형으로 창이 작아지면 레이아웃이 자동정렬 됩니다. */
@media (max-width: 600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}
</style>
</head>
<body>

<header>
  <h2>은행 관리 프로그램</h2>
</header>

<section>
  <nav>
    <ul>
      <li><h2>목록</h2></li>
      <li><a href="#" style="color: brown;"onclick="location.href='mainhome.php'">홈 화면</a></li>
      <br>
      <li><a href="#" onclick="location.href='infohome.php'">고객 정보</a></li>
      <br>
      <li><a href="#" onclick="location.href='controlhome.php'">관리 모드</a></li>
      <br>
      <li><a href="#" onclick="location.href='fastinfo.php'">빠른 검색</a></li>
    </ul>

    <div style="position:absolute; bottom:100px">
      <p> 김민수 </p>
      <p> 김태우 </p>
      <p> 이한주 </p>
    </div>
  </nav>
  
  <article>
                <?php
                $con = mysqli_connect("localhost", "root", "", "Test");
                $sql = "SELECT
                client_name,
                client_address,
                DATE_FORMAT(client_birth, '%m-%d') as date, 
                client_birth + INTERVAL (YEAR(CURRENT_DATE) - YEAR(client_birth))     YEAR AS currbirthday,
                client_birth + INTERVAL (YEAR(CURRENT_DATE) - YEAR(client_birth)) + 1 YEAR AS nextbirthday
            FROM client
            ORDER BY CASE
                WHEN currbirthday >= CURRENT_DATE THEN currbirthday
                ELSE nextbirthday
                END"
                
                ?>
                <h1>다가오는 생일 고객님들</h1>
                <div style="overflow: scroll; width: 30%; height: 400px; padding: 10px;">
                <?php
                
                $result = mysqli_query($con, $sql);
                $count = 1;
                while($row = mysqli_fetch_array($result)){

                    $client_name         = $row["client_name"];
                    $client_address     = $row["client_address"];
                    $client_birth      = $row["date"];
                    $client_phoneNum       = $row["client_phoneNum"];
                    
                ?>
                  
                    <span><?php echo $count?></span><span>. </span><span class="col2"><?=$client_name?></span><span> 고객님</span>
                    <span><</span><span class="col3"><?=$client_address?></span><span>></span><br><span>생일: </span>
                    <span></span><span class="col5"><?=$client_birth?></span>
                    <span class="col6"><?=$client_phoneNum?></span><br><br>
                
                   
                    
                  
            <?php
            $count = $count + 1;
                }
                
            ?>
            </div>
  </article>
</section>


</body>
</html>