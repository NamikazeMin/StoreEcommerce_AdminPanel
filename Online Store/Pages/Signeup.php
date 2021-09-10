<?php

    require_once '../Config/config.php';
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       $fname=filter_var($_POST["fname"],FILTER_SANITIZE_STRING); 
       $lname=filter_var($_POST["lname"],FILTER_SANITIZE_STRING);
       $email=$_POST["email"];
       $upass=filter_var($_POST["txtpassword"],FILTER_SANITIZE_STRING);
       $pass=password_hash($upass,PASSWORD_DEFAULT); 
       $output="";

       if(!empty($fname) && !empty($lname) && !empty($email) && !empty($pass))
       {
           //La Validation D email
            if(filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                        $query_deja_exeste="select * from users where user_email like '$email'";
                        $result_query_deja_exeste=mysqli_query($conn,$query_deja_exeste);
                        $count=mysqli_num_rows($result_query_deja_exeste);
                        if($count==0)
                        {
                            $random=rand(time(),10000000);
                            $query_insert="insert into users(users_id,user_randome,user_fname,user_lname,user_email,user_password,user_type) values(null,$random,'$fname','$lname','$email','$pass',0)";
                            if(mysqli_query($conn,$query_insert))
                            {
                                $output="yes";
                            }
                            else
                            {
                                $output="somthing was wrong";
                            }
                        }
                        else
                        {
                            //User Alreade Exeste 
                            $output.="<p>this email is Already Exeste</p>"; 
                        }
                     
                    
            }
           else
           {
            $output.="<p>this is not a valide Email</p>";
           }
       }
       else
       {
        $output.= "<p>All inputs Are Required</p>";
       }

       echo $output;
    }