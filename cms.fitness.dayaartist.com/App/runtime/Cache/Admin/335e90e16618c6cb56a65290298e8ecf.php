<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<title>订单流程</title>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>

<center>
  <form method="post" action="<?php echo U(Process/checkCourse);?>">
    <h1 style="margin-top:200px">1.查看/预约课程</h1>
    <table>
      <table>
      <input type="radio" name="is_order" value='2' id='check1'>查看预约课程
      <input type="radio" name="is_order" value='1' id='check2'>预约课程
      <br><br>
      <tr>
        <td>是否私教：</td>
        <td><input type="text" name="is_private" value='2'></td>
      </tr>
      <tr>
        <td>课程id：</td>
        <td><input type="text" name="course_id" value='1'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;课程名称：</td>
        <td><input type="text" name="course_name"></td>
      </tr>
      <tr>
        <td>老师姓名：</td>
        <td><input type="text" name="teacher_name" value='孝文'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师电话：</td>
        <td><input type="text" name="teacher_tel" value='15936458953'></td>
      </tr>
      <tr>
        <td>开始时间：</td>
        <td><input type="text" name="start_time" value='1514764800'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束时间：</td>
        <td><input type="text" name="end_time" value=''></td>
      </tr>
      <tbody id='hiddens' style="display:none">
        <tr>
          <td>学生姓名：</td>
          <td><input type="text" name="student_name"></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：</td>
          <td><input type="text" name="contact_tel"></td>
        </tr>
        <tr>
          <td>人数：</td>
          <td><input type="text" name="num"></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：</td>
          <td><input type="text" name="price"></td>
        </tr>
      </tbody>
      <tr>
        <td>时间：</td>
        <td><input type="text" name="time" value='1512442368'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;appid : </td>
        <td><input type="text" name="appid" value='wyse0iljo4'></td>
      </tr>
      <tr>
        <td>token：</td>
        <td><input type="text" name="token" value='0iljo456lbn5bq9ms5fpl9uw57gdt77f'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sign：</td>
        <td><input type="text" name="sign" value='68c3d310a3443b506df2e758dab62b49464a6ab91b66d98092dfd5de224ce2de'></td>
      </tr>
      <tr>
        <td><input type="submit" value="下一步"></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>

<script type="text/javascript">
  $('#check1').on('click',function(){
    $('#hiddens').hide();
  })
  $('#check2').on('click',function(){
    $('#hiddens').show();
  })
</script>