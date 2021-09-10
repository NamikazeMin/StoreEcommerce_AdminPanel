<?php
    include "../Config/config.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["function"]))
    {
        $output="";
        if($_POST["function"]=="add")
        {
            if(isset($_POST["value"]))
            {
                $nom=$_POST["value"];
                if(!empty($nom))
                {
                    $nom=filter_var($nom,FILTER_SANITIZE_STRING);
                    $query_check_catexeste="select * from categorie where cat_title like '$nom'";
                    $resultat=mysqli_query($conn,$query_check_catexeste);
                    if(mysqli_num_rows($resultat)==0)
                    {
                        $query="insert into categorie(cat_id,cat_title) values(null,'$nom')";
                        if(mysqli_query($conn,$query))
                        {
                            $output="yes";
                        }
                        else
                        {
                            $output="<p>Something was wrong</p>";
                        }
                    }
                    else
                    {
                        $output= "<p>This name is Already Exeste</p>";
                    }
                  
                }
                else
                {
                    $output= "<p>Type The Category Name</p>";
                }
            }
            else
            {
                session_unset();
                session_destroy();
                $output= "errorconnection";
            }
        }
        else if($_POST["function"]=="alter")
        {
            if(isset($_POST["value"]) && isset($_SESSION["categorie_update"]))
            {
                $nom=$_POST["value"];
                $id=$_SESSION["categorie_update"];
                if(!empty($nom))
                {
                    $nom=filter_var($nom,FILTER_SANITIZE_STRING);
                    $query_check_catexeste="select * from categorie where cat_title like '$nom' and cat_id <> $id";
                    $resultat=mysqli_query($conn,$query_check_catexeste);
                    if(mysqli_num_rows($resultat)==0)
                    {
                        $query="update categorie set cat_title='$nom' where cat_id = $id";
                        if(mysqli_query($conn,$query))
                        {
                            $output="yes";
                        }
                        else
                        {
                            $output="<p>Something was wrong</p>";
                        }
                    }
                    else
                    {
                        $output= "<p>This name is Already Exeste</p>";
                    }
                  
                }
                else
                {
                    $output= "<p>Type The Category Name</p>";
                }
            }
            else
            {
                session_unset();
                session_destroy();
                $output= "errorconnection";
            }
        }
    
    }
    else
    {
        session_unset();
        session_destroy();
        $output= "errorconnection";
    }
    echo $output;