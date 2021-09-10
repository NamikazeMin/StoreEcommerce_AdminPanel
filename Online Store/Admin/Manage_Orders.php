<?php
    include "../Config/config.php";
    session_start();
    if(isset($_GET["order_id"]))
    {
        $order_id=$_GET["order_id"];
        $query_fake_order="select * from fakeorder where order_id =".$order_id;
        $resultat_fake_order_exeste=mysqli_query($conn,$query_fake_order);
        if(mysqli_num_rows($resultat_fake_order_exeste)!=0)
        {
            if(isset($_GET["new_member_id"]))
            {
                $new_id=$_GET["new_member_id"];
                $query_change_user="update fakeorder set order_users=$new_id
                                    where order_id =".$order_id;
                mysqli_query($conn,$query_change_user);
                header("Location: Orders.php?function=update&order_id=$order_id");
            }
            else if(isset($_GET["function"]))
            {
                //For Cancel Or Confirm
                if($_GET["function"]=="cancel")
                {
                    //empty tabel fakeorder
                    $query_empty_fakeorder="delete from fakeorder where order_id =".$order_id;
                    mysqli_query($conn,$query_empty_fakeorder);
                    //empty tabel fakeorder
                    $query_empty_fakeorderinfo="delete from fakeorderinfo where order_id =".$order_id;
                    mysqli_query($conn,$query_empty_fakeorderinfo);
                    $_SESSION["order_in_update"]="false";
                    header("Location: Orders.php?function=show");

                }
                else if($_GET["function"]=="delete_product")
                {
                    if(isset($_GET["product_title"]))
                    {
                        $product_name=$_GET["product_title"];
                        $query_delete_product="delete from fakeorderinfo where order_product = (select product_id from product
                        where product_title like '$product_name')";
                        mysqli_query($conn,$query_delete_product);
                        header("Location: Orders.php?function=update&order_id=".$order_id);
                    }
                    else
                    {  
                    session_unset();
                    session_destroy();
                    header("Location: index.php");
                    }
                }
                else if($_GET["function"]=="confirm")
                {
                    $query_update_order="select * from orders_info";
                    $resultat_update_order= mysqli_query($conn,$query_update_order);
                    while($row=$resultat_update_order->fetch_assoc())
                    {
                        $product_id=$row["order_product"];
                        $stock=$row["order_amount"];
                        $query_check_if_exesite_in_fakeorderinfo="select * from fakeorderinfo where order_product=".$product_id;
                        $resultat_check_if_exesite_in_fakeorderinfo=mysqli_query($conn,$query_check_if_exesite_in_fakeorderinfo);
                        if(mysqli_num_rows($resultat_check_if_exesite_in_fakeorderinfo)==0)
                        {
                            //supprimer les produit dans la commade
                            $query_delete_product_in_order="delete from orders_info where order_product=".$product_id;
                            mysqli_query($conn,$query_delete_product_in_order);
                              //Mise Ajour la stock apre la supprission
                            $query_update_stock="update product set product_amount=product_amount + $stock where product_id = $product_id";
                            $result=mysqli_query($conn,$query_update_stock);
                            echo $conn->error;
                        }
                    }

                    $query_alter_products_in_order="select * from fakeorderinfo";
                    $total=0;
                    $resultat_alter_products_in_order=mysqli_query($conn,$query_alter_products_in_order);
                    while($row=$resultat_alter_products_in_order->fetch_assoc())
                    {
                        
                        $price=$row["order_info_price"];
                        $amount=$row["order_amount"];
                        $id=$row["order_product"];
                        $total+=$row["order_amount"]*$row["order_info_price"];
                        $query_check_if_exeste_in_orderinfo="select * from orders_info where order_product =".$id;
                        $resultat_info=mysqli_query($conn,$query_check_if_exeste_in_orderinfo);
                        if(mysqli_num_rows($resultat_info)==0)
                        {
                            //Query Ajouter Les Nouveau Produit
                            $query_insert_product="insert into orders_info(order_product,order_info_price,order_amount,order_id)
                            select order_product,order_info_price,order_amount,order_id from fakeorderinfo where order_product = ".$id;
                            mysqli_query($conn,$query_insert_product);
                            //Query Mise Ajour Le Stock
                            $query_update_stock_product="update product set product_amount =product_amount - 1 where product_id = $id";
                            mysqli_query($conn,$query_update_stock_product);
                        }
                        else 
                        {  
                            while($row2=$resultat_info->fetch_assoc())
                            {
                                $oldamount=$row2["order_amount"];
                                $select_amount="select product_amount from product where product_id=".$id;
                                $resultat_amount=mysqli_query($conn,$select_amount);
                                $product_amount;
                                while($res=$resultat_amount->fetch_assoc())
                                {
                                    $product_amount=$res["product_amount"];
                                }
                                
                                if($oldamount>$amount)
                                {
                                    
                                    $def=$oldamount-$amount;
                                    $product_amount+=$def;
                                    $query_update_amount="update product set product_amount =$product_amount where product_id = $id";
                                    mysqli_query($conn,$query_update_amount);
                                    echo $conn->error;
                                }
                                else if($oldamount<$amount)
                                {
                                    $def=$amount-$oldamount;
                                    $product_amount-=$def;
                                    $query_update_amount="update product set product_amount =$product_amount where product_id = $id";
                                    mysqli_query($conn,$query_update_amount);
                                    echo $conn->error;
                                }
                                
                                
                            }                     
                            $query_update_product="update orders_info set order_info_price= $price,order_amount=$amount where order_id = $order_id and order_product = $id";
                            mysqli_query($conn,$query_update_product);
                            
                        }
                        
                    }

                  //Query update Total
                    $query_update_total="update orders set order_total = $total where order_id = $order_id";
                    mysqli_query($conn,$query_update_total);
                    header("Location: Orders.php?function=show");
                
                    
                }
                else if($_GET["function"]=="add_new_product" && isset($_GET["new_product_id"]))
                {

                    $product=$_GET["new_product_id"];
                    $query_get_product="select * from product where product_id=".$product;
                    $resultat=mysqli_query($conn,$query_get_product);
                    while($row=$resultat->fetch_assoc())
                    {
                        $price=$row["product_price"];
                        $amount=$row["product_amount"];
                        $query_insert_product="insert into fakeorderinfo(order_info_id,order_id,order_product,order_info_price,order_amount)
                                                VALUES(null,$order_id,$product,$price,1)";
                        mysqli_query($conn,$query_insert_product);
                        
                    }
                    header("Location: Orders.php?function=update&order_id=".$order_id);

                }
            }
            }
        else
        {
            session_unset();
            session_destroy();
            header("Location: index.php"); 
        }
    }  
    else if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST["function"]) && isset($_POST["price"]) && isset($_POST["amount"]) && isset($_POST["order_id"]) && 
        isset($_POST["product_id"]))
        {
            $output="";
           if($_POST["function"]=="alter_product")
           {
                $product_id=$_POST["product_id"];
                $order_id=$_POST["order_id"];
                $amount=$_POST["amount"];
                $price=$_POST["price"];

                if(empty($amount) || empty($price))
                {
                    $output.="<p>All Inputs Are Required</p>";
                }
                else 
                {
                    $query="update fakeorderinfo set order_info_price= $price , order_amount= $amount where order_product = $product_id and order_id = $order_id";
                    mysqli_query($conn,$query);
                    $output="yes";
                }
           }
           else {
             
           }
        }
        else
        {
            session_unset();
            session_destroy();
            $output="errorconnection";
        }
        echo $output;
    }
    else
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
