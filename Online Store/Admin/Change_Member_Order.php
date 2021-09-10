<?php

    require "../Config/config.php";
    session_start();

    if(isset($_SESSION["connecte"]) && isset($_SESSION["admin_id"]) && isset($_GET["function"]) && isset($_GET["order_id"]))
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
                    $id=$row["users_id"];
                    $output.='<tr>
                                <td>'.$id.'</td>
                                <td>'.$fname.' '.$lname.'</td>
                                <td>'.$email.'</td>
                                <td>
                                    <a href="Manage_Orders.php?order_id='.$_GET["order_id"].'&new_member_id='.$id.'" id="change"><i class="far fa-edit"></i><span>Change</span></a>
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
                if($_GET["function"]=="change")
                {
                ?>
                    <label id="order_id"><?php echo $_GET["order_id"] ?></label>
                    <h1 class="title">Change Member</h1>
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
                                    <th>#ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--
                                 <tr>
                                    <td>1</td>
                                    <td>Khalid issil</td>
                                    <td>issilk16@gmail.com</td>
                                    <td>
                                         <a href="#" id="change"><i class="far fa-edit"></i><span>Change</span></a>
                                    </td>
                                </tr>
                                -->

                                <?php echo $output ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="Orders.php?function=update&order_id=<?php echo $_GET["order_id"] ?>" class="return"><i class="fa fa-arrow-left" aria-hidden="true"></i><span>Return</span></a>
                     <?php
                } ?>
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Change_Member_Order.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>