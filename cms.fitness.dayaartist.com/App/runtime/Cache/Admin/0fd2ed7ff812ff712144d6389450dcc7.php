<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>修改预约课程时间</title>
    <script src="jquery.min.js"></script>
</head>
<body>

<center>
    <form method="post" action="<?php echo U(CourseTeacher/editTime);?>">
        <h1 style="margin-top:200px">修改预约课程时间</h1>
        <table>
            <tr>
                <td>锁定修改时间</td>
            </tr>
            <tr>
                <td>预约时间unique_id：</td>
                <td><input type="text" name="course_name" value="11"></td>
            </tr>
            <tr>
                <td>修改课程时间段</td>
            </tr>
            <tr>
                <td>开始时间：</td>
                <td><input type="text" name="course_name" value="1511170130"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;结束时间：</td>
                <td><input type="text" name="discribe" value="1511170130"></td>
            </tr>
            <tr>
                <td>上课人数：</td>
                <td><input type="text" name="course_name" value="4"></td>
            </tr>
            <tr>
                <td><input type="submit" value="下一步"></td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>