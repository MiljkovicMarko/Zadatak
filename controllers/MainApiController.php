<?php
    namespace App\Controllers;

    class MainApiController extends \App\Core\ApiController {

        public function getStudentReport(int $id) {
            
            if ($id!==null)
            {
                $studentModel = new \App\Models\StudentModel($this->getDatabaseConnection());
                $gradeModel = new \App\Models\GradeModel($this->getDatabaseConnection());
                $student = $studentModel->getById($id);
                $grades = $gradeModel->getGradesByStudentId($id);
                if ($student->school_board==='CSM')
                {
                    $studentInfo=[];
                    foreach($student as $key => $val) {
                        if ($key!=='school_board'){
                            $studentInfo[$key]=$val;
                        }
                    }
                    $avg=0;
                    $gradesArray=[];
                    foreach($grades as $item) {
                        foreach($item as $key=>$val){
                            $t=intval($val);
                            array_push($gradesArray,$t);
                            $avg+=$t;
                        }
                    }
                    $avg/=count($gradesArray);
                    $studentInfo['grades']=$gradesArray;
                    $studentInfo['average']=$avg;
                    $studentInfo['result']=$avg>=7?'Pass':'Fail';
                    $studentInfo = json_encode($studentInfo);
                    ob_clean();
                    header('Content-type: application/json; charset=utf-8');
                    header('Access-Control-Allow-Origin: *');
                    echo $studentInfo;
                    exit;
                }
                if ($student->school_board ==='CSMB')
                {
                    $studentInfo=[];
                    foreach($student as $key => $val) {
                        if ($key!=='school_board'){
                            $studentInfo[$key]=$val;
                        }
                    }

                    $avg=0;
                    $gradesArray=[];
                    foreach($grades as $item) {
                        foreach($item as $key=>$val){
                            $t=intval($val);
                            array_push($gradesArray,$t);
                            $avg+=$t;
                        }
                    }
                    $avg/=count($gradesArray);
                    $studentInfo['grades']=$gradesArray;
                    $studentInfo['average']=$avg;
                    $pass='Fail';
                    foreach($gradesArray as $item){
                        if ($item>8)
                            $pass='Pass';
                    }
                    $studentInfo['result']=$pass;
                    $studentInfo = \App\Encoders\XMLEncoder::xmlEncode('student',$studentInfo);
                    ob_clean();
                    header('Content-type: text/xml');
                    header('Access-Control-Allow-Origin: *');
                    echo $studentInfo;
                    exit;
                }
                //send error
                return;
            }
            //send error
            return;
        }
    }
