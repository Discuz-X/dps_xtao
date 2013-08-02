
// JavaScript Document
var net = new Object();
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;
net.ContentLoader = function(url, onload, method, params, onerror, contentType) {
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror : this.defaultError;
	this.loadXMLDoc(url, method, params, contentType);
}
net.ContentLoader.prototype = {
	onReadyState: function() {
		var req = this.req, ready = req.readyState;
		if(ready == net.READY_STATE_COMPLETE) {
			var httpStatus = req.status;
			if(httpStatus == 200 || httpStatus == 0) this.onload.call(this);
			else this.onerror.call(this);
		}
	},
	defaultError: function() {
		//alert("error in fetching data!! readyState==" + this.req.readyState + "\n\nstatus=" + this.req.status + " \n\nheaders" + this.req.getAllResponseHeaders());
	}
}
net.ContentLoader.prototype.loadXMLDoc = function(url, method, params, contentType) {
	if(!method) {method = "GET";}//如果没有传入method 参数值，则默认为GET
	if(!contentType && method == "POST") {
		contentType = "application/x-www-form-urlencoded;";
	}
	if(window.XMLHttpRequest) {
		this.req = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		this.req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(this.req) {
		try {
			var loader = this;
			this.req.onreadystatechange = function() {
				loader.onReadyState.call(loader);
			}
			this.req.open(method, url, true);
			//POST方法需要设置的属性
			if(contentType) {
				this.req.setRequestHeader("Content-Type", contentType);
			}
			this.req.send(params);
		} catch(err) {
			this.onerror.call(this);
		}
	}
}