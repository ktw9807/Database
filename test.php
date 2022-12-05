<?php
    $con = mysqli_connect("localhost", "root", "", "Test");
    $sql = "select * from user1";
    $result = mysqli_query($con, $sql);
    
    $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
      $Id         = $row["Id"];
      $Name1     = $row["Name1"];
      $Age       = $row["Age"];
      
    ?>

<span class="col4"><?=$Id?></span>
<span class="col5"><?=$Name1?></span>
<span class="col6"><?=$Age?></span>