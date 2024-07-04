

<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);



function addJsonToSet($redis,$key_name,$value_name,$id){
  
   
    $exits = $redis->HEXISTS($key_name,$value_name);
    
        if($exits==1){
    
           $data = $redis->hget($key_name,$value_name);
    
        //    var_dump($data);
    
           $jsonData = json_decode($data,true);
    
               array_push($jsonData,$id);
    
          $redis->hset($key_name,$value_name,json_encode($jsonData));
    
        }
        
        if(!$exits==1){
    
            $data= [$id];
    
            // echo "in else loop condition";   
            
            //   echo$key_name;
            //    echo $value_name;
            //     echo  $id;
            $redis->hset($key_name, $value_name,json_encode($data));
    
    
        }
    
    }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST["id"]);
    $name = $_POST["name"];
    $cast = $_POST["cast"];
    $dob = trim($_POST["dob"]);
    $class = trim($_POST["class"]);
    $marks = trim($_POST["marks"]);                     
    $gender = trim($_POST["gender"]);
    
    if($dob !='') {
        $dobTimeStamp = strtotime($dob);
        $dob = date("d-M-Y",$dobTimeStamp);
    }

    
    $errors = false;
    // Validation
    if ($id < 1) {
        $errors = true;
        // echo 1;

    }

    if (!preg_match('/^[a-zA-Z]{3,10}$/', $name)) {
        $errors = true;
        // echo 2;
    }

    if (!preg_match('/^[a-zA-Z]{3,10}$/', $cast)) {
        $errors = true;
        // echo 3;
    }

    if (strtotime($dob) >= strtotime(date("Y-m-d"))) {
        $errors = true;
        // echo 4;
    }

    if ($class < 1 || $class > 12) {
        $errors = true;
        // echo 5;
    }

    if ($marks <= 0 || $marks >= 100) {
        $errors = true;
        // echo 6;
    }

    if (empty($gender)) {
        $errors = true;
        // echo 7;
    }
    
// echo $errors;
    if (!$errors) {
       
      
        $key = "user-info";

        if (!$redis->HEXISTS($key,$id)) {
            $field = [
                "name" => $name,
                "cast" => $cast,
                "class" => $class,
                "dob" => $dob,
                "marks" => $marks,
                "gender" => $gender
            
            ];
         
            
            $redis->hset("user-info", $id,json_encode($field));

            foreach ($field as $key_name=>$value_name) {
                
                addJsonToSet($redis,$key_name,$value_name,$id);
              }


            echo "<script>alert('Data added successfully')</script>";


        }
         else {
            echo "<script>alert('ID Already Exist')</script>";
        }
    }
    // else{
    //     echo "<script>alert('Failed To Submit Data')</script>";
    // }
    
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="home.css" rel="stylesheet">



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body >

    <!-- Welcome to home page... -->


    
    <form method="POST" id="form" action="">

        <h1>Student Form</h1>
       
        <label for="id">ID<input type="number" placeholder="+ve integer" name="id" id="id" class="align"></label>  <!--  min=0 max=100 -->

    <br>
        
        <label for="name">Name <input type="text" placeholder="John" name="name" id="name" class="capital align"></label> 

        <!-- pattern="" maxlength = 10  min=0 max=100 -->
        <!-- pattern="[a-z]{4,8}"  only alphabets and must be 4 to 8 letters -->

        <br>
        <label for="cast">Cast <input type="text" placeholder="Mishra" name="cast" class="capital align" id="cast"></label> 

        <!--  pattern=""  min=0 max=100 -->
 
        <br>
        <label for="dob">DOB  <input type="date" name="dob" id="dob" max="<?php echo date("Y-m-d"); ?>"  >  </label>   <!-- date  , placeholder="20oct"-->

        <br><br>

        <label for="class">Class <input type="number" placeholder="Class Division" name="class" id="class" class="align"></label> <!-- min=1 max=12 min=0 max=100 -->

        <br>
        <label for="marks">Total Marks <input type="number" placeholder="Total Marks Obtained" name="marks" id="marks" class="align"></label> <!-- min=0 max=500 min=0 max=100 -->

        <br>
        <label for="sender">gender : </label>
       <!-- <label for="sender" id="gender">Female <input type="radio" name="gender" value="female" ></label>
        <label for="sender" id="gender">Male <input type="radio" name="gender" value="male" > </label> -->
       <label for="sender" id="gender" >Male <input type="radio" name="gender" value="male" checked>Female <input type="radio" name="gender" value="female" ></label>
        <br>

        <button class="info-btn " id="submit-form" type="submit">Submit</button>
        <button class="info-btn" name=btn><a href="http://localhost/1search.php" target="_blank">Student
                info</button></a>

    </form>


    <script>
        $(document).ready(function () {


            $("#submit-form").on("click", function (e)  {

                e.preventDefault();

                console.log("ready for sub");

                const formData = {
                    id: $("#id").val(),
                    name: $("#name").val(),
                    cast: $("#cast").val(),
                    dob: $("#dob").val(),
                    class: $("#class").val(),
                    marks: $("#marks").val(),
                    gender: $('input[name="gender"]:checked').val(),
                };


                let isValid = true;

                $.each(formData, function (key, value) {
                    if (!value) {
                        alert("Please fill out the " + key);
                        isValid = false;
                        return false;
            
                    }
                });


                    const id = $("#id").val()
                    if (id < 1) {
                        alert("Please enter a valid ID");
                        return false;
                        
                    }

                    const name = $("#name").val();
                    const namePattern = /^[a-z,A-Z]{3,10}$/;
                    if (!namePattern.test(name)) {
                        alert("Please enter a valid name");
                        return false;
                        
                    }



                    const cast = $("#cast").val();
                    const castPattern = /^[a-z,A-Z]{3,10}$/;
                    if (!castPattern.test(cast)) {
                        alert("Please enter a valid Cast");
                        return false;
                        
                    }


                    const dob = $("#dob").val();
                    const dobDate = new Date(dob);
                    const today = new Date();

                    if (dobDate >= today) {
                        alert("Please enter a valid Date of Birth");
                        return false;
                        
                    }


                    const class1 = $("#class").val()
                    if (class1 < 0 || class1 > 12) {
                        alert("Please enter a valid Class");
                        return false;
                        
                    }


                    const marks = $("#marks").val()
                    if (marks < 0 || marks > 100) {
                        alert("Please enter a valid Marks");
                        return false;
                        
                    }

                if (isValid) {
                    // console.log(isValid);
                    $("#form").submit();
                }

            });
        });
    </script>



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
