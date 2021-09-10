<?php

    require_once '../Config/config.php';
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       $user=$_POST["email"];
       $pass=$_POST["password"];
       $output="";
       if(!empty($user) && !empty($pass))
       {
           if(!filter_var($user,FILTER_VALIDATE_EMAIL))
           {
            $output.="<p>This Is Not An Correct Email !</p>";              
           }
           else
           {
                $query="select * from users where user_email like '$user'";
                $count=mysqli_query($conn,$query);
                if(mysqli_num_rows($count)>0)
                {
                    while($row=$count->fetch_assoc())
                    {
                        $datapasse=$row["user_password"];
                        $type=$row["user_type"];
                        $randome_id=$row["user_randome"];
                        if(password_verify($pass,$datapasse))
                        {
                            $_SESSION["connecte"]=true;
                            if($type==0)
                            {
                                $output="user";
                            }
                            else
                            {
                                $_SESSION["admin_id"]=$randome_id;
                               $output="admin";
                            }
                        }
                        else
                        {
                            $output="<p>Your Password Is Incorrect</p>";
                        }
                        
                    }
                }
                else
                {
                    $output="<p>Account Not Found </p>";
                }
           }
       }
       else
       {
        $output="<p>All inputs Are Required</p>";
       }
       echo $output;
    }
    else
    {
        echo "non";
    }