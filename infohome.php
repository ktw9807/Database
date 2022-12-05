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
form {
    float: left;
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
  <h2>고객 정보</h2>
</header>

<section>
  <nav>
    <ul>
      <li><h2>목록</h2></li>
      <li><a href="#" onclick="location.href='mainhome.php'">홈 화면</a></li>
      <br>
      <li><a href="#" style="color: brown;" onclick="location.href='infohome.php'">고객 정보</a></li>
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

    <form method="post" value='main'>
      
      <h1>가급적이면 모두 입력해주세요.</h1>
      <p>주민번호와 이름 모두 입력시 총 사용금액의 조회가 가능합니다.</p>
      <input type='text2' name ='밸류2'  placeholder="주민번호">
      <input type='text2' name ='밸류3'  placeholder="고객 이름">
      <input type='submit' name='선택2' style="width: 50px; height: 22px;" value='검색'/>
    </form>


    <?php
        function sqlSearch()
        {
    ?>
            <div style="overflow: scroll; width: 100%; height: 600px; padding: 10px;">
            <?php
  
                $ID = $_POST['밸류2'];
                $NAME = $_POST['밸류3'];
                $con = mysqli_connect("localhost", "root", "", "Test");
                if($ID == '' && $NAME == ''){
                  echo "최소 하나는 입력해주세요!";
                } else if($ID == ''){
                  echo "현재까지의 사용금액 조회를 위해서는 주민번호와 이름 모두 입력해주세요!";
            ?>
                  <br><br>
            <?php
                  $sql = "select card_id, card_type, account.account_id, client.client_id, client.client_name, card_limit, account.account_balance
                  from client, card, account, transaction
                  where client.client_id = card.client_id and 
                        card.account_id = account.account_id and
                        account.account_id = transaction.account_id and
                  client.client_name LIKE '%$NAME%'
                  
                  ";

                } else if($NAME ==''){
                  echo "현재까지의 사용금액 조회를 위해서는 주민번호와 이름 모두 입력해주세요!";
            ?>
                  <br><br>
            <?php
                  $sql = "select card_id, card_type, account.account_id, client.client_id, client.client_name, card_limit, account.account_balance
                  from client, card, account, transaction
                  where client.client_id = card.client_id and 
                        card.account_id = account.account_id and
                        account.account_id = transaction.account_id and
                  client.client_id LIKE '%$ID%'";
                } else {
                  $sql = "select card_id, card_type, account.account_id, client.client_id, client.client_name, card_limit, DATE_FORMAT(transaction_dwDate, '%y-%m-%d') as transaction_dwDate, transaction_transNum, transaction_classification, transaction_details, transaction_transAmount, account.account_balance 
                  from client, card, account, transaction
                  where client.client_id = card.client_id and 
                        card.account_id = account.account_id and
                        account.account_id = transaction.account_id and
                  client.client_id LIKE '%$ID%' and client.client_name LIKE '%$NAME%'";
                  $sql2 = "select card_id, card_type, account.account_id, client.client_id, client.client_name, card_limit, sum(transaction_transAmount) as costSum
                  from client, card, account, transaction
                  where client.client_id = card.client_id and 
                        card.account_id = account.account_id and
                        account.account_id = transaction.account_id and
                  client.client_id LIKE '%$ID%' and client.client_name LIKE '%$NAME%'";
                }
                
                $result = mysqli_query($con, $sql);
                $temp = null;
                while($row = mysqli_fetch_array($result)){
                    $client_id = $row["client_id"];
                    $client_name = $row["client_name"];
                    $card_id = $row["card_id"];
                    $card_type = $row["card_type"];
                    $account_id = $row["account_id"];
                    $card_limit = $row["card_limit"];
                    


                    $transaction_dwDate= $row["transaction_dwDate"];
                    $transaction_transNum= $row["transaction_transNum"];
                    $transaction_classification= $row["transaction_classification"]; 
                    $transaction_details= $row["transaction_details"];
                    $transaction_transAmount= $row["transaction_transAmount"];
                    $account_balance = $row["account_balance"];
            ?>
                    <?php
                    if($temp!=  $account_id){
                    ?>
                      <br><br><span>## </span><span class="col4"><?=$client_id?></span><span>, </span>
                      <span class="col5"><?=$client_name?></span><span> 고객님 ##</span><br>
                      <span>카드 id: </span><span class="col1"><?=$card_id?></span><br>
                      <span>카드 type: </span><span class="col2"><?=$card_type?></span><br>
                      <span>카드 한도: </span><span class="col2"><?=$card_limit?></span><span> 원</span><br>
                      <span>계좌 ID: </span><span class="col3"><?=$account_id?></span><br><br>
                      <span>현재 잔고: </span><span class="col11"><?=$account_balance?></span><span> 원</span><br><br>
                      <span>-------------------------</span> <br>
                      
                    <?php
                    }
                    $temp =  $account_id;
                    
                    if($transaction_dwDate !=''){
                      ?>
                    <span>거래 일자: </span><span class="col6"><?=$transaction_dwDate?></span><br>
                    <span>거래 번호: </span><span class="col7"><?=$transaction_transNum?></span><br>
                    <span>예금 구분: </span><span class="col8"><?=$transaction_classification?></span><br>
                    <span>예금 내용: </span><span class="col9"><?=$transaction_details?></span><br>
                    <span>거래 금액: </span><span class="col10"><?=$transaction_transAmount?></span><span></span><br>
                    <span>-------------------------</span><br>
                    <?php
                    $temp =  $account_id;
                    }
                    ?>
                    
            <?php
                }
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_array($result2);
                $transaction_transNumsum = $row2["costSum"];
                if($ID !='' && $NAME != ''){
            ?> 
                  <br><h1>총 사용 금액: </h1><span class="col2"><?=$transaction_transNumsum?></span><span> 원</span><br>
            <?php  
                  
                }
            ?>

                    
                    
                    
                    
         </div>
        <?php
        }


        if(isset($_POST["선택2"])){
          sqlSearch();
        }
        ?>
        
      
      
    
  </article>
</section>



</body>
</html>