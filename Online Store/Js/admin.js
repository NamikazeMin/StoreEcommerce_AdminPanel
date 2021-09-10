
window.onload=function()
{
    var dashboadr=document.getElementById("dashboard");
    dashboadr.classList.add("menuselect");
}




var menu_show=document.getElementById("menu-show-hide"),
    menu=document.getElementById("menu"),
    logout=document.getElementById("logout");
    menu_show.onclick=function()
    {
        menu.classList.toggle("active");
    }
    //Show and hide Menu Users
var menu_users=document.getElementById("show-users"),
    menu_products=document.getElementById("show-products"),
    users_info=document.getElementById("users-info"),
    products_info=document.getElementById("products-info");

    menu_users.onclick=()=>
    {
        users_info.classList.toggle("hide_liste_users_products");
        if(menu_users.children[0].classList.contains("fa-minus"))
        {
            menu_users.children[0].classList.remove("fa-minus");
            menu_users.children[0].classList.add("fa-plus");
        }
        else
        {
            menu_users.children[0].classList.remove("fa-plus");
            menu_users.children[0].classList.add("fa-minus");
        }
    }
    //Show And Hide Products Liste
    menu_products.onclick=()=>
    {
        products_info.classList.toggle("hide_liste_users_products");

        if(menu_products.children[0].classList.contains("fa-minus"))
        {
            menu_products.children[0].classList.remove("fa-minus");
            menu_products.children[0].classList.add("fa-plus");
        }
        else
        {
            menu_products.children[0].classList.remove("fa-plus");
            menu_products.children[0].classList.add("fa-minus");
        }
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


