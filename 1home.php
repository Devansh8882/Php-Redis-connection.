<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="student.css" rel="stylesheet">

</head>

<body style="background-color: white; color: darkslategray " >

    <!-- Welcome to home page... -->

    <form method="POST" id="form" action="" >

        <h1>Student Form</h1>
        <label for="">ID</label>
        <input type="number" placeholder="+ve integer" min=0 max=100 required name="id"> <!--  max=100 -->

        <br>
        <label for="">Name</label>
        <input type="text" placeholder="John" maxlength="20" required name="name"  pattern="[a-z,A-Z]{3,10}" id="capital">           <!-- pattern="[a-z]{4,8}"  only alphabets and must be 4 to 8 letters -->
     
        <br>
        <label for="">Cast</label>
        <input type="text" placeholder="Mishra" name="cast" required  pattern="[a-z,A-Z]{3,10}" id="capital">

        <br>
        <label for="">DOB</label>
        <input type="date" name="dob" required> <!-- date  , placeholder="20oct"-->
        <br>

        <label for="">Class</label>
        <input type="number" placeholder="Class Division" min=1 max=12 name="class" required>
        <br>
        <label for="">Total Marks</label>
        <input type="number" placeholder="Total Marks Obtained" min=0 max=500 name="marks" required>
        <br>
        Gender:
        <input type="radio" name="gender" value="female">Female
        <input type="radio" name="gender" value="male" checked>Male
        <br>

        <button class ="info-btn" type="submit">Submit</button>
        <button class="info-btn" name = btn><a href="http://localhost/1search.php" target="_blank">Student info</button></a>

    </form>

    <?php
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST["id"];
        $name = $_POST["name"];
        $cast = $_POST["cast"];
        $dob = $_POST["dob"];
        $class = $_POST["class"];
        $marks = $_POST["marks"];
        $gender = $_POST["gender"];

        $key = "st:$id";
    

    // if(isset($_POST["btn"])){ 

   if (!$redis->EXISTS("$key")) {
        
        $field = array(
            "Name" => $name,
            "cast" => $cast,
            "cls" => $class,
            "DOB" => $dob,
            "TM" => $marks,
            "Gender" => $gender
        );
        
        $redis->hMset($key, $field);
        
        echo "<script>alert('Data added successfully')</script>";
    } 
    // elseif($id == " ")
    // {
    // //    echo " ";
    //        echo "<script>alert('Welcome to the page')</script>";
    // }
    else {
        echo "<script>alert('Submission failed')</script>";
        // echo "";
    }
    
    // }
    
    // else{
        //     echo "<script>alert('please enter data fields ')</script>";
        //   }   } 
     }   
      ?>

</body>

</html>
<!-- 
    
// if ($id = " ") {
    //     echo " ";
    // } 

    // if($redis->EMPTY($id)==0 || $redis->EMPTY($name)==0 || $redis->EMPTY($cast)==0 || $redis->EMPTY($dob)==0 || $redis->EMPTY($class)==0 || $redis->EMPTY($marks)==0 ||  $redis->EMPTY($gender)==0){
        
        
        // if($id && $name && $cast && $dob && $class && $marks && $geder){
            
            // if ($id < 0 ) {
                //     echo "<script>alert('Invalid Id')</script>";
                //     exit; -->