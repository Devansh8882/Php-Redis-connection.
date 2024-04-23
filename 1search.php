<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="demo2.css" rel="stylesheet">
</head>

<body style="background-color: white; color: lightcyan;">


    <form method="POST" id="form" action="">
        <div>
            <h1 class="se"> Student Enquiry</h1>
           
            Enter Id : <input type="number" placeholder="+ve integer" min=0 max=100 name="id" required>
            <!-- Enter Name : <input type="text" placeholder="John" maxlength="20"  name="name"  pattern="[a-z][A-Z]{2,10}"> 
           
            <br> Enter Cast : <input type="text" placeholder="Mishra" name="cast"   pattern="[a-z][A-Z]{2,10}" >
            Enter DOB :  <input type="date" name="dob" >
           
            <br> Enter Class : <input type="number" placeholder="Class Division" min=1 max=12 name="class" >
            Enter Marks :  <input type="number" placeholder="Total Marks Obtained" min=0 max=500 name="marks" >
         <br> Gender:
        <input type="radio" name="gender" value="female">Female
        <input type="radio" name="gender" value="male" >Male
        <br> -->

            <button class ="home-btn">SEARCH</button>
          
            &emsp;  &emsp; <a href="1home.php"> <input type="button" value="HOME PAGE" class ="home-btn"> </a>

    </form>
    <br> <br> <?php

    // echo"welcome to the page "; 
    
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);


    $id = $_POST["id"];
    $name = $_POST["name"];
    $cast = $_POST["cast"];
    $dob = $_POST["dob"];
    $class = $_POST["class"];
    $marks = $_POST["marks"];
    $gender = $_POST["gender"];

 

    //  echo "student:$id_num ";
    
    $field = $redis->HMGET("st:$id", array("Name", "cast", "cls", "DOB", "TM", "Gender"));

    //  print_r($field);
    



    if (!$id) {

        // echo"<br>Please enter ID before searching";
        echo "<br><table border='1' style =' background-color: black;'>
     <caption>Student Info</caption>
     <tr>
         <th>ID</th>
         <th>Name</th>           
         <th>Cast</th>
         <th>Class</th>
         <th>Date Of Birth</th>
         <th>Total Marks</th>
         <th>Gender</th>

     </tr>

     <tr>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     </tr>";


        //  die();
    } elseif ($redis->EXISTS("st:$id") == 0) {
        echo "<br>WRONG ID...! <br> Check data and enter correct ID";
        echo "<table border='1' style =' background-color: black;'>
        <caption>Student Info</caption>
        <tr>
        <th>ID</th>
        <th>Name</th>           
            <th>Cast</th>
            <th>Class</th>
            <th>Date Of Birth</th>
            <th>Total Marks</th>
            <th>Gender</th>
   
        </tr>";


        // die();
    } else {
        echo "<table id='table' border='1' >
        <caption>Student Info</caption>
        <tr>
            <th>ID</th>
            <th>Name</th>           
            <th>Cast</th>
            <th>Class</th>
            <th>Date Of Birth</th>
            <th>Total Marks</th>
            <th>Gender</th>
            
        </tr>
        
        <tr>
            <td>$id</td>";


        foreach ($field as $value) {
            # code...
            echo "<td> $value </td>";
        }

        echo "</tr>
           
           </table>";
    }

    ?>
    </div>



</body>

</html>




<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="demo2.css" rel="stylesheet">
</head>

<body style="background-color: white; color: lightcyan;">


    <form method="POST" id="form" action="">
        <div>
            <h1 class="se"> Student Enquiry</h1>
            Enter Id : <input type="text" id="t1" placeholder="Enter Id " name="st">

            <button class ="home-btn">SEARCH</button>
          
            &emsp;  &emsp; <a href="1home.php"> <input type="button" value="HOME PAGE" class ="home-btn"> </a>

    </form>
    <br> <br> <?php

    // echo"welcome to the page "; 
    
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);


    $id_num = $_POST["st"];

    //  echo "student:$id_num ";
    
    $field = $redis->HMGET("st:$id_num", array("Name", "cast", "Cls", "DOB", "TM", "Gender"));

    //  print_r($field);
    



    if (!$id_num) {

        // echo"<br>Please enter ID before searching";
        echo "<br><table border='1' style =' background-color: black;'>
     <caption>Student Info</caption>
     <tr>
         <th>ID</th>
         <th>Name</th>           
         <th>Cast</th>
         <th>Class</th>
         <th>Date Of Birth</th>
         <th>Total Marks</th>
         <th>Gender</th>

     </tr>

     <tr>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     <td>NULL</td>
     </tr>";


        //  die();
    } elseif ($redis->EXISTS("st:$id_num") == 0) {
        echo "<br>WRONG ID...! <br> Check data and enter correct ID";
        echo "<table border='1' style =' background-color: black;'>
        <caption>Student Info</caption>
        <tr>
        <th>ID</th>
        <th>Name</th>           
            <th>Cast</th>
            <th>Class</th>
            <th>Date Of Birth</th>
            <th>Total Marks</th>
            <th>Gender</th>
   
        </tr>";


        // die();
    } else {
        echo "<table id='table' border='1' >
        <caption>Student Info</caption>
        <tr>
            <th>ID</th>
            <th>Name</th>           
            <th>Cast</th>
            <th>Class</th>
            <th>Date Of Birth</th>
            <th>Total Marks</th>
            <th>Gender</th>
            
        </tr>
        
        <tr>
            <td>$id_num</td>";


        foreach ($field as $value) {
            # code...
            echo "<td> $value </td>";
        }

        echo "</tr>
           
           </table>";
    }

    ?>
    </div>



</body>

</html>
 -->







<!-- <div id="tf">
    Student details :<br> <textarea name="textfield" id="detail" cols="30" rows="10"></textarea>
    </div> -->