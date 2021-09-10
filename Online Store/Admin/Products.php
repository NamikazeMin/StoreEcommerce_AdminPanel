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
            $query_get_all_products="select product_id,product_image,product_title,product_price,product_amount FROM product";
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
                                <a href="Products.php?function=update&product_name='.$product_title.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="Products.php?function=delete&product_delete_id='.$product_id.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
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

            <h1 class="title">Manage Products</h1>
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

                                <!--
                                    <tr>
                                        <td><img src="../Product Images/samsung s8.jpg" alt="Image Not Found"></td>
                                        <td>Samsung s8</td>
                                        <td>3000 DH</td>
                                        <td>30</td>
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
                    <a href="Products.php?function=add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i><span>Add new Product</span></a>


        <?php }
        else if($_GET["function"]=="add")
            {

                $_SESSION["function_product"]="add";
                //Get All Category
                $query_get_all_categories="select * from categorie";
                $resultat=mysqli_query($conn,$query_get_all_categories);
                if(mysqli_num_rows($resultat))
                {
                    $output_cat="";
                    while($row=$resultat->fetch_assoc())
                    {
                        $id=$row["cat_id"];
                        $title=$row["cat_title"];
                        $output_cat.='<option value="'.$id.'">'.$title.'</option>';
                    }
                }
               
                //Get All Brandes
                $query_get_all_brandes="select * from brandes";
                $resultat=mysqli_query($conn,$query_get_all_brandes);
                if(mysqli_num_rows($resultat))
                {
                    $output_brandes="";
                    while($row=$resultat->fetch_assoc())
                    {
                        $id=$row["brande_id"];
                        $title=$row["brande_title"];
                        $output_brandes.='<option value="'.$id.'">'.$title.'</option>';
                    }
                }
                ?>
               <h1 class="title">Add Product</h1>
               <form action="#" class="form" id="form" autocomplete="off">
                    <div class="error_message" id="error_message">
                        this is An error Text
                    </div>
                    <div class="col-1" id="col-1">
                            <div class="Product_title">
                                <label>Title</label>
                                <input type="text" name="txttitle" id="txttitle">
                            </div>
                            <div class="Product_price">
                                <label>Price</label>
                                <input type="number" name="txtprice" id="txtprice" min="0">
                            </div>
                            <div class="product_amount">
                                <label>Amount</label>
                                <input type="number" name="txtamount" id="txtamount" min="0">
                            </div>
                            <div class="Product_pic">
                                <label>Picture</label>
                                <input type="file" name="filepic" id="filepic">
                            </div>
                            <div class="Product_description">
                                <label>Description</label>
                                <textarea id="txtdescription" name="txtdescription" cols="30" rows="10"></textarea>
                            </div>
                    </div>
                    <div class="col-2" id="col-2">
                            <div class="product_promotion">
                                <label>Promotion</label>
                                <input type="number" name="txtpromotion" id="txtpromotion" min="0" value="0">
                            </div>
                            <div class="product_categorie">
                                <label>Category</label>
                                <select id="select_cat" name="select_cat">
                                    <option value="0">Select Category</option>
                                    <?php echo $output_cat ?>
                                </select>
                            </div>
                            <div class="product_brande">
                                <label>Brande</label>
                                <select id="select_brande" name="select_brande">
                                    <option value="0">Select Brande</option>
                                    <?php  echo $output_brandes?>
                                </select>
                            </div>
                            <div class="Product_Keywords">
                                <label>Keywords</label>
                                <textarea id="txtkeywords" name="txtkeywords" cols="30" rows="10"></textarea>
                            </div>
                            <div class="add">
                                <button id="btnadd">Add Product</button>
                            </div>
                    </div>
               </form>
        <?php }
            else if($_GET["function"]=="update" && isset($_GET["product_name"]))
            {
                $_SESSION["function_product"]="alter";
                $product_name=filter_var($_GET["product_name"],FILTER_SANITIZE_STRING);
                $query_check_product_exeste="select product_id,product_cat,product_brande,product_price,product_description,product_prom,product_amount,product_keywords,cat_title,brande_title from product,categorie,brandes where product_cat=cat_id and product_brande=brande_id and  product_title like '$product_name'";
                $resultat=mysqli_query($conn,$query_check_product_exeste);
                if(mysqli_num_rows($resultat)>0)
                {   
                    while($row=$resultat->fetch_assoc())
                    {
                        $_SESSION["product_updated_id"]=$row["product_id"];
                        $product_cat=$row["product_cat"];
                        $product_brande=$row["product_brande"];
                        $product_price=$row["product_price"];
                        $product_description=$row["product_description"];
                        $product_prom=$row["product_prom"];
                        $product_amount=$row["product_amount"];
                        $product_keywords=$row["product_keywords"];
                        $cat_title=$row["cat_title"];
                        $brande_title=$row["brande_title"];
                    }
                    
                    $query_get_all_categories="select * from categorie where cat_id <> $product_cat";
                    $resultat=mysqli_query($conn,$query_get_all_categories);
                    if(mysqli_num_rows($resultat))
                    {
                        $output_cat="";
                        while($row=$resultat->fetch_assoc())
                        {
                            $id=$row["cat_id"];
                            $title=$row["cat_title"];
                            $output_cat.='<option value="'.$id.'">'.$title.'</option>';
                        }
                    }
                    
                     //Get All Brandes
                    $query_get_all_brandes="select * from brandes where brande_id <>  $product_brande";
                    $resultat=mysqli_query($conn,$query_get_all_brandes);
                    if(mysqli_num_rows($resultat))
                    {
                        $output_brandes="";
                        while($row=$resultat->fetch_assoc())
                        {
                            $id=$row["brande_id"];
                            $title=$row["brande_title"];
                            $output_brandes.='<option value="'.$id.'">'.$title.'</option>';
                        }
                    }
                    
                    
                    ?>
                        <h1 class="title">Alter Product</h1>
                        <form action="#" class="form" id="form" autocomplete="off">
                            <div class="error_message" id="error_message">
                                this is An error Text
                            </div>
                            <div class="col-1" id="col-1">
                                    <div class="Product_title">
                                        <label>Title</label>
                                        <input type="text" name="txttitle" id="txttitle" value="<?php echo $product_name ?>">
                                    </div>
                                    <div class="Product_price">
                                        <label>Price</label>
                                        <input type="number" name="txtprice" id="txtprice" min="0" value="<?php echo $product_price ?>">
                                    </div>
                                    <div class="product_amount">
                                        <label>Amount</label>
                                        <input type="number" name="txtamount" id="txtamount" min="0" value="<?php echo $product_amount ?>">
                                    </div>
                                    <div class="Product_pic">
                                        <label>Picture</label>
                                        <input type="file" name="filepic" id="filepic">
                                    </div>
                                    <div class="Product_description">
                                        <label>Description</label>
                                        <textarea id="txtdescription" name="txtdescription" cols="30" rows="10"><?php echo $product_description ?>
                                        </textarea>
                                    </div>
                            </div>
                            <div class="col-2" id="col-2">
                                    <div class="product_promotion">
                                        <label>Promotion</label>
                                        <input type="number" name="txtpromotion" id="txtpromotion" min="0" value="<?php echo $product_prom ?>">
                                    </div>
                                    <div class="product_categorie">
                                        <label>Category</label>
                                        <select id="select_cat" name="select_cat">
                                            <option value="<?php echo $product_cat ?>"><?php echo $cat_title ?></option>
                                            <?php echo $output_cat ?> <!--Liste Of Category-->
                                        </select>
                                    </div>
                                    <div class="product_brande">
                                        <label>Brande</label>
                                        <select id="select_brande" name="select_brande">
                                            <option value="<?php echo $product_brande ?>"><?php echo $brande_title ?></option>
                                            <?php  echo $output_brandes?> <!--Liste Of Brande-->
                                        </select>
                                    </div>
                                    <div class="Product_Keywords">
                                        <label>Keywords</label>
                                        <textarea id="txtkeywords" name="txtkeywords" cols="30" rows="10"><?php echo $product_keywords ?></textarea>
                                    </div>
                                    <div class="add">
                                        <button id="btnadd">Update Product</button>
                                    </div>
                            </div>
                        </form>
                <?php
                }
                else
                {
                    session_unset();
                    session_destroy();
                    header("Location: ../index.html");
                }
                
            }
            else if($_GET["function"]=="delete" && isset($_GET["product_delete_id"]))
            {
                $query_get_info="select * from product where product_id = ".$_GET["product_delete_id"];
                $resultat=mysqli_query($conn,$query_get_info);
                if(mysqli_num_rows($resultat)>0)
                {
                    while($row=$resultat->fetch_assoc())
                    {
                        $pname=$row["product_title"];
                        $pimage=$row["product_image"];
                    }

                    $query_delete="delete from product where product_id=".$_GET["product_delete_id"];
                    if(mysqli_query($conn,$query_delete))
                    {
                        //Supprimer Limage De Produit
                        if(file_exists("../Product Images/$pimage"))
                        {
                                        unlink("../Product Images/$pimage");
                        }
                ?>
                    <h1 class="title">Delete Product</h1>
                    <div class="Rapport">
                        <div class="Message succes">
                            <p>the product <label><?php echo $pname ?> </label>  is successfully deleted </p>
                        </div>
                        <div class="redirect">
                            <a href="Products.php?function=show" id="return_to_products">Return To Products Page</a>
                        </div>
                    </div>
                <?php
                 }
                 else
                 { ?>
                        <h1 class="title">Delete Product</h1>
                        <div class="Rapport">
                            <div class="Message error">
                                <p>somthing was wrong Try Again  !</p>
                            </div>
                            <div class="redirect">
                                <a href="Products.php?function=show" id="return_to_products">Return To Products Page</a>
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
           <?php
            }
        ?>

 
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Products.js"></script>
    <script src="../Js/AddProducts.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>