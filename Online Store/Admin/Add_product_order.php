<?php
require "../Config/config.php";
    session_start();
    if(isset($_SESSION["connecte"]) && isset($_SESSION["admin_id"]) && isset($_GET["function"]) && isset($_GET["order_id"]))
    {   
        $order_id=$_GET["order_id"];

        //Ladmin est Exeste 
        $admin_random=$_SESSION["admin_id"];
        $query_check_admin="select * from users where user_randome = $admin_random";
        if(mysqli_num_rows(mysqli_query($conn,$query_check_admin))>0)
        {   
            $output="";
            $query_get_all_products="select product_id,product_image,product_title,product_price,product_amount FROM product
                                     where product_id not in(select order_product from fakeorderinfo)";
            $resultat=mysqli_query($conn,$query_get_all_products);
            if(mysqli_num_rows($resultat)>0)
            {
                while($row=$resultat->fetch_assoc())
                {
                    $product_id=$row["product_id"];
                    $product_image=$row["product_image"];
                    $product_price=$row["product_price"];
                    $product_title=$row["product_title"];
                    $product_amount=$row["product_amount"];
                    $output.='<tr>
                                <td><img src="../Product Images/'.$product_image.'" alt="Image Not Found"></td>
                                <td>'.$product_title.'</td>
                                <td>'.$product_price.' DH</td>
                                <td>'.$product_amount.'</td>
                                <td>
                                    <a href="Manage_Orders.php?order_id='.$order_id.'&function=add_new_product&new_product_id='.$product_id.'" id="add_to_order"><i class="far fa-edit"></i><span>Add</span></a>
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
    <link rel="stylesheet" href="../Css/Products.css">
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
            ?>

            <label id="order_id"><?php echo $_GET["order_id"] ?></label>
            <h1 class="title">Add Products</h1>
            <div class="product_search">
                        <div class="errortext" id="errorsearchbox">
                            <!-- For Search Errors -->
                        </div>
                        <div class="searchbox">
                            <input type="text" id="txtsearch" placeholder="type Title to search ...">
                            <button id="btnsearch">Search</button>
                        </div>
                    </div>
                    <div class="product_liste">
                        <table id="product_table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>

                               <!--<tr>
                                        <td><img src="../Product Images/samsung s8.jpg" alt="Image Not Found"></td>
                                        <td>Samsung s8</td>
                                        <td>300 DH</td>
                                        <td>30</td>
                                        <td>
                                            <a href="Manage" id="add_to_order"><i class="far fa-edit"></i><span>Add</span></a>
                                        </td>
                                    </tr>
                                    -->
                                <?php echo $output ?>
                            
                            </tbody>
                        </table>
                    </div>
                    <a href="Orders.php?function=update&order_id=<?php echo $_GET["order_id"] ?>" class="return"><i class="fa fa-arrow-left" aria-hidden="true"></i><span>Return</span></a>
        <?php }
        ?>
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Add_product_order.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>