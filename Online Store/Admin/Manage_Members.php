<?php
    include "../Config/config.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["function"]))
    {
        $output="";
        if($_POST["function"]=="add")
        {
            $fname=$_POST["fname"];
            $lname=$_POST["lname"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $type=$_POST["type"];
            if(empty($fname) || empty($lname) ||empty($email) ||empty($password) ||empty($type))
            {   
                $output="<p>All Inputs Are Required</p>";
            }
            else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $output="<p>Invalide Email !</p>";
            }
            else
            {
                $fname=filter_var($fname,FILTER_SANITIZE_STRING);
                $lname=filter_var($lname,FILTER_SANITIZE_STRING);
                $email=filter_var($email,FILTER_SANITIZE_EMAIL);
                $password=filter_var($password,FILTER_SANITIZE_STRING);
                $type=filter_var($fname,FILTER_SANITIZE_STRING);
                $pass=password_hash($password,PASSWORD_DEFAULT); 
                if($type=="Admin")
                {
                    $type="1";
                }
                else
                {
                    $type="0";
                }
                $query_deja_exeste="select * from users where user_email like '$email'";
                $result_query_deja_exeste=mysqli_query($conn,$query_deja_exeste);
                $count=mysqli_num_rows($result_query_deja_exeste);
                if($count==0)
                {
                    $random=rand(time(),10000000);
                    $query_insert="insert into users(users_id,user_randome,user_fname,user_lname,user_email,user_password,user_type) values(null,$random,'$fname','$lname','$email','$pass',$type)";
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

        }
        else if($_POST["function"]=="update" && isset($_SESSION["member_updated_id"]))
        {
            $fname=$_POST["fname"];
            $lname=$_POST["lname"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $type=$_POST["type"];
            $randome_id=$_SESSION["member_updated_id"];
            if(empty($fname) || empty($lname) ||empty($email) ||empty($type))
            {   
                $output="<p>All Inputs Are Required</p>";
            }
            else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $output="<p>Invalide Email !</p>";
            }
            else
            {
                $fname=filter_var($fname,FILTER_SANITIZE_STRING);
                $lname=filter_var($lname,FILTER_SANITIZE_STRING);
                $email=filter_var($email,FILTER_SANITIZE_EMAIL);
                if($type=="User")
                {
                    $type=0;
                }
                else
                {
                    $type=1;
                }

                $query_email_deja_exeste="select * from users where user_email like '$email' and user_randome <> $randome_id";
                $resultat=mysqli_query($conn,$query_email_deja_exeste);
                if(mysqli_num_rows($resultat)==0)
                {
                    if(empty($password))
                    {
                        $query_update="update users SET user_fname='$fname',user_lname='$lname',user_email='$email',user_type=$type where user_randome=$randome_id";
                    }
                    else
                    {
                        $pass=password_hash($password,PASSWORD_DEFAULT); 
                        $query_update="update users SET user_fname='$fname',user_lname='$lname',user_email='$email',user_password='$pass',user_type=$type where user_randome=$randome_id";
                    }
                    if(mysqli_query($conn,$query_update))
                    {
                        $output="yes";
                    }
                    else
                    {
                        $output="<p>somthing was wrong</p>";
                    }
                }
                else
                {
                    $output="<p>Sorry this email is Already Existe In Another Account</p>";
                }
                

                           


            }

        }
        else
        {
            $output= "<p>somthing was wrong</p>";
        }
    }
    else
    {
        session_unset();
        session_destroy();
        $output= "errorconnection";
    }
    echo $output;


