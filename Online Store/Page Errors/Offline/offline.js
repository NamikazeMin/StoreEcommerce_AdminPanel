function hasNetwork(online) {
    var div_error_network=document.getElementById("error_network");
    // Update the DOM to reflect the current status
    if (online)
    {
      if(div_error_network.classList.contains("active_error_network"))
          div_error_network.classList.remove("active_error_network");
    } else 
    {
      if(!div_error_network.classList.contains("active_error_network"))
          div_error_network.classList.add("active_error_network");
    }
  }








  window.addEventListener("load", () => {
    hasNetwork(navigator.onLine);
  
    window.addEventListener("online", () => {
      // Set hasNetwork to online when they change to online.
      hasNetwork(true);
    });
  
    window.addEventListener("offline", () => {
      // Set hasNetwork to offline when they change to offline.
      hasNetwork(false);
    });
  });