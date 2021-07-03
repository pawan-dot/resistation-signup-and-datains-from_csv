<?php
include('dbcon.php');
if(isset($_POST['submit'])){
    // echo '<pre>';
    // print_r($_FILES);

	$file=$_FILES['file']['tmp_name'];
	
	$ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
	if($ext=='xlsx'){
		require('PHPExcel/PHPExcel.php');
		require('PHPExcel/PHPExcel/IOFactory.php');
		
		$obj=PHPExcel_IOFactory::load($file);
		foreach($obj->getWorksheetIterator() as $sheet){
            // echo '<pre>';
            // print_r( $sheet);
			$getHighestRow=$sheet->getHighestRow();
            //   echo '<pre>';
            //   print_r($getHighestRow );
			for($i=0;$i<=$getHighestRow;$i++){

				$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
				$allmail=$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
        $count=0;
				if($name!=''){
                    //random pass
                    $str="sadfghjxvcnm!@&^%$#*&$";
                    $str=str_shuffle($str);
                    $str=substr($str,0,10);
                    //echo $str;
                    //id fetch from database
                   

                    $userid = "SELECT * FROM admine";
                    $run= mysqli_query($con, $userid );
                    $row=mysqli_num_rows($run);
                    if($row>=1){
                    $data=mysqli_fetch_assoc($run);
                    $id=$data['user_id'];
                  }

                    //echo $id;

                    //get real time and date to insert data
                    
                     // Return current date from the remote server
                     $date = date('d-m-y h:i:s');
                     //echo $date;
                     
          
           $insertquery="INSERT INTO `my_users`(`full_name`, `email`, `password`, `created_by`, `is_admine`, `created_on`) VALUES ('$name', '$email', '$str','$id', 'false', '$date')";
           $run=mysqli_query($con,$insertquery);
          // $ount=mysqli_num_rows($run);
           

           //SEND MAIL TO ALL EMAIL MENTIONED IN SHEAT
            if($allmail!=''){

                $subject="Account creatoin";
                $body=" your new account is created";
       
                $sender_email="from:pk02.verma@gmail.com";
       
                if(mail($allmail,$subject,$body,$sender_email)){
                  //echo "email sent $to_email..";
                   header('location:welcome.php');
       
                }else{
                  "email sending failed to User...";
                }
            }
          
          ?>
          <script>
           alert('Data inserted successfully through admin ID =<?php echo $id?>');
          </script>
          <?php 
        }
    }
  }
	}else{
		echo "Invalid file format";
	}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Welcome page!</title>
  </head>
  <body>
 
 <div class="div-container row justify-content-center">
        
  <form class="form-inline " method="POST" enctype="multipart/form-data">
    
    <div class="form-group mx-sm-3 mb-2">
    
      <input type="file" class="form-control" name="file" placeholder="Upload file">
     </div>

       <button type="submit" name="submit" class="btn btn-primary mb-2 ">submit</button>
  </form>

</div>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
