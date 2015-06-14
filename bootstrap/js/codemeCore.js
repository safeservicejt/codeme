function setBgColor(el,elValue)
{
	var len=el.length;
	
	for (var i = 0; i < len; ++i) {
	    el[i].style.backgroundColor = elValue;
	}
}
function setDisplay(el,elValue)
{
	var len=el.length;

	for (var i = 0; i < len; ++i) {

		if(elValue=='show')
		{
			el[i].style.display = '';
		}
		else
		{
			el[i].style.display = 'none';
		}
	    
	}
}

function setFadein(el)
{
  el.style.opacity = 0;

  var last = +new Date();
  var tick = function() {
    el.style.opacity = +el.style.opacity + (new Date() - last) / 400;
    last = +new Date();

    if (+el.style.opacity < 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
    }
  };

  tick();
}

function setFadeinAll(el)
{
	var len=el.length;

	for (var i = 0; i < len; ++i) {
		setFadein(el[i]);	    
	}
}


function getText(el)
{
	var tmp=el.innerText;

	return tmp;
}

function getHTML(el)
{
	var tmp=el.innerHTML;

	return tmp;
}

function addClass(el)
{
	if (el.classList)
	  el.classList.add(className);
	else
	  el.className += ' ' + className;
}



