var txtcategorie=document.getElementById("txtcategorie"),
    btnOperation=document.getElementById("btnadd"),
    error=document.getElementById("error_message"),
    cat_title=document.getElementById("cat-title");


    if(btnOperation.textContent=="Add Categry") //Pour Ajouter La Categorie
    {
        btnOperation.onclick=function()
        {
        var xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function()
        {
            if(this.readyState==4 && this.status==200)
            {
                var data=this.response;
                if(data=="yes")
                {
                    txtcategorie.value="";
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    cat_title.style="margin-top:0px";
                    window.location="../Admin/Categorie.php?function=show";
                }
                else if(data=="errorconnection")
                {
                    window.location="../Pages/index.html";
                }
                else
                {
                    error.classList.add("active");
                    error.innerHTML=data;
                    cat_title.style="margin-top:"+error.offsetHeight+"px";
                }
            }
        }
        xhttp.open("POST","../Admin/Manage_Categories.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=add&value="+txtcategorie.value);
        }


            //Place Holder
            txtcategorie.onfocus=function()
            {
                txtcategorie.setAttribute("placeholder","");
            }
            txtcategorie.onblur=()=>
            {
                if(txtcategorie.value=="")
                {
                    txtcategorie.setAttribute("placeholder",txtcategorie.getAttribute("data-place"));
                }
            }
    }
    else if(btnOperation.textContent=="Update Category") //Pour Modifier La Categorie
    {
        btnOperation.onclick=function()
        {
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function()
            {
                if(this.readyState==4 && this.status==200)
                {
                    var data=this.response;
                    if(data=="yes")
                    {
                        txtcategorie.value="";
                        if(error.classList.contains("active"));
                        error.classList.remove("active");
                        cat_title.style="margin-top:0px";
                        window.location="../Admin/Categorie.php?function=show";
                    }
                    else if(data=="errorconnection")
                    {
                        window.location="../index.html";
                    }
                    else
                    {
                        error.classList.add("active");
                        error.innerHTML=data;
                        cat_title.style="margin-top:"+error.offsetHeight+"px";
                    }
                }
            }
            xhttp.open("POST","../Admin/Manage_Categories.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("function=alter&value="+txtcategorie.value);
        }
    }