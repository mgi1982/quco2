function makeFrame() {
   ifrm = document.createElement("IFRAME");
   ifrm.setAttribute("src", "http://quco2.dev/js/qucoit.js");
   ifrm.style.width = (window.innerWidth / 3 ) +"px";
   ifrm.style.height = window.innerHeight + "px";
   ifrm.style.position = "absolute";
   ifrm.style.top = "0px";
   ifrm.style.right = "0px";
   document.body.appendChild(ifrm);
}; 
