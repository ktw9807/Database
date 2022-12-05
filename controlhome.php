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
form[value='main']{
  float: left;
  padding: 10px;
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
  <h2>관리 모드</h2>
</header>

<section>
  <nav>
    <ul>
      <li><h2>목록</h2></li>
      <li><a href="#" onclick="location.href='mainhome.php'">홈 화면</a></li>
      <br>
      <li><a href="#" onclick="location.href='infohome.php'">고객 정보</a></li>
      <br>
      <li><a href="#" style="color: brown;" onclick="location.href='controlhome.php'">관리 모드</a></li>
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
        
    <p>*특정 문자가 들어가면 모두 출력*</p>
    
    <form method="post" value='main'>
      <select name='밸류' method ="post" style="float: left; width: 90px; height: 22px;" >
        <option value="none">== 선택 ==</option>
        <option value="Number">주민번호</option>
        <option value="Name">이름</option>
        <option value="Tel">전화번호</option>
        <option value="Bank_id">예금계좌 ID (email)</option>
      </select>

      <input type='text2' name ='밸류2'  placeholder="Input some text.">

      <input type='submit' name='선택2' style="width: 50px; height: 22px;" value='검색'/>
    </form>

    <div style="overflow: scroll; width: 100%; height: 600px; padding: 10px;">
      <?php
            function sqlSearch(){
              
                $selected = $_POST['밸류'];
                $selected2 = $_POST['밸류2'];
       

                $con = mysqli_connect("localhost", "root", "", "Test");
                if($selected == 'Name'){
                  $sql = "select *, DATE_FORMAT(account_openDate, '%y-%m-%d') as account_openDate from client, account where client.client_id = account.client_id and client.client_name LIKE '%$selected2%' order by account.account_openDate";
                } else if($selected == 'Number'){
                  $sql = "select *, DATE_FORMAT(account_openDate, '%y-%m-%d') as account_openDate from client, account where client.client_id = account.client_id and client.client_id LIKE '%$selected2%' order by account.account_openDate";
                } else if($selected == 'Tel'){
                  $sql = "select *, DATE_FORMAT(account_openDate, '%y-%m-%d') as account_openDate from client, account where client.client_id = account.client_id and client.client_phoneNum LIKE '%$selected2%' order by account.account_openDate";
                } else if($selected == 'Bank_id'){
                  $sql = "select *, DATE_FORMAT(account_openDate, '%y-%m-%d') as account_openDate from client, account where client.client_id = account.client_id and client.client_email LIKE '%$selected2%' order by account.account_openDate";
                } else if($selected == 'none'){
                  $sql = "select *, DATE_FORMAT(account_openDate, '%y-%m-%d') as account_openDate from client, account where client.client_id = account.client_id order by account.account_openDate";
                }
                ?>

                <?php
                
                $result = mysqli_query($con, $sql);
                $count = 1;
                while($row = mysqli_fetch_array($result)){
                    $client_id         = $row["client_id"];
                    $client_name     = $row["client_name"];
                    $client_address       = $row["client_address"];
                    $client_email       = $row["client_email"];
                    $client_phoneNum       = $row["client_phoneNum"];
                    $client_job       = $row["client_job"];
                    $account_openDate = $row["account_openDate"];
                    $account_id       =$row["account_id"];
                    $account_balance  = $row["account_balance"];
                ?>
                    <span><?php echo $count?></span><span>. </span><span class="col2"><?=$client_name?></span><span> 고객님</span>
                    <span class="col1"><?=$client_id?></span><span> 번</span><br><br>
                    <span class="col3"><?=$client_address?></span>
                    <span class="col5"><?=$client_email?></span>
                    <span class="col6"><?=$client_phoneNum?></span>
                    <span class="col7"><?=$client_job?></span><br>
                    <span>계좌 정보 :</span>
                    <span class="col8"><?=$account_openDate ?></span><span> 개설, </span>
                    <span class="col9"><?=$account_id ?></span><span>, 잔고: </span>
                    <span class="col10"><?=$account_balance?></span> <span>원</span><br><br>
                    
            <?php
                    $count = $count + 1;
                }
              }

            ?>
        <?php
        if(isset($_POST["선택2"])){
          sqlSearch();
        }
        ?>
      
      </div>
      
  </article>
  
</section>



</body>
</html>