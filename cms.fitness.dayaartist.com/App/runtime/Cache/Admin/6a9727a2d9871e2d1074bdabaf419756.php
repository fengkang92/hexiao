<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>编辑更新老师价格</title>
    <script src="jquery.min.js"></script>
</head>
<body>

<center>
    <form method="post" action="<?php echo U(CourseTeacher/editTeacherPrice);?>">
        <h1 style="margin-top:200px">编辑更新老师价格</h1>
        <table>
            <tr>
                <td>老师信息</td>
            </tr>
            <tr>
                <td>老师unique_id：</td>
                <td><input type="text" name="course_name" value="0"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师原名称：</td>
                <td><input type="text" name="discribe" value="30分钟学会弹钢琴"></td>
            </tr>
            <tr>
                <td>联系方式：</td>
                <td><input type="text" name="course_name" value="15510996092"></td>
            </tr>
            <tr>
                <td>课程价格：</td>
                <td><input type="text" name="price[]" value="300"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优惠价格：</td>
                <td><input type="text" name="discount[]" value="288"></td>
            </tr>
            <tr>
                <td><input type="submit" value="下一步"></td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>