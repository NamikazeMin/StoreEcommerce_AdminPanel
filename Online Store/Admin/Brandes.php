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
            $query_get_all_brandes="select brande_id,categorie.cat_title,brande_title from brandes ,categorie
                                    where Brand_cat=cat_id";
            $resultat=mysqli_query($conn,$query_get_all_brandes);
            if(mysqli_num_rows($resultat))
            {
                while($row=$resultat->fetch_assoc())
                {
                    $id=$row["brande_id"];
                    $cat_title=$row["cat_title"];
                    $brande_title=$row["brande_title"];
                    $output.='<tr>
                                <td>'.$id.'</td>
                                <td>'.$cat_title.'</td>
                                <td>'.$brande_title.'</td>
                                <td>
                                <a href="Brandes.php?function=update&brande_id='.$id.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="Brandes.php?function=delete&brande_name='.$brande_title.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
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
    <link rel="stylesheet" href="../Css/Brandes.css">
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
                {?>
                    <h1 class="title">Manage Brandes</h1>
                        <div class="brande_search">
                            <div class="errortext" id="errorsearchbox">
                                        <!-- For Searcg Errors --->
                            </div>
                            <div class="searchbox">
                                <input type="text" id="txtsearch" placeholder="type Title to search ...">
                                <button id="btnsearch">Search</button>
                            </div>
                        </div>
                        <div class="brande_liste">
                            <table id="brandes_table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Categorie</th>
                                        <th>Title</th>
                                        <th>Controll</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <!--   <tr>
                                            <td>1</td>
                                            <td>Phone</td>
                                            <td>Samsung </td>
                                            <td>
                                            <a href="#" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                            <a href="#" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                            </td>
                                        </tr>
                                     -->
                                <?php echo $output; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="Brandes.php?function=add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i><span>Add new brande</span></a>

            <?php }
             else if($_GET["function"]=="add")
             {
                $query_get_all_categories="select * from categorie";
                $resultat=mysqli_query($conn,$query_get_all_categories);
                if(mysqli_num_rows($resultat))
                {
                    while($row=$resultat->fetch_assoc())
                    {
                        $id=$row["cat_id"];
                        $title=$row["cat_title"];
                        $output.='<option value="'.$id.'">'.$title.'</option>';
                    }
                }
                 ?>
                 <h1 class="title">Add Brande</h1>
                 <div class="form">
                        <div class="error_message" id="error_message">
                        </div>
                        <div class="brande-title" id="brande-title">
                                <label>Brande Title</label>
                                <input type="text" id="txtbrande" placeholder="type title">
                        </div>
                        <div class="cat_title">
                            <label>Brande Categorie</label>
                            <select name="select_cat" id="select_cat">
                                <option value="0">Select Category</option>
                                <?php echo $output ?>
                            </select>
                        </div>
                        <div class="add">
                            <button id="btnadd">Add Brande</button>
                        </div>
                </div>
 
         <?php }
         else if($_GET["function"]=="update" && isset($_GET["brande_id"]))
         {
             $_SESSION["brande_update"]=$_GET["brande_id"];
             $brande_id=filter_var($_GET["brande_id"],FILTER_SANITIZE_STRING);

            //The Brand Updater Exeste 
             $query_check_brandexeste="select brande_title,Brand_cat,cat_title from brandes,categorie
                                     where cat_id=Brand_cat and brande_id = $brande_id";
             $resultat=mysqli_query($conn,$query_check_brandexeste);
             if(mysqli_num_rows($resultat)>0)
             {
                 while($row=$resultat->fetch_assoc())
                 {
                     $nom=$row["brande_title"];
                     $cat_id=$row["Brand_cat"];
                     $brand_cat=$row["cat_title"];
                 }
                 //Get All Categories
                 $query_get_all_categories="select * from categorie where cat_id <> $cat_id";
                 $resultat=mysqli_query($conn,$query_get_all_categories);
                 if(mysqli_num_rows($resultat))
                 {
                     while($row=$resultat->fetch_assoc())
                     {
                         $id=$row["cat_id"];
                         $title=$row["cat_title"];
                         $output.='<option value="'.$id.'">'.$title.'</option>';
                     }
                 }
                 ?>
                <h1 class="title">Alter Category</h1>
                <div class="form">
                            <div class="error_message" id="error_message">
                            </div>
                            <div class="brande-title" id="brande-title">
                                    <label>Brande Title</label>
                                    <input type="text" id="txtbrande" placeholder="type title" value="<?php echo $nom ?>">
                            </div>
                            <div class="cat_title">
                                <label>Brande Categorie</label>
                                <select name="select_cat" id="select_cat">
                                    <option value="<?php echo $cat_id ?>"><?php echo $brand_cat ?></option>
                                    <?php echo $output ?>
                                </select>
                            </div>
                            <div class="add">
                                <button id="btnadd">Update Brande</button>
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
         else if($_GET["function"]=="delete" && isset($_GET["brande_name"]))
         {
             $nom=$_GET["brande_name"];
             $query_check_brandexeste="select * from brandes where brande_title like '$nom'";
             $resultat=mysqli_query($conn,$query_check_brandexeste);
             if(mysqli_num_rows($resultat)>0)
             {
                 $query_delete_brande="delete from brandes where brande_title like '$nom'";
                 if(mysqli_query($conn,$query_delete_brande))
                 { ?>
                     <h1 class="title">Delete Brande</h1>
                                 <div class="Rapport">
                                     <div class="Message succes">
                                         <p>the Brande <label><?php echo $nom ?> </label>  is successfully deleted </p>
                                     </div>
                                     <div class="redirect">
                                         <a href="Brandes.php?function=show" id="return_to_brandes">Return To Categories Page</a>
                                     </div>
                                 </div>
                 <?php
                 }
                 else
                 {
                     ?>
                     <h1 class="title">Delete Brande</h1>
                     <div class="Rapport">
                         <div class="Message error">
                             <p>somthing was wrong Try Again  !</p>
                         </div>
                         <div class="redirect">
                              <a href="Brandes.php?function=show" id="return_to_brandes">Return To Categories Page</a>
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
         { ?>
            <script>
                window.location="../Page Errors/404/Page404.html";
            </script>
    <?php   }
         ?>
        </div>
    </div>
    <script src="../Js/menu.js"></script>
    <script src="../Js/Brandes.js"></script>
    <script src="../Js/AddBrandes.js"></script>
    <script src="../Page Errors/Offline/offline.js"></script>
</body>
</html>