<?php //include "component/config.php" ;

//For Local

$server = "localhost";
$username ="compuitu_wiz";
$password = "wiz@compuitusa";

$db_name =  "compuitu_crm_db";

/*$server = "localhost";
$username ="root";
$password = "";

$db_name =  "efficien_crm_db";*/

//For Master
$serverm = "107.180.57.7";
$usernamem ="wiz_master";
$passwordm = "wiz@master";

$db_namem =  "master_crm_db2";

/*$serverm = "localhost";
$usernamem ="root";
$passwordm = "";

$db_namem =  "master_crm_db2";*/

require('pdf/fpdf.php');

require_once ('class.phpmailer.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','BU',15);
    // Move to the right
    $this->Cell(80);
    
	// Line break
	 $this->SetFont('Arial','',10);
	$this->Cell(0,0,'Date :'.date("m/d/Y"),0,0,'R');
    $this->Ln(20);
}
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
}

}?>

<?php
date_default_timezone_set("US/Pacific");
$name  = $_POST['name'];
$email = $_POST['email'];
$ip    = $_POST['ip'];
$company = $_POST['company'];
$phone   = $_POST['phone'];
$fax     = $_POST['fax'];
$addr = $_POST['addr'];
$country    = $_POST['country'];
$state    = $_POST['state'];
$city    = $_POST['city'];
$zip    = $_POST['zip'];
$place    = $_POST['place'];
$pass = $_POST['pass'];
$sequ_question = $_POST['sequ_question'];
$sequ_answer = $_POST['sequ_answer'];
$alt_phn = $_POST['alt_phn'];
$area_code = $_POST['area_code'];
$agent = $_POST['agent'];
$plan = $_POST['plan'];
$noofcom =  $_POST['com_no'];
$sh_name =  $_POST['sh_name'];
$sh_company =  $_POST['sh_company'];
$sh_address =  $_POST['sh_address'];
$sh_city =  $_POST['sh_city'];
$sh_state =  $_POST['sh_state'];
$sh_zip =  $_POST['sh_zip'];
$paymode =  $_POST['paymode'];
$price  = $_POST['price'];
$comment  = $_POST['comment'];
$planyr = $_POST['plan_yr'];
$ref  = $_SERVER['HTTP_REFERER'];
$company_name='CompuITusa';

////  ----saignature ----/////

$imgsig = $_POST['sigdata'];
$imgsig = str_replace('data:image/png;base64,', '', $imgsig);
$imgsig = str_replace(' ', '+', $imgsig);
$datasig =$imgsig;
$curr_date=date("Y-m-d");
//if($paymode == 0)
//{
//	$cr_cardname  =  $_GET['cr_cardname'];
//	$cr_cardtype  =  $_GET['cr_cardtype'];
//	$cr_cardno  =  $_GET['cr_cardno'];
//	$cr_cvv  =  $_GET['cr_cvv'];
//	$cr_expmonth  =  $_GET['cr_expmonth'];
//	$cr_expyear  =  $_GET['cr_expyear'];
//
//}elseif($paymode == 1)
//{
//	$ec_bankname  =  $_GET['ec_bankname'];
//	$ec_name  =  $_GET['ec_name'];
//	$ec_acno  =  $_GET['ec_acno'];
//	$ec_transitno  =  $_GET['ec_transitno'];
//	$ec_chno  =  $_GET['ec_chno'];
//	
//	
//	
//}elseif($paymode == 2)
//{
//	$dc_cardname  =  $_GET['dc_cardname'];
//	$dc_cardtype  =  $_GET['dc_cardtype'];
//	$dc_cardno  =  $_GET['dc_cardno'];
//	$dc_cvv  =  $_GET['dc_cvv'];
//	$dc_startmonth  =  $_GET['dc_startmonth'];
//	$dc_startyear  =  $_GET['dc_startyear'];
//	$dc_expmonth  =  $_GET['dc_expmonth'];
//	$dc_expyear  =  $_GET['dc_expyear'];
//	
//}elseif($paymode == 3)
//{
//	
//}

///////---------------------------------------------------------//////

//For Local Database

$con  = mysql_connect($server,$username,$password);
mysql_select_db($db_name,$con);

$inscustqry = mysql_query("INSERT INTO `customer_details`(`cust_email`, `cust_name`, `cust_IP`, `cust_company`, `cust_phone`, `cust_fax`, `cust_address`, `cust_country`, `cust_state`, `cust_city`, `cust_zip`, `cust_wherefrom`, `cust_password`, `cust_seq_ques`, `cust_seq_ans`, `cust_altphone`, `cust_reg_date`) VALUES ('$email', '$name', '$ip', '$company', '$phone', '$fax', '$addr', '$country', '$state', '$city', '$zip', '$place', '$pass', '$sequ_question', '$sequ_answer', '$alt_phn', NOW())");

//For Master Database

$conm  = mysql_connect($serverm,$usernamem,$passwordm);
mysql_select_db($db_namem,$conm);

$inscustqry1 = mysql_query("INSERT INTO `customer_details`(`cust_email`, `cust_name`, `cust_IP`, `cust_company`, `cust_phone`, `cust_fax`, `cust_address`, `cust_country`, `cust_state`, `cust_city`, `cust_zip`, `cust_wherefrom`, `cust_password`, `cust_seq_ques`, `cust_seq_ans`, `cust_altphone`, `cust_reg_date`,`company_name`,`area_code`) VALUES ('$email', '$name', '$ip', '$company', '$phone', '$fax', '$addr', '$country', '$state', '$city', '$zip', '$place', '$pass', '$sequ_question', '$sequ_answer', '$alt_phn', NOW(),'$company_name','$area_code')");

if($inscustqry && $inscustqry1)
{
	//For Local Database
	
    $con  = mysql_connect($server,$username,$password);
    mysql_select_db($db_name,$con);
	
	$orderid  = "ORDCIT".strtoupper(substr(md5(date('r')).rand(),-5));
	$insorderqry = mysql_query("INSERT INTO `order_details`(`order_id`, `cust_email`, `cust_addr`, `cust_phone`, `agent_username`, `pay_mode`, `price`, `transaction_status`, `trans_date`, `plan`, `noofcom`, `comment`, `order_date`,`planyears`,`is_varified`,`trans_feedback`) VALUES ('$orderid', '$email', '$addr', '$phone', '$agent', '$paymode','$price', '0', NOW(), '$plan', '$noofcom', '$comment', NOW(),'$planyr','0','')");
	
	$shippingqry  =mysql_query("INSERT INTO `shipping_details`(`cust_email`, `shipping_name`, `shipping_company`, `shipping_addr`, `shipping_city`, `shipping_state`, `shipping_zip`) VALUES ('$email', '$name', '$sh_company', '$sh_address', '$sh_city', '$sh_state', '$sh_zip')");
	
	//For Master Database
	
    $conm  = mysql_connect($serverm,$usernamem,$passwordm);
    mysql_select_db($db_namem,$conm);
	
	//$orderid  = "ORDCIT".strtoupper(substr(md5(date('r')).rand(),-5));
	$insorderqry1 = mysql_query("INSERT INTO `order_details`(`order_id`, `cust_email`, `cust_addr`, `cust_phone`, `agent_username`, `pay_mode`, `price`, `transaction_status`, `trans_date`, `plan`, `noofcom`, `comment`, `order_date`,`planyears`,`company_name`,`area_code`) VALUES ('$orderid', '$email', '$addr', '$phone', '$agent', '$paymode','$price', '0', NOW(), '$plan', '$noofcom', '$comment', NOW(),'$planyr','$company_name','$area_code')");

    $shippingqry1  =mysql_query("INSERT INTO `shipping_details`(`cust_email`, `shipping_name`, `shipping_company`, `shipping_addr`, `shipping_city`, `shipping_state`, `shipping_zip`,`company_name`,`area_code`) VALUES ('$email', '$name', '$sh_company', '$sh_address', '$sh_city', '$sh_state', '$sh_zip','$company_name','$area_code')");	
	
	
	if($paymode == 0)
{
	$cr_cardname  =  $_POST['cr_cardname'];
	$cr_cardtype  =  $_POST['cr_cardtype'];
	$cr_cardno  =  $_POST['cr_cardno'];
	$cr_cvv  =  $_POST['cr_cvv'];
	$cr_expmonth  =  $_POST['cr_expmonth'];
	$cr_expyear  =  $_POST['cr_expyear'];
	
	//For Local Database
	
    $con  = mysql_connect($server,$username,$password);
    mysql_select_db($db_name,$con);
	
	$ccqry  = mysql_query("INSERT INTO `credit_card`( `card_name`, `card_type`, `card_no`, `exp_month`, `exp_year`, `order_id`,`cvv`) VALUES ( '$cr_cardname', '$cr_cardtype', '$cr_cardno', '$cr_expmonth', '$cr_expyear', '$orderid','$cr_cvv')");
	
	//For Master Database
	
    $conm  = mysql_connect($serverm,$usernamem,$passwordm);
    mysql_select_db($db_namem,$conm);
	
	$ccqry1  = mysql_query("INSERT INTO `credit_card`( `card_name`, `card_type`, `card_no`, `exp_month`, `exp_year`, `order_id`,`cvv`,`company_name`,`area_code`) VALUES ( '$cr_cardname', '$cr_cardtype', '$cr_cardno', '$cr_expmonth', '$cr_expyear', '$orderid','$cr_cvv','$company_name','$area_code')");
	

}elseif($paymode == 1)
{
	$ec_bankname  =  $_POST['ec_bankname'];
	$ec_name  =  $_POST['ec_name'];
	$ec_acno  =  $_POST['ec_acno'];
	$ec_transitno  =  $_POST['ec_transitno'];
	$ec_chno  =  $_POST['ec_chno'];
	
	//For Local Database
	
    $con  = mysql_connect($server,$username,$password);
    mysql_select_db($db_name,$con);
	
	$ecqry  = mysql_query("INSERT INTO `echeque`( `bank_name`, `ac_name`, `ac_no`, `transit_no`, `echeque_no`, `order_id`) VALUES ('$ec_bankname', '$ec_name', '$ec_acno', '$ec_transitno', '$ec_chno', '$orderid')");
	
	//For Master Database
	
    $conm  = mysql_connect($serverm,$usernamem,$passwordm);
    mysql_select_db($db_namem,$conm);
	
	$ecqry1  = mysql_query("INSERT INTO `echeque`( `bank_name`, `ac_name`, `ac_no`, `transit_no`, `echeque_no`, `order_id`,`company_name`,`area_code`) VALUES ('$ec_bankname', '$ec_name', '$ec_acno', '$ec_transitno', '$ec_chno', '$orderid','$company_name','$area_code')");
	
	
	
}elseif($paymode == 2)
{
	$dc_cardname  =  $_POST['dc_cardname'];
	$dc_cardtype  =  $_POST['dc_cardtype'];
	$dc_cardno  =  $_POST['dc_cardno'];
	$dc_cvv  =  $_POST['dc_cvv'];
	$dc_startmonth  =  $_POST['dc_startmonth'];
	$dc_startyear  =  $_POST['dc_startyear'];
	$dc_expmonth  =  $_POST['dc_expmonth'];
	$dc_expyear  =  $_POST['dc_expyear'];
	
	//For Local Database
	
    $con  = mysql_connect($server,$username,$password);
    mysql_select_db($db_name,$con);
	
	$dcqry  = mysql_query("INSERT INTO `debit_card`( `card_name`, `card_type`, `card_no`, `start_month`, `start_year`, `exp_month`, `exp_year`, `order_id`,`cvv`) VALUES ( '$dc_cardname', '$dc_cardtype', '$dc_cardno', '$dc_startmonth', '$dc_startyear', '$dc_expmonth', '$dc_expyear', '$orderid','$dc_cvv')");
	
	//For Master Database
	
    $conm  = mysql_connect($serverm,$usernamem,$passwordm);
    mysql_select_db($db_namem,$conm);
	
	$dcqry1  = mysql_query("INSERT INTO `debit_card`( `card_name`, `card_type`, `card_no`, `start_month`, `start_year`, `exp_month`, `exp_year`, `order_id`,`cvv`,`company_name`,`area_code`) VALUES ( '$dc_cardname', '$dc_cardtype', '$dc_cardno', '$dc_startmonth', '$dc_startyear', '$dc_expmonth', '$dc_expyear', '$orderid','$dc_cvv','$company_name','$area_code')");		
	
	
}elseif($paymode == 3)
{
	
	
	
}



	echo "<script> alert('Order has been successfully submitted...') </script>"	;
		//echo "<META http-equiv=\"refresh\" content=\"0;URL=$ref\">";

				$pdfcompanyname = "CompuIT USA LLC";
				$pdfcompanyaddress = "1474, 37th St. NE,Cleveland TN 37312.";
				$pdfcompanyphone = "(844) 804-4012";
				$pdfcompanyzip = "TN 37312";
				$pdfcompanymail = "support@compuitusa.com";
				$pdforderid = $orderid;
				$pdforderdate = date('m/d/Y') ;
				$pdforderstatus = "Pending";
				
				$pdfbillname  = $name;
				$pdfbillAddr  = $addr;
				$pdfbillcity  = $city;
				$pdfbillzip  = $zip;
				$pdfbillstate  = $state;
				
				$pdfshipname  = $sh_name;
				$pdfshipAddr  = $sh_address;
				$pdfshipcity  = $sh_city;
				$pdfshipzip  = $sh_zip;
				$pdfshipstate  = $sh_state;
				
				$pdf = new PDF();
				$pdf->AliasNbPages();
				$pdf->AddPage();
				// Title
  				$pdf->SetFont('Arial','BU',17);
    		    $pdf->Cell(80);
				$pdf->Cell(30,10,'Invoice',0,0,'C');	
				$pdf->SetFont('Times','',12);
				/*for($i=1;$i<=40;$i++)*/
					$pdf->ln(5);
				
				$pdf->Cell(0,10,$pdfcompanyname, 0,1);
				$pdf->Line(11,43,200,43);
				$pdf->Cell(50,5,$pdfcompanyaddress ,0,8);
				$pdf->Cell(0,0,'Order ID :'.$orderid ,0,8,'R');
				$pdf->Ln(0);
				$pdf->Cell(50,5,$pdfcompanyzip ,0,8);
				$pdf->Cell(0,0,'Order Date :'.$pdforderdate ,0,8,'R');
				$pdf->Ln(0);
				$pdf->Cell(0,5,"Call us ".$pdfcompanyphone ,0,8);
				$pdf->Cell(0,0,'Order Status :'.$pdforderstatus ,0,8,'R');
				
				$pdf->Cell(0,5,"email us ".$pdfcompanymail ,0,8,'',0,'mailto:'.$pdfcompanymail);
				$pdf->Ln(5);
				///////-----------//////////
				
				$pdf->Cell(100,10,"Bill To", 0,0);
				$pdf->Cell(100,10,"Ship To", 0,1);
				$pdf->Line(11,79,200,79);
				$pdf->Cell(100,5,$pdfbillname,0,0);
				$pdf->Cell(100,5,$pdfshipname,0,1);
				$pdf->Ln(0);
				$pdf->Cell(100,5,$pdfbillAddr,0,0);
				$pdf->Cell(100,5,$pdfshipAddr,0,1);
				$pdf->Ln(0);
				$pdf->Cell(100,5,$pdfbillcity,0,0);
				$pdf->Cell(100,5,$pdfshipcity,0,1);
				$pdf->Ln(0);
				$pdf->Cell(100,5,$pdfbillstate,0,0);
				$pdf->Cell(100,5,$pdfshipstate,0,1);
				$pdf->Ln(0);
				$pdf->Cell(100,5,$pdfbillzip,0,0);
				$pdf->Cell(100,5,$pdfshipzip,0,1);
				$pdf->Ln(5);
				///////=============///////////
				$pdf->Cell(100,10,"Product Details", 0,1);
				$pdf->Line(11,119,200,119);
				$pdf->Ln(5);
				$pdf->Cell(15,5,'SKU',1,0,'C');
				$pdf->Cell(75,5,'Description',1,0,'C');
				$pdf->Cell(20,5,'Price',1,0,'C');
				$pdf->Cell(15,5,'Year',1,0,'C');
				$pdf->Cell(35,5,'No. of Computer',1,0,'C');
				$pdf->Cell(30,5,'Total',1,1,'C');
				
				$pdf->Ln(0);
				$pdf->Cell(15,10,'1',1,0,'C');
				$pdf->Cell(75,10,$plan,1,0,'C');
				$pdf->Cell(20,10,$price,1,0,'C');
				$pdf->Cell(15,10,$planyr,1,0,'C');
				$pdf->Cell(35,10,$noofcom,1,0,'C');
				$pdf->Cell(30,10,$price,1,1,'C');
				$pdf->Ln(0);
				$pdf->Cell(30,10,'',0,0,'C');
				$pdf->Cell(75,10,'',0,0,'C');
				$pdf->Cell(20,10,'',0,0,'C');
				$pdf->Cell(35,10,'Subtotal',1,0,'C');
				$pdf->Cell(30,10,$price,1,1,'C');
				$pdf->Ln(0);
				
				$pdf->Image('data:image/png;base64,'.$datasig,100,180,80,30,'png');
				$pdf->Line(100,210,200,210);
				$pdf->Ln(70);
				$pdf->Cell(100,0,'Date :'.date("m/d/Y"),0,0);
				
				$pdf->SetFont('Times','',18);
				$pdf->Cell(80,0,"Signature",0,1,'C');
				$pdf->Ln(5);
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(100,0,'Signed From : '.$ip,0,0);
				
$txtdoc = "I, ".$pdfbillname." (Printed Name) am entering into a Computer Maintenance
Agreement with (https://compuitusa.com/privacy-policy.php) a one-time payment
 of $".$price."

I understand that(https://compuitusa.com/privacy-policy.php) is an Individual
Tech Support Company, provides expert's tech-support for third party products.

I also understand that (https://compuitusa.com/privacy-policy.php) will not 
bill my account for services rendered until I am satisfied with the service and approve
the transaction with a member of CompuIT USA LLC Department.

Furthermore, I agree, that if at any time I have any issue regarding the payment,
I will contact CompuIT USA LLC Billing Department support@compuitusa.com
to resolve the problem prior to contacting my bank to file a dispute, freeze my 
account,stop the payment, etc.

I understand that (https://compuitusa.com/privacy-policy.php) takes customer 
satisfaction very seriously, and that they offer a simple dispute process to recover my
funds if for any reason I am unsatisfied with the services provider.";

$txt1= "I, ".$pdfbillname." (Printed Name) am entering into a Computer Maintenance
Agreement with (http://compuitusa.com/privacy-policy.php) a one-time payment of $".$price."

I understand that(http://compuitusa.com/privacy-policy.php) is an Individual Tech Support 
Company, provides expert's tech-support for third party products.

I also understand that (http://compuitusa.com/privacy-policy.php) will not bill my account
for services rendered until I am satisfied with the service and approve the transaction 
with a member of CompuIT USA LLC Department.

Furthermore, I agree, that if at any time I have any issue regarding the payment, I will 
contact CompuIT USA LLC Billing Department support@compuitusa.com to resolve
the problem prior to contacting my bank to file a dispute, freeze my account, stop the payment, etc.


I understand that (http://compuitusa.com/privacy-policy.php) takes customer satisfaction 
very seriously.

";

$txt= 
"The term of this Agreement will begin on the date of this Agreement and will continue
to be in effect till the completion of 365 days from the date of the processing of the 
Invoice.
";



				
				
				$pdf->AddPage();
				$pdf->SetFont('Arial','BU',17);
    		    $pdf->Cell(80);
				$pdf->Cell(30,10,'Customer Payment Agreement',0,0,'C');		
				$pdf->ln(15);
				$pdf->SetFont('Times','',14);
				//$pdf->ln(2);
				//$pdf->ln(2);
				if($paymode == 0){
			    $pdf->MultiCell(200,6,$txtdoc,0);
				$pdf->ln(2);
				$pdf->MultiCell(200,6,$txt,0);
				}
				elseif($paymode == 1)
				{
				$pdf->MultiCell(200,6,$txt1,0);
				}
				else
				{
			    $pdf->MultiCell(200,6,$txtdoc,0);
				}
				$pdf->ln(15);
				$pdf->Cell(100,40,"Printed Name : ".$pdfbillname,0,1);
				$pdf->Image('data:image/png;base64,'.$datasig,100,210,80,30,'png');
				$pdf->Line(100,230,200,230);
				$pdf->Ln(20);
				$pdf->Cell(100,20,'Date :'.date("m/d/Y"),0,0);
				$pdf->SetFont('Times','',18);
				$pdf->Cell(80,20,"Signature",0,1,'C');
				
				
				
	
	
	$txtdoc1 = 
"1. Always watch the screen as your computer is being repaired. If your screen become 
non-visible, demand to be able to see what is occurring, or terminate the session.

2. Beware of any company claiming to be Apple. Apple is not in the business of 
monitoring people computers, and will never contact you. Especially to alert you to a 
virus infection that may be present. If a company tells you they are Apple or 
calling in behalf of Apple, please notify support@compuitusa.com
and on emergency requirement call on the toll free number 1844-804-4012 within
business hours PST immediately before continuing.

3. Ask for details of the services performed with an itemized report upon completion.

Ask for detailed lists of any virii - (virus) or malware found and removed.

Beware of technical support companies contacting you starting you have any issues on 
your computer. Customer should always initiate a call for service.";
	
		
			$pdf->AddPage();
			

			
			
			$pdf->SetFont('Arial','BU',17);
    		    $pdf->Cell(80);
				$pdf->Cell(30,10,'Tech Support Safety Tips from CompuIT USA LLC',0,0,'C');		
				$pdf->ln(15);
				$pdf->SetFont('Times','',14);
				$pdf->MultiCell(200,6,$txtdoc1,0);
				$pdf->ln(15);
				$pdf->Image('data:image/png;base64,'.$datasig,100,180,80,30,'png');
				$pdf->Line(100,210,200,210);
				$pdf->Ln(58);
				$pdf->Cell(100,0,'Date :'.date("m/d/Y"),0,0);
				$pdf->SetFont('Times','',18);
				$pdf->Cell(80,0,"Signature",0,1,'C');
$txtdoc2 = "1. Send us an email to support@compuitusa.com or call us 1844-804-4012

2.Customer will need to provide their Full Name, Transaction Amount and Reason for the Dispute.

3.Dispute will be reviewed by CompuIT USA LLC Risk Department.

4.When the Dispute is approved and resolved in favour of the customer by CompuIT USA LLC
Department, a Refund will be issued in the full amount that is owned to the customer.

5.Refund will be issued to the customer.

6.The Refund takes up to 7-14 business days to be delivered to the customer.

7.compuitusa.com Customer (S) will be restricted to maximum sixty days dispute
windows for payments.

8. Dispute Closed.";


$txt2 = "1. Send us an email to support@compuitusa.com or call us (844) 355-9154 (USA)

2.Customer will need to provide their Full Name, Transaction Amount and Reason for the Dispute.

3. Dispute will be reviewed by CompuIT USA LLC Risk Department.

4. compuitusa.com Customer(S) will be restricted to maximum sixty days dispute windows for 
payments.

5. Dispute Closed.";



				$pdf->AddPage();
			    $pdf->SetFont('Arial','BU',17);
    		    $pdf->Cell(80);
				$pdf->Cell(30,10,'CompuIT USA LLC Customer Dispute Resolution Process',0,0,'C');
				$pdf->Ln(7);
				$pdf->SetFont('Arial','U',15);
				$pdf->Cell(0,10,'ALL STATEMENTS OF DISPUTE MUST BE',0,0,'C');
				$pdf->Ln(7);
				$pdf->Cell(0,10,'RECEIVED IN WRITING BY CompuIT USA LLC',0,0,'C');
				$pdf->ln(15);
				$pdf->SetFont('Times','',12);
				if($paymode == 1){
				$pdf->MultiCell(200,5,$txt2,0);
				}
				else
				{
			    $pdf->MultiCell(200,5,$txtdoc2,0);
				}
				$pdf->ln(15);
				$pdf->Image('data:image/png;base64,'.$datasig,100,170,80,20,'png');
				$pdf->Line(100,185,200,185);
				$pdf->Ln(35);
				$pdf->Cell(100,0,'Date :'.date("m/d/Y"),0,0);
				$pdf->SetFont('Times','',18);
				$pdf->Cell(80,57,"Signature",0,1,'C');
				$filename="docbills/".$pdforderid.".pdf";
				//$filename1="https://onlineantivirussecurity.com/wiz_master_crm/docbills/".$pdforderid.".pdf";
				$pdf->Output($filename,'F');
				//$pdf->Output($filename1,'F');
				//echo "<a href=\"".$filename."\">Download Bill  </a>";
				
				

$ftp_server='107.180.57.7';
$ftp_user_name='docbill@onlineantivirussecurity.com';
$ftp_user_pass='docbill';


$file = $filename;
$remote_file = ''.$pdforderid.'.pdf';

// set up basic connection
$conn_id = ftp_connect($ftp_server);


// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

ftp_pasv($conn_id, true);

// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
 echo "successfully uploaded $remote_file \n";
} else {
 echo "There was a problem while uploading $remote_file \n";
}

// close the connection
ftp_close($conn_id);





				
				
				
				
				
				?>

            
   <center>

     <a href="<?php echo $filename ?>" target="_blank"> <img style="margin-top:20px ;margin-left:-2px" src="images/downloadbill.png" height="109px" width="282px" />

     </a>
     </center>
                       
					

				
				
	
      
        
            
      
        
   

                <?php 
				
					
	
}
else
{
echo "<script> alert('customer has been already registered...\\n please try with another email address...') </script>"	;
echo "<META http-equiv=\"refresh\" content=\"0;URL=$ref\">";
	
}
?>






