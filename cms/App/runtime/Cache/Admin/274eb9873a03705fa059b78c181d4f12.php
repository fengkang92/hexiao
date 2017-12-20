<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<title>3.第三方支付完成</title>
<script src="jquery.min.js"></script>
</head>
<body>

<center>
  <form method="post" action="<?php echo U(Process/payOver);?>">
    <h1 style="margin-top:200px">3.第三方支付完成</h1>
    <table>
      <tr>
        <td>交易号：</td>
        <td><input type="text" name="trade_no" value='201712051636258079'></td>
      </tr>
      <tr>
        <td>状态</td>
        <td><input type="text" name="status" value='1'></td>
      </tr>
      <tr>
        <td>appid：</td>
        <td><input type="text" name="appid" value='wyse0iljo4'></td>
      </tr>
      <tr>
        <td>时间戳</td>
        <td><input type="text" name="time" value='1512442368'></td>
      </tr>
      <tr>
        <td>token</td>
        <td><input type="text" name="token" value='0iljo456lbn5bq9ms5fpl9uw57gdt77f'></td>
      </tr>
      <tr>
        <td>sign</td>
        <td><input type="text" name="sign" value='03620d88293c86f0f430ddf1e6a1ad3419ea1ce0b8487ffdebe5d3915f2e6ef4'></td>
      </tr>
      <tr>
        <td><input type="submit" value="下一步"></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>