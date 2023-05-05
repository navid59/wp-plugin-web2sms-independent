<?php session_start();?>
<link rel="stylesheet" href="../css/web2sms.css">
<div class="smartphone">
  <div class="content">
    <div class="subcontent">
      <?php
      echo ($_SESSION['smsStrContent']);
      ?>
    </div>
  </div>
</div>