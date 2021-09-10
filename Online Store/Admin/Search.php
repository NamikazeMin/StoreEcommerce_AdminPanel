<?php
    require_once '../Config/config.php';
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["value"]) && isset($_POST["data"]))
    {
        if($_POST["data"]=="users")
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select * from users where user_email like '".$value."%'";
            $resultat=mysqli_query($conn,$query);
            if(mysqli_num_rows($resultat)>0)
            {
                    while($row=$resultat->fetch_assoc())
                    {
                        $fname=$row["user_fname"];
                        $lname=$row["user_lname"];
                        $email=$row["user_email"];
                        $type=$row["user_type"];
                        $random=$row["user_randome"];
                        if($type==1)
                        {
                            $type="Admin";
                        }
                        else
                        {
                            $type="User";
                        }
                        $output.='<tr>
                        <td>'.$fname.' '.$lname.'</td>
                        <td>'.$email.'</td>
                        <td>'.$type.'</td>
                        <td>
                        <a href="Members.php?function=update&user_id='.$random.'" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                        <a href="Members.php?function=delete&user_id='.$random.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                        </td>
                        </tr>';
                    }
            }
            else
            {
                $output .="error;<p>No User at this email</p>";
            }
            }
            else
            {
                $output .="error;<p>Type Your Email To Search</p>";
            }
            echo $output;
        }
       else if($_POST["data"]=="categories")
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select * from categorie where cat_title like '".$value."%'";
            $resultat=mysqli_query($conn,$query);
            if(mysqli_num_rows($resultat)>0)
            {
                    while($row=$resultat->fetch_assoc())
                    {
                        $id=$row["cat_id"];
                        $title=$row["cat_title"];
                        $output.='<tr>
                                <td>'.$id.'</td>
                                <td>'.$title.'</td>
                                <td>
                                <a href="#" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                <a href="#" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                </td>
                            </tr>';
                    }
            }
            else
            {
                $output .="error;<p>No Categorie at this title</p>";
            }
            }
            else
            {
                $output .="error;<p>Type Your Title To Search</p>";
            }
            echo $output;
        }
        else if($_POST["data"]=="brandes")
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select brande_id,categorie.cat_title,brande_title from brandes ,categorie
                    where Brand_cat=cat_id and brande_title like '".$value."%'";
            $resultat=mysqli_query($conn,$query);
            if(mysqli_num_rows($resultat)>0)
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
                                    <a href="#" id="edit"><i class="far fa-edit"></i><span>Edit</span></a>
                                    <a href="#" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                    </td>
                                </tr>';
                    }
            }
            else
            {
                $output .="error;<p>No Brande at this title</p>";
            }
            }
            else
            {
                $output .="error;<p>Type Your Title To Search</p>";
            }
            echo $output;
        }
        else if($_POST["data"]=="products")
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select product_id,product_image,product_title,product_price,product_amount FROM product where product_title  like '".$value."%'";
            $resultat=mysqli_query($conn,$query);
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
            else
            {
                $output .="error;<p>No Product at this title</p>";
            }
            }
            else
            {
                $output .="error;<p>Type Your Title To Search</p>";
            }
            echo $output;
        }
        else if($_POST["data"]=="orders")
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select order_id,user_email,order_date,order_total from orders , users
                    where order_users=users_id and user_email  like '".$value."%'
                    order by order_date desc ";
            $resultat=mysqli_query($conn,$query);
            if(mysqli_num_rows($resultat)>0)
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
                                    <a href="Orders.php?function=function&order_id='.$id.'&user_email='.$email.'" id="delete"><i class="fas fa-times"></i><span>Delete</span></a>
                                    </td>
                                </tr>';
                    }
            }
            else
            {
                $output .="error;<p>no order to this member</p>";
            }
            }
            else
            {
                $output .="error;<p>Type Your Member mail To Search</p>";
            }
            echo $output;
        }
        else if($_POST["data"]=="Change_Member_Order" && isset($_POST["order_id"]))
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select * from users where user_email  like '".$value."%'";
            $resultat=mysqli_query($conn,$query);
            if(mysqli_num_rows($resultat)>0)
            {
                    while($row=$resultat->fetch_assoc())
                    {
                        $fname=$row["user_fname"];
                        $lname=$row["user_lname"];
                        $email=$row["user_email"];
                        $id=$row["users_id"];
                        $output.='<tr>
                                    <td>'.$id.'</td>
                                    <td>'.$fname.' '.$lname.'</td>
                                    <td>'.$email.'</td>
                                    <td>
                                        <a href="Manage_Orders.php?order_id='.$_POST["order_id"].'&new_member_id='.$id.'" id="change"><i class="far fa-edit"></i><span>Change</span></a>
                                    </td>
                                  </tr>';
                    }
            }
            else
            {
                $output .="error;<p>No User at this email</p>";
            }
            }
            else
            {
                $output .="error;<p>Type The mail To Search</p>";
            }
            echo $output;
        }
        else if($_POST["data"]=="Add_product_order" && isset($_POST["order_id"]))
        {
            $output="";
            $value=$_POST["value"];
            if(!empty($value))
            {
            $query="select product_id,product_image,product_title,product_price,product_amount FROM product
                    where product_id not in(select order_product from fakeorderinfo) and product_title like '%".$value."%'";
            $resultat=mysqli_query($conn,$query);
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
                                        <a href="Manage_Orders.php?order_id='.$_POST["order_id"].'&function=add_new_product&new_product_id='.$product_id.'" id="add_to_order"><i class="far fa-edit"></i><span>Add</span></a>
                                    </td>
                                </tr>';
                    }
            }
            else
            {
                $output .="error;<p>No Product at this title</p>";
            }
            }
            else
            {
                $output .="error;<p>Type The Title of Product To Search</p>";
            }
            echo $output;
        }
        else 
        {
            echo "none";
        }
        
    }
    else
    {
        session_unset();
        session_destroy();
        header("Location: ../index.html");
    }



