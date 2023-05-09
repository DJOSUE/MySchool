<?php 
    $system_name = $this->crud->getInfo('system_name');
    $system_email = $this->crud->getInfo('system_email');
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
    .button {
        background-color: #39A2D9;
        /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
    
    .invoice-w {
        font-family: "Proxima Nova W01", "Rubik", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        max-width: 800px;

        position: relative;
        overflow: hidden;
        padding: 100px;
        padding-bottom: 20px;
    }
    
    /* .invoice-w:before {
        width: 140%;
        height: 450px;
        background-color: #e6f7ff;
        position: absolute;
        top: -15%;
        left: -24%;
        -webkit-transform: rotate(-27deg);
        transform: rotate(-27deg);
        content: "";
        z-index: 1;
    } */
    
    .invoice-w .infos {
        position: relative;
        z-index: 2;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }
    
    .invoice-w .infos .info-1 {
        font-size: 1.08rem;
    }
    
    .invoice-w .infos .info-1 .company-name {
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
        margin-top: 10px;
    }
    
    .invoice-w .infos .info-1 .company-extra {
        font-size: 0.81rem;
        color: rgba(0, 0, 0, 0.4);
        margin-top: 1rem;
    }
    
    .invoice-w .infos .info-2 {
        padding-top: 140px;
        text-align: right;
    }
    
    .invoice-w .infos .info-2 .company-name {
        margin-bottom: 1rem;
        font-size: 1.26rem;
    }
    
    .invoice-w .infos .info-2 .company-address {
        color: rgba(0, 0, 0, 0.6);
    }
    
    .invoice-w .terms {
        font-size: 0.81rem;
        margin-top: 2.5rem;
    }
    
    .invoice-w .terms .terms-header {
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .invoice-w .terms .terms-content {
        color: rgba(0, 0, 0, 0.4);
    }
    
    .invoice-table thead th {
        border-bottom: 2px solid #333;
		width: 100%;
    }
    
    .invoice-table tbody tr td {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .invoice-table tbody tr:last-child td {
        padding-bottom: 40px;
    }
    
    .invoice-table tfoot tr td {
        border-top: 3px solid #333;
        font-size: 1.26rem;
    }
    
    .invoice-heading {
        margin-bottom: 4rem;
        margin-top: 3rem;
        position: relative;
        z-index: 2;
    }
    
    .invoice-heading h3 {
        margin-bottom: 0px;
    }
    
    .invoice-footer {
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-top: 6rem;
    }
    
    .invoice-footer .invoice-logo img {
        vertical-align: middle;
        height: 20px;
        width: auto;
        display: inline-block;
    }
    
    .invoice-footer .invoice-logo span {
        vertical-align: middle;
        margin-left: 10px;
        display: inline-block;
    }
    
    .invoice-footer .invoice-info span {
        display: inline-block;
    }
    
    .invoice-footer .invoice-info span+span {
        margin-left: 1rem;
        padding-left: 1rem;
        border-left: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .invoice-body {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    
    .invoice-body .invoice-desc {
        -webkit-box-flex: 0;
        -ms-flex: 0 1 250px;
        flex: 0 1 250px;
        font-size: 1.17rem;
    }
	.text-right {
        text-align: right !important;
    }
    </style>
</head>

<body style="margin:0px; background: #39a2d9; font-family: 'Rubik', sans-serif;">
    <div width="100%"
        style="background: #39a2d9; padding: 0px; line-height:28px; height:100%;  width: 100%; color: #606060; ">
        <div
            style="max-width: 700px; padding:0px;  margin: 2% auto; font-size: 14px; background: #fff; border-top: 5px solid #001b3d; border-radius: 4px;">
            <div style="vertical-align: top; padding-bottom:50px;padding-top:50px;border-bottom: 1px solid rgba(0, 0, 0, 0.1);background: #001b3d;"
                align="center"><a href="#"><img
                        src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logow');?>"
                        alt="<?php echo $system_name;?>" style="border:none;max-width:75%"></a></div>
            <div style="padding: 40px; background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p><?php echo $email_msg;?></p>
                                <span style="font-size: 16px; font-weight:bold"><?php echo $system_name;?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px; border-top: 1px solid rgba(0, 0, 0, 0.1); padding:5px;">
                <p> <img alt="" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                        style="vertical-align: middle; height: 20px; width: auto;"> <?php echo $system_name;?><br>
            </div>
        </div>
    </div>
</body>

</html>