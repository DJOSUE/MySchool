<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UploadBulk extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }

    public function agreements_bulk()
    {
        $path   = $_FILES["upload_agreement"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $total  = 0;

        foreach($object->getWorksheetIterator() as $worksheet)
        {
           $highestRow = $worksheet->getHighestRow();
           $highestColumn = $worksheet->getHighestColumn();
           
            for($row=2; $row <= $highestRow; $row++)
            {

                $student_code   = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $student_id     = $this->studentModel->get_student_id($student_code);
                $year           = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                $semester_id    = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                
                $semester_enroll = $this->academic->get_semester_enroll($year, $semester_id);
                
                $agreement['student_id']        =   $student_id;
                $agreement['agreement_date']    =   $worksheet->getCellByColumnAndRow(1, $row)->getValue();                
                $agreement['tuition']           =   $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $agreement['scholarship']       =   $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $agreement['discounts']         =   $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $agreement['materials']         =   $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $agreement['fees']              =   $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $agreement['down_payment']      =   $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $agreement['modality_id']       =   $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                $agreement['book_type']         =   $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                $agreement['program_type_id']   =   $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                $agreement['number_payments']   =   $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                $agreement['payment_date']      =   $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                $agreement['automatic_payment'] =   $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                $agreement['year']              =   $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                $agreement['semester_id']       =   $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                $agreement['created_by']        =   $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                $agreement['created_by_type']   =   'admin';
                $agreement['is_imported']       =   1;

                $start_semester                 = $semester_enroll['start_date'];

                $agreement['semester_enroll_id'] = $semester_enroll['semester_enroll_id'];

                if($student_id != "")
                {
                    $total++;
                    $this->db->insert('agreement', $agreement);

                    $table      = 'agreement';
                    $action     = 'insert';
                    $agreement_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $agreement_id, $agreement);

                    $number = intval($agreement['number_payments']);
                    $payment_date = intval($agreement['payment_date']);

                    if( $number > 0)
                    {
                        $cell = 16;

                        $objDate = date_create($start_semester);
                        $month = intval(date_format($objDate, "m"));
                        $amortization_id = 0;

                        for($i=1; $i <= $number; $i++)
                        {
                            $date       = $year."-". $month ."-". $payment_date;
                            $due_date   = date_create($date);

                            $cell = $i + 16;

                            $amortization['agreement_id']       =   $agreement_id;
                            $amortization['amortization_no']    =   $i;
                            $amortization['amount']             =   $worksheet->getCellByColumnAndRow($cell, $row)->getValue();  
                            $amortization['due_date']           = date_format($due_date, "Y-m-d");

                            $this->db->insert('agreement_amortization', $amortization);

                            $table      = 'agreement_amortization';
                            $action     = 'insert';
                            $insert_id  = $this->db->insert_id();
                            $this->crud->save_log($table, $action, $insert_id, $amortization);

                            $amortization_id = $amortization_id == 0 ? $insert_id : $amortization_id;
                            
                            $month++;
                        }
                    }

                    // //Down_Payment

                    // $fees           = floatval($agreement['fees']);
                    // $materials      = floatval($agreement['materials']);
                    // $down_payment   = floatval($agreement['down_payment']);
                    // $scholarship    = floatval($agreement['scholarship']);
                    // $discounts      = floatval($agreement['discounts']);

                    // $payment        = floatval($worksheet->getCellByColumnAndRow(23, $row)->getValue());
                    // $payment_fee    = floatval($worksheet->getCellByColumnAndRow(24, $row)->getValue());                    

                    // $total          = ($fees + $materials + $down_payment + $payment_fee);
                    // $discount       = $number == 1 ? ($scholarship + $discounts) : 0;
                    // $total          = $total - $discounts; 
                    // $valid_payment  = $payment == $total;
                    
                    // $has_dow_payment = intval($worksheet->getCellByColumnAndRow(21, $row)->getValue());
                    // if($has_dow_payment == 1 && $valid_payment)
                    // {
                    //     $payment['invoice_number']  =   $this->payment->get_next_invoice_number();
                    //     $payment['invoice_date']    =   $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    //     $payment['user_id']         =   $student_id;
                    //     $payment['user_type']       =   'student';
                    //     $payment['amount']          =   $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    //     $payment['year']            =   $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    //     $payment['semester_id']     =   $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    //     $payment['created_by']      =   $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    //     $payment['created_by_type'] =  'admin';

                    //     $this->db->insert('payment', $payment);

                    //     $table      = 'payment';
                    //     $action     = 'insert';
                    //     $payment_id  = $this->db->insert_id();
                    //     $this->crud->save_log($table, $action, $payment_id, $payment);

                    //     // Payment details
                    //     if($materials > 0)
                    //     {
                    //         // payment_details Material/books = 2 
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '2';
                    //         $payment_details['amount']          = $materials;
                    //         // $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);
                    //     }

                    //     if($fees > 0)
                    //     {
                    //         // payment_details Fees = 3
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '3';
                    //         $payment_details['amount']          = $fees;
                    //         // $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);
                    //     }

                    //     if($payment_fee > 0)
                    //     {
                    //         // payment_details others Fees = 3
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '4';
                    //         $payment_details['amount']          = $payment_fee;
                    //         // $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);
                    //     }

                    //     if($payment > 0)
                    //     {   
                    //         // payment_details Tuition
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '1';
                    //         $payment_details['amount']          = $down_payment;
                    //         $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);
                    //     }

                    //     // Payment Discounts
                    //     if($number == 1 && $discount > 0)
                    //     {
                    //         // payment_details Tuition
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '1';
                    //         $payment_details['amount']          = $down_payment;
                    //         $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);

                    //         // payment_details Tuition
                    //         $payment_details['payment_id']      = $payment_id;
                    //         $payment_details['concept_type']    = '3';
                    //         $payment_details['amount']          = $down_payment;
                    //         $payment_details['amortization_id'] = $amortization_id;
                            
                    //         $this->db->insert('payment_details', $payment_details);

                    //         $table      = 'payment_details';
                    //         $action     = 'insert';
                    //         $insert_id  = $this->db->insert_id();
                    //         $this->crud->save_log($table, $action, $insert_id, $payment_details);
                    //     }
                    // }

                }

            }
        }

        //Result 

        $result = 'Number of rows: '.($highestRow - 1).'<br/>'.'Total Imported: '.$total.'<br/>';

        return $result;
    }

    public function enroll_bulk()
    {
        $path   = $_FILES["upload_enroll"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        $total  = 0;

        foreach($object->getWorksheetIterator() as $worksheet)
        {
           $highestRow = $worksheet->getHighestRow();
           $highestColumn = $worksheet->getHighestColumn();
           
            for($row=2; $row <= $highestRow; $row++)
            {

                $email      = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $student_id = $this->studentModel->get_student_id_by_email($email);

                $year           = $this->runningYear;
                $semester_id    = $this->runningSemester;
                $class_id       = html_escape($this->input->post('class_id'));
                $section_id     = html_escape($this->input->post('section_id'));

                $program_type_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $modality_id     = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                $subjects = $this->academic->get_subject_by_modality($class_id, $section_id, $modality_id);

                if($program_type_id == 1) 
                {

                }

                
            }
        }
    }
    
}
