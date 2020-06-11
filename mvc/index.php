<!-- index.php -->

<!-- //tao mo hinh mvc cho chuc nang quan ly sinh vien, co cau truc thu muc sau:
//mvc
//    /assets: chua tat ca cac thu muc lien qua den front-end
//          /css: chua cac file .css
//          /js: chua cac file .js
//          /images:chua cac anh
//    /configs: chua cac file cau hinh cua he thong nhu db, config
//          /database.php : chua ca hang ket noi csdl
//    /controller: chua cac class controller( C trong MVC)
//            /StudentController.php
//    /models: chua cac class model(M trong MVC)
//             /Student.php
//    /views: chua cac views (V trong MVC)
//          /students/
//                  /create.php: them moi sinh vien
//                  /update.php: sua sinh vien
//                  /delete.php: xoa
//                  //index.php: liet ke sinh vien
//  index.php: file index goc cua ung dung
//  /.htaccess: file thuong duung cho rewrite url -->


<?php

session_start();
//mvc/index.php
//file index goc cua ung dung, co tac dung phan tich url tu user de goi dung controller va action tuong ung
//vd: user muon truy cap trang liet ke sinh vien
// thi dev can phai biet la chuc nang liet ke sinh vien nay la do class controller nao va phuong thuc tuong ung nao dang xu ly
//do mo hinh mvc la do chinh ban tu xay dung cau truc, nen viec quy dinh url tren he thong cua ban bat buoc phai tu dua ra 1 chuan url
//url theo mo hinh mvc hien tai se co kieu nhu sau:
//url sau tuong ung voi chuc nang liet ke sinh vien
//index.php?controller=student&acion=index
//khoi tao session va set mui gio chuan
date_default_timezone_set('Asia/Ho_Chi_Minh');

//phan tich url de lay ra controller va action
//index.php?controller=student&acion=index
//neu co truyen tham so controller thi gan $_GET tuong ung, con neu ko truyen thi mac dinh la StudentController
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'student';
//student

//lay gia tri cua action (ten phuong thuc cua class tu url
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
//thuc hien chuyen doi controller thanh ten class controller da tao  StudentController
$controller = ucfirst($controller); //
$controller .= "Controller"; //StudentController

//chuyen doi tiep thanh dung ten file, gan them chuoi .php
//muc dich de nhung file controller do vao
$path_controller = "controllers/$controller.php";
//controllers/StudentController.php

//kiem tra neu duong dan tren ko ton tai, thi se bao not Found'

if (!file_exists($path_controller)) {
    die('Trang ban tim ko ton tai');
}
//goi file controller vao 
require_once "$path_controller";

//sau khi nhung dc class controller, thi se tien hanh khoi tao doi tuong
//khoi tao doi tuong tu class, va goi phuong thuc tuong ung
$object = new $controller;

//can check neu nhu action khong ton tai thi bao loi

if (!method_exists($object, $action)) {
    die("khong ton tai phuong thuc $action trong class $controller");
}

$object->$action();

//do dang la mo hinh mvc, nen tat ca url tren he thong deu chay tu file index.php goc cua ung dung