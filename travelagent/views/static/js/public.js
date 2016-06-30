$(document).ready(function() {
	// 收缩侧边导航
	$("#openNav .extendBtn").on("click",function() {
		$("#openNav").hide();
		$("#closeNav").show();
		return false;
	});

	$("#closeNav .extendBtn").on("click",function() {
		$("#closeNav").hide();
		$("#openNav").show();
		return false;
	});

	// 侧边导航下拉
	$("#openNav > ul > li > a").on("click",function() {
		if ($(this).parent().hasClass("open")) {
			$(this).next().hide();
			$(this).parent().removeClass("open");
		} else {
			$(this).next().show();
			$(this).parent().addClass("open");
		}
		return false;
	});

	// input date（请根据需要在各个页面自行修改）
	$(".Wdate").on("focus",function() {
		WdatePicker({isShowClear:false,readOnly:true});
	});

	// tab选项卡
	$(".tabNav li").on("click",function() {
		$(".tabNav .active").removeClass("active");
		$(".tabContent .active").removeClass("active");
		$(this).addClass("active");
		$(".tabContent div").eq($(this).index()).addClass("active");
	});

	// 表格全选
	$("tr th input:checkbox").on("change",function() {
		var index = $(this).index();
		var td = $(this).parents("table").find("tr td").eq(index).children("input");
		if ($(this).is(":checked")) {
			td.prop("checked",true);
		} else {
			td.prop("checked",false);
		}
	});
	
	
	//提示聚焦清除
	$("#addPopups .pBox input[type=text]").each(function(){//聚焦是清除
		$(this).focus(function(){
			 $(this).parent().find("em").css("visibility","hidden");
		});
	 });
	$("#addPopups .pBox select").each(function(){//聚焦是清除
		$(this).focus(function(){
			 $(this).parent().find("em").css("visibility","hidden");
		});
	 });
	
	//close 
   $(document).on('click',"#promptBox >span.op,#promptBox > .btn .cancel_but",function(){
	   $(".ui-widget-overlay").addClass('hide');
	   $("#promptBox").addClass('hide');
   })
	
	
});

/**
 * 弹窗功能模块
 * @param {obj} obj 弹窗对象
 */
function PopUps(obj) {
	this.init(obj);
}

$.extend(PopUps.prototype, {
	init : function(obj) {
		this.obj = $(obj);
		this.show();
	},
	// 显示弹窗
	show : function() {
		$(".shadow").show();
		this.obj.show();
		this.obj.css({"margin-top": - this.obj.height()/2 + "px", "margin-left": - this.obj.width()/2 + "px"});
		this.move();
		this.close();
	},
	// 隐藏弹窗
	hide : function() {
		$(".shadow").hide();
		this.obj.hide();
	},
	// 弹窗拖拽
	move : function() {
		var that = this;
			console.log($(this.obj));

		$(this.obj.find("h3")).mousedown(function(e) {
			var oldLeft = $(that.obj).offset().left,
				oldTop = $(that.obj).offset().top,
				width = e.pageX - oldLeft,
				height = e.pageY - oldTop;

			$(document).mousemove(function(e) {
				var left = e.pageX + $(document).scrollLeft() - width,
					top = e.pageY + $(document).scrollTop() - height;

				// 控制弹窗在窗口可视范围内
				if (left < 0) {
					left = 0;
				}

				if (left > $(window).width() - $(that.obj).width()) {
					left = $(window).width() - $(that.obj).width();
				}

				if (top < 0) {
					top = 0;
				}

				if (top > $(window).height() - $(that.obj).height()) {
					top = $(window).height() - $(that.obj).height();
				}

				$(that.obj).offset({top : top, left : left});
				return false;
			});

			$(document).mouseup(function() {
				$(document).off("mousemove");
				$(document).off("mouseup");
				return false;
			});
		});
	},
	// 点击关闭弹窗
	close : function() {
		var that = this;

		this.obj.find("h3 .close").on("click",function() {
			that.hide();
		});
		
		this.obj.find(".btnBox2 .close").on("click",function() {
			that.hide();
		});
		
		this.obj.find(".btnBox .close").on("click",function() {
			that.hide();
		});
	}
	
	

});

//2016-05-09 ->09/05/2016
function createDate(time){
	var date = time.substr(0,10);
	var year = date.split('-');
	date = year[2]+'/'+year[1]+'/'+year[0];
	return date;
}

//09/05/2016 ->2016-05-09
function createTime(time){
	var date = time.split('/');
	date = date[2]+'-'+date[1]+'-'+date[0];
	return date;
}

//2016/05/09 ->2016-05-09
function createTimeSecond(time){
	var date = time.split('/');
	date = date[0]+'-'+date[1]+'-'+date[2];
	return date;
}

//09/05/2016 12:12:23
function createDate(time){
	var date = time.substr(0,10);
	var year = date.split('-');
	date = year[2]+'/'+year[1]+'/'+year[0]+' '+time.substr(11,8);
	return date;
}

//封装alert
function Alert(info){
	$(".ui-widget-overlay").remove();
	 $("#promptBox").remove();
	 var str = "<div class='ui-widget-overlay ui-front'></div>";
	 var str_con = '<div id="promptBox" class="pop-ups write ui-dialog" >';
		str_con += '<h3>Prompt</h3>';
		str_con += '<span class="op"><a class="close r"></a></span>';
		str_con += '<p>'+info+'</p>';
		str_con += '<p class="btn">';
		str_con += '<input type="button" class="cancel_but" value="OK"></input>';
		str_con += '</p></div>';
		
	 //$("#promptBox").before(str); 
	 $(document.body).append(str);
	 $(document.body).append(str_con);
}


