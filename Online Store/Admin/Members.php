<?php

    require "../Config/config.php";
    session_start();

    if(isset($_SESSION["connecte"]) && isset($_SESSION["admin_id"]) && isset($_GET["function"]))
    {   


        //Ladmin est Exeste 
        $admin_random=$_SESSION["admin_id"];
        $query_check_admin="select * from users where user_randome = $admin_random";
        if(mysqli_num_rows(mysqli_query($conn,$query_check_admin))>0)
        {
            $query_get_all_users="select * from users";
            $resultat=mysqli_query($conn,$query_get_all_users);
            $output="";
            if(mysqli_num_rows($resultat)>0)
            {
                while($row=$resultat->fetch_assoc())
                {
                    $fname=$row["user_fname"];
                    $lname=$row["user_lname"];
                    $email=$row["user_email"];
                    $type=$row["user_type"];
                    $random=$row["user_randome"];
                    if($type==1)
                    {
                        $type="Admin";
                    }
                    else
                    {
                        $type="User";
                    }
                    $output.='<tr>
                    <td>'.$fname.' '.$lname.'</td>
                    <td>'.$email.'</td>
                    <td>'.$type.'</td>
                    <td>
                    <a href="'.$_SERVER["PHP_SELF"].'?function=update&user_id='.$random.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                    <a href="'.$_SERVER["PHP_SELF"].'?function=delete&user_id='.$random.'"  id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                    </td>
                    </tr>';
                }
            }
            
        }
        else
        {
            header("Location: ../index.html");
        }
    }
    else
    {
        header("Location: ../index.html");
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/header.css">
    <link rel="stylesheet" href="../Css/Members.css">
    <title>Document</title>
</head>
<body>
        <div class="error_network" id="error_network">
            <i class="fa fa-wifi" aria-hidden="true"></i><p>Please Check Your Network !</p>
        </div>
    <div class="container">
        <?php 
        include_once 'header.php';
        ?>
        <div class="content">
            <?php 
                if($_GET["function"]=="show")
                {
                ?>
                    <h1 class="title">Manage Members</h1>
                    <div class="users_search">
                        <div class="errortext" id="errorsearchbox">
                            <!-- For Searcg Errors --->
                        </div>
                        <div class="searchbox">
                            <input type="text" id="txtsearch" placeholder="type Email to search ...">
                            <button id="btnsearch">Search</button>
                        </div>
                    </div>
                    <div class="members_liste">
                        <table id="users_table">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                         <!--   <tr>
                                <td>Khalid Issil</td>
                                <td>issilk16@gmail.com</td>
                                <td>Admin</td>
                                <td>
                                <a href="#" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="#" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                </td>
                            </tr>-->
                            <?php echo $output ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="Members.php?function=add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i><span>Add new user</span></a>
                
            <?php
                }
                else if($_GET["function"]=="add")
                {?>
                    <h1 class="title">Add New Member</h1>
                    <div class="form">
                    <div class="error_message" id="error_message">
                        <p>this is an error message</p>
                    </div>
                    <div class="username" id="divusername">
                            <div class="fname">
                                <label>First Name</label>
                                <input type="text" id="fname" autocomplete="off" placeholder="first name" data-place="first name">
                            </div>
                            <div class="lname">
                                <label>Last Name</label>
                                <input type="text" id="lname" autocomplete="off" placeholder="last name" data-place="last name">
                            </div>
                    </div>
                    <div class="useremail">
                            <label>Email</label>
                            <input type="text" id="email" autocomplete="off" placeholder="Type The Email" data-place="Type The Email">
                    </div>
                    <div class="userpassword">
                            <label>Password</label>
                            <input type="text" id="password" autocomplete="off" placeholder="Type The Password" data-place="Type The Password">
                    </div>
                    <div class="usertype">
                            <div class="typeuser">
                            <label for="f-option" class="l-radio">
                                <input type="radio" id="f-option" class="rdbuser" name="selector" tabindex="1">
                                <span>User</span>
                            </label>
  
                            </div>
                            <div class="typeadmin">
                            <label for="s-option" class="l-radio">
                                <input type="radio" id="s-option" class="rdbadmin" name="selector" tabindex="2">
                                <span>Admin</span>
                            </label>
                            </div>
                    </div>
                    <div class="add">
                        <button id="btnadd">Add Member</button>
                    </div>
                    </div>
             
            <?php   }
            else if($_GET["function"]=="update" && isset($_GET["user_id"]))
            {
                $query_get_info="select * from users where user_randome = ".$_GET["user_id"];
                $resultat=mysqli_query($conn,$query_get_info);
                if(mysqli_num_rows($resultat)>0)
                {
                    while($row=$resultat->fetch_assoc())
                    {
                        $fname=$row["user_fname"];
                        $lname=$row["user_lname"];
                        $email=$row["user_email"];
                        $type=$row["user_type"];
                        $_SESSION["member_updated_id"]=$_GET["user_id"];
                    }
                    ?>
                        <h1 class="title">Update Member</h1>
                        <div class="form">
                            <div class="error_message" id="error_message">
                            </div>
                            <div class="username" id="divusername">
                                    <div class="fname">
                                        <label>First Name</label>
                                        <input type="text" id="fname" autocomplete="off" placeholder="first name" value="<?php echo $fname ?>">
                                    </div>
                                    <div class="lname">
                                        <label>Last Name</label>
                                        <input type="text" id="lname" autocomplete="off" placeholder="last name" value="<?php echo $lname ?>">
                                    </div>
                            </div>
                            <div class="useremail">
                                    <label>Email</label>
                                    <input type="text" id="email" autocomplete="off" placeholder="Type The Email" value="<?php echo $email ?>">
                            </div>
                            <div class="userpassword">
                                    <label>Password</label>
                                    <input type="text" id="password" autocomplete="off" placeholder="Type The Password">
                            </div>
                            <div class="usertype">
                                    <div class="typeuser">
                                    <label for="f-option" class="l-radio">
                                        <input type="radio" id="f-option" class="rdbuser" name="selector" <?php if($type==0)echo "checked" ?> tabindex="1">
                                        <span>User</span>
                                    </label>
        
                                    </div>
                                    <div class="typeadmin">
                                    <label for="s-option" class="l-radio">
                                        <input type="radio" id="s-option" class="rdbadmin" name="selector" <?php if($type==1)echo "checked" ?> tabindex="2">
                                        <span>Admin</span>
                                    </label>
                                    </div>
                            </div>
                            <div class="add">
                                <button id="btnadd">Update Member</button>
                            </div>
                            </div>

                <?php
                }
                else
                {
                    header("Location: Members.php?function=show");
                }
                ?>
                
            <?php }
            else if($_GET["function"]=="delete" && isset($_GET["user_id"]))
            {
                $query_get_info="select * from users where user_randome = ".$_GET["user_id"];
                $resultat=mysqli_query($conn,$query_get_info);
                if(mysqli_num_rows($resultat)>0)
                {
                    while($row=$resultat->fetch_assoc())
                    {
                        $fname=$row["user_fname"];
                        $lname=$row["user_lname"];
                    }

                    $query_delete="delete from users where user_randome=".$_GET["user_id"];
                    if(mysqli_query($conn,$query_delete))
                    {
                ?>
                    <h1 class="title">Delete Member</h1>
                    <div class="Rapport">
                        <div class="Message succes">
                            <p>the user <label><?php echo $fname. ' '.$lname ?> </label>  is successfully deleted </p>
                        </div>
                        <div class="redirect">
                            <a href="Members.php?function=show" id="return_to_members">Return To Members Page</a>
                        </div>
                    </div>
                <?php
                 }
                 else
                 { ?>
                        <h1 class="title">Delete Member</h1>
                        <div class="Rapport">
                            <div class="Message error">
                                <p>somthing was wrong Try Again  !</p>
                            </div>
                            <div class="redirect">
                                <a href="Members.php?function=show" id="return_to_members">Return To Members Page</a>
                            </div>
                        </div>
                        <?php 
                 }
               }
               else
               {
                session_unset();
                session_destroy();
                header("Location: ../index.html");
               }
           
            }
            else
            {?>
                <script>
                    window.location="../Page Errors/404/Page404.html";
                </script>
           <?php }
            
            ?>
           
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/members.js"></script>
    <script src="../Js/AddMember.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>
