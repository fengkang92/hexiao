<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>添加课程老师</title>
    <script src="jquery.min.js"></script>
</head>
<body>

<center>
    <form method="post" action="<?php echo U(CourseTeacher/addCourseTeacher);?>">
        <h1 style="margin-top:200px">添加课程老师/价格绑定老师</h1>
        <table>
            <tr>
                <td>课程信息</td>
            </tr>
            <tr>
                <td>课程名称：</td>
                <td><input type="text" name="course_name" value="test30分钟学会弹钢琴"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;课程简介：</td>
                <td><input type="text" name="discribe" value="零基础也 能轻轻松松完整谈曲子"></td>
            </tr>
            <tr>
                <td>预约单位：</td>
                <td><input type="text" name="unit" value="课"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;课程详情：</td>
                <td><input type="text" name="content" value="商品详情"></td>
            </tr>
            <tr>
                <td>课程标签：</td>
                <td><input type="text" name="tag" value="弹钢琴"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;课程类型：</td>
                <td><input type="text" name="type" value="钢琴"></td>
            </tr>
            <tr>
                <td>提前预约时间：</td>
                <td><input type="text" name="advance" value="7"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;课程展示图：</td>
                <td><input type="text" name="main_img_url" value="http://cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"></td>
            </tr>
            <tr>
                <td>A老师信息</td>
            </tr>
            <tr>
                <td>老师名称：</td>
                <td><input type="text" name="teacher_name[]" value="coco1"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;教学经验：</td>
                <td><input type="text" name="experience[]" value="2-4年"></td>
            </tr>
            <tr>
                <td>适合人群：</td>
                <td><input type="text" name="students[]" value="零基础"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师介绍：</td>
                <td><input type="text" name="introduce[]" value="经验丰富"></td>
            </tr>
            <tr>
                <td>联系方式：</td>
                <td><input type="text" name="tel[]" value="15510996092"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师照片：</td>
                <td><input type="text" name="main_img_url[]" value="http://cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"></td>
            </tr>
            <tr>
                <td>课程价格：</td>
                <td><input type="text" name="price[]" value="300"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优惠价格：</td>
                <td><input type="text" name="discount[]" value="288"></td>
            </tr>
            <tr>
                <td>B老师信息</td>
            </tr>
            <tr>
                <td>老师名称：</td>
                <td><input type="text" name="teacher_name[]" value="coco2"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;教学经验：</td>
                <td><input type="text" name="experience[]" value="2-4年"></td>
            </tr>
            <tr>
                <td>适合人群：</td>
                <td><input type="text" name="students[]" value="零基础"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师介绍：</td>
                <td><input type="text" name="introduce[]" value="经验丰富"></td>
            </tr>
            <tr>
                <td>联系方式：</td>
                <td><input type="text" name="tel[]" value="15510996092"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;老师照片：</td>
                <td><input type="text" name="main_img_url[]" value="http://cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"></td>
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