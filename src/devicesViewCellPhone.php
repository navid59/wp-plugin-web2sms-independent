<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/web2sms.css">
</head>
<body>

<div class="smartphone">
  <div class="content">
    <div class="subcontent">
      <?php
      echo ($_SESSION['smsStrContent']);
      ?>
    </div>
  </div>
</div>

</body>
</html>
