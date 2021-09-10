<?php

    require "../Config/config.php";
    session_start();

    if(isset($_SESSION["connecte"]) && isset($_SESSION["admin_id"]))
    {   
        //Ladmin est Exeste 
        $admin_random=$_SESSION["admin_id"];
        $query_check_admin="select * from users where user_randome = $admin_random";
        if(mysqli_num_rows(mysqli_query($conn,$query_check_admin))>0)
        {

            //Get Total Users
            $query_get_Total_memebers="select count(*) as nombre from users";
            $resultat=mysqli_query($conn,$query_get_Total_memebers);
            while($row=$resultat->fetch_assoc())
            {
                $total_members=$row["nombre"];
            }
            

            //Get Total Brandes
            $query_get_Total_brandes="select count(*) as nombre from brandes";
            $resultat=mysqli_query($conn,$query_get_Total_brandes);
            while($row=$resultat->fetch_assoc())
            {
                $total_brandes=$row["nombre"];
            }


            //Get Total Products
            $query_get_Total_products="select count(*) as nombre from product";
            $resultat=mysqli_query($conn,$query_get_Total_products);
            while($row=$resultat->fetch_assoc())
            {
                $total_products=$row["nombre"];
            }

            //Get Total Orders
            $query_get_Total_orders="select count(*) as nombre from orders";
            $resultat=mysqli_query($conn,$query_get_Total_orders);
            while($row=$resultat->fetch_assoc())
            {
                $total_orders=$row["nombre"];
            }



            //Get The 6 Latest Members
            $query_get_Last_Users="select * FROM users order by users_id desc LIMIT 6";
            $resultat=mysqli_query($conn,$query_get_Last_Users);
            $last_users="";
            if(mysqli_num_rows($resultat)>0)
            {
                while($row=$resultat->fetch_assoc())
                {
                    $firstname=$row["user_fname"];
                    $lastname=$row["user_lname"];
                    $random=$row["user_randome"];
                    $last_users.='<div class="user">
                    <label class="username">'.$firstname.' '.$lastname.'</label>
                    <label class="edit"><a href="Members.php?function=update&user_id='.$random.'"><i class="far fa-edit"></i><span>Edit</span></a></label>
                    </div>';
                }
            }
            else
            {
                $last_users='<p>Aucun User Now</p>';
            }
          

            //Get The 6 Latest Products
            $query_get_Last_Products="select * FROM product order by product_id desc LIMIT 6";
            $resultat=mysqli_query($conn,$query_get_Last_Products);
            $last_products="";
            if(mysqli_num_rows($resultat)>0)
            {
                while($row=$resultat->fetch_assoc())
                {
                    $product_title=$row["product_title"];
                    $last_products.='<div class="product">
                    <label class="product_name">'.$product_title.'</label>
                    <label class="edit"><a href="#"><i class="far fa-edit"></i><span>Edit</span></a></label>
                    </div>';
                }
            }
            else
            {
                $last_products='<p>no product for the moment</p>';
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
    <link rel="stylesheet" href="../Css/admin_index.css">
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
            <h1 class="title">Welcome To Admin Panel</h1>
            <div class="rapport">
                <a href="Members.php?function=show" class="rap">
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="details">
                        <p>Total Members</p>
                        <span><?php echo $total_members; ?></span>
                    </div>
                </a>
                <a href="Brandes.php?function=show" class="rap">
                    <div class="icon">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                    </div>
                    <div class="details">
                        <p>Total Brandes</p>
                        <span><?php echo $total_brandes; ?></span>
                    </div>
                </a>
                <a href="Products.php?function=show" class="rap">
                    <div class="icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="details">
                        <p>Total Products</p>
                        <span><?php echo $total_products; ?></span>
                    </div>
                </a>
                <a href="#" class="rap">
                    <div class="icon">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </div>
                    <div class="details">
                        <p>Total Orders</p>
                        <span><?php echo $total_orders; ?></span>
                    </div>
                </a>
            </div>
            <div class="last-info">
                <div class="users-info">
                    <div class="header">
                     <p><i class="fa fa-users" aria-hidden="true"></i> Latest 6 Registerd Users</p>
                     <label class="show-users" id="show-users"><i class="fa fa-minus" aria-hidden="true"></i>                       
                        <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
                    </label> 
                    </div>
                    <div class="body" id="users-info">
                    <!--
                        <div class="user">
                            <label class="username">Khalid issil</label>
                            <label class="edit"><a href="#"><i class="far fa-edit"></i><span>Edit</span></a></label>
                        </div>
                        -->
                        <?php echo $last_users; ?>
                    </div>
                </div>

                <div class="products-info" >
                    <div class="header">
                     <p><i class="fas fa-tag"></i> Latest 6 Registerd Products</p>
                     <label class="show-products" id="show-products"><i class="fa fa-minus" aria-hidden="true"></i>                       
                    <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
                    </label> 
                    </div>
                    <div class="body" id="products-info">
                    <!--
                        <div class="product">
                            <label class="product_name">Samsung S8</label>
                            <label class="edit"><a href="#"><i class="far fa-edit"></i><span>Edit</span></a></label>
                        </div>
                        -->
                    <?php echo $last_products ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../Js/admin.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>