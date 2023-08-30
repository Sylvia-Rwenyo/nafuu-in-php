<?php
include_once "../conn.php";
// define global variables

// register patients 
if(isset($_POST['register']))
{	
    //create session
    session_start();
    
    //store values submitted in the signup form in variables
	 $firstName = $_POST['firstName'];
     $lastName = $_POST['lastName'];
	 $emailAddress = $_POST['emailAddress'];
     $phoneNumber = $_POST['phoneNumber'];
     $institution = $_POST['institution'];
     $conditionsArr= array();
     for($i=0; $i < count($_POST['condition']); $i++){
        $conditionsArr[] = $_POST['condition'][$i];
         }
    $conditions = implode('*', $conditionsArr);	 $password = $_POST['password'];
     $age = $_POST['age'];
     $address = $_POST['address'];
	 $gender = $_POST['gender'];
    
     
     //statement to enter values into the registration table in the database
	 $sql = "INSERT INTO regPatients (firstName, lastName, emailAddress, institution,  password, illness, address, age, gender,phoneNumber )
	 VALUES ('$firstName','$lastName', '$emailAddress','$institution', '$password', '$conditions', '$address', '$age', '$gender', '$phoneNumber')";

     //if sql query is executed...
	 if (mysqli_query($conn, $sql)) {
        if(!isset($_SESSION['category'])){
        login($conn);
        }else{
            header('location:../dashboard.php');
        }
			 } else {	
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
     //close connection
	 mysqli_close($conn);

}

// register hospitals 
if(isset($_POST['reg-partner']))
{	
    //create session
    session_start();
    
    //store values submitted in the signup form in variables
	 $institutionName = $_POST['institutionName'];
     $location = $_POST['location'];
	 $emailAddress = $_POST['emailAddress'];
     $phoneNumber = $_POST['phoneNumber'];

     $conditionsArr= array();
     for($i=0; $i < count($_POST['conditions']); $i++){
        $conditionsArr[] = $_POST['conditions'][$i];
         }
    $conditions = implode('*', $conditionsArr);
	$password = $_POST['password'];
    $postalAddress = $_POST['postalAddress'];
    
     
     //statement to enter values into the registration table in the database
	 $sql = "INSERT INTO regInstitutions (institutionName, location, emailAddress, phoneNumber,  password, illnesses, postalAddress)
	 VALUES ('$institutionName','$location', '$emailAddress','$phoneNumber', '$password', '$conditions', '$postalAddress')";

     //if sql query is executed...
	 if (mysqli_query($conn, $sql)) {
        login($conn);
			 } else {	
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
     //close connection
	 mysqli_close($conn);

}

if(isset($_POST['add-patient'])){
    $firstName = $_POST['firstName'];
     $lastName = $_POST['lastName'];
     $age = $_POST['age'];
     $gender = $_POST['gender'];
	 $emailAddress = $_POST['emailAddress'];
     $phoneNumber = $_POST['phoneNumber'];
     $address = $_POST['address'];
     $institution = $_POST['institution'];
     $conditionsArr= array();
     for($i=0; $i < count($_POST['condition']); $i++){
        $conditionsArr[] = $_POST['condition'][$i];
         }
    $conditions = implode('*', $conditionsArr);    
	 
    $sql=mysqli_query($conn,"SELECT * FROM regpatients where email='$emailAddress' AND phone_number='$phoneNumber'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "User Already Registered"; 
        exit;
    }
    else
    {
        $query="INSERT INTO regpatients(firstName, lastName, age, gender, emailAddress, phoneNumber, address, institution, condition) VALUES ('$firstName' ,'$lastName' ,'$age' ,'$gender' ,'$emailAddress' ,'$phoneNumber' ,'$address' ,'$institution' ,'$conditions')";
    }
    //if sql query is executed...
	 if (mysqli_query($conn, $query)) {
        if(!isset($_SESSION['category'])){
        login($conn);
        }else{
            header('location:../dashboard.php?status=success');
        }
			 } else {	
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
     //close connection
	 mysqli_close($conn);
}

if(isset($_POST['register-doc'])){
    //create session
    session_start();

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $institution = $_POST['institution'];
    $conditionsArr= array();
     for($i=0; $i < count($_POST['conditions']); $i++){
        $conditionsArr[] = $_POST['conditions'][$i];
         }
    $conditions = implode('*', $conditionsArr);	 $password = $_POST['password'];
    $address = $_POST['address'];
    $years = $_POST['years'];//years experience
    $password = $_POST['password'];

	 
    $sql=mysqli_query($conn,"SELECT * FROM regdoctors where email='$emailAddress' AND phone_number='$phoneNumber'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "Doctor Already Registered"; 
        exit;
    }
    else
    {
        $query="INSERT INTO regdoctors(firstName, lastName, gender, emailAddress, institution, specialty, phoneNumber, address, password) VALUES ('$firstName' ,'$lastName' ,'$gender' ,'$emailAddress', '$institution', '$conditions' ,'$phoneNumber' ,'$address' ,'$password')";
    }
    //if sql query is executed...
	 if (mysqli_query($conn, $query)) {
        if(!isset($_SESSION['category'])){
        login($conn);
        }else{
            header('location:doctors-dashboard.php?status=success');
        }
			 } else {	
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
     //close connection
	 mysqli_close($conn);
}

if(isset($_POST['register-doc-by-partner'])){
    //create session
    session_start();

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['emailAddress'];
    $institution = $_SESSION['username'];
    $conditionsArr= array();
     for($i=0; $i < count($_POST['condition']); $i++){
        $conditionsArr[] = $_POST['condition'][$i];
         }
    $conditions = implode('*', $conditionsArr);
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $years = $_POST['years'];
    $password = substr($emailAddress, 0, strpos($emailAddress, "@"));

	 
    $sql=mysqli_query($conn,"SELECT * FROM regdoctors where emailAddress='$emailAddress' AND phoneNumber='$phoneNumber'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "Doctor Already Registered"; 
        exit;
    }
    else
    {
        $query="INSERT INTO regdoctors(firstName, lastName, gender, institution, emailAddress, specialty, phoneNumber, address, password) VALUES
         ('$firstName' ,'$lastName' ,'$gender' , '$institution' ,'$emailAddress', '$conditions', '$phoneNumber' ,'$address' ,'$password')";
    }
    //if sql query is executed...
	 if (mysqli_query($conn, $query)) {
        if(!isset($_SESSION['category'])){
        login($conn);
        }else{
            header('location:../dashboard.php?status=success');
        }
			 } else {	
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
     //close connection
	 mysqli_close($conn);
}


if(isset($_POST['dosage-registration'])){
    $fname_patient = $_POST["patientName"];
    $patient_email = $_POST["patientEmail"];
    $patient_id = $_POST["patient_id"];
    $attending_doctor_name = $_POST["attending_doctor_name"];
    $attending_doctor_email = $_POST["attending_doctor_email"];
    $attending_doctor_id = $_POST["attending_doctor_id"];
	$dosageName = $_POST['dosageName'];
	$tablets = $_POST['tablets'];
	$numberOfDays = $_POST['numberOfDays'];
	$timesADay = $_POST['timesADay'];
    $sql=mysqli_query($conn,"SELECT * FROM dosage where dosageName='$dosageName'");
    if(mysqli_num_rows($sql)>0)
    {
        echo "Medicine Dosage Already Exists For This Patient"; 
        exit;
    }
    else
    {
        $query="INSERT INTO dosage(attending_doctor_id, attending_doctor_email, attending_doctor_name, patient_id, patientEmail, patientName, dosageName, tablets, times_a_day, number_of_days) VALUES ('$attending_doctor_id', '$attending_doctor_email', '$attending_doctor_name', '$patient_id','$patient_email', '$fname_patient', '$dosageName', '$tablets', '$timesADay', '$numberOfDays')";
        $sql=mysqli_query($conn,$query)or die("Could Not Perform the Query");
        header ("Location: ../single-patient-records.php?p=$patient_id");
    }
}

if(isset($_POST['dosage-update']))
{
	$id = $_GET['id'];
    $original_dosageName = 0;
    $original_tablets = 0;
    $original_numberOfDays = 0;
    $original_timesADay = 0;
    $query3 = "SELECT * FROM dosage WHERE dosageId ='$id'";
    $result3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));
    while($row = mysqli_fetch_array($result3))
    {
        $original_dosageName = $row['dosageName'];
        $original_tablets = $row['tablets'];
        $original_numberOfDays = $row['number_of_days'];
        $original_timesADay = $row['times_a_day'];
    }
	$id = $_GET['id'];
    if(!empty($_POST['dosageName'])){
        $dosageName = $_POST['dosageName'];
    }
    else{
        $dosageName = $original_dosageName;
    }
    if(!empty($_POST['tablets'])){
        $tablets = $_POST['tablets'];
    }
    else{
        $tablets = $original_tablets;
    }
    if(!empty($_POST['numberOfDays'])){
        $numberOfDays = $_POST['numberOfDays'];
    }
    else{
        $numberOfDays = $original_numberOfDays;
    }
    if(!empty($_POST['timesADay'])){
        $timesADay = $_POST['timesADay'];
    }
    else{
        $timesADay = $original_timesADay;
    }

     $sql = "UPDATE dosage SET dosageName = '$dosageName', tablets = '$tablets', number_of_days = '$numberOfDays', times_a_day = '$timesADay' WHERE dosageId=$id";
    
    if (mysqli_query($conn, $sql)) 
    {
        $query2 = "SELECT * FROM dosage WHERE dosageId ='$id'";
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result))
        {
            $pId = $row['patient_id'];	
        }
        echo "<script> alert(\"Item updated\");window.location.href='../doctors/dosage-registration.php?id=$pId'; </script>";	 
    } 
    else 
    {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
	 mysqli_close($conn);
}
if(isset($_POST['dosage-delete'])){
	$id = $_GET['id'];
    $query2 = "SELECT * FROM dosage WHERE dosageId ='$id'";
    $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
    while($row = mysqli_fetch_array($result))
    {
        $pId = $row['patient_id'];	
    }
     $sql = "DELETE FROM dosage WHERE dosageId=$id";
	 if (mysqli_query($conn, $sql))
	  {echo "<script>
		alert(\"Item deleted\");
		window.location.href='../doctors/dosage-registration.php?id=$pId';
		</script>";	
     } 
	 else 
     {
		echo "Error: " . $sql . "" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}


if(isset($_POST['logIn']))
{
    login($conn);
}

function login($conn){
    //import variables
    session_start();
    extract($_POST);
    $emailAddress = $_POST ["emailAddress"];
    $password = $_POST ["password"];
    $stmt;
     //statement to select values from the registration table in the database
    $stmt = "SELECT * FROM regpatients where emailAddress='$emailAddress' and password='$password'";
    $sql=mysqli_query($conn, $stmt);
    $row  = mysqli_fetch_array($sql);
    if(is_array($row)){
       
            $_SESSION['category'] = 'patient';
            $_SESSION["email"]=$row['emailAddress'];
            $_SESSION["username"] = $row['firstName'];
            $_SESSION["id"]=$row['id'];
            $_SESSION["loggedIN"] = true;
            header('location:../dashboard.php');
    }else{
        $stmt = "SELECT * FROM regdoctors where emailAddress='$emailAddress' and password='$password'"; 
        $sql=mysqli_query($conn, $stmt);
        $row  = mysqli_fetch_array($sql);
        if(is_array($row)){
            $_SESSION['category'] = 'doctor';
            $_SESSION["email"]=$row['emailAddress'];
            $_SESSION["username"] = $row['firstName'];
            $_SESSION["id"]=$row['id'];
            $_SESSION["loggedIN"] = true;
            header('location:../dashboard.php');
        }else{
        $stmt = "SELECT * FROM reginstitutions where emailAddress='$emailAddress' and password='$password'"; 
        $sql=mysqli_query($conn, $stmt);
        $row  = mysqli_fetch_array($sql);
        if(is_array($row)){
            $_SESSION['category'] = 'hospital';
            $_SESSION["email"]=$row['emailAddress'];
            $_SESSION["username"] = $row['institutionName'];
            $_SESSION["id"]=$row['id'];
            $_SESSION["loggedIN"] = true;
            header('location:../dashboard.php');
        }else{
            echo "Invalid email address /Password";
         }
}
    }
}

if(isset($_GET['action'])){
    // log out if the user selects "Log Out" on the menu bar
        if($_GET['action']== "logOut"){
            session_start();
            session_unset();
            echo ' <script> 
                        window.location.href = "../index.php"
                    </script>
        '; 
        }
    
        if($_GET['action'] == "deleteAccount"){
            session_start();
            $id = $_GET['id'];
            $stmt;
            // check the user's category
            if($_SESSION['category'] == 'patient'){
             //statements to select values from the registration tables in the database
            $stmt = "DELETE FROM regPatients where id='$id'";
            }else if($_SESSION['category'] == 'doctor'){
                $stmt = "DELETE FROM regDoctors where id='$id'";
            }else if($_SESSION['category'] == 'hospital'){
                $stmt = "DELETE FROM regInstitutions where id='$id'";
            }
            $sql=mysqli_query($conn, $stmt);
             if ($sql)
              {     
                session_unset();      
                echo ' <script> 
                         window.location.href = "../index.php";
                       </script>';
             } 
        
             else {
                echo "Error: " . $stmt . "
        " . mysqli_error($conn);
             }
             mysqli_close($conn);
        }
    }
    if(isset($_POST['update']))
{	 
     // specify directory for uploading the file
     $target_dir3 = "Uploads/";
     $fileName3 = basename($_FILES["profilePhoto"]["name"]);
     $targetFilePath3 = $target_dir3 . $fileName3;
     $imageFileType3 = strtolower(pathinfo($targetFilePath3,PATHINFO_EXTENSION));

    //if file input is not empty
     if(!empty($_FILES["profilePhoto"]["name"])){
     //move uploaded file
     move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $targetFilePath3);
     } 
    session_start();
   //store values submitted in the edit profile form in variables
    $id = $_POST['id'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $profilePhoto = $fileName3;
    $phoneNumber = $_POST['phoneNumber'];
    //statement to update values
    $sql = "UPDATE regPatients SET  emailAddress='$emailAddress', password='$password', 
                   profilePhoto='$profilePhoto', phoneNumber='$phoneNumber' WHERE id='$id'";

    // if sql query is executed and database connection is established
    if (mysqli_query($conn, $sql)) {
        // $_SESSION["username"]=$name;
        $_SESSION["email"]=$emailAddress;
        echo ' <script> 
        window.location.href = "../settings.php";
        </script>
        ';
    } else {	
    echo "Error: " . $sql . "
" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

// handle data submitted by user
if (isset($_POST["record-sleep"])) {
    // Start a session
    session_start();

    // Get the form values
    $start = $_POST['start-time'];
    $end = $_POST['end-time'];
    $id = $_SESSION['id'];

    // Calculate sleep time based on the difference between start time and end time
    $startTime = strtotime($start);
    $endTime = strtotime($end);
    $sleepTime = ($endTime - $startTime)/3600 ; // Convert to hours

    // Insert the sleep log into the database
    $sql = "INSERT INTO patientSleepLog (userID, sleepTime) VALUES ('$id', '$sleepTime')";

    // Connect to your database and execute the SQL query
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (mysqli_query($conn, $sql)) {
        echo $sleepTime;
    }else{
        // Show error if the SQL query is not executed
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    // Close the database connection
    mysqli_close($conn);
}

if(isset($_POST["record-meal"]))
{	
    //create session
    session_start();
    
    //store values submitted in the signup form in variables
	 $mealName = $_POST['meal-name'];
     $mealTime = $_POST['meal-time'];
     $current_date = date('Y-m-d');
     $id = $_SESSION['id'];
     //statement to enter values into the registration table in the database
	 $sql = "INSERT INTO patientsMealLog (userID, mealName, mealTime, recordDate)
	 VALUES ('$id','$mealName','$mealTime', '$current_date')";

     //if sql query is not executed...
	 if (mysqli_query($conn, $sql)) {
        echo 'Meal recorded';	
         }else{
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	     }
     //close connection
	 mysqli_close($conn);

}
if(isset($_POST["record-medTime"]))
{	
    //create session
    session_start();
    
    //store values submitted in the  form in variables
	 $medName = $_POST['med-name'];
     $medTime = $_POST['med-time'];
     $id = $_SESSION['id'];
     //statement to enter values into a table in the database
	 $sql = "INSERT INTO patientMedLog (userID, medName, medTime)
	 VALUES ('$id','$medName','$medTime')";

     //if sql query is not executed...
	 if (mysqli_query($conn, $sql)) {
        echo 'Medicine intake recorded';	

    }else{
                //show error
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	
     }
     //close connection
	 mysqli_close($conn);

}

// video chat back end

if (isset($_POST['action']) && $_POST['action'] === 'offer') {
    session_start();
    // Retrieve the offer SDP from the client
    $offerSdp = $_POST['offerSdp'];

    // Store the offer SDP in the session
    $_SESSION['offerSdp'] = $offerSdp;

    // Send the offer SDP to the other peer or save it for later use

    // Prepare the response
    $response = array('status' => 'success');

    // Send the response back to the client
    echo json_encode($response);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'answer') {
    session_start();
    // Retrieve the answer SDP from the client
    $answerSdp = $_POST['answerSdp'];

    // Send the answer SDP to the other peer or save it for later use

    // Prepare the response
    $response = array('status' => 'success');

    // Send the response back to the client
    echo json_encode($response);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'candidate') {
    session_start();
    // Retrieve the ICE candidate from the client
    $candidate = json_decode($_POST['candidate']);

    // Send the ICE candidate to the other peer or save it for later use

    // Prepare the response
    $response = array('status' => 'success');

    // Send the response back to the client
    echo json_encode($response);
    exit();
}

if(isset($_POST['input-message']))
{	
    //create session
    session_start();
    //store values submitted in the chat form in variables 
    $message = $conn->real_escape_string($_POST['message']);
    $userId = $_SESSION['id'];
    $emailAddress = $_SESSION['email'];
    $readStatus = $_POST['readStatus'];
    $sent_to = $_POST['sent_to'];
    $sender_class = $_POST['sender_class'];
    $sent_to_id = 0;
    $query = 0;
     
    if(($_SESSION['category']) == 'patient'){
        $query2 = "SELECT id FROM regdoctors WHERE emailAddress ='$sent_to'";
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result))
        {
            $sent_to_id = $row['id'];	
        }
        $chat_identity = $sent_to."_".$emailAddress;
        //statement to messages and userId in the database
        $query = "INSERT INTO chat (chat_identity, message, sender_class, sent_from_id, emailAddress, sent_to_id, sent_to, readStatus) VALUES ('$chat_identity','$message', '$sender_class','$userId', '$emailAddress', '$sent_to_id', '$sent_to', '$readStatus')";
    }
    elseif(($_SESSION['category']) == 'doctor'){
        $query2 = "SELECT id FROM regpatients WHERE emailAddress ='$sent_to'";
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result))
        {
            $sent_to_id = $row['id'];	
        }
        $chat_identity = $emailAddress."_".$sent_to;
        //statement to messages and userId in the database
        $query = "INSERT INTO chat (chat_identity, message, sender_class, sent_from_id, emailAddress, sent_to_id, sent_to, readStatus) VALUES ('$chat_identity', '$message','$sender_class','$userId', '$emailAddress', '$sent_to_id', '$sent_to', '$readStatus')";
    }
    
    if (mysqli_query($conn,$query)) 
    {
        echo "<script> window.location.href= '../chats/messages-page.php?id=$sent_to_id'; </script>";	
        //add notifications here 
    } 
    else 
    {
        echo "Error: " . $query . "" . mysqli_error($conn) . "Could Not Send Message";
    }
	 mysqli_close($conn);

}

if(isset($_POST['message-delete'])){
    //create session
    session_start();
    //store values submitted in the chat form in variables
	$id = $_GET['id'];
    $sent_to = $_POST['sent_to'];
    $sql = "DELETE FROM chat WHERE id=$id";
    $query2 = 0;
    if (mysqli_query($conn, $sql))
    {
        if(($_SESSION['category']) == 'doctor'){
            $query2 = "SELECT id FROM regpatients WHERE emailAddress ='$sent_to'";
        }
        elseif(($_SESSION['category']) == 'patient'){
            $query2 = "SELECT id FROM regdoctors WHERE emailAddress ='$sent_to'";
        }
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result))
        {
            $sent_to_id = $row['id'];
            echo "<script> window.location.href= '../chats/messages-page.php?id=$sent_to_id'; </script>";	
        }
     } 
	 else 
     {
		echo "Error: " . $sql . "" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}

if(isset($_POST['submit-report-or-suggestion']))
{	
    //create session
    session_start();
    //store values submitted in the chat form in variables 
    $message = $conn->real_escape_string($_POST['message']);
    $userId = $_SESSION['id'];
    $emailAddress = $_SESSION['email'];
    $readStatus = $_POST['readStatus'];
    $sent_to = $_POST['sent_to'];
    $sender_class = $_POST['sender_class'];
    $sent_to_id = 0;
    $query = 0;
     
    if(($_SESSION['category']) == 'patient' || ($_SESSION['category']) == 'doctor'){
        $query2 = "SELECT id FROM reginstitutions WHERE emailAddress ='$sent_to'";
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result))
        {
            $sent_to_id = $row['id'];	
        }
        $chat_identity = $sent_to."_".$emailAddress;
        $query = "INSERT INTO reports (chat_identity, message, sender_class, sent_from_id, emailAddress, sent_to_id, sent_to, readStatus) VALUES ('$chat_identity', '$message','$sender_class','$userId', '$emailAddress', '$sent_to_id', '$sent_to', '$readStatus')";
        if (mysqli_query($conn,$query)) 
        {
            echo "<script> window.location.href= '../chats/reports-messages.php?hosp-id=$sent_to_id'; </script>";	
            //add notifications here 
        } 
        else 
        {
            echo "Error: " . $query . "" . mysqli_error($conn) . "Could Not Send Message";
        }
        mysqli_close($conn);
    }
    elseif(($_SESSION['category']) == 'hospital'){
        $query2 = "SELECT id FROM regpatients WHERE emailAddress ='$sent_to'";
        $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        if(mysqli_num_rows($result) == 0){
            $query2 = "SELECT id FROM regdoctors WHERE emailAddress ='$sent_to'";
            $result = mysqli_query($conn, $query2) or die(mysqli_error($conn));
            if(mysqli_num_rows($result) == 0){
                echo "Error, Does not Exist from both patients and doctors records";
            }
        }
        while($row = mysqli_fetch_array($result))
        {
            $sent_to_id = $row['id'];	
        }
        $chat_identity = $emailAddress."_".$sent_to;
        $query = "INSERT INTO reports (chat_identity, message, sender_class, sent_from_id, emailAddress, sent_to_id, sent_to, readStatus) VALUES ('$chat_identity', '$message','$sender_class','$userId', '$emailAddress', '$sent_to_id', '$sent_to', '$readStatus')";
        if (mysqli_query($conn,$query)) 
        {
            $query3 = "SELECT MAX(id) FROM reports WHERE emailAddress ='$emailAddress'";
            $result = mysqli_query($conn, $query3) or die(mysqli_error($conn));
            while($row = mysqli_fetch_array($result))
            {
                $message_id = $row['id'];	
            }
            echo "<script> window.location.href= '../chats/reports-messages.php?id=$message_id'; </script>";	
            //add notifications here 
        } 
        else 
        {
            echo "Error: " . $query . "" . mysqli_error($conn) . "Could Not Send Message";
        }
        mysqli_close($conn);
    }
}
// book appointment date 
if(isset($_GET["a"]))
    if($_GET["a"] == "p"){{	
        //create session
        session_start();
        
        //store values submitted in the  form in variables
         $doctorID = $_GET['dID'];
         $patientID = $_GET['pID'];
         $appointmentDate = $_GET['d'];
         $appointmentTime = $_GET['t'];
         //statement to enter values into a table in the database
         $sql = "INSERT INTO appointments (doctorID, patientID, appointmentDate, appointmentTime)
         VALUES ('$doctorID','$patientID','$appointmentDate', '$appointmentTime')";
    
         //if sql query is not executed...
         if (mysqli_query($conn, $sql)) {
            echo '
            <script>window.location.href = "../calendar.php?p='.$patientID.'"</script>
            ';	
        }else{
                    //show error
            echo "Error: " . $sql . "
    " . mysqli_error($conn);
        
         }
         //close connection
         mysqli_close($conn);
    
    }}
?>