<?php
// # tao bang students co cac truong id, name, age, created_at
// CREATE table students(
//     id int(11) PRIMARY key AUTO_INCREMENT,
//     name varchar(50),
//         age int(11),
//         created_at timestamp DEFAULT CURRENT_TIMESTAMP
//     );

//PDO: PHP data object: la 1 chuan ket noi csdl theo co che hoan toan huong doi tuong
//PDO: cho phep ket noi vao nhieu csdl khac nhau trong khi mysqli chi cho phep ket noi vao csdl mysql
//thuc hien cac bc sau de ket noi csdl theo co che PDO

//1- KHoi tao ket noi
const DB_DSN = 'mysql:host=localhost;port=3306;dbname=buoi9;charset=utf8'; //chuoi khai bao data source name- thong tin chuoi ket noi theo co che PDO *NOTE: phai chinh xac khong dc thua thieu dau cach...
const DB_USERNAME = 'root';
const DB_PASSWORD = '';

//tao ra bien ket noi, la doi tuong cua class PDO- la class ma PHP da xay dung san cho viec ket noi csdl theo co che PDO
$connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
if (!$connection) {
    die("ket noi that bai");
}
echo "Thanh cong";

//csdl: day18, table: students- id, name, age, created_at
//1- Truy van Insert voi PDO
//khai bao cau truy van insert
//PDO se ho tro co che khai bao cac gia tri cua tung truing trong bang theo kieu placeholder(thamso)
//kieu placeholder nay se giup chong loi bao mat SQL injection ma khi su dung thu vien mysqli se rat de mac phai
//có thể truyền giá trị thật mà không cần tạo kiểu placeholder tuy nhiên ko bảo mật
$sql_insert = "insert into students(`name`,`age`) values(:name_p,:age_p)";
//tao doi tuong truy van
$obj_insert = $connection->prepare($sql_insert);
//gán các giá trị thật cho placeholder
//có bao nhiêu palcehokder thì mảng sẽ có từng đó phần tử tương ứng
$arr_insert = [

    ':name_p' => 'bon',
    ':age_p' => 18
];
//thực thi truy vấn
//với truy vấn indert, update, delete thì hàm execute se tra ve true, false
$isInsert = $obj_insert->execute($arr_insert);
//neu viec truy van that bi, co the dung ham debugDumpParams ben duoi ham execute de co them thong tin ve loi
//$debug =  $obj_insert->debugDumpParams()

// echo "<pre>";
// print_r($debug);
// echo "</pre>";
if ($isInsert) {
    echo "insert thanh cong";
} else
    echo "insert that bai";
//2 - Truy van update, update ban ghi voi id =1, set name = 'abc'
//tao cau truy van update theo kieu placeholder
//neu gia tri chac chan la so thi ko can placeholder vi loi bao mat SQL Injection thuong xay ra khi du lieu la chuoi
$sql_update = "update students set `name` = :name where id=1 ";
//tao doi tuong truy van
$obj_update = $connection->prepare($sql_update);
//tao 1 mang de gan gia tri cho cac placeholder trong cau truy van
$arr_update = [
    ':name' => "abc",
];
//thuc thi truy van,
$is_update = $obj_update->execute($arr_update);
if ($is_update) {
    echo "update thanh cong";
} else {
    echo "update ko thanh cong";
}

//delete
$sql_delete = "delete from students where id > 2";

//tao doi tuong truy van
$obj_delete = $connection->prepare($sql_delete);
//do cau truy van ko co placeholder nao ca nen bo qua buoc tao mang
//thuc thi truy van
$is_delete = $obj_delete->execute();

if ($is_delete) {
    echo "delete thanh cong";
} else
    echo "delete ko thanh cong";

//4: TRUY VAN SELECT theo co che PDO
//-truy van nhieu ban ghi, lay ra tat ca ban ghi dang co trong bang students
//tao cau truy van select
$sql_select_all = "select * from students";
//tao 1 doi tuong select
$obj_select_all = $connection->prepare($sql_select_all);
//thuc thi truy van, do khong co placeholder nen khong can khai bao mang
//do truy van select thi ham execute se ko tra ve true/false
//nen can thuc hien them 1 vai buoc de lay dc du lieu mong muon
$obj_select_all->execute();
//sau khi chay ham execute xong, thi bien $obj_select_all tuong duong nhu 1 doi tuong trung gian va se su dung doi tuong nay de lay ra manf du lieu mong muon
//phai truyen vao hang Fetch_assoc cua class PDO de mang tra ve la 1 mang ket hop, de thao tac hon
$students = $obj_select_all->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($students);
echo "</pre>";

//-truy van 1 ban ghi, lay ra thog tin ban ghi dang co id =1

$sql_select_one = "select * from students where id =1";

$obj_select_one =  $connection->prepare($sql_select_one);

$obj_select_one->execute();
//neu biet chac chan chi lay 1 ban ghi thi se dung fetch
$student = $obj_select_one->fetch(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($student);
echo "</pre>";

//truy van select lay thong tin theo cot
//vd: dem tong so ban ghi dang co trong bang students
$sql_select_count = "select count(id) as count_id from students";
$obj_select_count = $connection->prepare($sql_select_count);

$obj_select_count->execute();
//lay gia tri cua truong count_id su dung ham fetchColumn ma ko can thao tac voi mang nhu 2 th select tren
$count = $obj_select_count->fetchColumn();
echo "<pre>";
print_r($count);
echo "</pre>";