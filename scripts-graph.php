(function(e,t){"use strict";var n=e.History=e.History||{},r=e.jQuery;if(typeof n.Adapter!="undefined")throw new Error("History.js Adapter has already been loaded...");n.Adapter={bind:function(e,t,n){r(e).bind(t,n)},trigger:function(e,t,n){r(e).trigger(t,n)},extractEventData:function(e,n,r){var i=n&&n.originalEvent&&n.originalEvent[e]||r&&r[e]||t;return i},onDomLoad:function(e){r(e)}},typeof n.init!="undefined"&&n.init()})(window),function(e,t){"use strict";var n=e.console||t,r=e.document,i=e.navigator,s=e.sessionStorage||!1,o=e.setTimeout,u=e.clearTimeout,a=e.setInterval,f=e.clearInterval,l=e.JSON,c=e.alert,h=e.History=e.History||{},p=e.history;try{s.setItem("TEST","1"),s.removeItem("TEST")}catch(d){s=!1}l.stringify=l.stringify||l.encode,l.parse=l.parse||l.decode;if(typeof h.init!="undefined")throw new Error("History.js Core has already been loaded...");h.init=function(e){return typeof h.Adapter=="undefined"?!1:(typeof h.initCore!="undefined"&&h.initCore(),typeof h.initHtml4!="undefined"&&h.initHtml4(),!0)},h.initCore=function(d){if(typeof h.initCore.initialized!="undefined")return!1;h.initCore.initialized=!0,h.options=h.options||{},h.options.hashChangeInterval=h.options.hashChangeInterval||100,h.options.safariPollInterval=h.options.safariPollInterval||500,h.options.doubleCheckInterval=h.options.doubleCheckInterval||500,h.options.disableSuid=h.options.disableSuid||!1,h.options.storeInterval=h.options.storeInterval||1e3,h.options.busyDelay=h.options.busyDelay||250,h.options.debug=h.options.debug||!1,h.options.initialTitle=h.options.initialTitle||r.title,h.options.html4Mode=h.options.html4Mode||!1,h.options.delayInit=h.options.delayInit||!1,h.intervalList=[],h.clearAllIntervals=function(){var e,t=h.intervalList;if(typeof t!="undefined"&&t!==null){for(e=0;e<t.length;e++)f(t[e]);h.intervalList=null}},h.debug=function(){(h.options.debug||!1)&&h.log.apply(h,arguments)},h.log=function(){var e=typeof n!="undefined"&&typeof n.log!="undefined"&&typeof n.log.apply!="undefined",t=r.getElementById("log"),i,s,o,u,a;e?(u=Array.prototype.slice.call(arguments),i=u.shift(),typeof n.debug!="undefined"?n.debug.apply(n,[i,u]):n.log.apply(n,[i,u])):i="\n"+arguments[0]+"\n";for(s=1,o=arguments.length;s<o;++s){a=arguments[s];if(typeof a=="object"&&typeof l!="undefined")try{a=l.stringify(a)}catch(f){}i+="\n"+a+"\n"}return t?(t.value+=i+"\n-----\n",t.scrollTop=t.scrollHeight-t.clientHeight):e||c(i),!0},h.getInternetExplorerMajorVersion=function(){var e=h.getInternetExplorerMajorVersion.cached=typeof h.getInternetExplorerMajorVersion.cached!="undefined"?h.getInternetExplorerMajorVersion.cached:function(){var e=3,t=r.createElement("div"),n=t.getElementsByTagName("i");while((t.innerHTML="<!--[if gt IE "+ ++e+"]><i></i><![endif]-->")&&n[0]);return e>4?e:!1}();return e},h.isInternetExplorer=function(){var e=h.isInternetExplorer.cached=typeof h.isInternetExplorer.cached!="undefined"?h.isInternetExplorer.cached:Boolean(h.getInternetExplorerMajorVersion());return e},h.options.html4Mode?h.emulated={pushState:!0,hashChange:!0}:h.emulated={pushState:!Boolean(e.history&&e.history.pushState&&e.history.replaceState&&!/ Mobile\/([1-7][a-z]|(8([abcde]|f(1[0-8]))))/i.test(i.userAgent)&&!/AppleWebKit\/5([0-2]|3[0-2])/i.test(i.userAgent)),hashChange:Boolean(!("onhashchange"in e||"onhashchange"in r)||h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8)},h.enabled=!h.emulated.pushState,h.bugs={setHash:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),safariPoll:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),ieDoubleCheck:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8),hashEscape:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<7)},h.isEmptyObject=function(e){for(var t in e)if(e.hasOwnProperty(t))return!1;return!0},h.cloneObject=function(e){var t,n;return e?(t=l.stringify(e),n=l.parse(t)):n={},n},h.getRootUrl=function(){var e=r.location.protocol+"//"+(r.location.hostname||r.location.host);if(r.location.port||!1)e+=":"+r.location.port;return e+="/",e},h.getBaseHref=function(){var e=r.getElementsByTagName("base"),t=null,n="";return e.length===1&&(t=e[0],n=t.href.replace(/[^\/]+$/,"")),n=n.replace(/\/+$/,""),n&&(n+="/"),n},h.getBaseUrl=function(){var e=h.getBaseHref()||h.getBasePageUrl()||h.getRootUrl();return e},h.getPageUrl=function(){var e=h.getState(!1,!1),t=(e||{}).url||h.getLocationHref(),n;return n=t.replace(/\/+$/,"").replace(/[^\/]+$/,function(e,t,n){return/\./.test(e)?e:e+"/"}),n},h.getBasePageUrl=function(){var e=h.getLocationHref().replace(/[#\?].*/,"").replace(/[^\/]+$/,function(e,t,n){return/[^\/]$/.test(e)?"":e}).replace(/\/+$/,"")+"/";return e},h.getFullUrl=function(e,t){var n=e,r=e.substring(0,1);return t=typeof t=="undefined"?!0:t,/[a-z]+\:\/\//.test(e)||(r==="/"?n=h.getRootUrl()+e.replace(/^\/+/,""):r==="#"?n=h.getPageUrl().replace(/#.*/,"")+e:r==="?"?n=h.getPageUrl().replace(/[\?#].*/,"")+e:t?n=h.getBaseUrl()+e.replace(/^(\.\/)+/,""):n=h.getBasePageUrl()+e.replace(/^(\.\/)+/,"")),n.replace(/\#$/,"")},h.getShortUrl=function(e){var t=e,n=h.getBaseUrl(),r=h.getRootUrl();return h.emulated.pushState&&(t=t.replace(n,"")),t=t.replace(r,"/"),h.isTraditionalAnchor(t)&&(t="./"+t),t=t.replace(/^(\.\/)+/g,"./").replace(/\#$/,""),t},h.getLocationHref=function(e){return e=e||r,e.URL===e.location.href?e.location.href:e.location.href===decodeURIComponent(e.URL)?e.URL:e.location.hash&&decodeURIComponent(e.location.href.replace(/^[^#]+/,""))===e.location.hash?e.location.href:e.URL.indexOf("#")==-1&&e.location.href.indexOf("#")!=-1?e.location.href:e.URL||e.location.href},h.store={},h.idToState=h.idToState||{},h.stateToId=h.stateToId||{},h.urlToId=h.urlToId||{},h.storedStates=h.storedStates||[],h.savedStates=h.savedStates||[],h.normalizeStore=function(){h.store.idToState=h.store.idToState||{},h.store.urlToId=h.store.urlToId||{},h.store.stateToId=h.store.stateToId||{}},h.getState=function(e,t){typeof e=="undefined"&&(e=!0),typeof t=="undefined"&&(t=!0);var n=h.getLastSavedState();return!n&&t&&(n=h.createStateObject()),e&&(n=h.cloneObject(n),n.url=n.cleanUrl||n.url),n},h.getIdByState=function(e){var t=h.extractId(e.url),n;if(!t){n=h.getStateString(e);if(typeof h.stateToId[n]!="undefined")t=h.stateToId[n];else if(typeof h.store.stateToId[n]!="undefined")t=h.store.stateToId[n];else{for(;;){t=(new Date).getTime()+String(Math.random()).replace(/\D/g,"");if(typeof h.idToState[t]=="undefined"&&typeof h.store.idToState[t]=="undefined")break}h.stateToId[n]=t,h.idToState[t]=e}}return t},h.normalizeState=function(e){var t,n;if(!e||typeof e!="object")e={};if(typeof e.normalized!="undefined")return e;if(!e.data||typeof e.data!="object")e.data={};return t={},t.normalized=!0,t.title=e.title||"",t.url=h.getFullUrl(e.url?e.url:h.getLocationHref()),t.hash=h.getShortUrl(t.url),t.data=h.cloneObject(e.data),t.id=h.getIdByState(t),t.cleanUrl=t.url.replace(/\??\&_suid.*/,""),t.url=t.cleanUrl,n=!h.isEmptyObject(t.data),(t.title||n)&&h.options.disableSuid!==!0&&(t.hash=h.getShortUrl(t.url).replace(/\??\&_suid.*/,""),/\?/.test(t.hash)||(t.hash+="?"),t.hash+="&_suid="+t.id),t.hashedUrl=h.getFullUrl(t.hash),(h.emulated.pushState||h.bugs.safariPoll)&&h.hasUrlDuplicate(t)&&(t.url=t.hashedUrl),t},h.createStateObject=function(e,t,n){var r={data:e,title:t,url:n};return r=h.normalizeState(r),r},h.getStateById=function(e){e=String(e);var n=h.idToState[e]||h.store.idToState[e]||t;return n},h.getStateString=function(e){var t,n,r;return t=h.normalizeState(e),n={data:t.data,title:e.title,url:e.url},r=l.stringify(n),r},h.getStateId=function(e){var t,n;return t=h.normalizeState(e),n=t.id,n},h.getHashByState=function(e){var t,n;return t=h.normalizeState(e),n=t.hash,n},h.extractId=function(e){var t,n,r,i;return e.indexOf("#")!=-1?i=e.split("#")[0]:i=e,n=/(.*)\&_suid=([0-9]+)$/.exec(i),r=n?n[1]||e:e,t=n?String(n[2]||""):"",t||!1},h.isTraditionalAnchor=function(e){var t=!/[\/\?\.]/.test(e);return t},h.extractState=function(e,t){var n=null,r,i;return t=t||!1,r=h.extractId(e),r&&(n=h.getStateById(r)),n||(i=h.getFullUrl(e),r=h.getIdByUrl(i)||!1,r&&(n=h.getStateById(r)),!n&&t&&!h.isTraditionalAnchor(e)&&(n=h.createStateObject(null,null,i))),n},h.getIdByUrl=function(e){var n=h.urlToId[e]||h.store.urlToId[e]||t;return n},h.getLastSavedState=function(){return h.savedStates[h.savedStates.length-1]||t},h.getLastStoredState=function(){return h.storedStates[h.storedStates.length-1]||t},h.hasUrlDuplicate=function(e){var t=!1,n;return n=h.extractState(e.url),t=n&&n.id!==e.id,t},h.storeState=function(e){return h.urlToId[e.url]=e.id,h.storedStates.push(h.cloneObject(e)),e},h.isLastSavedState=function(e){var t=!1,n,r,i;return h.savedStates.length&&(n=e.id,r=h.getLastSavedState(),i=r.id,t=n===i),t},h.saveState=function(e){return h.isLastSavedState(e)?!1:(h.savedStates.push(h.cloneObject(e)),!0)},h.getStateByIndex=function(e){var t=null;return typeof e=="undefined"?t=h.savedStates[h.savedStates.length-1]:e<0?t=h.savedStates[h.savedStates.length+e]:t=h.savedStates[e],t},h.getCurrentIndex=function(){var e=null;return h.savedStates.length<1?e=0:e=h.savedStates.length-1,e},h.getHash=function(e){var t=h.getLocationHref(e),n;return n=h.getHashByUrl(t),n},h.unescapeHash=function(e){var t=h.normalizeHash(e);return t=decodeURIComponent(t),t},h.normalizeHash=function(e){var t=e.replace(/[^#]*#/,"").replace(/#.*/,"");return t},h.setHash=function(e,t){var n,i;return t!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.setHash,args:arguments,queue:t}),!1):(h.busy(!0),n=h.extractState(e,!0),n&&!h.emulated.pushState?h.pushState(n.data,n.title,n.url,!1):h.getHash()!==e&&(h.bugs.setHash?(i=h.getPageUrl(),h.pushState(null,null,i+"#"+e,!1)):r.location.hash=e),h)},h.escapeHash=function(t){var n=h.normalizeHash(t);return n=e.encodeURIComponent(n),h.bugs.hashEscape||(n=n.replace(/\%21/g,"!").replace(/\%26/g,"&").replace(/\%3D/g,"=").replace(/\%3F/g,"?")),n},h.getHashByUrl=function(e){var t=String(e).replace(/([^#]*)#?([^#]*)#?(.*)/,"$2");return t=h.unescapeHash(t),t},h.setTitle=function(e){var t=e.title,n;t||(n=h.getStateByIndex(0),n&&n.url===e.url&&(t=n.title||h.options.initialTitle));try{r.getElementsByTagName("title")[0].innerHTML=t.replace("<","&lt;").replace(">","&gt;").replace(" & "," &amp; ")}catch(i){}return r.title=t,h},h.queues=[],h.busy=function(e){typeof e!="undefined"?h.busy.flag=e:typeof h.busy.flag=="undefined"&&(h.busy.flag=!1);if(!h.busy.flag){u(h.busy.timeout);var t=function(){var e,n,r;if(h.busy.flag)return;for(e=h.queues.length-1;e>=0;--e){n=h.queues[e];if(n.length===0)continue;r=n.shift(),h.fireQueueItem(r),h.busy.timeout=o(t,h.options.busyDelay)}};h.busy.timeout=o(t,h.options.busyDelay)}return h.busy.flag},h.busy.flag=!1,h.fireQueueItem=function(e){return e.callback.apply(e.scope||h,e.args||[])},h.pushQueue=function(e){return h.queues[e.queue||0]=h.queues[e.queue||0]||[],h.queues[e.queue||0].push(e),h},h.queue=function(e,t){return typeof e=="function"&&(e={callback:e}),typeof t!="undefined"&&(e.queue=t),h.busy()?h.pushQueue(e):h.fireQueueItem(e),h},h.clearQueue=function(){return h.busy.flag=!1,h.queues=[],h},h.stateChanged=!1,h.doubleChecker=!1,h.doubleCheckComplete=function(){return h.stateChanged=!0,h.doubleCheckClear(),h},h.doubleCheckClear=function(){return h.doubleChecker&&(u(h.doubleChecker),h.doubleChecker=!1),h},h.doubleCheck=function(e){return h.stateChanged=!1,h.doubleCheckClear(),h.bugs.ieDoubleCheck&&(h.doubleChecker=o(function(){return h.doubleCheckClear(),h.stateChanged||e(),!0},h.options.doubleCheckInterval)),h},h.safariStatePoll=function(){var t=h.extractState(h.getLocationHref()),n;if(!h.isLastSavedState(t))return n=t,n||(n=h.createStateObject()),h.Adapter.trigger(e,"popstate"),h;return},h.back=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.back,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.back(!1)}),p.go(-1),!0)},h.forward=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.forward,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.forward(!1)}),p.go(1),!0)},h.go=function(e,t){var n;if(e>0)for(n=1;n<=e;++n)h.forward(t);else{if(!(e<0))throw new Error("History.go: History.go requires a positive or negative integer passed.");for(n=-1;n>=e;--n)h.back(t)}return h};if(h.emulated.pushState){var v=function(){};h.pushState=h.pushState||v,h.replaceState=h.replaceState||v}else h.onPopState=function(t,n){var r=!1,i=!1,s,o;return h.doubleCheckComplete(),s=h.getHash(),s?(o=h.extractState(s||h.getLocationHref(),!0),o?h.replaceState(o.data,o.title,o.url,!1):(h.Adapter.trigger(e,"anchorchange"),h.busy(!1)),h.expectedStateId=!1,!1):(r=h.Adapter.extractEventData("state",t,n)||!1,r?i=h.getStateById(r):h.expectedStateId?i=h.getStateById(h.expectedStateId):i=h.extractState(h.getLocationHref()),i||(i=h.createStateObject(null,null,h.getLocationHref())),h.expectedStateId=!1,h.isLastSavedState(i)?(h.busy(!1),!1):(h.storeState(i),h.saveState(i),h.setTitle(i),h.Adapter.trigger(e,"statechange"),h.busy(!1),!0))},h.Adapter.bind(e,"popstate",h.onPopState),h.pushState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.pushState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.pushState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0},h.replaceState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.replaceState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.replaceState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0};if(s){try{h.store=l.parse(s.getItem("History.store"))||{}}catch(m){h.store={}}h.normalizeStore()}else h.store={},h.normalizeStore();h.Adapter.bind(e,"unload",h.clearAllIntervals),h.saveState(h.storeState(h.extractState(h.getLocationHref(),!0))),s&&(h.onUnload=function(){var e,t,n;try{e=l.parse(s.getItem("History.store"))||{}}catch(r){e={}}e.idToState=e.idToState||{},e.urlToId=e.urlToId||{},e.stateToId=e.stateToId||{};for(t in h.idToState){if(!h.idToState.hasOwnProperty(t))continue;e.idToState[t]=h.idToState[t]}for(t in h.urlToId){if(!h.urlToId.hasOwnProperty(t))continue;e.urlToId[t]=h.urlToId[t]}for(t in h.stateToId){if(!h.stateToId.hasOwnProperty(t))continue;e.stateToId[t]=h.stateToId[t]}h.store=e,h.normalizeStore(),n=l.stringify(e);try{s.setItem("History.store",n)}catch(i){if(i.code!==DOMException.QUOTA_EXCEEDED_ERR)throw i;s.length&&(s.removeItem("History.store"),s.setItem("History.store",n))}},h.intervalList.push(a(h.onUnload,h.options.storeInterval)),h.Adapter.bind(e,"beforeunload",h.onUnload),h.Adapter.bind(e,"unload",h.onUnload));if(!h.emulated.pushState){h.bugs.safariPoll&&h.intervalList.push(a(h.safariStatePoll,h.options.safariPollInterval));if(i.vendor==="Apple Computer, Inc."||(i.appCodeName||"")==="Mozilla")h.Adapter.bind(e,"hashchange",function(){h.Adapter.trigger(e,"popstate")}),h.getHash()&&h.Adapter.onDomLoad(function(){h.Adapter.trigger(e,"hashchange")})}},(!h.options||!h.options.delayInit)&&h.init()}(window)
	/*

	Author: Juan Josè Albàn, based in the work of Braden Kowitz
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

		//*************************************************************************************************//

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