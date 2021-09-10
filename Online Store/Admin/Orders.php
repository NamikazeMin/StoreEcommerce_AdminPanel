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
            $output="";
            //Get All Orders
            $query_get_all_orders="select order_id,user_email,order_date,order_total from orders , users
                                    where order_users=users_id
                                    order by order_date desc";
            $resultat=mysqli_query($conn,$query_get_all_orders);
            if(mysqli_num_rows($resultat))
            {
                while($row=$resultat->fetch_assoc())
                {
                    $id=$row["order_id"];
                    $email=$row["user_email"];
                    $date=$row["order_date"];
                    $total=$row["order_total"];
                    $output.='<tr>
                                <td>'.$id.'</td>
                                <td>'.$email.'</td>
                                <td>'.$date.'</td>
                                <td>'.$total.'</td>
                                <td>
                                <a href="Orders.php?function=update&order_id='.$id.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="Orders.php?function=delete&order_id='.$id.'&user_email='.$email.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
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
    <link rel="stylesheet" href="../Css/Orders.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <?php 
         include_once 'header.php';
        ?>
        <div class="content">
        <?php
                if($_GET["function"]=="show")
                {
                    $_SESSION["order_in_update"]="false";
                    ?>
                    <h1 class="title">Manage Orders</h1>
                        <div class="order_search">
                            <div class="errortext" id="errorsearchbox">
                                        <!-- For Search Errors --->
                            </div>
                            <div class="searchbox">
                                <input type="text" id="txtsearch" placeholder="type Member to search ...">
                                <button id="btnsearch">Search</button>
                            </div>
                        </div>
                        <div class="order_liste">
                            <table id="order_table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Member</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Controll</th>
                                    </tr>
                                </thead>
                                <tbody>
                                      <!--  <tr>
                                            <td>1</td>
                                            <td>issilk16@gmail.com</td>
                                            <td>21/05/2021</td>
                                            <td>4000</td>
                                            <td>
                                            <a href="#" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                            <a href="#" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                            </td>
                                        </tr>
                                        -->
                                     <?php echo $output ?>
                                </tbody>
                            </table>
                        </div>

            <?php }
                else if($_GET["function"]=="update" && isset($_GET["order_id"]))
                {   
                    $order_id=$_GET["order_id"];
                    $query_check_order="select * from orders where order_id = ".$order_id;
                    if(mysqli_num_rows(mysqli_query($conn,$query_check_order))>0)
                    {

                        if($_SESSION["order_in_update"]=="false")
                        {
                             //empty tabel fakeorder
                            $query_empty_fakeorder="delete from fakeorder where order_id =".$order_id;
                            mysqli_query($conn,$query_empty_fakeorder);
                            //empty tabel fakeorder
                            $query_empty_fakeorderinfo="delete from fakeorderinfo where order_id =".$order_id;
                            mysqli_query($conn,$query_empty_fakeorderinfo);


                            
                            $_SESSION["order_in_update"]="true";
                            //Insert The Fake order in Fake Tabel
                            $query_fake_order="insert into fakeorder (order_id,order_users,order_date,order_total)
                            select order_id,order_users,order_date,order_total from orders where order_id = ".$order_id;
                            mysqli_query($conn,$query_fake_order);

                            //Insert The Fake Order Info in Fake Tabel
                            $query_fake_order_info="insert into fakeorderinfo(order_id,order_info_price,order_product,order_amount)
                            select order_id,order_info_price,order_product,order_amount from orders_info
                            where order_id = ".$order_id;
                            mysqli_query($conn,$query_fake_order_info);
                        }
                        





                        //Get The Member Of The Order
                        $query_get_member="select order_users,user_fname,user_lname,user_email from fakeorder,users
                                           where order_users=users_id and order_id =".$order_id;
                        $resultat_get_member=mysqli_query($conn,$query_get_member);
                        while($row = $resultat_get_member->fetch_assoc())
                        {
                            $user_id=$row["order_users"];
                            $firstname=$row["user_fname"];
                            $lastname=$row["user_lname"];
                            $email=$row["user_email"];
                        }

                        //Get Products Of The Order
                        $query_get_products="select product_image,product_title,order_info_price,order_amount
                                            from fakeorderinfo,product where order_product=product_id and order_id =".$order_id;
                        $products="";
                        $resultat=mysqli_query($conn,$query_get_products);
                        while($row=$resultat->fetch_assoc())
                        {
                            $image=$row["product_image"];
                            $price=$row["order_info_price"];
                            $title=$row["product_title"];
                            $amount=$row["order_amount"];
                            $products.='<tr>
                                                <td><img src="../Product Images/'.$image.'" alt="Image Not Found"></td>
                                                <td>'.$title.'</td>
                                                <td>'.$price.'</td>
                                                <td>'.$amount.'</td>
                                                <td>
                                                        <a href="Change_info_product_order.php?function=show&order_id='.$order_id.'&product_title='.$title.'" id="change"><i class="far fa-edit"></i><span>Change</span></a>
                                                        <a href="Manage_Orders.php?order_id='.$order_id.'&function=delete_product&product_title='.$title.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                                </td>
                                            </tr>';
                        }

                        ?>
                        <h1 class="title">Alter Order</h1>
                            <div class="order_info">
                                <h1>Member Info</h1>
                                <table id="user_order_table">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Controll</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td><?php echo $user_id ?></td>
                                                    <td><?php echo $firstname.' '.$lastname ?></td>
                                                    <td><?php echo $email ?></td>
                                                    <td>
                                                    <a href="Change_Member_Order.php?function=change&order_id=<?php echo $order_id ?>" id="change"><i class="far fa-edit"></i><span>Change</span></a>
                                                    </td>
                                                </tr>
                                                
                                        </tbody>
                                    </table>
                        <!--Products Info -->
                        <h1>Products Info</h1> 
                                <table id="product_order_table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Prix</th>
                                            <th>Amount</th>
                                            <th>Controll</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <!--  <tr>
                                            <td><img src="../Product Images/samsung s8.jpg" alt="Image Not Found"></td>
                                            <td>Samsung s8</td>
                                            <td>3000 DH</td>
                                            <td>30</td>
                                            <td>
                                                    <a href="#" id="change"><i class="far fa-edit"></i><span>Change</span></a>
                                            </td>
                                        </tr>
                                        -->   
                                        <?php echo $products ?>      
                                    </tbody>
                                </table>
                                <a href="Add_product_order.php?function=show&order_id=<?php echo $order_id ?>" class="addnew">Add Product</a>
                                <div class="functions">
                                    <a href="Manage_Orders.php?order_id=<?php echo $order_id?>&function=cancel" id="cancel">Cancel</a>
                                    <a href="Manage_Orders.php?order_id=<?php echo $order_id?>&function=confirm" id="confirm">Confirm</a>
                                </div>
                            </div>   
                    <?php 
                    }
                    else
                    {?>
                        <script>
                            window.location="Orders.php?function=show";
                        </script>
            <?php   }

                }
                else if($_GET["function"]=="delete" && isset($_GET["order_id"]) && isset($_GET["user_email"]))
                {
                    
                    $query_delete_info="delete from orders_info where order_id = ".$_GET["order_id"];
                    $query_delte_order="delete from orders where order_id = ".$_GET["order_id"];
                    if(mysqli_query($conn,$query_delete_info) && mysqli_query($conn,$query_delte_order))
                    { ?>
                        <h1 class="title">Delete Order</h1>
                        <div class="Rapport">
                            <div class="Message succes">
                                <p>the order from customer <label><?php echo $_GET["user_email"] ?> </label>  is successfully deleted </p>
                            </div>
                            <div class="redirect">
                                <a href="Orders.php?function=show" id="return_to_orders">Return To Orders Page</a>
                            </div>
                        </div>
                   <?php }
                   else {?>
                        <h1 class="title">Delete Member</h1>
                        <div class="Rapport">
                            <div class="Message error">
                                <p>somthing was wrong Try Again  !</p>
                            </div>
                            <div class="redirect">
                                <a href="Orders.php?function=show" id="return_to_orders">Return To Members Page</a>
                            </div>
                        </div>
                  <?php }
                }
            
            ?>
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Orders.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>