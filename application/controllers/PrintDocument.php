<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class PrintDocument extends EduAppGT
    {
        /*
            Software:       MySchool - School Management System
            Author:         DHCoder - Software, Web and Mobile developer.
            Author URI:     https://dhcoder.com
            PHP:            5.6+
            Created:        22 September 2021.
        */

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 2023 05:00:00 GMT");

        }

        //Index function for Admin controller.
        function index()
        {
            $this->isLogin();
        }

        function print_agreement($agreement_id)
        {
            $this->isLogin();

            $id = base64_decode($agreement_id);
            $data = array(
                'agreement_id' => $id
            );
            $today = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/print/agreement.php',$data, TRUE); 
            $stylesheet = file_get_contents(base_url().'public/style/print/agreement.css');
            $pdfFilePath = "agreement_".$id.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-P', 0, '', 10, 10, 10, 10, 10, 'P'); 
            $mpdf->packTableData = true;
            
            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            // echo $html ;
        }

        function student_month_certificate($ids)
        {
            $id = base64_decode($ids);

            $data = array(
                'student_month_id' => $id
            );
            $today = date('d-m-Y_h_i');
            $html = $this->load->view('backend/print/student_month_certificate.php',$data, TRUE); 
            $stylesheet = file_get_contents(base_url().'/public/style/print/smc.css');
            $pdfFilePath = "agreement_".$id.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-L', 0, '', 0, 0, 0, 0, 0, 'L'); 
            $mpdf->packTableData = true;

            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            // echo $html ;
        }

        function student_month_certificate_all($month)
        {
            $id = intval(base64_decode($month));
            
            $html = "";
            $today = date('d-m-Y_h_i');
            $stylesheet = file_get_contents(base_url().'/public/style/print/smc.css');
            $pdfFilePath = "agreement_".$today.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-L', 0, '', 0, 0, 0, 0, 0, 'L'); 
            $mpdf->packTableData = true;
            
            $info = $this->db->get_where('v_student_month' , array('month' => $id))->result_array(); 

            foreach($info as $item)
            {
                $data = array(
                    'student_month_id' => $item['student_month_id']
                );                
                //$html .= $this->load->view('backend/print/vacation_request.php',$data, TRUE); 
                $html .= $this->load->view('backend/print/student_month_certificate.php',$data, TRUE); 
            }

            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            // echo $html ;
        }
        
        function student_certificate($info)
        {
            $dataInfo = explode('-', base64_decode($info));           

            $data = array(
                'student_id'    => $dataInfo[0],
                'class_id'      => $dataInfo[1],
                'section_id'    => $dataInfo[2],
                'year'          => $dataInfo[3],
                'semester_id'   => $dataInfo[4]
            );

            $today = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/print/student_certificate.php',$data, TRUE); 
            $stylesheet = file_get_contents(base_url().'/public/style/print/student_certificate.css');
            $pdfFilePath = "student_certificate.pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-L', 0, '', 0, 0, 0, 0, 0, 'L'); 
            $mpdf->packTableData = true;

            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            echo $html ;
        }

        function vacation_request($request_id)
        {
            $this->isLogin();

            $id = base64_decode($request_id);
            $data = array(
                'request_id' => $id
            );
            $today = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/print/vacation_request.php',$data, TRUE); 
            $stylesheet = file_get_contents(base_url().'public/style/print/vacation_request.css');
            $pdfFilePath = "vacation_request_".$id.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-P', 0, '', 10, 10, 10, 10, 10, 'P'); 
            $mpdf->packTableData = true;

            
            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            echo $html ;
        }

        function vacation_request_all($year, $semester_id)
        {
            $this->isLogin();
            
            $vacation_requests = $this->db->get_where('student_request', array('year' => $year, 'semester_id' => $semester_id, 'status' => 2))->result_array();

            $html = "";
            $stylesheet = file_get_contents(base_url().'public/style/print/vacation_request.css');
            $pdfFilePath = "vacation_request_all.pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'Letter-P', 0, '', 10, 10, 10, 10, 10, 'P'); 
            $mpdf->packTableData = true;

            foreach($vacation_requests as $item)
            {
                $data = array(
                    'request_id' => $item['request_id']
                );                
                $html .= $this->load->view('backend/print/vacation_request.php',$data, TRUE); 
            }

            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");

            echo $html ;
        }

        function print_invoice($param1)
        {
            $payment_id = base64_decode($param1);
            $data = array(
                'payment_id' => $payment_id
            );  

            // coder for CodeIgniter TCPDF Integration
            // make new advance pdf document
            $tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);              
            
            //set default header information
            
            $tcpdf->SetHeaderData(PDF_HEADER_LOGO, 195, '', '', array(0,0,0), array(255,255,255));

            $tcpdf->setFooterData(array(255,255,255), array(255,255,255));
            
            //set header  textual styles
            $tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            //set footer textual styles
            $tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            //set default monospaced textual style
            $tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // set default margins
            $tcpdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
            // Set Header Margin
            $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            // Set Footer Margin
            $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
            // set auto for page breaks
            $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            // set image for scale factor
            $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
            // it is optional :: set some language-dependent strings
            if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
            {
            // optional
            require_once(dirname(__FILE__).'/lang/eng.php');
            // optional
            $tcpdf->setLanguageArray($l);
            }
            
            // set default font for subsetting mode
            $tcpdf->setFontSubsetting(true);
            
            // Set textual style
            // dejavusans is an UTF-8 Unicode textual style, on the off chance that you just need to
            // print standard ASCII roasts, you can utilize center text styles like
            // helvetica or times to lessen record estimate.
            $tcpdf->SetFont('dejavusans', '', 14, '', true);
            
            // Add a new page
            // This technique has a few choices, check the source code documentation for more data.
            $tcpdf->AddPage();
            
            
            // set text shadow for effect
            $tcpdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,197,198), 'opacity'=>1, 'blend_mode'=>'Normal'));
            
            //Set some substance to print
            
            $set_html = $this->load->view('backend/print/payment_invoice.php',$data, TRUE);
            
            //Print content utilizing writeHTMLCell()
            $tcpdf->writeHTMLCell(0, 0, '', '', $set_html, 0, 1, 0, true, '', true);
            
            // Close and yield PDF record
            // This technique has a few choices, check the source code documentation for more data.
            $tcpdf->Output('tcpdfexample-onlinecode.pdf', 'I');
            // successfully created CodeIgniter TCPDF Integration
        }

        public function print_agreement_addendum($param1)
        {
            $agreement_id = base64_decode($param1);
            $data = array(
                'agreement_id' => $agreement_id
            );  

            // coder for CodeIgniter TCPDF Integration
            // make new advance pdf document
            $tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);              
            
            //set default header information
            
            $tcpdf->SetHeaderData(PDF_HEADER_LOGO, 195, '', '', array(0,0,0), array(255,255,255));

            $tcpdf->setFooterData(array(255,255,255), array(255,255,255));
            
            //set header  textual styles
            $tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            //set footer textual styles
            $tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            //set default monospaced textual style
            $tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // set default margins
            $tcpdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
            // Set Header Margin
            $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            // Set Footer Margin
            $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
            // set auto for page breaks
            $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            // set image for scale factor
            $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
            // it is optional :: set some language-dependent strings
            if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
            {
            // optional
            require_once(dirname(__FILE__).'/lang/eng.php');
            // optional
            $tcpdf->setLanguageArray($l);
            }
            
            // set default font for subsetting mode
            $tcpdf->setFontSubsetting(true);
            
            // Set textual style
            // dejavusans is an UTF-8 Unicode textual style, on the off chance that you just need to
            // print standard ASCII roasts, you can utilize center text styles like
            // helvetica or times to lessen record estimate.
            $tcpdf->SetFont('dejavusans', '', 14, '', true);
            
            // Add a new page
            // This technique has a few choices, check the source code documentation for more data.
            $tcpdf->AddPage();
            
            
            // set text shadow for effect
            $tcpdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,197,198), 'opacity'=>1, 'blend_mode'=>'Normal'));
            
            //Set some substance to print
            
            $set_html = $this->load->view('backend/print/print_addendum.php',$data, TRUE);
            
            //Print content utilizing writeHTMLCell()
            $tcpdf->writeHTMLCell(0, 0, '', '', $set_html, 0, 1, 0, true, '', true);
            
            // Close and yield PDF record
            // This technique has a few choices, check the source code documentation for more data.
            $tcpdf->Output('tcpdfexample-onlinecode.pdf', 'I');
            // successfully created CodeIgniter TCPDF Integration
        }
        
        //Check user is login session.
        function isLogin()
        {
            $array      = ['admin', 'teacher', 'student', 'parent', 'accountant', 'librarian'];
            $login_type = get_account_type();
            
            if (!in_array($login_type, $array))
            {
                redirect(base_url(), 'refresh');
            }
        }
    }