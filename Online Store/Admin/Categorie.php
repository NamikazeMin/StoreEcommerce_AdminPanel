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
            $query_get_all_categories="select * from categorie";
            $resultat=mysqli_query($conn,$query_get_all_categories);
            if(mysqli_num_rows($resultat))
            {
                while($row=$resultat->fetch_assoc())
                {
                    $id=$row["cat_id"];
                    $title=$row["cat_title"];
                    $output.='<tr>
                                <td>'.$id.'</td>
                                <td>'.$title.'</td>
                                <td>
                                <a href="Categorie.php?function=update&categorie_id='.$id.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="Categorie.php?function=delete&categorie_name='.$title.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                </td>
                            </tr>';
                }
            }
            
        }
        else
        {
            header("Location: ../Pages/index.html");
        }
    }
    else
    {
        header("Location: ../Pages/index.html");
    }
?>



















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/header.css">
    <link rel="stylesheet" href="../Css/Categorie.css">
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
            { ?>

            <h1 class="title">Manage Categories</h1>
            <div class="categorie_search">
                        <div class="errortext" id="errorsearchbox">
                            <!-- For Search Errors -->
                        </div>
                        <div class="searchbox">
                            <input type="text" id="txtsearch" placeholder="type Title to search ...">
                            <button id="btnsearch">Search</button>
                        </div>
                    </div>
                    <div class="categorie_liste">
                        <table id="categories_table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Title</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                               <!-- <tr>
                                        <td>1</td>
                                        <td>Computer</td>
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
                    <a href="Categorie.php?function=add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i><span>Add new categore</span></a>

        <?php   
            }
            else if($_GET["function"]=="add")
            {?>
                <h1 class="title">Add Category</h1>
               <div class="form">
               <div class="error_message" id="error_message">
                </div>
                    <div class="cat-title" id="cat-title">
                            <label>Category Title</label>
                            <input type="text" id="txtcategorie" placeholder="type title" data-place="type title">
                    </div>
                    <div class="add">
                        <button id="btnadd">Add Categry</button>
                    </div>
               </div>

        <?php }
            else if($_GET["function"]=="update" && isset($_GET["categorie_id"]))
            {
                $_SESSION["categorie_update"]=$_GET["categorie_id"];
                $id=filter_var($_GET["categorie_id"],FILTER_SANITIZE_STRING);
                $query_check_catexeste="select * from categorie where cat_id = $id";
                $resultat=mysqli_query($conn,$query_check_catexeste);
                if(mysqli_num_rows($resultat)>0)
                {
                    while($row=$resultat->fetch_assoc())
                    {
                        $nom=$row["cat_title"];
                    }
                    ?>
                <h1 class="title">Alter Category</h1>
                    <div class="form">
                    <div class="error_message" id="error_message">
                        </div>
                            <div class="cat-title" id="cat-title">
                                    <label>Category Title</label>
                                    <input type="text" id="txtcategorie" placeholder="type title" value="<?php echo $nom ?>">
                            </div>
                            <div class="add">
                                <button id="btnadd">Update Category</button>
                            </div>
                    </div>

            <?php
                }  
                else
                {
                    session_unset();
                    session_destroy();
                    header("Location: ../index.html");
                }
            }
            else if($_GET["function"]=="delete" && isset($_GET["categorie_name"]))
            {
                $nom=$_GET["categorie_name"];
                $query_check_catexeste="select * from categorie where cat_title like '$nom'";
                $resultat=mysqli_query($conn,$query_check_catexeste);
                if(mysqli_num_rows($resultat)>0)
                {
                    $query_delete_categorie="delete from categorie where cat_title like '$nom'";
                    if(mysqli_query($conn,$query_delete_categorie))
                    {
                        ?>
                        <h1 class="title">Delete Categorie</h1>
                                    <div class="Rapport">
                                        <div class="Message succes">
                                            <p>the Categorie <label><?php echo $nom ?> </label>  is successfully deleted </p>
                                        </div>
                                        <div class="redirect">
                                            <a href="Categorie.php?function=show" id="return_to_categorys">Return To Categories Page</a>
                                        </div>
                                    </div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <h1 class="title">Delete Categorie</h1>
                        <div class="Rapport">
                            <div class="Message error">
                                <p>somthing was wrong Try Again  !</p>
                            </div>
                            <div class="redirect">
                                 <a href="Categorie.php?function=show" id="return_to_categorys">Return To Categories Page</a>
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
    <script src="../Js/Categories.js"></script>
    <script src="../Js/AddCategorie.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>