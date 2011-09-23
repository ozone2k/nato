/**************************************************************

	Script		: Overlay
	Version		: 1.2
	Authors		: Samuel birch
	Desc		: Covers the window with a semi-transparent layer.
	Licence		: Open Source MIT Licence

**************************************************************/


var Overlay = new Class({
	
	getOptions: function(){
		return {
			opacity: 0.7,
			zIndex: 1001,
			container: document.body,
			onClick: new Class()
		};
	},

	initialize: function(options){
		this.setOptions(this.getOptions(), options);
		
		this.options.container = $(this.options.container);
		
		this.container = new Element('div').setProperty('id', 'OverlayContainer').setStyles({
			position: 'absolute',
			left: '0px',
			top: '0px',
			width: '100%',
			display:'none',
			height: $(document.body).getScrollSize().y+'px',
			zIndex: this.options.zIndex
		}).injectInside(this.options.container);
		
		this.iframe = new Element('iframe').setProperties({
			'id': 'OverlayIframe',
			'name': 'OverlayIframe',
			'src': 'javascript:void(0);',
			'frameborder': 1,
			'scrolling': 'no'
		}).setStyles({
			'position': 'absolute',
			'top': 0,
			'left': 0,
			'width': '99%',
			'height': '100%',
			'filter': 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)',
			'opacity': 0,
			'zIndex': 1
		}).injectInside(this.container);
		
		this.overlay = new Element('div').setProperty('id', 'Overlay').setStyles({
			position: 'absolute',
			left: '0px',
			top: '0px',
			width: '100%',
			height: '100%',
			zIndex: 2
		}).injectInside(this.container);
		
		this.container.addEvent('click', function(){
			this.options.onClick();
		}.bind(this));
		
		this.fade = new Fx.Morph(this.container, 'opacity').set(0);
		this.position();
		
		window.addEvent('resize', this.position.bind(this));
	},
	
	position: function(){ 
		if(this.options.container == document.body){ 
		}else{ 
			var myCoords = this.options.container.getCoordinates(); 
			this.container.setStyles({
				top: myCoords.top+'px', 
				height: myCoords.height+'px', 
				left: myCoords.left+'px', 
				width: myCoords.width+'px'
			}); 
		} 
	},
	
	
	
	show: function(){

	this.fade.start({'opacity':[0,this.options.opacity], 'display':'block'});
	var s = document.getElementsByTagName('select');
	for (i = 0; i != s.length; i++) {s[i].style.visibility = 'hidden';}
	var ip = document.getElementsByTagName('input');
	for (i = 0; i != ip.length; i++) {ip[i].style.visibility = 'hidden';}
	var fO = document.getElementsByTagName('object');
	for (i = 0; i < fO.length; i++) {fO[i].style.visibility = 'hidden';}
	var fE = document.getElementsByTagName('embed');
	for (i = 0; i < fE.length; i++) {fE[i].style.visibility = 'hidden';}
	},
	
	hide: function(){
	var s = document.getElementsByTagName('select');
	for (i = 0; i != s.length; i++) {s[i].style.visibility = 'visible';}
  var ip = document.getElementsByTagName('input');
	for (i = 0; i != ip.length; i++) {ip[i].style.visibility = 'visible';}
  var fO = document.getElementsByTagName('object');
	for (i = 0; i < fO.length; i++) {fO[i].style.visibility = 'visible';}
	var fE = document.getElementsByTagName('embed');
	for (i = 0; i < fE.length; i++) {fE[i].style.visibility = 'visible';}

	this.fade.start({'opacity':[0,this.options.opacity], 'display':'none'});
}	
	
	
});
Overlay.implement(new Options);



/*************************************************************/
