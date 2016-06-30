$(document).ready(function() {
	var p=$("#p").val();
	var datacount=$("#datacount").val();
	if(p==0){
	var total=Math.ceil(datacount/2);
	if (total==0){
		total=1;
	}
	  var pagefirst=$("#pagefirst").val();
	  var pagelast=$("#pagelast").val();
	$('#member_page_div').jqPaginator({
		    totalPages: total,
		    visiblePages: 5,
		    currentPage: 1,
		    wrapper:'<ul class="pagination"></ul>',
		    first: '<li class="first"><a href="javascript:void(0);">'+pagefirst+'</a></li>',
		    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
		    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
		    last: '<li class="last"><a href="javascript:void(0);">'+pagelast+'</a></li>',
		    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
		    onPageChange: function (num, type) {
		    	var this_page = $("input#pag").val();
		    	var url=$("#page_url").val();
		    	var p=$("#p").val();
		    	if(p==1){
		    	var full_name=$("input[name=full_name]").val();
		    	var passport_num=$("input[name=passport_num]").val();
		    	}
		    	else{
		    		var full_name='';
		    		var passport_num='';
			    	}
		    	if(this_page==num){$("input#pag").val('fail');return false;}
		    	$.ajax({
	                url:url,
	                type:'POST',
	                data:{pag:num,full_name:full_name,passport_num:passport_num},
	             	dataType:'json',
	            	success:function(data){
	            		var baseurl=$("#baseurl").val();
	                	var str = '';
	            		if(data != 0){
	            			var tmp = "{{each member}}";
	            				tmp+="<tr>";
	            				tmp+="<td>{{$index+1}}</td>";
	            				tmp+="<td>{{$value.full_name}}</td>";
	            				tmp+="<td>{{$value.gender}}</td>";
	            				tmp+="<td>{{$value.birthday}}</td>";
	            				tmp+="<td>{{$value.passport_num}}</td>";
	            				tmp+="<td>{{$value.date_expire}}</td>";
	            				tmp+="<td>{{$value.email}}</td>";
	            				tmp+="<td>{{$value.phone}}</td>";
	            				tmp+= "<td><button class='btn1'><img src='"+baseurl+"images/write.png'></button>";
	            				tmp+= "<button class='btn2'><img src='"+baseurl+"images/delete.png'></button></td>";
	            				tmp+="</tr>";
	            				tmp+="{{/each}}";
								var render = template.compile(tmp);
								var html = render({member:data});
			    	         	$("table#member_page_table > tbody").html(html);
				    	        }
			            		else{
			            		$("table#member_page_table > tbody").html("");
			            		}
	            	}      
	            });
	    	}
		
		});
		}
		 $("#searchmember").click(function(){
				var this_page = $("input#pag").val();
		    	var url=$("#serchurl").val();
		    	$("#p").val('1');
		    	var full_name=$("input[name=full_name]").val();
		    	var passport_num=$("input[name=passport_num]").val();
		    	if(this_page==1){$("input#pag").val('fail');return false;}
		    	$.ajax({
	                url:url,
	                type:'POST',
	                data:{pag:1,full_name:full_name,passport_num:passport_num},
	             	dataType:'json',
	            	success:function(data){
	            		var baseurl=$("#baseurl").val();
	            		$("#datacount").val(data.length);
	            		if(data != 0){
	            			var tmp = "{{each member}}";
	            			var t="{{$index}}";
	            			if(t<2){
            				tmp+="<tr>";
            				tmp+="<td>{{$index+1}}</td>";
            				tmp+="<td>{{$value.full_name}}</td>";
            				tmp+="<td>{{$value.gender}}</td>";
            				tmp+="<td>{{$value.birthday}}</td>";
            				tmp+="<td>{{$value.passport_num}}</td>";
            				tmp+="<td>{{$value.date_expire}}</td>";
            				tmp+="<td>{{$value.email}}</td>";
            				tmp+="<td>{{$value.phone}}</td>";
            				tmp+= "<td><button class='btn1'><img src='"+baseurl+"images/write.png'></button>";
            				tmp+= "<button class='btn2'><img src='"+baseurl+"images/delete.png'></button></td>";
            				tmp+="</tr>";
	            			}
            				tmp+="{{/each}}";
	    	            	
		            		var render = template.compile(tmp);
		    				var html = render({member:data});
		    	         	$("table#member_page_table > tbody").html(html);
		            		}
		            		else{
		            		$("table#member_page_table > tbody").html("");
		            		}
	            		
	            		var datacount=$("#datacount").val();
	            		var total=Math.ceil(datacount/2);
	            		if (total==0){
	            			total=1;
	            		}
	            		  var pagefirst=$("#pagefirst").val();
	            		  var pagelast=$("#pagelast").val();
	            			$('#member_page_div').jqPaginator({
	            			    totalPages: total,
	            			    visiblePages: 5,
	            			    currentPage: 1,
	            			    wrapper:'<ul class="pagination"></ul>',
	            			    first: '<li class="first"><a href="javascript:void(0);">'+pagefirst+'</a></li>',
	            			    prev: '<li class="prev"><a href="javascript:void(0);">«</a></li>',
	            			    next: '<li class="next"><a href="javascript:void(0);">»</a></li>',
	            			    last: '<li class="last"><a href="javascript:void(0);">'+pagelast+'</a></li>',
	            			    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
	            			    onPageChange: function (num, type) {
	            			    	var this_page = $("input#pag").val();
	            			    	var url=$("#page_url").val();
	            			    	var p=$("#p").val();
	            			    	if(p==1){
	            			    	var full_name=$("input[name=full_name]").val();
	            			    	var passport_num=$("input[name=passport_num]").val();
	            			    	}
	            			    	else{
	            			    		var full_name='';
	            			    		var passport_num='';
	            				    	}
	            			    	if(this_page==num){$("input#pag").val('fail');return false;}
	            			    	$.ajax({
	            		                url:url,
	            		                type:'POST',
	            		                data:{pag:num,full_name:full_name,passport_num:passport_num},
	            		             	dataType:'json',
	            		            	success:function(data){
	            		            		var baseurl=$("#baseurl").val();
	            		                	var str = '';
	            		            		if(data != 0){
	            		            			var tmp = "{{each member}}";
	            	            				tmp+="<tr>";
	            	            				tmp+="<td>{{$index+1}}</td>";
	            	            				tmp+="<td>{{$value.full_name}}</td>";
	            	            				tmp+="<td>{{$value.gender}}</td>";
	            	            				tmp+="<td>{{$value.birthday}}</td>";
	            	            				tmp+="<td>{{$value.passport_num}}</td>";
	            	            				tmp+="<td>{{$value.date_expire}}</td>";
	            	            				tmp+="<td>{{$value.email}}</td>";
	            	            				tmp+="<td>{{$value.phone}}</td>";
	            	            				tmp+= "<td><button class='btn1'><img src='"+baseurl+"images/write.png'></button>";
	            	            				tmp+= "<button class='btn2'><img src='"+baseurl+"images/delete.png'></button></td>";
	            	            				tmp+="</tr>";
	            	            				tmp+="{{/each}}";
				            					var render = template.compile(tmp);
				            					var html = render({member:data});
				                	         	$("table#member_page_table > tbody").html(html);
	            		            		 	}
		            		            		else{
		            		            		$("table#member_page_table > tbody").html("");	
		            		            		}
	            		    	             
	            		            	}      
	            		            });
	            		    	}
	            			
	            			});
	            		
	            	}      
	            });
		 });
});
