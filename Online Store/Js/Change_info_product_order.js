var txtprice=document.getElementById("txtprice"),
    txtamount=document.getElementById("txtamount"),
    btnupdate=document.getElementById("update"),
    error=document.getElementById("error_message"),
    info=document.getElementById("info"),
    lblproduct_id=document.getElementById("lblproduct_id"),
    lblorder_id=document.getElementById("lblorder_id");




    var lastprice=txtprice.value,
        lastamount=txtamount.value;

        txtprice.onblur=function()
        {
            if(txtprice.value=="" || parseInt(txtprice.value)==0)
            {
                txtprice.value=lastprice;
            }
        }

        txtamount.onblur=function()
        {
            if(txtamount.value=="" || parseInt(txtamount.value)==0)
            {
                txtamount.value=lastamount;
            }
        }

    btnupdate.onclick=function()
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
                        info.style="margin-top:0px";
                        window.location="../Admin/Orders.php?function=update&order_id="+lblorder_id.textContent;
                    }
                    else if(data=="errorconnection")
                    {
                        window.location="../index.html";
                    }
                    else
                    {
                        error.classList.add("active");
                        error.innerHTML=data;
                        info.style="margin-top:"+error.offsetHeight+"px";
                    }
                    
                }
            }
            xhttp.open("POST","../Admin/Manage_Orders.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("function=alter_product&price="+txtprice.value+"&amount="+txtamount.value+"&order_id="+lblorder_id.textContent+"&product_id="+lblproduct_id.textContent); 
    }


