function ajaxRequest() 
{ 
   try 
   { 
      var request = new XMLHttpRequest() 
   } 
   catch(e1) 
   { 
      try 
      { 
         request = new ActiveXObject("Msxml2.XMLHTTP") 
      } 
      catch(e2) 
      { 
         try 
         { 
            request = new ActiveXObject("Microsoft.XMLHTTP") 
         } 
         catch(e3) 
         { 
            request = false 
         } 
      } 
   } 
   return request 
}


function postAjaxRequest(url, params, target) 
{ 
   request = new PIPHP_JS_AjaxRequest() 
 
   request.onreadystatechange = function() 
   { 
      if (this.readyState == 4) 
         if (this.status == 200) 
            if (this.responseText != null) 
               target.innerHTML = this.responseText 
// You can remove these two alerts after debugging 
            else alert("Ajax error: No data received") 
         else alert( "Ajax error: " + this.statusText) 
   } 
 
   request.open("POST", url, true) 
   request.setRequestHeader("Content-type", 
      "application/x-www-form-urlencoded") 
   request.setRequestHeader("Content-length", 
      params.length) 
   request.setRequestHeader("Connection", "close") 
   request.send(params) 
}

function getAjaxRequest(url, params, target) 
{ 
   nocache = "&nocache=" + Math.random() * 1000000 
   request = new PIPHP_JS_AjaxRequest() 
    
   request.onreadystatechange = function() 
   { 
      if (this.readyState == 4) 
         if (this.status == 200) 
            if (this.responseText != null) 
               target.innerHTML = this.responseText 
// You can remove these two alerts after debugging 
            else alert("Ajax error: No data received") 
         else alert( "Ajax error: " + this.statusText) 
   } 
 
   request.open("GET", url + "?" + params + nocache, true) 
   request.send(null) 
}



