///  Add New Member
var txtfirstname=document.getElementById("fname"),
    txtlastname=document.getElementById("lname"),
    txtemail=document.getElementById("email"),
    txtpassword=document.getElementById("password"),
    rdbuser=document.getElementsByClassName("rdbuser"),
    rdbadmin=document.getElementsByClassName("rdbadmin"),
    error=document.getElementById("error_message"),
    btnOpper=document.getElementById("btnadd"),
    divusername=document.getElementById("divusername");



if(btnOpper.textContent=="Update Member") //For Update Member
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
                    txtfirstname.value="";
                    txtlastname.value="";
                    txtemail.value="";
                    txtpassword.value="";
                    rdbuser[0].checked=false;
                    rdbadmin[0].checked=false;
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    divusername.style="margin-top:0px";
                    window.location="../Admin/Members.php?function=show";
                }
                else if(data=="errorconnection")
                {
                    window.location="../Pages/index.html";
                }
                else
                {
                error.classList.add("active");
                error.innerHTML=data;
                divusername.style="margin-top:"+error.offsetHeight+"px";
                }
            }
        }
        var type="";
        if(rdbadmin[0].checked==true)
        {
            type="Admin";
        }
        else if(rdbuser[0].checked==true)
        {
            type="User";
        }
        xhttp.open("POST","../Admin/Manage_Members.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=update&fname="+txtfirstname.value+"&lname="+txtlastname.value+"&email="+txtemail.value+"&password="+txtpassword.value+"&type="+type);

    }
}
else if(btnOpper.textContent=="Add Member") //For Add Member
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
                    txtfirstname.value="";
                    txtlastname.value="";
                    txtemail.value="";
                    txtpassword.value="";
                    rdbuser[0].checked=false;
                    rdbadmin[0].checked=false;
                    if(error.classList.contains("active"));
                    error.classList.remove("active");
                    divusername.style="margin-top:0px";
                    window.location="../Admin/Members.php?function=show";
                }
                else if(data=="errorconnection")
                {
                    window.location="../index.html";
                }
                else
                {
                error.classList.add("active");
                error.innerHTML=data;
                divusername.style="margin-top:"+error.offsetHeight+"px";
                }
            }
        }
        var type="";
        if(rdbadmin[0].checked==true)
        {
            type="Admin";
        }
        else if(rdbuser[0].checked==true)
        {
            type="User";
        }
        xhttp.open("POST","../Admin/Manage_Members.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=add&fname="+txtfirstname.value+"&lname="+txtlastname.value+"&email="+txtemail.value+"&password="+txtpassword.value+"&type="+type);

    }







    //Show And Hide Placeholder when Output is Empty
    //first Name
    txtfirstname.onfocus=function()
    {
        txtfirstname.setAttribute("placeholder","");
    }
    txtfirstname.onblur=()=>
    {
        if(txtfirstname.value=="")
        {
            txtfirstname.setAttribute("placeholder",txtfirstname.getAttribute("data-place"));
        }
    }

    //last Name
    txtlastname.onfocus=function()
    {
        txtlastname.setAttribute("placeholder","");
    }
    txtlastname.onblur=()=>
    {
        if(txtlastname.value=="")
        {
            txtlastname.setAttribute("placeholder",txtfirstname.getAttribute("data-place"));
        }
    }

    //email 
    txtemail.onfocus=function()
    {
        txtemail.setAttribute("placeholder","");
    }
    txtemail.onblur=()=>
    {
        if(txtemail.value=="")
        {
            txtemail.setAttribute("placeholder",txtemail.getAttribute("data-place"));
        }
    }
    
    //password
    txtpassword.onfocus=function()
    {
        txtpassword.setAttribute("placeholder","");
    }
    txtpassword.onblur=()=>
    {
        if(txtpassword.value=="")
        {
            txtpassword.setAttribute("placeholder",txtpassword.getAttribute("data-place"));
        }
    }
    
}





   