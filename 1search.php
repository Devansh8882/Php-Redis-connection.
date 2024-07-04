<!DOCTYPE html>
<html lang="en"> 

<head>
    <title>Student Info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="search.css" rel="stylesheet">
</head>

<body style="background-color: white; color: lightcyan;">


    <form method="POST" id="form" action="">
        <div>
            <h1 class="se"> Student Enquiry</h1>

            Enter Name : <input type="text" placeholder="John" maxlength="20" name="name" pattern="[a-z,A-Z]{3,10}">
            &emsp; &emsp; &emsp; &emsp;
            Enter Cast : <input type="text" placeholder="Mishra" name="cast" pattern="[a-z,A-Z]{3,10}" id="cast">
            <br><br>
            Enter Id : <input type="number" placeholder="+ve integer" min="1" name="id">
            &emsp; &emsp; &emsp;
            Enter Class : <input type="number" placeholder="Class Division" min=1 max=12 name="class">
            &emsp; &emsp; &emsp;
            Enter DOB : <input type="date" name="dob" id="dob" max="<?php echo date("Y-m-d"); ?> ">

            <br> <br>
            Gender: &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;&emsp; &emsp; Enter Marks :
            <br>&emsp; &emsp;
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender" value="male">Male
            &emsp; &emsp; &emsp; &emsp; &emsp;&emsp;
            Minimum <input type="number" placeholder="Min Range" min=0 max=100 name="min">
            Maximim<input type="number" placeholder="Max Range " min=0 max=100 name="max">
            <br>
            <br> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
            <button class="home-btn">SEARCH</button>

            &emsp; &emsp;
            <a href="1home.php"> <input type="button" value="HOME PAGE" class="home-btn"> </a>

    </form>
    <br> <br>


    <?php

    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    
    //ARRAY.....

   
    $id = trim($_POST["id"]);
    $name = trim($_POST["name"]);
    $cast = trim($_POST["cast"]);
    $dob = trim($_POST["dob"]);
    $class = trim($_POST["class"]);
    $min = trim($_POST["min"]);
    $max = trim($_POST["max"]);
    $gender = trim($_POST["gender"]);


    // Redis key....
    $key_name = "user-info";


    function fatch_data($redis, $key_name, $field)
    {
        $data = $redis->hget($key_name, $field);

        // var_dump($data);
    
        $jsonData = json_decode($data, true);

        // var_dump($jsonData);  
    
        return $jsonData;

    }





    //redis key ,,.,.,.,.,
    

    
        // $fieldArr = array('');   CHECK...
    if (!$id && !$name && !$cast && !$dob && !$class && !$min && !$max && !$gender) {
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

        echo "inside first condition ";

        // if(min !="" || max != "") {}
        
        

        if ($id != "") {


            if ($redis->HEXISTS($key_name, $id) == 1) {

                echo "ID_match_case";



                $json_data = fatch_data($redis, $key_name, $id);





                echo "<table id='table' border='1' style =' background-color: black;'>
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



                if (
                    ($name == "" || $name == $json_data['name']) &&
                    ($cast == "" || $cast == $json_data['cast']) &&
                    ($dob == "" || $dob == $json_data['dob']) &&
                    ($class == "" || $class == $json_data['class']) &&
                    ($min == "" || $min <= $json_data['marks']) &&
                    ($max == "" || $max >= $json_data['marks']) &&
                    ($gender == "" || $gender == $json_data['gender'])
                ) {
                    // echo " _other data is either empty or not matches the data in redis  ";


                    echo " <tr>
                    <td>$id</td>";

                    foreach ($json_data as $value) {
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

            }
        } elseif ($id == "" || $id == 0) {

            echo "id not set case ";
            // echo "$count";

            // $id=1;
            // echo "st:$id";
    
            echo "<table id='table' border='1' style =' background-color: black;'>
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

                    // OTHER FIELD SET CASE........
                  
                    if ( $name != "" || $cast != "" || $dob != "" || $class != "" || $gender != "") 
                        {
                            echo "OTHER FIELD set case ";

                            $rKey="";
                            $fieldKey="";

                           $fieldArr = array('name', 'cast', 'dob', 'class', 'gender');
                             foreach($fieldArr as $field){
                                if(isset($_REQUEST[$field]) && trim($_REQUEST[$field])!=""){
                                    $rKey = $field;
                                    $fieldKey = trim($_REQUEST[$field]);   
                                
                                }  }
                                  


                                    if($redis->HEXISTS($rKey,$fieldKey)==1){
                                   $searchIds =  json_decode($redis->hget($rKey,$fieldKey),true);

                                   $idsCount = count($searchIds);
                                   

                                   for ($i=0; $i < $idsCount ; $i++) { 
                                    # code...
                                    $json_data = fatch_data($redis, $key_name, $searchIds[$i]);

                                    //  var_dump($json_data);

                                    if (
                                        ($name == "" || $name == $json_data['name']) &&
                                        ($cast == "" || $cast == $json_data['cast']) &&
                                        ($dob == "" || $dob == $json_data['dob']) &&
                                        ($class == "" || $class == $json_data['class']) &&
                                        ($min == "" || $min <= $json_data['marks']) &&
                                        ($max == "" || $max >= $json_data['marks']) &&
                                        ($gender == "" || $gender == $json_data['gender'])
                                    ) {
                                        // echo " _other data is either empty or not matches the data in redis  ";
                    
                    
                                        echo " <tr>
                                        <td>$searchIds[$i]</td>";
                    
                                        foreach ($json_data as $value) {
                                            # code...
                                            echo "<td> $value </td>";
                                        }
                    
                                        echo "</tr>";
                                        
                                    } 
                                        
                                        
                                        
                                    }  echo "</table>";

                                 }
                                    
                                    else {
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
                        

                                    
                             }
                                // MIN AND MAX CASE HERE .......
                                
                        else   
                        {
                            echo "MIN MAX set case ";  
                            
                         
                            // FOR RANGE.....
                          
                           $min = empty($min)? 1 : $min;  
                           $max = empty($max)? 100 : $max;

              
                           
                            while( $min <= $max ) { 
                                # code...
                                // echo $min,$max;

                                if($redis->HEXISTS("marks",$min)==0){

                                    $min++;
                                }

                              elseif($redis->HEXISTS("marks",$min)==1){
                                 $searchIds =  json_decode($redis->hget("marks",$min),true);
 
                                    $idsCount = count($searchIds);

            //   var_dump($searchIds);
                                    
                                    for ($i=0; $i < $idsCount ; $i++) { 
                                        # code...
                                        

                                        $json_data = fatch_data($redis, $key_name , $searchIds[$i]);
    
                                        //  var_dump($json_data);
    
                                        
                                            // echo " _other data is either empty or not matches the data in redis  ";
                        
                        
                                            echo " <tr>
                                            <td>$searchIds[$i]</td>";
                        
                                            foreach ($json_data as $value) {
                                                # code...
                                                echo "<td> $value </td>";
                                            }
                        
                                            echo "</tr>";
                                            
                                        

                                    //INCREMENT.....
                                    
                                        $min++;
                                            
                                            
                                            
                                        }  
                                    } 

                                    else{
                                        
                                    }
                                   
 

                            } echo "</table>";
                            

                        }
                       






         

            
        }
    
    }

   

    ?>



    </div>

</body>

</html>












<!-- //  elseif ($redis->EXISTS($redis_id_key_set) == 0) {

//     echo "data not found 2"; -->


<!-- 
    // $redis_hash_data = $redis->HGETALL($redis_id_key_set);
    // $aa=$redis_hash_data['Name'];
            // echo"$aa"; -->




            <!-- // else {
    

    //                     continue;
    
    //                 }
    //                 // else {
    //                 //     // echo "<script>alert('Data Not Found')
    //                 //     // </script>";
    
    //                 // }
    


    //                 // if($count==0){
    //                 //     echo "<script>alert('Data Not Found')
    //                 //     </script>
    
    //                 //     <tr>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     <td>NULL</td>
    //                 //     </tr>";
    
    //                 // }
    
    //             }
    
    //             echo "</table>";
    

    //         } else {
    //             echo "<script>alert('Data Not Found')
    //             </script>";
    
    //             // echo "";
    
    //         }
    



    //         // var_dump($test);
    //         // echo "else when id is not given".$test;
    
    //     } else {
    //         echo "<script>alert('Data Not Found')
    //         </script>";
     -->

<!-- 
     // $count=0;      // count ++ if any data matches
    
    // for ($id = 1; $id <= $count; $id++) {   // echo"$count";
      //     //  $count--;

      //     $redis_hash_data = $redis->HGETALL("st:$id");


          // if (
          //     ($redis->EXISTS("st:$id") == 1) &&
          //     ($name == "" || $name == $redis_hash_data['Name']) &&
          //     ($cast == "" || $cast == $redis_hash_data['cast']) &&
          //     ($dob == "" || $dob == $redis_hash_data['DOB']) &&
          //     ($class == "" || $class == $redis_hash_data['cls']) &&
          //     ($min == "" || $min <= $redis_hash_data['TM']) &&
          //     ($max == "" || $max >= $redis_hash_data['TM']) &&
          //     ($gender == "" || $gender == $redis_hash_data['Gender'])
          // ) {


          //     $field = $redis->HMGET("st:$id", array("Name", "cast", "cls", "DOB", "TM", "Gender"));



          //     echo " <tr>
          //             <td>$id</td>";

          //     foreach ($field as $value) {
          //         # code...
          //         echo "<td> $value </td>";
          //     }

          //     echo "</tr>";



          // } -->

<!-- 
    // $field = $redis->HMGET($redis_id_key_set, array("Name", "cast", "cls", "DOB", "TM", "Gender"));       //get fields from redis ......
    

    // max value among all the keys 
    
    // $redis_keys = $redis->keys('*');  //array
    
    // Array to store the extracted numbers
    

    // $key_numbers = [];
    
    // foreach ($redis_keys as $key) {
    
    //     if (preg_match('/st:(\d+)/', $key, $matches)) {
    //         // Store the number in the key_num variable
    //         $key_num = $matches[1];
    //         // Add the number to the array
    //         $key_numbers[] = $key_num;
    //     }
    // }
    

    // $count =  max($key_numbers);
    
    // check for each field -->
