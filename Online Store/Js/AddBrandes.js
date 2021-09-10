var txtbrande=document.getElementById("txtbrande"),
    btnOperation=document.getElementById("btnadd"),
    error=document.getElementById("error_message"),
    brande_title=document.getElementById("brande-title"),
    select_cat=document.getElementById("select_cat");


    if(btnOperation.textContent=="Add Brande") //Pour Ajouter La Marque
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
                    txtbrande.value="";
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    brande_title.style="margin-top:0px";
                    window.location="../Admin/Brandes.php?function=show";
                }
                else if(data=="errorconnection")
                {
                    window.location="../index.html";
                }
                else
                {
                    error.classList.add("active");
                    error.innerHTML=data;
                    brande_title.style="margin-top:"+error.offsetHeight+"px";
                }
            }
        }
        xhttp.open("POST","../Admin/Manage_Brandes.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=add&title="+txtbrande.value+"&categorie="+select_cat.value);
        }

        //Place Holder
        txtbrande.onfocus=function()
        {
            txtbrande.setAttribute("placeholder","");
        }
        txtbrande.onblur=()=>
        {
            if(txtbrande.value=="")
            {
                txtbrande.setAttribute("placeholder",txtbrande.getAttribute("data-place"));
            }
        }
    }
    else if(btnOperation.textContent=="Update Brande")//Pour Modifier La Marque
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
                        txtbrande.value="";
                        if(error.classList.contains("active"));
                        error.classList.remove("active");
                        brande_title.style="margin-top:0px";
                        window.location="../Admin/Brandes.php?function=show";
                    }
                    else if(data=="errorconnection")
                    {
                        window.location="../Pages/index.html";
                    }
                    else
                    {
                        error.classList.add("active");
                        error.innerHTML=data;
                        brande_title.style="margin-top:"+error.offsetHeight+"px";
                    }
                }
            }
            xhttp.open("POST","../Admin/Manage_Brandes.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("function=alter&title="+txtbrande.value+"&categorie="+select_cat.value);
            
        }
    }
    