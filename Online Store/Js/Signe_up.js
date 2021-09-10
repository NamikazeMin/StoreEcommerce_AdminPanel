var form=document.getElementById("signeupform"),
    btnsugneup=document.getElementById("btnsubmit"),
    error=document.getElementById("error_message"),
    showpassword=document.getElementById("showpassword");

    form.onsubmit=(e)=>
    {
        e.preventDefault();
    }

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


    btnsugneup.onclick=function()
    { 
        var xhr=new XMLHttpRequest;
        xhr.open("POST","../Pages/Signeup.php")
        xhr.onreadystatechange=function()
        {
            if(this.status==200 && this.readyState==4)
            {
                var data=this.response;
                if(data=="yes")
                {
                    window.location="../Pages/store.php";
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
        var formdata=new FormData(form);
        xhr.send(formdata);
    }