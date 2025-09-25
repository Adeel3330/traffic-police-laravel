<?php 
// error_reporting(E_ALL);
$conn = mysqli_connect("localhost","trafficpoliceajk_ajktraffic","MBd7n_^iX-}{","trafficpoliceajk_database");
include('vendor/php-excel-reader/excel_reader2.php');
include('vendor/SpreadsheetReader.php');
// echo 1;die;
$targetPath = 'files_to_update_record/';
$allfiles = scandir($targetPath);

	foreach ($allfiles as $key => $value) {
		if($value == "." || $value == ".."){ continue; }
		$GetFileFrom = 'files_to_update_record/'.$value;
		$image 			= file_get_contents($GetFileFrom);
        
        $Reader = new SpreadsheetReader($GetFileFrom);
        // var_dump($Reader);exit;
         
        $sheetCount = count($Reader->sheets());
       
        for($i=0;$i<$sheetCount;$i++)
        { 
            
            if($i > 500){ echo "3000"; die; }
          
          $Reader->ChangeSheet($i);
          
            foreach ($Reader as $Row)
            { 
                $ApplicantName = "";
                if(isset($Row[0])) {
                    $ApplicantName = $Row[0];
                }
                
                 $LicenseCategory = "";
                if(isset($Row[1])) {
                    $LicenseCategory = mysqli_real_escape_string($conn,$Row[1]);
                }
                 $LicenseType = "";
                if(isset($Row[2])) {
                    $LicenseType = mysqli_real_escape_string($conn,$Row[2]);
                }
                
                 $CNIC = "";
                if(isset($Row[3])) {
                    $CNIC = mysqli_real_escape_string($conn,$Row[3]);
                }
                
                
                
                 $LearnerNumber = "";
                if(isset($Row[4])) {
                    $LearnerNumber = mysqli_real_escape_string($conn,$Row[4]);
                }
                
                 $LicenseNumber = "";
                if(isset($Row[5])) {
                    $LicenseNumber = mysqli_real_escape_string($conn,$Row[5]);
                }
                
                 $Status = "";
                if(isset($Row[6])) {
                    $Status = mysqli_real_escape_string($conn,$Row[6]);
                }
                
                 $issue_date = "";
                if(isset($Row[7])) {
                    $issue_date = mysqli_real_escape_string($conn,$Row[7]);
                }
                
                 $expire_date = "";
                if(isset($Row[8])) {
                    $expire_date = mysqli_real_escape_string($conn,$Row[8]);
                }
                
                 $address = "";
                if(isset($Row[9])) {
                    $address = mysqli_real_escape_string($conn,$Row[9]);
                }

                $district_name = "";
                if(isset($Row[10])) {
                    $district_name = mysqli_real_escape_string($conn,$Row[10]);
                }
                    //if(empty($LicenseNumber)){ continue; }
               
                if (!empty($ApplicantName) && !empty($issue_date) && !empty($expire_date)) {
                   
                    $getsql = "SELECT id FROM dlms_license_status where CNIC='".$CNIC."'";
               
                    $getresult = $conn->query($getsql);
                    if ($getresult->num_rows > 0) {
                         
                            // output data of each row
                            while($row = $getresult->fetch_assoc()) {
                              
                                $Update = "UPDATE dlms_license_status SET 
                                                    ApplicantName='".$ApplicantName."',
                                                    LicenseCategory='".$LicenseCategory."',
                                                    LicenseType='".$LicenseType."',
                                                    LearnerNumber='".$LearnerNumber."',
                                                    LicenseNumber='".$LicenseNumber."',
                                                    Status='".$Status."',
                                                    issue_date='".$issue_date."',
                                                    expire_date='".$expire_date."',
                                                    district_name='".$district_name."',
                                                    address='".$address."',
                                                    is_updated=1,
                                                    updated_at='".date('Y-m-d h:i:s')."'
                                                    WHERE id='".$row["id"]."'";
                                                  
                              $getsetresult =  $conn->query($Update);
                            }
                            
                        }else{

                           
                    $query = "insert into dlms_license_status(ApplicantName,LicenseCategory,LicenseType,CNIC,LearnerNumber,LicenseNumber,Status,issue_date,expire_date,address,is_added) values('".$ApplicantName."','".$LicenseCategory."','".$LicenseType."','".$CNIC."','".$LearnerNumber."','".$LicenseNumber."','".$Status."','".$issue_date."','".$expire_date."','".$address."',1)";
                   
                    $result = mysqli_query($conn, $query);
                    
                        }
                    if (! empty($result) || !empty($getsetresult)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }
    
	    unlink($GetFileFrom);
	}



?>
