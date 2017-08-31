function lineSet() {
	/*
	let newW = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
			newH = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
	if(newW === App.windowDimensions.w && newH === App.windowDimensions.h) {
		return;
	}

	App.windowDimensions.w = newW
	App.windowDimensions.h = newH
	*/
	let tester = document.createElement('div');
	tester.innerHTML = '<div style="visibility:hidden; position:fixed; left: 0; top: 0; width: 100%; height: 100%;">asdf</div>'
	document.querySelector('body').appendChild(tester);
	let windowDimensions = tester.querySelector('div').getBoundingClientRect();
	document.querySelector('body').removeChild(tester);
	let 	theight = windowDimensions.height,
		twidth = windowDimensions.width,
		hypo = Math.sqrt(theight*theight + twidth*twidth),
		sinner = (theight/hypo),
		degree = Math.asin( sinner )*(180/Math.PI),
	    	theLine = document.getElementById('liner');

	theLine.style.width = hypo+'px';
	theLine.style.transform = 'rotate(-'+degree+'deg)'

	var styleCookie = theLine.getAttribute('style');
	Cookies.set('liner_styles', styleCookie);
}
