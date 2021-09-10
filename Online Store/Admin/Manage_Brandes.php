<?php
    include "../Config/config.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["function"]))
    {
        $output="";
        if($_POST["function"]=="add")
        {
            if(isset($_POST["title"]) && isset($_POST["categorie"]) )
            {
                $nom=$_POST["title"];
                $brand_cat=$_POST["categorie"];
                if(!empty($nom))
                {
                    if($brand_cat!=0)
                    {
                        $nom=filter_var($nom,FILTER_SANITIZE_STRING);
                        $query_check_catexeste="select * from brandes  where brande_title like '$nom'";
                        $resultat=mysqli_query($conn,$query_check_catexeste);
                        if(mysqli_num_rows($resultat)==0)
                        {
                            $query="insert into brandes(brande_id,Brand_cat,brande_title) values(null,$brand_cat,'$nom')";
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
                        $output= "<p>Choose The Brande Categorie</p>";
                    }
                    
                  
                }
                else
                {
                    $output= "<p>Type The Brande Name</p>";
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
            if(isset($_POST["title"]) && isset($_SESSION["brande_update"]))
            {
                $nom=$_POST["title"];
                $id_brande=$_SESSION["brande_update"];
                $brand_cat=$_POST["categorie"];
                if(!empty($nom))
                {
                    $nom=filter_var($nom,FILTER_SANITIZE_STRING);
                    $query_check_brandexeste="select * from brandes where brande_title like '$nom' and brande_id <> $id_brande";
                    $resultat=mysqli_query($conn,$query_check_brandexeste);
                    if(mysqli_num_rows($resultat)==0)
                    {
                        $query="update brandes set brande_title='$nom',Brand_cat =$brand_cat where brande_id = $id_brande";
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
                        $output= "<p>This Brande is Already Exeste</p>";
                    }
                  
                }
                else
                {
                    $output= "<p>Type The Brande Name</p>";
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