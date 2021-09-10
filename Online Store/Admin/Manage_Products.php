<?php
    include "../Config/config.php";
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_SESSION["function_product"]))
    {
            $output="";
            $ptitle=filter_var($_POST["txttitle"],FILTER_SANITIZE_STRING);
            $pamount=filter_var($_POST["txtamount"],FILTER_SANITIZE_NUMBER_INT);
            $pprice=$_POST["txtprice"];
            $pimage=$_FILES["filepic"];
            $pdescription=filter_var($_POST["txtdescription"],FILTER_SANITIZE_STRING);
            $ppromo=filter_var($_POST["txtpromotion"],FILTER_SANITIZE_NUMBER_INT);
            $pcat=filter_var($_POST["select_cat"],FILTER_SANITIZE_NUMBER_INT);
            $pbrande=filter_var($_POST["select_brande"],FILTER_SANITIZE_NUMBER_INT);
            $pkeywords=filter_var($_POST["txtkeywords"],FILTER_SANITIZE_STRING);
            $function=$_SESSION["function_product"];
            $image_name=$pimage["name"];
            if($function=="add")
            {
                if(empty($ptitle) || empty($pamount) || empty($pprice) || empty($pdescription) || $ppromo=="")
                {
                    $output="<p>All Inputs Are Required !</p>";
                }
                else if($pcat==0)
                {
                    $output="<p>Choose The Category !</p>";
                }
                else if($pbrande==0)
                {
                    $output="<p>Choose The Brande !</p>";
                }
                else if(empty($image_name))
                {
                    $output="<p>choose the product image !</p>";
                }
                else if($pprice<=0)
                {
                    $output="<p>the price must be greater than 0 !</p>";
                }
                else if($pamount<=0)
                {
                    $output="<p>the amout must be greater than 0 !</p>";
                }
                else if($ppromo<0 || $ppromo>=100)
                {
                    $output="<p>the promotion must be between 0 and 99 !</p>";
                }
                else
                {
                    $image_tmp=$pimage["tmp_name"];
                    $time=time();
                    //getExtension
                    $image_explode=explode(".",$image_name);
                    $extension=end($image_explode);

                    //check if is good extension
                    $good_exetesion=["jpg","jpeg","png"];
                    if(in_array(strtolower($extension),$good_exetesion))
                    {
                        $query_deja_exeste="select * from product where product_title like '$ptitle'";
                        $result_query_deja_exeste=mysqli_query($conn,$query_deja_exeste);
                        $count=mysqli_num_rows($result_query_deja_exeste);
                        if($count==0)
                        {
                            //New Image The Name Of Image In Database And In Folders Images
                            $new_image_name=$time.$image_name;
                            if(move_uploaded_file($image_tmp,"../Product Images/".$new_image_name))
                            {
                                if(empty($pkeywords))
                                {
                                    $query_insert="insert into product (product_id,product_cat,product_brande,product_title,product_price,product_description,product_prom,product_image,product_amount)
                                    VALUES (null,$pcat,$pbrande,'$ptitle',$pprice,'$pdescription',$ppromo,'$new_image_name',$pamount)";
                                }
                                else
                                {
                                    $query_insert="insert into product (product_id,product_cat,product_brande,product_title,product_price,product_description,product_prom,product_image,product_amount,product_keywords)
                                    VALUES (null,$pcat,$pbrande,'$ptitle',$pprice,'$pdescription',$ppromo,'$new_image_name',$pamount,'$pkeywords')";
                                }

                                if(mysqli_query($conn,$query_insert))
                                {
                                    $output="yes";
                                }
                                else
                                {
                                    $output.= "<p>Something was wrong Try Again !</p>";
                                }
                            }
                        }
                        else
                        {
                            //Product Alreade Exeste 
                            $output="<p>this Name of product is Already Exeste !</p>"; 
                        }
                        
                    }
                    else
                    {
                        $output= "<p>The Right Extension Images is jpg , jpeg , png !</p>"; 
                    }
                }

            }
            else if($function=="alter" && isset($_SESSION["product_updated_id"]))
            {
                if(empty($ptitle) || empty($pamount) || $pprice=="" || empty($pdescription) || $ppromo=="")
                {
                    $output="<p>All Inputs Are Required stop !</p>";
                }
                else if($pcat==0)
                {
                    $output="<p>Choose The Category !</p>";
                }
                else if($pbrande==0)
                {
                    $output="<p>Choose The Brande !</p>";
                }
                else if($pprice<0)
                {
                    $output="<p>the price must be greater than 0 !</p>";
                }
                else if($pamount<=0)
                {
                    $output="<p>the amout must be greater than 0 !</p>";
                }
                else if($ppromo<0 || $ppromo>=100)
                {
                    $output="<p>the promotion must be between 0 and 99 !</p>";
                }
                else
                {
                    $product_id=$_SESSION["product_updated_id"];
                    $query_deja_exest="select * from product where product_title like '$ptitle' and product_id <> $product_id";
                    $result_query_deja_exeste=mysqli_query($conn,$query_deja_exest);
                    
                    if(mysqli_num_rows($result_query_deja_exeste)==0)
                    {
                        if(empty($image_name))
                        {
                            $query="update product set product_cat=$pcat,product_brande=$pbrande,product_title='$ptitle',product_price=$pprice,product_description='$pdescription',product_prom=$ppromo,product_amount=$pamount,product_keywords='$pkeywords' where product_id= $product_id";
                            if(mysqli_query($conn,$query))
                            {
                                $output="yes";
                            }
                            else
                            {
                                $output="<p>Something was wrong Try Again !</p>";
                            }
                            
                        }
                        else
                        {


                            $image_tmp=$pimage["tmp_name"];
                            $time=time();
                            //getExtension
                            $image_explode=explode(".",$image_name);
                            $extension=end($image_explode);
        
                            //check if is good extension
                            $good_exetesion=["jpg","jpeg","png"];
                            if(in_array(strtolower($extension),$good_exetesion))
                            {
                                $query_get_image="select product_image from product where product_id = $product_id";
                                $result_query_get_image=mysqli_query($conn,$query_get_image);

                                while($row=$result_query_get_image->fetch_assoc())
                                {
                                    $last_image=$row["product_image"];
                                }
                                 //New Image The Name Of Image In Database And In Folders Images
                                 $new_image_name=$time.$image_name;
                                 if(move_uploaded_file($image_tmp,"../Product Images/".$new_image_name))
                                 {
                                     //Remove The Last Image
                                     if(file_exists("../Product Images/$last_image"))
                                     {
                                        unlink("../Product Images/$last_image");
                                     }
                                     $query="update product set product_cat=$pcat,product_image='$new_image_name',product_brande=$pbrande,product_title='$ptitle',product_price=$pprice,product_description='$pdescription',product_prom=$ppromo,product_amount=$pamount,product_keywords='$pkeywords' where product_id= $product_id";
                                     if(mysqli_query($conn,$query))
                                     {
                                         $output="yes";
                                     }
                                     else
                                     {
                                         $output="<p>Something was wrong Try Again !</p>";
                                     }
                                 }
                                
                            }
                            else
                            {
                                $output= "<p>The Right Extension Images is jpg , jpeg , png !</p>"; 
                            }
                        }
                    }
                    else
                    {
                        $output="<p>this Name of product is Already Exeste !</p>"; 
                    }
                    
                }

                
            }
            else
            {
                $output="<p>Something was wrong Try Again !</p>";
            }


    }
    else
    {
        session_unset();
        session_destroy();
        $output= "errorconnection";
    }
    echo $output;