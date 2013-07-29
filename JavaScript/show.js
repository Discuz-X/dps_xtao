/*
 参数
 parent			放置瀑布流元素的容器，默认为 $("waterfall")
 container		放置瀑布流的父容器，默认为 $("threadlist")
 maxcolumn		最多多少列，默认为 0 不限制
 space			图片间距，默认为 10
 index			从第几张开始排列，默认为 0
 tag			瀑布流元素的 tagName，默认为 li
 columnsheight	存放列高度的数组

 返回值
 index			当前瀑布流已经排列了多少个图片
 totalwidth		当前瀑布流的总宽度
 totalheight	当前瀑布流的总高度
 columnsheight	存放瀑布流列高的数组
 */
function recadd(tid) {
	$('recommendv_add_' + tid).innerHTML = parseInt($('recommendv_add_' + tid).innerHTML) + 1;
}
function recsubtract(tid) {
	$('recommendv_subtract_' + tid).innerHTML = parseInt($('recommendv_subtract_' + tid).innerHTML) + 1;
}
function showDiv(divID) {
	if(divID != null && divID != "") {
		var v = document.getElementById(divID);
		if(v.style.display == "none") {
			v.style.display = "inline";
		}
	}
}

function hiddenDiv(divID) {
	if(divID != null && divID != "") {
		var vv = document.getElementById(divID);
		if(vv.style.display == "inline") {
			vv.style.display = "none";
		}
	}
}
