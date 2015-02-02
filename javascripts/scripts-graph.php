!function(){if(this.SVG=function(e){return SVG.supported?new SVG.Doc(e):void 0},SVG.ns="http://www.w3.org/2000/svg",SVG.xlink="http://www.w3.org/1999/xlink",SVG.did=1e3,SVG.eid=function(e){return"Svgjs"+e.charAt(0).toUpperCase()+e.slice(1)+SVG.did++},SVG.create=function(e){var t=document.createElementNS(this.ns,e);return t.setAttribute("id",this.eid(e)),t},SVG.extend=function(){var e,t,n,r;for(e=[].slice.call(arguments),t=e.pop(),r=e.length-1;r>=0;r--)if(e[r])for(n in t)e[r].prototype[n]=t[n];SVG.Set&&SVG.Set.inherit&&SVG.Set.inherit()},SVG.get=function(e){var t=document.getElementById(e);return t?t.instance:void 0},SVG.supported=function(){return!!document.createElementNS&&!!document.createElementNS(SVG.ns,"svg").createSVGRect}(),!SVG.supported)return!1;SVG.regex={test:function(e,t){return this[t].test(e)},unit:/^(-?[\d\.]+)([a-z%]{0,2})$/,hex:/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,rgb:/rgb\((\d+),(\d+),(\d+)\)/,isHex:/^#[a-f0-9]{3,6}$/i,isRgb:/^rgb\(/,isCss:/[^:]+:[^;]+;?/,isStyle:/^font|text|leading|cursor/,isBlank:/^(\s+)?$/,isNumber:/^-?[\d\.]+$/,isPercent:/^-?[\d\.]+%$/},SVG.defaults={matrix:"1 0 0 1 0 0",attrs:{"fill-opacity":1,"stroke-opacity":1,"stroke-width":0,"stroke-linejoin":"miter","stroke-linecap":"butt",fill:"#000000",stroke:"#000000",opacity:1,x:0,y:0,cx:0,cy:0,width:0,height:0,r:0,rx:0,ry:0,offset:0,"stop-opacity":1,"stop-color":"#000000"},trans:function(){return{x:0,y:0,scaleX:1,scaleY:1,rotation:0,skewX:0,skewY:0,matrix:this.matrix,a:1,b:0,c:0,d:1,e:0,f:0}}},SVG.Color=function(e){var t;this.r=0,this.g=0,this.b=0,"string"==typeof e?SVG.regex.isRgb.test(e)?(t=SVG.regex.rgb.exec(e.replace(/\s/g,"")),this.r=parseInt(t[1]),this.g=parseInt(t[2]),this.b=parseInt(t[3])):SVG.regex.isHex.test(e)&&(t=SVG.regex.hex.exec(this._fullHex(e)),this.r=parseInt(t[1],16),this.g=parseInt(t[2],16),this.b=parseInt(t[3],16)):"object"==typeof e&&(this.r=e.r,this.g=e.g,this.b=e.b)},SVG.extend(SVG.Color,{toString:function(){return this.toHex()},toHex:function(){return"#"+this._compToHex(this.r)+this._compToHex(this.g)+this._compToHex(this.b)},toRgb:function(){return"rgb("+[this.r,this.g,this.b].join()+")"},brightness:function(){return.3*(this.r/255)+.59*(this.g/255)+.11*(this.b/255)},_fullHex:function(e){return 4==e.length?["#",e.substring(1,2),e.substring(1,2),e.substring(2,3),e.substring(2,3),e.substring(3,4),e.substring(3,4)].join(""):e},_compToHex:function(e){var t=e.toString(16);return 1==t.length?"0"+t:t}}),SVG.Color.test=function(e){return e+="",SVG.regex.isHex.test(e)||SVG.regex.isRgb.test(e)},SVG.Color.isRgb=function(e){return e&&"number"==typeof e.r},SVG.Array=function(e,t){e=(e||[]).valueOf(),0==e.length&&t&&(e=t.valueOf()),this.value=this.parse(e)},SVG.extend(SVG.Array,{morph:function(e){if(this.destination=this.parse(e),this.value.length!=this.destination.length){for(var t=this.value[this.value.length-1],n=this.destination[this.destination.length-1];this.value.length>this.destination.length;)this.destination.push(n);for(;this.value.length<this.destination.length;)this.value.push(t)}return this},settle:function(){var e,t=[];for(e=this.value.length-1;e>=0;e--)-1==t.indexOf(this.value[e])&&t.push(this.value[e]);return this.value=t},at:function(e){if(!this.destination)return this;for(var t=0,n=this.value.length,r=[];n>t;t++)r.push(this.value[t]+(this.destination[t]-this.value[t])*e);return new SVG.Array(r)},toString:function(){return this.value.join(" ")},valueOf:function(){return this.value},parse:function(e){return e=e.valueOf(),Array.isArray(e)?e:this.split(e)},split:function(e){return e.replace(/\s+/g," ").replace(/^\s+|\s+$/g,"").split(" ")}}),SVG.PointArray=function(){this.constructor.apply(this,arguments)},SVG.PointArray.prototype=new SVG.Array,SVG.extend(SVG.PointArray,{toString:function(){for(var e=0,t=this.value.length,n=[];t>e;e++)n.push(this.value[e].join(","));return n.join(" ")},at:function(e){if(!this.destination)return this;for(var t=0,n=this.value.length,r=[];n>t;t++)r.push([this.value[t][0]+(this.destination[t][0]-this.value[t][0])*e,this.value[t][1]+(this.destination[t][1]-this.value[t][1])*e]);return new SVG.PointArray(r)},parse:function(e){if(e=e.valueOf(),Array.isArray(e))return e;e=this.split(e);for(var t,n=0,r=e.length,i=[];r>n;n++)t=e[n].split(","),i.push([parseFloat(t[0]),parseFloat(t[1])]);return i},move:function(e,t){var n=this.bbox();e-=n.x,t-=n.y;for(var r=this.value.length-1;r>=0;r--)this.value[r]=[this.value[r][0]+e,this.value[r][1]+t];return this},size:function(e,t){var n,r=this.bbox();for(n=this.value.length-1;n>=0;n--)this.value[n][0]=(this.value[n][0]-r.x)*e/r.width+r.x,this.value[n][1]=(this.value[n][1]-r.y)*t/r.height+r.x;return this},bbox:function(){if(0==this.value.length)return{x:0,y:0,width:0,height:0};var e,t=this.value[0][0],n=this.value[0][1],r={x:t,y:n};for(e=this.value.length-1;e>=0;e--)this.value[e][0]<r.x&&(r.x=this.value[e][0]),this.value[e][1]<r.y&&(r.y=this.value[e][1]),this.value[e][0]>t&&(t=this.value[e][0]),this.value[e][1]>n&&(n=this.value[e][1]);return r.width=t-r.x,r.height=n-r.y,r}}),SVG.Number=function(e){switch(this.value=0,this.unit="",typeof e){case"number":this.value=isNaN(e)?0:isFinite(e)?e:0>e?-3.4e38:3.4e38;break;case"string":var t=e.match(SVG.regex.unit);t&&(this.value=parseFloat(t[1]),"%"==t[2]&&(this.value/=100),this.unit=t[2]);break;default:e instanceof SVG.Number&&(this.value=e.value,this.unit=e.unit)}},SVG.extend(SVG.Number,{toString:function(){return("%"==this.unit?~~(1e8*this.value)/1e6:this.value)+this.unit},valueOf:function(){return this.value},to:function(e){return"string"==typeof e&&(this.unit=e),this},plus:function(e){return this.value=this+new SVG.Number(e),this},minus:function(e){return this.plus(-(new SVG.Number(e)))},times:function(e){return this.value=this*new SVG.Number(e),this},divide:function(e){return this.value=this/new SVG.Number(e),this}}),SVG.ViewBox=function(e){var t,n,r,i,s=e.bbox(),o=(e.attr("viewBox")||"").match(/-?[\d\.]+/g);this.x=s.x,this.y=s.y,this.width=e.node.clientWidth||e.node.getBoundingClientRect().width,this.height=e.node.clientHeight||e.node.getBoundingClientRect().height,o&&(t=parseFloat(o[0]),n=parseFloat(o[1]),r=parseFloat(o[2]),i=parseFloat(o[3]),this.zoom=this.width/this.height>r/i?this.height/i:this.width/r,this.x=t,this.y=n,this.width=r,this.height=i),this.zoom=this.zoom||1},SVG.extend(SVG.ViewBox,{toString:function(){return this.x+" "+this.y+" "+this.width+" "+this.height}}),SVG.BBox=function(e){var t;if(this.x=0,this.y=0,this.width=0,this.height=0,e){try{t=e.node.getBBox()}catch(n){t={x:e.node.clientLeft,y:e.node.clientTop,width:e.node.clientWidth,height:e.node.clientHeight}}this.x=t.x+e.trans.x,this.y=t.y+e.trans.y,this.width=t.width*e.trans.scaleX,this.height=t.height*e.trans.scaleY}this.cx=this.x+this.width/2,this.cy=this.y+this.height/2},SVG.extend(SVG.BBox,{merge:function(e){var t=new SVG.BBox;return t.x=Math.min(this.x,e.x),t.y=Math.min(this.y,e.y),t.width=Math.max(this.x+this.width,e.x+e.width)-t.x,t.height=Math.max(this.y+this.height,e.y+e.height)-t.y,t.cx=t.x+t.width/2,t.cy=t.y+t.height/2,t}}),SVG.RBox=function(e){var t,n,r={};if(this.x=0,this.y=0,this.width=0,this.height=0,e){for(t=e.doc().parent,n=e.doc().viewbox().zoom,r=e.node.getBoundingClientRect(),this.x=r.left,this.y=r.top,this.x-=t.offsetLeft,this.y-=t.offsetTop;t=t.offsetParent;)this.x-=t.offsetLeft,this.y-=t.offsetTop;for(t=e;t=t.parent;)"svg"==t.type&&t.viewbox&&(n*=t.viewbox().zoom,this.x-=t.x()||0,this.y-=t.y()||0)}this.x/=n,this.y/=n,this.width=r.width/=n,this.height=r.height/=n,this.cx=this.x+this.width/2,this.cy=this.y+this.height/2},SVG.extend(SVG.RBox,{merge:function(e){var t=new SVG.RBox;return t.x=Math.min(this.x,e.x),t.y=Math.min(this.y,e.y),t.width=Math.max(this.x+this.width,e.x+e.width)-t.x,t.height=Math.max(this.y+this.height,e.y+e.height)-t.y,t.cx=t.x+t.width/2,t.cy=t.y+t.height/2,t}}),SVG.Element=function(e){this._stroke=SVG.defaults.attrs.stroke,this.styles={},this.trans=SVG.defaults.trans(),(this.node=e)&&(this.type=e.nodeName,this.node.instance=this)},SVG.extend(SVG.Element,{x:function(e){return e&&(e=new SVG.Number(e),e.value/=this.trans.scaleX),this.attr("x",e)},y:function(e){return e&&(e=new SVG.Number(e),e.value/=this.trans.scaleY),this.attr("y",e)},cx:function(e){return null==e?this.bbox().cx:this.x(e-this.bbox().width/2)},cy:function(e){return null==e?this.bbox().cy:this.y(e-this.bbox().height/2)},move:function(e,t){return this.x(e).y(t)},center:function(e,t){return this.cx(e).cy(t)},size:function(e,t){return this.attr({width:new SVG.Number(e),height:new SVG.Number(t)})},clone:function(){var e,t,n=this.type;return e="rect"==n||"ellipse"==n?this.parent[n](0,0):"line"==n?this.parent[n](0,0,0,0):"image"==n?this.parent[n](this.src):"text"==n?this.parent[n](this.content):"path"==n?this.parent[n](this.attr("d")):"polyline"==n||"polygon"==n?this.parent[n](this.attr("points")):"g"==n?this.parent.group():this.parent[n](),t=this.attr(),delete t.id,e.attr(t),e.trans=this.trans,e.transform({})},remove:function(){return this.parent&&this.parent.removeElement(this),this},doc:function(e){return this._parent(e||SVG.Doc)},attr:function(e,t,n){if(null==e){for(e={},t=this.node.attributes,n=t.length-1;n>=0;n--)e[t[n].nodeName]=SVG.regex.test(t[n].nodeValue,"isNumber")?parseFloat(t[n].nodeValue):t[n].nodeValue;return e}if("object"==typeof e)for(t in e)this.attr(t,e[t]);else if(null===t)this.node.removeAttribute(e);else{if(null==t)return this._isStyle(e)?"text"==e?this.content:"leading"==e&&this.leading?this.leading():this.style(e):(t=this.node.getAttribute(e),null==t?SVG.defaults.attrs[e]:SVG.regex.test(t,"isNumber")?parseFloat(t):t);if("style"==e)return this.style(t);if("x"==e&&Array.isArray(this.lines))for(n=this.lines.length-1;n>=0;n--)this.lines[n].attr(e,t);"stroke-width"==e?this.attr("stroke",parseFloat(t)>0?this._stroke:null):"stroke"==e&&(this._stroke=t),SVG.Color.test(t)||SVG.Color.isRgb(t)?t=new SVG.Color(t):"number"==typeof t?t=new SVG.Number(t):Array.isArray(t)&&(t=new SVG.Array(t)),null!=n?this.node.setAttributeNS(n,e,t.toString()):this.node.setAttribute(e,t.toString()),this._isStyle(e)&&("text"==e?this.text(t):"leading"==e&&this.leading?this.leading(t):this.style(e,t),this.rebuild&&this.rebuild(e,t))}return this},transform:function(e,t){if(0==arguments.length)return this.trans;if("string"==typeof e){if(arguments.length<2)return this.trans[e];var n={};return n[e]=t,this.transform(n)}var n=[];e=this._parseMatrix(e);for(t in e)null!=e[t]&&(this.trans[t]=e[t]);return this.trans.matrix=this.trans.a+" "+this.trans.b+" "+this.trans.c+" "+this.trans.d+" "+this.trans.e+" "+this.trans.f,e=this.trans,e.matrix!=SVG.defaults.matrix&&n.push("matrix("+e.matrix+")"),0!=e.rotation&&n.push("rotate("+e.rotation+" "+(null==e.cx?this.bbox().cx:e.cx)+" "+(null==e.cy?this.bbox().cy:e.cy)+")"),(1!=e.scaleX||1!=e.scaleY)&&n.push("scale("+e.scaleX+" "+e.scaleY+")"),0!=e.skewX&&n.push("skewX("+e.skewX+")"),0!=e.skewY&&n.push("skewY("+e.skewY+")"),(0!=e.x||0!=e.y)&&n.push("translate("+new SVG.Number(e.x/e.scaleX)+" "+new SVG.Number(e.y/e.scaleY)+")"),this._offset&&0!=this._offset.x&&0!=this._offset.y&&n.push("translate("+ -this._offset.x+" "+ -this._offset.y+")"),0==n.length?this.node.removeAttribute("transform"):this.node.setAttribute("transform",n.join(" ")),this},style:function(e,t){if(0==arguments.length)return this.attr("style")||"";if(arguments.length<2)if("object"==typeof e)for(t in e)this.style(t,e[t]);else{if(!SVG.regex.isCss.test(e))return this.styles[e];e=e.split(";");for(var n=0;n<e.length;n++)t=e[n].split(":"),2==t.length&&this.style(t[0].replace(/\s+/g,""),t[1].replace(/^\s+/,"").replace(/\s+$/,""))}else null===t||SVG.regex.test(t,"isBlank")?delete this.styles[e]:this.styles[e]=t;e="";for(t in this.styles)e+=t+":"+this.styles[t]+";";return""==e?this.node.removeAttribute("style"):this.node.setAttribute("style",e),this},data:function(e,t,n){if(arguments.length<2)try{return JSON.parse(this.attr("data-"+e))}catch(r){return this.attr("data-"+e)}else this.attr("data-"+e,null===t?null:n===!0||"string"==typeof t||"number"==typeof t?t:JSON.stringify(t));return this},bbox:function(){return new SVG.BBox(this)},rbox:function(){return new SVG.RBox(this)},inside:function(e,t){var n=this.bbox();return e>n.x&&t>n.y&&e<n.x+n.width&&t<n.y+n.height},show:function(){return this.style("display","")},hide:function(){return this.style("display","none")},visible:function(){return"none"!=this.style("display")},toString:function(){return this.attr("id")},_parent:function(e){for(var t=this;null!=t&&!(t instanceof e);)t=t.parent;return t},_isStyle:function(e){return"string"==typeof e?SVG.regex.test(e,"isStyle"):!1},_parseMatrix:function(e){if(e.matrix){var t=e.matrix.replace(/\s/g,"").split(",");6==t.length&&(e.a=parseFloat(t[0]),e.b=parseFloat(t[1]),e.c=parseFloat(t[2]),e.d=parseFloat(t[3]),e.e=parseFloat(t[4]),e.f=parseFloat(t[5]))}return e}}),SVG.Parent=function(e){this.constructor.call(this,e)},SVG.Parent.prototype=new SVG.Element,SVG.extend(SVG.Parent,{children:function(){return this._children||(this._children=[])},add:function(e,t){if(!this.has(e)){if(t=null==t?this.children().length:t,e.parent){var n=e.parent.children().indexOf(e);e.parent.children().splice(n,1)}this.children().splice(t,0,e),this.node.insertBefore(e.node,this.node.childNodes[t]||null),e.parent=this}return this._defs&&(this.node.removeChild(this._defs.node),this.node.appendChild(this._defs.node)),this},put:function(e,t){return this.add(e,t),e},has:function(e){return this.children().indexOf(e)>=0},get:function(e){return this.children()[e]},first:function(){return this.children()[0]},last:function(){return this.children()[this.children().length-1]},each:function(e,t){var n,r,i=this.children();for(n=0,r=i.length;r>n;n++)i[n]instanceof SVG.Element&&e.apply(i[n],[n,i]),t&&i[n]instanceof SVG.Container&&i[n].each(e,t);return this},removeElement:function(e){var t=this.children().indexOf(e);return this.children().splice(t,1),this.node.removeChild(e.node),e.parent=null,this},clear:function(){for(var e=this.children().length-1;e>=0;e--)this.removeElement(this.children()[e]);return this._defs&&this._defs.clear(),this},defs:function(){return this.doc().defs()}}),SVG.Container=function(e){this.constructor.call(this,e)},SVG.Container.prototype=new SVG.Parent,SVG.extend(SVG.Container,{viewbox:function(e){return 0==arguments.length?new SVG.ViewBox(this):(e=1==arguments.length?[e.x,e.y,e.width,e.height]:[].slice.call(arguments),this.attr("viewBox",e))}}),SVG.FX=function(e){this.target=e},SVG.extend(SVG.FX,{animate:function(e,t,n){var r,i,s,o,u=this.target,a=this;return"object"==typeof e&&(n=e.delay,t=e.ease,e=e.duration),e=null==e?1e3:e,t=t||"<>",a.to=function(e){var n;if(e=0>e?0:e>1?1:e,null==r){r=[];for(o in a.attrs)r.push(o);if(u.morphArray){var f,l=new u.morphArray(a._plot||u.points.toString());a._size&&l.size(a._size.width.to,a._size.height.to),f=l.bbox(),a._x?l.move(a._x.to,f.y):a._cx&&l.move(a._cx.to-f.width/2,f.y),f=l.bbox(),a._y?l.move(f.x,a._y.to):a._cy&&l.move(f.x,a._cy.to-f.height/2),delete a._x,delete a._y,delete a._cx,delete a._cy,delete a._size,a._plot=u.points.morph(l)}}if(null==i){i=[];for(o in a.trans)i.push(o)}if(null==s){s=[];for(o in a.styles)s.push(o)}for(e="<>"==t?-Math.cos(e*Math.PI)/2+.5:">"==t?Math.sin(e*Math.PI/2):"<"==t?-Math.cos(e*Math.PI/2)+1:"-"==t?e:"function"==typeof t?t(e):e,a._x?u.x(a._at(a._x,e)):a._cx&&u.cx(a._at(a._cx,e)),a._y?u.y(a._at(a._y,e)):a._cy&&u.cy(a._at(a._cy,e)),a._size&&u.size(a._at(a._size.width,e),a._at(a._size.height,e)),a._plot&&u.plot(a._plot.at(e)),a._viewbox&&u.viewbox(a._at(a._viewbox.x,e),a._at(a._viewbox.y,e),a._at(a._viewbox.width,e),a._at(a._viewbox.height,e)),n=r.length-1;n>=0;n--)u.attr(r[n],a._at(a.attrs[r[n]],e));for(n=i.length-1;n>=0;n--)u.transform(i[n],a._at(a.trans[i[n]],e));for(n=s.length-1;n>=0;n--)u.style(s[n],a._at(a.styles[s[n]],e));a._during&&a._during.call(u,e,function(t,n){return a._at({from:t,to:n},e)})},"number"==typeof e&&(this.timeout=setTimeout(function(){var t=1e3/60,n=(new Date).getTime(),r=n+e;a.interval=setInterval(function(){var t=(new Date).getTime(),i=t>r?1:(t-n)/e;a.to(i),t>r&&(a._plot&&u.plot((new SVG.PointArray(a._plot.destination)).settle()),clearInterval(a.interval),a._after?a._after.apply(u,[a]):a.stop())},e>t?t:e)},n||0)),this},bbox:function(){return this.target.bbox()},attr:function(e,t){if("object"==typeof e)for(var n in e)this.attr(n,e[n]);else this.attrs[e]={from:this.target.attr(e),to:t};return this},transform:function(e,t){if(1==arguments.length){e=this.target._parseMatrix(e),delete e.matrix;for(t in e)this.trans[t]={from:this.target.trans[t],to:e[t]}}else{var n={};n[e]=t,this.transform(n)}return this},style:function(e,t){if("object"==typeof e)for(var n in e)this.style(n,e[n]);else this.styles[e]={from:this.target.style(e),to:t};return this},x:function(e){return this._x={from:this.target.x(),to:e},this},y:function(e){return this._y={from:this.target.y(),to:e},this},cx:function(e){return this._cx={from:this.target.cx(),to:e},this},cy:function(e){return this._cy={from:this.target.cy(),to:e},this},move:function(e,t){return this.x(e).y(t)},center:function(e,t){return this.cx(e).cy(t)},size:function(e,t){if(this.target instanceof SVG.Text)this.attr("font-size",e);else{var n=this.target.bbox();this._size={width:{from:n.width,to:e},height:{from:n.height,to:t}}}return this},plot:function(e){return this._plot=e,this},viewbox:function(e,t,n,r){if(this.target instanceof SVG.Container){var i=this.target.viewbox();this._viewbox={x:{from:i.x,to:e},y:{from:i.y,to:t},width:{from:i.width,to:n},height:{from:i.height,to:r}}}return this},update:function(e){return this.target instanceof SVG.Stop&&(null!=e.opacity&&this.attr("stop-opacity",e.opacity),null!=e.color&&this.attr("stop-color",e.color),null!=e.offset&&this.attr("offset",new SVG.Number(e.offset))),this},during:function(e){return this._during=e,this},after:function(e){return this._after=e,this},stop:function(){return clearTimeout(this.timeout),clearInterval(this.interval),this.attrs={},this.trans={},this.styles={},delete this._x,delete this._y,delete this._cx,delete this._cy,delete this._size,delete this._plot,delete this._after,delete this._during,delete this._viewbox,this},_at:function(e,t){return"number"==typeof e.from?e.from+(e.to-e.from)*t:SVG.regex.unit.test(e.to)?(new SVG.Number(e.to)).minus(new SVG.Number(e.from)).times(t).plus(new SVG.Number(e.from)):e.to&&(e.to.r||SVG.Color.test(e.to))?this._color(e,t):1>t?e.from:e.to},_color:function(e,t){var n,r;return t=0>t?0:t>1?1:t,n=new SVG.Color(e.from),r=new SVG.Color(e.to),(new SVG.Color({r:~~(n.r+(r.r-n.r)*t),g:~~(n.g+(r.g-n.g)*t),b:~~(n.b+(r.b-n.b)*t)})).toHex()}}),SVG.extend(SVG.Element,{animate:function(e,t,n){return(this.fx||(this.fx=new SVG.FX(this))).stop().animate(e,t,n)},stop:function(){return this.fx&&this.fx.stop(),this}}),["click","dblclick","mousedown","mouseup","mouseover","mouseout","mousemove","mouseenter","mouseleave"].forEach(function(e){SVG.Element.prototype[e]=function(t){var n=this;return this.node["on"+e]="function"==typeof t?function(){return t.apply(n,arguments)}:null,this}}),SVG.on=function(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent("on"+t,n)},SVG.off=function(e,t,n){e.removeEventListener?e.removeEventListener(t,n,!1):e.detachEvent("on"+t,n)},SVG.extend(SVG.Element,{on:function(e,t){return SVG.on(this.node,e,t),this},off:function(e,t){return SVG.off(this.node,e,t),this}}),SVG.Defs=function(){this.constructor.call(this,SVG.create("defs"))},SVG.Defs.prototype=new SVG.Container,SVG.G=function(){this.constructor.call(this,SVG.create("g"))},SVG.G.prototype=new SVG.Container,SVG.extend(SVG.G,{x:function(e){return null==e?this.trans.x:this.transform("x",e)},y:function(e){return null==e?this.trans.y:this.transform("y",e)}}),SVG.extend(SVG.Container,{group:function(){return this.put(new SVG.G)}}),SVG.extend(SVG.Element,{siblings:function(){return this.parent.children()},position:function(){var e=this.siblings();return e.indexOf(this)},next:function(){return this.siblings()[this.position()+1]},previous:function(){return this.siblings()[this.position()-1]},forward:function(){var e=this.position();return this.parent.removeElement(this).put(this,e+1)},backward:function(){var e=this.position();return e>0&&this.parent.removeElement(this).add(this,e-1),this},front:function(){return this.parent.removeElement(this).put(this)},back:function(){return this.position()>0&&this.parent.removeElement(this).add(this,0),this},before:function(e){e.remove();var t=this.position();return this.parent.add(e,t),this},after:function(e){e.remove();var t=this.position();return this.parent.add(e,t+1),this}}),SVG.Mask=function(){this.constructor.call(this,SVG.create("mask")),this.targets=[]},SVG.Mask.prototype=new SVG.Container,SVG.extend(SVG.Mask,{remove:function(){for(var e=this.targets.length-1;e>=0;e--)this.targets[e]&&this.targets[e].unmask();return delete this.targets,this.parent.removeElement(this),this}}),SVG.extend(SVG.Element,{maskWith:function(e){return this.masker=e instanceof SVG.Mask?e:this.parent.mask().add(e),this.masker.targets.push(this),this.attr("mask",'url("#'+this.masker.attr("id")+'")')},unmask:function(){return delete this.masker,this.attr("mask",null)}}),SVG.extend(SVG.Container,{mask:function(){return this.defs().put(new SVG.Mask)}}),SVG.Clip=function(){this.constructor.call(this,SVG.create("clipPath")),this.targets=[]},SVG.Clip.prototype=new SVG.Container,SVG.extend(SVG.Clip,{remove:function(){for(var e=this.targets.length-1;e>=0;e--)this.targets[e]&&this.targets[e].unclip();return delete this.targets,this.parent.removeElement(this),this}}),SVG.extend(SVG.Element,{clipWith:function(e){return this.clipper=e instanceof SVG.Clip?e:this.parent.clip().add(e),this.clipper.targets.push(this),this.attr("clip-path",'url("#'+this.clipper.attr("id")+'")')},unclip:function(){return delete this.clipper,this.attr("clip-path",null)}}),SVG.extend(SVG.Container,{clip:function(){return this.defs().put(new SVG.Clip)}}),SVG.Gradient=function(e){this.constructor.call(this,SVG.create(e+"Gradient")),this.type=e},SVG.Gradient.prototype=new SVG.Container,SVG.extend(SVG.Gradient,{from:function(e,t){return"radial"==this.type?this.attr({fx:new SVG.Number(e),fy:new SVG.Number(t)}):this.attr({x1:new SVG.Number(e),y1:new SVG.Number(t)})},to:function(e,t){return"radial"==this.type?this.attr({cx:new SVG.Number(e),cy:new SVG.Number(t)}):this.attr({x2:new SVG.Number(e),y2:new SVG.Number(t)})},radius:function(e){return"radial"==this.type?this.attr({r:new SVG.Number(e)}):this},at:function(e){return this.put(new SVG.Stop(e))},update:function(e){return this.clear(),e(this),this},fill:function(){return"url(#"+this.attr("id")+")"},toString:function(){return this.fill()}}),SVG.extend(SVG.Defs,{gradient:function(e,t){var n=this.put(new SVG.Gradient(e));return t(n),n}}),SVG.extend(SVG.Container,{gradient:function(e,t){return this.defs().gradient(e,t)}}),SVG.Stop=function(e){this.constructor.call(this,SVG.create("stop")),this.update(e)},SVG.Stop.prototype=new SVG.Element,SVG.extend(SVG.Stop,{update:function(e){return null!=e.opacity&&this.attr("stop-opacity",e.opacity),null!=e.color&&this.attr("stop-color",e.color),null!=e.offset&&this.attr("offset",new SVG.Number(e.offset)),this}}),SVG.Doc=function(e){this.parent="string"==typeof e?document.getElementById(e):e,this.constructor.call(this,"svg"==this.parent.nodeName?this.parent:SVG.create("svg")),this.attr({xmlns:SVG.ns,version:"1.1",width:"100%",height:"100%"}).attr("xlink",SVG.xlink,SVG.ns),this._defs=new SVG.Defs,this.node.appendChild(this._defs.node),"svg"!=this.parent.nodeName&&this.stage()},SVG.Doc.prototype=new SVG.Container,SVG.extend(SVG.Doc,{stage:function(){var e,t=this,n=document.createElement("div");return n.style.cssText="position:relative;height:100%;",t.parent.appendChild(n),n.appendChild(t.node),e=function(){"complete"===document.readyState?(t.style("position:absolute;"),setTimeout(function(){t.style("position:relative;overflow:hidden;"),t.parent.removeChild(t.node.parentNode),t.node.parentNode.removeChild(t.node),t.parent.appendChild(t.node),t.fixSubPixelOffset(),SVG.on(window,"resize",function(){t.fixSubPixelOffset()})},5)):setTimeout(e,10)},e(),this},defs:function(){return this._defs},fixSubPixelOffset:function(){var e=this.node.getScreenCTM();this.style("left",-e.e%1+"px").style("top",-e.f%1+"px")}}),SVG.Shape=function(e){this.constructor.call(this,e)},SVG.Shape.prototype=new SVG.Element,SVG.Use=function(){this.constructor.call(this,SVG.create("use"))},SVG.Use.prototype=new SVG.Shape,SVG.extend(SVG.Use,{element:function(e){return this.target=e,this.attr("href","#"+e,SVG.xlink)}}),SVG.extend(SVG.Container,{use:function(e){return this.put(new SVG.Use).element(e)}}),SVG.Rect=function(){this.constructor.call(this,SVG.create("rect"))},SVG.Rect.prototype=new SVG.Shape,SVG.extend(SVG.Container,{rect:function(e,t){return this.put((new SVG.Rect).size(e,t))}}),SVG.Ellipse=function(){this.constructor.call(this,SVG.create("ellipse"))},SVG.Ellipse.prototype=new SVG.Shape,SVG.extend(SVG.Ellipse,{x:function(e){return null==e?this.cx()-this.attr("rx"):this.cx(e+this.attr("rx"))},y:function(e){return null==e?this.cy()-this.attr("ry"):this.cy(e+this.attr("ry"))},cx:function(e){return null==e?this.attr("cx"):this.attr("cx",(new SVG.Number(e)).divide(this.trans.scaleX))},cy:function(e){return null==e?this.attr("cy"):this.attr("cy",(new SVG.Number(e)).divide(this.trans.scaleY))},size:function(e,t){return this.attr({rx:(new SVG.Number(e)).divide(2),ry:(new SVG.Number(t)).divide(2)})}}),SVG.extend(SVG.Container,{circle:function(e){return this.ellipse(e,e)},ellipse:function(e,t){return this.put(new SVG.Ellipse).size(e,t).move(0,0)}}),SVG.Line=function(){this.constructor.call(this,SVG.create("line"))},SVG.Line.prototype=new SVG.Shape,SVG.extend(SVG.Line,{x:function(e){var t=this.bbox();return null==e?t.x:this.attr({x1:this.attr("x1")-t.x+e,x2:this.attr("x2")-t.x+e})},y:function(e){var t=this.bbox();return null==e?t.y:this.attr({y1:this.attr("y1")-t.y+e,y2:this.attr("y2")-t.y+e})},cx:function(e){var t=this.bbox().width/2;return null==e?this.x()+t:this.x(e-t)},cy:function(e){var t=this.bbox().height/2;return null==e?this.y()+t:this.y(e-t)},size:function(e,t){var n=this.bbox();return this.attr(this.attr("x1")<this.attr("x2")?"x2":"x1",n.x+e).attr(this.attr("y1")<this.attr("y2")?"y2":"y1",n.y+t)},plot:function(e,t,n,r){return this.attr({x1:e,y1:t,x2:n,y2:r})}}),SVG.extend(SVG.Container,{line:function(e,t,n,r){return this.put((new SVG.Line).plot(e,t,n,r))}}),SVG.Polyline=function(){this.constructor.call(this,SVG.create("polyline"))},SVG.Polyline.prototype=new SVG.Shape,SVG.Polygon=function(){this.constructor.call(this,SVG.create("polygon"))},SVG.Polygon.prototype=new SVG.Shape,SVG.extend(SVG.Polyline,SVG.Polygon,{morphArray:SVG.PointArray,plot:function(e){return this.attr("points",this.points=new SVG.PointArray(e,[[0,0]]))},move:function(e,t){return this.attr("points",this.points.move(e,t))},x:function(e){return null==e?this.bbox().x:this.move(e,this.bbox().y)},y:function(e){return null==e?this.bbox().y:this.move(this.bbox().x,e)},size:function(e,t){return this.attr("points",this.points.size(e,t))}}),SVG.extend(SVG.Container,{polyline:function(e){return this.put(new SVG.Polyline).plot(e)},polygon:function(e){return this.put(new SVG.Polygon).plot(e)}}),SVG.Path=function(e){this.constructor.call(this,SVG.create("path")),this.unbiased=!!e},SVG.Path.prototype=new SVG.Shape,SVG.extend(SVG.Path,{_plot:function(e){return this.attr("d",e||"M0,0")}}),SVG.extend(SVG.Container,{path:function(e,t){return this.put(new SVG.Path(t)).plot(e)}}),SVG.extend(SVG.Path,{x:function(e){return null==e?this.bbox().x:this.transform("x",e)},y:function(e){return null==e?this.bbox().y:this.transform("y",e)},size:function(e,t){var n=e/this._offset.width;return this.transform({scaleX:n,scaleY:null!=t?t/this._offset.height:n})},plot:function(e){var t=this.trans.scaleX,n=this.trans.scaleY;return this._plot(e),this._offset=this.transform({scaleX:1,scaleY:1}).bbox(),this.unbiased?this._offset.x=this._offset.y=0:(this._offset.x-=this.trans.x,this._offset.y-=this.trans.y),this.transform({scaleX:t,scaleY:n})}}),SVG.Image=function(){this.constructor.call(this,SVG.create("image"))},SVG.Image.prototype=new SVG.Shape,SVG.extend(SVG.Image,{load:function(e){return e?this.attr("href",this.src=e,SVG.xlink):this}}),SVG.extend(SVG.Container,{image:function(e,t,n){return t=null!=t?t:100,this.put((new SVG.Image).load(e).size(t,null!=n?n:t))}});var e="size family weight stretch variant style".split(" ");SVG.Text=function(){this.constructor.call(this,SVG.create("text")),this.styles={"font-size":16,"font-family":"Helvetica, Arial, sans-serif","text-anchor":"start"},this._leading=new SVG.Number("1.2em"),this._rebuild=!0},SVG.Text.prototype=new SVG.Shape,SVG.extend(SVG.Text,{x:function(e,t){return null==e?t?this.attr("x"):this.bbox().x:(t||(t=this.style("text-anchor"),e="start"==t?e:"end"==t?e+this.bbox().width:e+this.bbox().width/2),this.textPath||this.lines.each(function(){this.newLined&&this.x(e)}),this.attr("x",e))},cx:function(e){return null==e?this.bbox().cx:this.x(e-this.bbox().width/2)},cy:function(e,t){return null==e?this.bbox().cy:this.y(t?e:e-this.bbox().height/2)},move:function(e,t,n){return this.x(e,n).y(t)},center:function(e,t,n){return this.cx(e,n).cy(t,n)},text:function(e){if(null==e)return this.content;if(this.clear(),"function"==typeof e)this._rebuild=!1,e(this);else{this._rebuild=!0,e=SVG.regex.isBlank.test(e)?"text":e;var t,n,r=e.split("\n");for(t=0,n=r.length;n>t;t++)this.tspan(r[t]).newLine();this.rebuild()}return this},tspan:function(e){var t=this.textPath?this.textPath.node:this.node,n=(new SVG.TSpan).text(e),r=this.style();return t.appendChild(n.node),this.lines.add(n),SVG.regex.isBlank.test(r)||n.style(r),this.content+=e,n.parent=this,n},size:function(e){return this.attr("font-size",e)},leading:function(e){return null==e?this._leading:(e=new SVG.Number(e),this._leading=e,this.lines.each(function(){this.newLined&&this.attr("dy",e)}),this)},rebuild:function(){return this._rebuild&&this.lines.attr({x:this.attr("x"),dy:this._leading,style:this.style()}),this},clear:function(){for(var e=this.textPath?this.textPath.node:this.node;e.hasChildNodes();)e.removeChild(e.lastChild);return delete this.lines,this.lines=new SVG.Set,this.content="",this}}),SVG.extend(SVG.Container,{text:function(e){return this.put(new SVG.Text).text(e)}}),SVG.TSpan=function(){this.constructor.call(this,SVG.create("tspan"))},SVG.TSpan.prototype=new SVG.Shape,SVG.extend(SVG.TSpan,{text:function(e){return this.node.appendChild(document.createTextNode(e)),this},dx:function(e){return this.attr("dx",e)},dy:function(e){return this.attr("dy",e)},newLine:function(){return this.newLined=!0,this.parent.content+="\n",this.dy(this.parent._leading),this.attr("x",this.parent.x())}}),SVG.TextPath=function(){this.constructor.call(this,SVG.create("textPath"))},SVG.TextPath.prototype=new SVG.Element,SVG.extend(SVG.Text,{path:function(e){for(this.textPath=new SVG.TextPath;this.node.hasChildNodes();)this.textPath.node.appendChild(this.node.firstChild);return this.node.appendChild(this.textPath.node),this.track=this.doc().defs().path(e,!0),this.textPath.parent=this,this.textPath.attr("href","#"+this.track,SVG.xlink),this},plot:function(e){return this.track&&this.track.plot(e),this}}),SVG.Nested=function(){this.constructor.call(this,SVG.create("svg")),this.style("overflow","visible")},SVG.Nested.prototype=new SVG.Container,SVG.extend(SVG.Container,{nested:function(){return this.put(new SVG.Nested)}}),SVG._stroke=["color","width","opacity","linecap","linejoin","miterlimit","dasharray","dashoffset"],SVG._fill=["color","opacity","rule"];var t=function(e,t){return"color"==t?e:e+"-"+t};["fill","stroke"].forEach(function(e){var n={};n[e]=function(n){if("string"==typeof n||SVG.Color.isRgb(n)||n&&"function"==typeof n.fill)this.attr(e,n);else for(index=SVG["_"+e].length-1;index>=0;index--)null!=n[SVG["_"+e][index]]&&this.attr(t(e,SVG["_"+e][index]),n[SVG["_"+e][index]]);return this},SVG.extend(SVG.Element,SVG.FX,n)}),SVG.extend(SVG.Element,SVG.FX,{rotate:function(e,t,n){return this.transform({rotation:e||0,cx:t,cy:n})},skew:function(e,t){return this.transform({skewX:e||0,skewY:t||0})},scale:function(e,t){return this.transform({scaleX:e,scaleY:null==t?e:t})},translate:function(e,t){return this.transform({x:e,y:t})},matrix:function(e){return this.transform({matrix:e})},opacity:function(e){return this.attr("opacity",e)}}),SVG.Text&&SVG.extend(SVG.Text,SVG.FX,{font:function(t){for(var n in t)"anchor"==n?this.attr("text-anchor",t[n]):e.indexOf(n)>-1?this.attr("font-"+n,t[n]):this.attr(n,t[n]);return this}}),SVG.Set=function(){this.clear()},SVG.SetFX=function(e){this.set=e},SVG.extend(SVG.Set,{add:function(){var e,t,n=[].slice.call(arguments);for(e=0,t=n.length;t>e;e++)this.members.push(n[e]);return this},remove:function(e){var t=this.members.indexOf(e);return t>-1&&this.members.splice(t,1),this},each:function(e){for(var t=0,n=this.members.length;n>t;t++)e.apply(this.members[t],[t,this.members]);return this},clear:function(){return this.members=[],this},valueOf:function(){return this.members}}),SVG.Set.inherit=function(){var e,t=[];for(var e in SVG.Shape.prototype)"function"==typeof SVG.Shape.prototype[e]&&"function"!=typeof SVG.Set.prototype[e]&&t.push(e);t.forEach(function(e){SVG.Set.prototype[e]=function(){for(var t=0,n=this.members.length;n>t;t++)this.members[t]&&"function"==typeof this.members[t][e]&&this.members[t][e].apply(this.members[t],arguments);return"animate"==e?this.fx||(this.fx=new SVG.SetFX(this)):this}}),t=[];for(var e in SVG.FX.prototype)"function"==typeof SVG.FX.prototype[e]&&"function"!=typeof SVG.SetFX.prototype[e]&&t.push(e);t.forEach(function(e){SVG.SetFX.prototype[e]=function(){for(var t=0,n=this.set.members.length;n>t;t++)this.set.members[t].fx[e].apply(this.set.members[t].fx,arguments);return this}})},SVG.extend(SVG.Container,{set:function(){return new SVG.Set}}),SVG.extend(SVG.Element,{remember:function(e,t){if("object"==typeof arguments[0])for(var t in e)this.remember(t,e[t]);else{if(1==arguments.length)return this.memory()[e];this.memory()[e]=t}return this},forget:function(){if(0==arguments.length)this._memory={};else for(var e=arguments.length-1;e>=0;e--)delete this.memory()[arguments[e]];return this},memory:function(){return this._memory||(this._memory={})}}),"function"==typeof define&&define.amd?define(function(){return SVG}):"undefined"!=typeof exports&&(exports.SVG=SVG)}.call(this)

	/*
	Author: Juan Jose Alban
	Requires: svg.js jquery
	*/

	//select linecolor, hexadec
		//dettach Style and linke stroke
		var dfill = "e7e9fd"//"fff"	
		var dstroke= "afbfff"//"999"
		//
		//attach Style and linke stroke, // lighter for fills!!!
		var afill =	"d0d9ff"//"eee"
		var astroke = "91a7ff"//"ccc"
		//
		var a = "1"
		//
		//
		function hexToRgb(hex) {
		    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
		        return r + r + g + g + b + b;
		    });

		    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		    return result ? {
		        r: parseInt(result[1], 16),
		        g: parseInt(result[2], 16),
		        b: parseInt(result[3], 16)
		    } : null;
		}

		afill = "rgba("+hexToRgb(afill).r+","+hexToRgb(afill).g+","+hexToRgb(afill).b+","+a+")"
		astroke = "rgba("+hexToRgb(astroke).r+","+hexToRgb(astroke).g+","+hexToRgb(astroke).b+","+a+")"
		dfill = "rgba("+hexToRgb(dfill).r+","+hexToRgb(dfill).g+","+hexToRgb(dfill).b+","+a+")"
		dstroke = "rgba("+hexToRgb(dstroke).r+","+hexToRgb(dstroke).g+","+hexToRgb(dstroke).b+","+a+")"

		//
		var lzgraphics = lzgraphics || {};

		lzgraphics.render = function() {
		  $("lzgraph").each(function(i,el){
		    var src = $(el).attr("data-src");
		    $.getJSON(src, function(data) {
		      $(el).empty();
		      var g = new lzgraphics.Graph(el);
		      g.fromJSON(data);
		    });
		    $(this).on("mousedown", function(e) {
		      e.preventDefault();
		    });
		  });
		};

		$(window).on('navigated', function() {
		  lzgraphics.render();
		});
		$(function() {
		  lzgraphics.render();
		});

		lzgraphics.Vector = function(_x, _y) {
		  
		  this.x = _x || 0;
		  this.y = _y || 0;
		  
		  this.dist = function(vector) {
		    var dx = this.x - vector.x;
		    var dy = this.y - vector.y;
		    return Math.sqrt(dx*dx + dy*dy);
		  };

		  this.minus = function(vector) {
		    return new lzgraphics.Vector(
		      this.x - vector.x,
		      this.y - vector.y);
		  };
		  
		  this.scale = function(scale) {
		    this.x *= scale;
		    this.y *= scale;
		  };
		  
		  this.apply = function(vector) {
		    this.x += vector.x;
		    this.y += vector.y;
		  };

		};


		lzgraphics.Node = function(_x, _y, _draw) {
		  
		  Node.radius = 8;
		  Node.hoverRadius = 50;
		  
		  this.pos = new lzgraphics.Vector(_x,_y);
		  this.home = new lzgraphics.Vector(_x,_y);
		  
		  var draw = _draw;
		  
		  this.isAttachedToCursor = false;
		  
		  var set = draw.set();
		  var hoverEl = draw.circle(Node.hoverRadius).attr({ fill: 'transparent' });
		  var dotEl = draw.circle(Node.radius);
		  set.add(hoverEl, dotEl);
		  set.center(this.pos.x, this.pos.y);
		  
		  this.distFromHome = function() {
		    return this.pos.dist(this.home);
		  };
		  
		  this.dist = function(node) {
		    return this.pos.dist(node.pos);
		  };
		  
		  this.attachStyle = function() {
		    dotEl.fill(afill).stroke(astroke);
		    this.isAttachedToCursor = true;
		  };
		  
		  this.detachStyle = function() {
		    dotEl.fill(dfill).stroke(dstroke);
		    this.isAttachedToCursor = false;
		  };
		  this.detachStyle();
		  
		  this.redraw = function() {
		    set.center(this.pos.x, this.pos.y);
		  };
		  
		};


		lzgraphics.Edge = function(_n1, _n2, _draw) {
		  var draw = _draw;
		  this.n1 = _n1;
		  this.n2 = _n2;
		  this.homeLength = this.n1.home.dist(this.n2.home);
		  var el = draw.line(this.n1.pos.x, this.n1.pos.y, this.n2.pos.x, this.n2.pos.y);
		  el.stroke({width: 1, color:afill});
		  
		  this.redraw = function() {
		    el.attr({
		      x1: this.n1.pos.x,
		      y1: this.n1.pos.y,
		      x2: this.n2.pos.x,
		      y2: this.n2.pos.y
		    });
		  };
		  
		  this.length = function() {
		    return this.n1.pos.dist(this.n2.pos);
		  };
		  
		};


		lzgraphics.Graph = function(elementOrId) {
		  
		  var draw = new SVG(elementOrId);
		  var edgeGroup = draw.group();
		  var nodeGroup = draw.group();
		  
		  this.nodes = [];
		  this.edges = [];
		  this.physics = new lzgraphics.Physics(this, draw);
		  var width, height;
		  
		  this.size = function(_width, _height) {
		    width = _width;
		    height = _height;
		    draw.size(_width, _height);
		    draw.parent.style.width = width + 'px';
		    draw.parent.style.height = height + 'px';
		  };
		  
		  this.clear = function() {
		    edgeGroup.clear();
		    nodeGroup.clear();
		    this.nodes = [];
		    this.edges = [];
		  };
		  
		  this.addNode = function(x, y) {
		    var n = new lzgraphics.Node(x, y, nodeGroup);
		    this.nodes.push(n);
		    return n;
		  };
		    
		  this.addEdge = function(n1, n2) {
		    var e = new lzgraphics.Edge(n1, n2, edgeGroup);
		    this.edges.push(e);
		    return e;
		  };
		  
		  this.redraw = function() {
		    for (var n in this.nodes) {
		      this.nodes[n].redraw();
		    }
		    for (var e in this.edges) {
		      this.edges[e].redraw();
		    }
		  };
		  
		  this.fromJSON = function(json) {
		    this.clear();
		    this.size(json.width, json.height);
		    var nodeObjs = {};
		    for (var n in json.nodes) {
		      var newNode = this.addNode(
		        json.nodes[n].x,
		        json.nodes[n].y
		        );
		      nodeObjs[n] = newNode;
		    }
		    for (var e in json.edges) {
		      this.addEdge(
		        nodeObjs[json.edges[e].n1],
		        nodeObjs[json.edges[e].n2]
		        );
		    }
		  };
		  
		};

		lzgraphics.Cursor = function(graphEl) {
		  
		  var self = this;
		  this.graphEl = $(graphEl);
		  this.pos = new lzgraphics.Vector(0, 0);
		  this.mouseDown = false;
		  this.mousePresent = false;
		  this.onmouseleave = null;
		  this.onmouseenter = null;
		  this.onmousemove = null;
		  
		  this.graphEl.on("mousemove", function(e) {
		    if (e.offsetX !== undefined) {
		      self.pos.x = e.offsetX;
		      self.pos.y = e.offsetY;
		      self.mousePresent = true;
		      if (self.onmousemove) { self.onmousemove(); }
		    }
		  });
		  
		  this.graphEl.on("mousedown ", function() {
		    self.mouseDown = true;
		  });
		  
		  this.graphEl.on("mouseup ", function() {
		    self.mouseDown = false;
		  });
		  
		  this.graphEl.on("mouseenter ", function() {
		    self.mousePresent = true;
		    if (self.onmouseenter) { self.onmouseenter(); }
		  });
		  
		  this.graphEl.on("mouseleave ", function() {
		    self.mouseDown = false;
		    self.mousePresent = false;
		    if (self.onmouseleave) { self.onmouseleave(); }
		  });

		};

		lzgraphics.Physics = function(_graph, _draw) {
		  
		  this.autoStart = true;
		  this.clickForce = 0.4;
		  this.hoverForce = 0.02;
		  this.homeForce = 0.25;
		  this.edgeForce = 0.2;
		  this.hoverDistance = 100;
		  this.clickDistance = 20;
		  this.timeTillStop = 1000;
		  
		  var self = this;
		  var graph = _graph;
		  var draw = _draw;
		  var cursor = new lzgraphics.Cursor(draw.parent);
		  
		  // Forces
		  this.applyCursorForce = function(node) {
		    if (cursor.mousePresent) {
		      var diff = cursor.pos.minus(node.pos);
		      var dist = cursor.pos.dist(node.pos);
		      if (cursor.mouseDown) {
		        if (node.isAttachedToCursor) {
		          diff.scale(this.clickForce);
		          node.pos.apply(diff);
		        }
		        else if (dist<this.hoverDistance) {
		          diff.scale(this.hoverForce);
		          node.pos.apply(diff);
		        }
		      }
		      else {
		        if (dist<this.clickDistance) {
		          node.attachStyle();
		        }
		        else {
		          node.detachStyle();
		        }
		        if (dist<this.hoverDistance) {
		          diff.scale(this.hoverForce);
		          node.pos.apply(diff);
		        }
		      }
		    }
		  };
		  
		  cursor.onmouseleave = function() {
		    for (var n in graph.nodes) {
		      graph.nodes[n].detachStyle();
		    }
		    if (self.autoStart) { self.stopIn(self.timeTillStop); }
		  };
		  
		  cursor.onmouseenter = function() {
		    if (self.autoStart) { self.start(); }
		  };
		  
		  cursor.onmousemove = function() {
		    if (self.autoStart) {
		      self.start();
		      self.stopIn(self.timeTillStop);
		    }
		  };
		  
		  this.applyHomeForce = function(node) {
		    var diff = node.home.minus(node.pos);
		    diff.scale(this.homeForce);
		    node.pos.apply(diff);
		  };
		  
		  this.applyEdgeForce = function(edge) {
		    var force = edge.n1.pos.minus(edge.n2.pos);
		    var length = edge.length();
		    var stretch = length - edge.homeLength;
		    
		// unitize and scale the force

		    force.scale( this.edgeForce * stretch / length);
		    edge.n2.pos.apply(force);
		    force.scale(-1);
		    edge.n1.pos.apply(force);
		  };
		  
		  // animation loop setup
		  var stepTime = 1000.0 / 30;
		  var running = false;
		  var animationTimer = null;
		  var stopTimer = null;
		  this.stop = function() {
		    running = false;
		    if (animationTimer) { clearTimeout(animationTimer); }
		    animationTimer = null;
		  };
		  this.start = function() {
		    if (running) { return; }
		    running = true;
		    if (animationTimer) { clearTimeout(animationTimer); }
		    if (stopTimer) { clearTimeout(stopTimer); }
		    animationTimer = setTimeout(nextStep, stepTime);
		  };
		  var nextStep = function() {
		    if (running) {
		      self.step();
		      animationTimer = setTimeout(nextStep, stepTime);
		    }
		  };
		  this.step = function() {
		    for (var n in graph.nodes) {
		      var node = graph.nodes[n];
		      this.applyCursorForce(node);
		      this.applyHomeForce(node);
		    }
		    for (var e in graph.edges) {
		      this.applyEdgeForce(graph.edges[e]);
		    }
		    graph.redraw();
		  };
		  this.stopIn = function(msec) {
		    if (!running) { return; }
		    if (stopTimer) { clearTimeout(stopTimer); }
		    stopTimer = setTimeout(self.stop, msec);
		  };
		  
		};