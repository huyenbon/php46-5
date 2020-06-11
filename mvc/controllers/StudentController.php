<?php
class StudentController
{
    //thuoc tinh luu thong tin dong cua tung view
    //trong file layout se hient hi ra thuoc tinh nay
    public $content;

    //phuong thuc render co tac dung lay noi dung tuong ung/\
    //de gan vao layout tuong ung
    //co 2 tham so
    //$file : duong dan toi file view tuong ung
    //$variables: cac bien ma su dung trong file view tren
    protected function render($file, $variables = [])
    {
        //giai nen bien $variables de $fille co the su dung 
        extract($variables);
        //bat dau tao ra 1 vung nho tam de ghi nho viec luu thong tin view cua $file
        ob_start();
        //nhung duong dan file $file vao de phuc vu cho qua trinh luu ben tren
        require_once "$file";
        //ket thuc viec luu thong tin file
        $render_view = ob_get_clean();

        return $render_view;
    }



    public function index()
    {
        //gan noi dung cho thuoc tinh content
        //tat ca duong dan file khi nhung deu phai dung tu file indext.php goc cua ung dung
        $this->content = $this->render('views/students/index.php');
        //goi layout tuong ung
        //trong file layout da co phan hien thi $this->content
        require_once 'views/layouts/main.php';

        // echo " day la phuong thuc index cua class StudentControler";
    }
}