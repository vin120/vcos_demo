
$(document).ready(function() {
	var org_data = '';
	$.ajax({
	    url:org_add_ajax_url,
	    type:'get',
	    async:false,
	 	dataType:'text',
		success:function(data){
			if(data!=0){
				org_data = $.parseJSON(data);
				setLinkageSelValue(org_data);
			}
		}      
	});
//	var data = org_data ;
	/*
	var data = {
			
		1 : {
			name : "泰山邮轮公司",
			cell : {
				10 : {
					name : "泰山邮轮1号",
					cell : {
						100 : { 
							name : "行政部" ,
							cell:{
								1001:{
									name:"1001"
								}
							}
						},
						101 : { name : "管理部" }
					}
				},
				11 : { name : "泰山邮轮1号" },
				12 : { name : "泰山邮轮1号" }
			}
		},
		2 : {
			name:"aaaaaaaaa",
		}
	};*/
	
	
	
	
});

function setLinkageSelValue(data)
{
	var opts = {
		data: data,
		select: '#selectDpm'
	};

	var linkageSel = new LinkageSel(opts);

	// 获取选中值
	$("#save").click( function(){
    	console.log(linkageSel.getSelectedValue());
    })
	
}