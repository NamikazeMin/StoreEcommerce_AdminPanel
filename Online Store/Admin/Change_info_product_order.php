<?php

    require "../Config/config.php";
    session_start();

    if(isset($_SESSION["connecte"]) && isset($_SESSION["admin_id"]) && isset($_GET["function"]) && isset($_GET["order_id"]) && isset($_GET["product_title"]))
    {   
        $product_title=$_GET["product_title"];
        //Ladmin est Exeste 
        $admin_random=$_SESSION["admin_id"];
        $query_check_admin="select * from users where user_randome = $admin_random";
        if(mysqli_num_rows(mysqli_query($conn,$query_check_admin))>0)
        {
            $query_select_product="select * FROM fakeorderinfo where order_product = (select product_id from product where product_title like '$product_title') and order_id = ".$_GET["order_id"];
            $resultat=mysqli_query($conn,$query_select_product);
            while($row=$resultat->fetch_assoc())
            {
                $price=$row["order_info_price"];
                $amount=$row["order_amount"];
                $product_id=$row["order_product"];
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
    <link rel="stylesheet" href="../Css/Change_info_product_order.css">
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
            <h1 class="title">Update Product</h1>
                    <label id="lblorder_id"><?php echo $_GET["order_id"] ?></label>
                    <label id="lblproduct_id"><?php echo $product_id ?></label>
            <div class="form">
                <div class="error_message" id="error_message">
                </div>
                <div class="info" id="info">
                        <div class="price">
                            <label>Product Price</label>
                            <input type="number" id="txtprice" value="<?php echo $price ?>">
                        </div>
                        <div class="amount">
                            <label>Product Amount</label>
                            <input type="number" id="txtamount" value="<?php echo $amount ?>">
                        </div>
                        <div class="add">
                            <button class="update" id="update">Update</button>
                            <a href="Orders.php?function=update&order_id=<?php echo $_GET["order_id"] ?>" class="return"><i class="fa fa-arrow-left" aria-hidden="true"></i><span>Return</span></a>
                        </div>
                </div>
            </div>
            </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Change_info_product_order.js"></script>
    <script src="../Js/Orders.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>