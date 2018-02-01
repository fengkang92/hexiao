<?php

namespace Admin\Controller;

use Think\Controller;

class CourseTeacherController extends Controller
{
    /**
     *
     */
    public function addCourseTeacher()
    {
        if (IS_POST) {
            $data = [
                "appid" => 1,
                "AppKey" => "FIANDKFGY1DFB2AD",
                "time" => 1511170130,
                "sign" => "ADJVO8ASD9BSDS84GVF3AB",
                "type" => 1,
                "plan" => [
                    "course_name" => "test30分钟学会弹钢琴",
                    "discribe" => "零基础也 能轻轻松松完整谈曲子",
                    "unit" => "课",
                    "content" => "商品详情",
                    "tag" => "弹钢琴",
                    "type" => "钢琴",
                    "advance" => 7,
                    "main_img_url" => "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"
                ],
                "service" => [
                    [
                        "teacher_name" => "coco1",
                        "experience" => "2-4年",
                        "students" => "零基础",
                        "introduce" => "经验丰富",
                        "tel" => "110",
                        "main_img_url" => "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg",
                        "price" => 110,
                        "discount" => 100
                    ],
                    [
                        "teacher_name" => "coco2",
                        "experience" => "2-4年",
                        "students" => "零基础",
                        "introduce" => "经验丰富",
                        "tel" => "110",
                        "main_img_url" => "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg",
                        "price" => 110,
                        "discount" => 100
                    ]
                ]
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.addCourseAndTeracher';
            $res = curls($url, json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/addTeacherCourse'));
        } else {
            $this->display();
        }

    }

    public function addTeacherCourse()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 2,
                "service"=> [
                    "teacher_name"=> "coco1",
                    "experience"=> "2-4年",
                    "students"=> "零基础",
                    "introduce"=> "经验丰富",
                    "tel"=> "110",
                    "main_img_url"=> "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"
                ],
                "plan"=> [
                    [
                        "course_name"=> "test30分钟学会弹钢琴1",
                        "discribe"=> "零基础也 能轻轻松松完整谈曲子",
                        "unit"=> "课",
                        "content"=> "商品详情",
                        "tag"=> "弹钢琴",
                        "type"=> "钢琴",
                        "advance"=> 7,
                        "main_img_url"=> "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg",
                        "price"=> 110,
                        "discount"=> 100
                    ],
                    [
                        "course_name"=> "test30分钟学会弹钢琴2",
                        "discribe"=> "零基础也 能轻轻松松完整谈曲子",
                        "unit"=> "课",
                        "content"=> "商品详情",
                        "tag"=> "弹钢琴",
                        "type"=> "钢琴",
                        "advance"=> 7,
                        "main_img_url"=> "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg",
                        "price"=> 110,
                        "discount"=> 100
                    ]
                ]
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.addTeacherCourse';
            $res = curls($url, json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/addTime'));
        } else {
            $this->display();
        }

    }

    public function addTime()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "service_unique_id"=> 0,
                "server_name"=> "海辉",
                "tel"=> "13500001234",
                "time_unique_id"=> 0,
                "service_time"=> [
                    [
                        "start_time"=> 1511170130,
                        "end_time"=> 1511170130,
                        "initial_stock"=> 1
                    ],
                    [
                        "start_time"=> 1511170130,
                        "end_time"=> 1511170130,
                        "initial_stock"=> 2
                    ]
                ]
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.addTime';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/editCourse'));
        }else{
            $this->display();
        }

    }

    public function editCourse()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 1,
                "unique_id"=> 0,
                "course_name"=> "30分钟学会弹钢琴",
                "edit_course_name"=> "test30分钟学会弹钢琴2",
                "discribe"=> "零基础也 能轻轻松松完整谈曲子",
                "unit"=> "课",
                "content"=> "商品详情",
                "tag"=> "弹钢琴",
                "types"=> "钢琴",
                "advance"=> 7,
                "main_img_url"=> "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.editCourse';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/editCoursePrice'));
        }else{
            $this->display();
        }

    }

    public function editCoursePrice()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 1,
                "unique_id"=> 0,
                "server_name"=> "30分钟学会弹钢琴",
                "price"=> 100,
                "discount"=> 99
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.editCoursePrice';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/editTeacher'));
        }else{
            $this->display();
        }

    }

    public function editTeacher()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 1,
                "unique_id"=> 0,
                "teacher_name"=> "海辉",
                "tel"=> "13500001234",
                "edit_tel"=> "13500001234",
                "edit_teacher_name"=> "海辉",
                "experience"=> "2-4年",
                "students"=> "零基础",
                "introduce"=> "经验丰富",
                "main_img_url"=> "http=>//cms.joyfamliy.com/Data/UploadFiles/literature/product-class@14.jpg"
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.editTeacher';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/editTeacherPrice'));
        }else{
            $this->display();
        }

    }

    public function editTeacherPrice()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 2,
                "unique_id"=> 0,
                "server_name"=> "海辉",
                "tel"=> "13500001234",
                "price"=> 100,
                "discount"=> 99
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.editTeacherPrice';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/editTime'));
        }else{
            $this->display();
        }

    }

    public function editTime()
    {
        if (IS_POST) {
            $data = [
                "appid"=> 1,
                "AppKey"=> "FIANDKFGY1DFB2AD",
                "time"=> 1511170130,
                "sign"=> "ADJVO8ASD9BSDS84GVF3AB",
                "type"=> 1,
                "unique_id"=> 11,
                "start_time"=> 1511170130,
                "end_time"=> 1511170130,
                "initial_stock"=> 1
            ];
            $url = 'http://118.89.243.186/phalapi/public/index.php?s=course.editTime';
            $res = curls($url,json_encode($data));
            $this->success('成功', U('Admin/CourseTeacher/end'));
        }else{
            $this->display();
        }

    }

    public function end()
    {
        $this->display();

    }

    public function start()
    {
        $this->display();

    }

}
