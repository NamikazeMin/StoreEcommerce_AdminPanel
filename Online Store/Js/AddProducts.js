
 var   btnOpper=document.getElementById("btnadd"),
       form=document.getElementById("form"),
       error=document.getElementById("error_message"),
       div_col_1=document.getElementById("col-1"),
       div_col_2=document.getElementById("col-2");
       form.onsubmit=(e)=>
       {
           e.preventDefault();
       }

    if(btnOpper.textContent=="Add Product") // Pour Ajouter Le Produit 
    {
        btnOpper.onclick=function()
        {

            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function()
            {
                    if(this.readyState==4 && this.status==200)
                    {
                        var data=this.response;
                        if(data=="yes")
                        {
                            if(error.classList.contains("active"));
                            error.classList.remove("active");
                            div_col_1.style="margin-top:0px";
                            div_col_2.style="margin-top:0px";
                            window.location="../Admin/Products.php?function=show";
                            
                        }
                        else if(data=="errorconnection")
                        {
                            window.location="../index.html";
                        }
                        else
                        {
                            error.classList.add("active");
                            error.innerHTML=data;
                            div_col_1.style="margin-top:"+error.offsetHeight+"px";
                            div_col_2.style="margin-top:"+error.offsetHeight+"px";
                        }
                        
                    }
                }
                xhttp.open("POST","../Admin/Manage_Products.php");
                var formdata=new FormData(form);
                xhttp.send(formdata,"function=add");      
        }
    }
    else if(btnOpper.textContent=="Update Product")
    {

        btnOpper.onclick=function()
        {
        
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function()
            {
                if(this.readyState==4 && this.status==200)
                {
                    var data=this.response;
                    if(data=="yes")
                    {
                        if(error.classList.contains("active"));
                        error.classList.remove("active");
                        div_col_1.style="margin-top:0px";
                        div_col_2.style="margin-top:0px";
                        window.location="../Admin/Products.php?function=show";
                        
                    }
                    else if(data=="errorconnection")
                    {
                        window.location="../Pages/index.html";
                    }
                    else
                    {
                        error.classList.add("active");
                        error.innerHTML=data;
                        div_col_1.style="margin-top:"+error.offsetHeight+"px";
                        div_col_2.style="margin-top:"+error.offsetHeight+"px";
                    }
                    
                }
            }
            xhttp.open("POST","../Admin/Manage_Products.php");
            var formdata=new FormData(form);
            xhttp.send(formdata,"function=alter");
            
        }
    }
    

