window.onload=function()
{
    var dashboadr=document.getElementById("orders");
    dashboadr.classList.add("menuselect");
}

var txtsearch=document.getElementById("txtsearch"),
    btnsearch=document.getElementById("btnsearch"),
    product_table=document.getElementById("product_table"),
    errorsearchbox=document.getElementById("errorsearchbox"),
    order_id=document.getElementById("order_id");

    btnsearch.onclick=function()
    { 
        if(errorsearchbox.classList.contains("active_error"))
        {
            errorsearchbox.classList.remove("active_error");
        }
        var xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function()
        {
            if(this.readyState==4 && this.status==200)
            {
                var data=this.response;
                if(data.search("error")==-1)
                {
                    product_table.children[1].innerHTML=data;
                }
                else
                {
                    var table=data.split(";");
                    errorsearchbox.innerHTML=table[1];
                    if(!errorsearchbox.classList.contains("active_error"))
                    {
                        errorsearchbox.classList.add("active_error");
                    }
                }
            }
        }
        xhttp.open("POST","../Admin/Search.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("value="+txtsearch.value+"&data=Add_product_order&order_id="+order_id.textContent);
        txtsearch.value="";
    }
    
    var placeholder=txtsearch.getAttribute("placeholder");
    txtsearch.onfocus=function()
    {
        txtsearch.setAttribute("placeholder","");
    }
    txtsearch.onblur=()=>
    {
        if(txtsearch.value=="")
        {
            txtsearch.setAttribute("placeholder",placeholder);
        }
    }