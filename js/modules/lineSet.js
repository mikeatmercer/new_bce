function lineSet() {
	if(document.documentElement.clientWidth === App.windowDimensions.w && document.documentElement.clientHeight === App.windowDimensions.h) {
		return;
	}
	
	App.windowDimensions.w = document.documentElement.clientWidth
	App.windowDimensions.h = document.documentElement.clientHeight
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
