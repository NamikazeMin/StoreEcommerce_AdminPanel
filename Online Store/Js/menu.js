var menu_show=document.getElementById("menu-show-hide"),
    menu=document.getElementById("menu"),
    logout=document.getElementById("logout");
    menu_show.onclick=function()
    {
        menu.classList.toggle("active");
    }




    logout.onclick=function()
    {
        var xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function()
        {
            if(this.readyState==4 && this.status==200)
            {
            }
        }
        xhttp.open("POST","../Admin/Logout.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("logout=true");
    }