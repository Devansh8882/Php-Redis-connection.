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

            Enter Id : <input type="number" placeholder="+ve integer" min=0 max=100 name="enter_id">
            Enter Name : <input type="text" placeholder="John" maxlength="20" name="name" pattern="[a-z,A-Z]{3,10}">

            <br> Enter Cast : <input type="text" placeholder="Mishra" name="cast" pattern="[a-z,A-Z]{3,10}">
            Enter DOB : <input type="date" name="dob">

            <br> Enter Class : <input type="number" placeholder="Class Division" min=1 max=12 name="class">
            Enter Marks : <br> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; 
            Minimum <input type="number" placeholder="Min Range" min=0 max=100 name="min">
            Maximim<input type="number" placeholder="Max Range " min=0 max=100 name="max">
            <br> Gender:
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender" value="male">Male
            <br>

            <button class="home-btn">SEARCH</button>

            &emsp; &emsp; <a href="1home.php"> <input type="button" value="HOME PAGE" class="home-btn"> </a>

    </form>
    <br> <br>


    <?php

    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);


    $id = $_POST["enter_id"];
    $name = $_POST["name"];
    $cast = $_POST["cast"];
    $dob = $_POST["dob"];
    $class = $_POST["class"];
    $min = $_POST["min"];
    $max = $_POST["max"];
    $gender = $_POST["gender"];

    // Redis key....
    $redis_id_key_set = "st:$id";
 
    $field = $redis->HMGET($redis_id_key_set, array("Name", "cast", "cls", "DOB", "TM", "Gender"));

    //array of redis keys...
    
    $total=$redis->keys('*');  //array

    $count = count($total);

    // check for each field 
    

    if ($id == "" && $name == "" && $cast == "" && $dob == "" && $class == "" && $min == "" && $max=="" && $gender == "") {
        echo "case 1 fulfilled ";
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

    } elseif ($id != "" || $name != "" || $cast != "" || $dob != "" || $class != "" || $min != "" || $max != "" || $gender != "") {


        if ($redis->EXISTS($redis_id_key_set) == 1) {

            echo "ID_match_case";
            $redis_hash_data = $redis->HGETALL($redis_id_key_set);


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
             
             </tr>";
         
            if (  ($name == "" || $name == $redis_hash_data['Name']) &&
                ($cast == "" || $cast == $redis_hash_data['cast']) &&
                ($dob == "" || $dob == $redis_hash_data['DOB']) &&
                ($class == "" || $class == $redis_hash_data['cls']) &&
                ($min == "" || $min <= $redis_hash_data['TM']) &&
                ($max == "" || $max >= $redis_hash_data['TM']) &&
                ($gender == "" || $gender == $redis_hash_data['Gender'])) 
            {
                echo " _other data is either empty or matches the data in redis  ";



                // echo "third loop";
                // echo "-------end--------- ";
    
        
                echo" <tr>
                    <td>$id</td>";

                foreach ($field as $value) {
                    # code...
                    echo "<td> $value </td>";
                }

                echo "</tr>
                    
                    </table>";

            } else {
                echo "<script>alert('Data Not Found')
                    </script>

                    <tr>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    <td>NULL</td>
                    </tr>
                    </table>";

                    }

            
    
            
            
        } elseif($id == "" || $id ==0) {
            
            echo "id not set case ";
            
            echo"$count";

            // $id=1;
            // echo "st:$id";
            
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
            
            </tr>";

            
            
            if($count !=0 ){
                for($id = 1; $redis->EXISTS("st:$id") == 1 ; $id++)
            
                {    
                    $redis_hash_data = $redis->HGETALL("st:$id");
                    
                                    
                                    
                    if(($name == "" || $name == $redis_hash_data['Name']) &&
                    ($cast == "" || $cast == $redis_hash_data['cast']) &&
                    ($dob == "" || $dob == $redis_hash_data['DOB']) &&
                    ($class == "" || $class == $redis_hash_data['cls']) &&
                    ($min == "" || $min <= $redis_hash_data['TM']) &&
                    ($max == "" || $max >= $redis_hash_data['TM']) &&
                    ($gender == "" || $gender == $redis_hash_data['Gender']))
                    {  
                        // $count--;
    
                        $field = $redis->HMGET("st:$id", array("Name", "cast", "cls", "DOB", "TM", "Gender"));
    
                        
                        
                        echo" <tr>
                        <td>$id</td>";
                        
                        foreach ($field as $value) {
                            # code...
                            echo "<td> $value </td>";
                        }
                        
                        echo "</tr>";
                        
                        
                        
                    }
    
                
                    else{
                        $count--;
                    
                        if($count==0){
                            echo "<script>alert('Data Not Found')
                            </script>

                            <tr>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            </tr>";

                        }
                    
                    }
                    // else {
                    //     // echo "<script>alert('Data Not Found')
                    //     // </script>";
                        
                    // }
                    
                    
    
                }
                
                echo "</table>";
                

            }
            else {
                // echo "<script>alert('Data Not Found')
                // </script>";

                echo "new condition arrived...";
                
            }

           
            
            
            // var_dump($test);
            // echo "else when id is not given".$test;

        }else {
            echo "<script>alert('Data Not Found')
            </script>";
        }
    }

    ?>



    </div>
    
</body>

</html>

