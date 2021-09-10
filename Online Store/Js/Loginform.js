var txtemail=document.getElementById("txtemail"),
    txtpassword=document.getElementById("txtpassword"),
    btnconnect=document.getElementById("btnsubmit"),
    form=document.getElementById("loginform"),
    error=document.getElementById("error_message"),
    showpassword=document.getElementById("showpassword");


    showpassword.onclick=()=>
    {
       if(showpassword.classList.contains("fa-eye"))
       {
            showpassword.classList.remove("fa-eye");
            showpassword.classList.add("fa-eye-slash");
            txtpassword.setAttribute("type","password");
       }
       else
       {
        showpassword.classList.remove("fa-eye-slash");
        showpassword.classList.add("fa-eye");
        txtpassword.setAttribute("type","text");

       }
    }


    form.onsubmit=(e)=>
    {
        e.preventDefault();
    }

    btnconnect.onclick=function()
    {
        var xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function()
        {
            if(this.readyState==4 && this.status==200)
            {
                var data=this.response;
                if(data=="user")
                {
                    window.location="Pages/store.php";
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    form.style="margin-top:0px";
                }
                else if(data=="admin")
                {
                    window.location="Admin/index.php";
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    form.style="margin-top:0px";
                }
                else
               {
                    error.classList.add("active");
                    error.innerHTML=data;
                    form.style="margin-top:"+error.offsetHeight+"px";
               }
               
            }
        }
        xhttp.open("POST","Pages/LoginForm.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("email="+txtemail.value+"&password="+txtpassword.value);
    }