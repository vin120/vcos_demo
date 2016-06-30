$(document).ready(function() {
	$("select[name=voyage_id]").change(function(){
		var voyage_id=$(this).val();
		var voyageurl=$("#voyageurl").val();
		  $.ajax({
			  url:voyageurl,
			  type:'POST',
			  data:{voyage_id:voyage_id},
			  dataType:'json',
			  success:function(data){
				  if(data!=0){
					 var json = eval(data); //数组 
		             $("select[name=type_code]").empty(); 
		             $("select[name=type_code]").append($("<option/>").text("All").attr("value",""));
		             $.each(json, function (index, item) { 
		            	 $("select[name=type_code]").append($("<option/>").text(json[index].type_name).attr("value",json[index].type_code));
		             });
				  }
				  else{
					  $("select[name=type_code]").empty(); 
					  $("select[name=type_code]").append($("<option/>").text("NO").attr("value",""));
				  }
			  } 
		  });
	});//航线改变，对应的选择房间
	$("#search").click(function(){
		var counturl=$("#counturl").val();
		var voyage_id=$("select[name=voyage_id]").val();
		var type_code=$("select[name=type_code]").val();
		  $.ajax({
			  url:counturl,
			  type:'POST',
			  data:{voyage_id:voyage_id,type_code:type_code},
			  dataType:'json',
			  success:function(d){
				$("#count").html(d);
				if(d!=0){
					var total = parseInt(Math.ceil(d/2));
					if(total==0){
						total=1;
						}
	            	  var pagefirst=$("#pagefirst").val();
	            	  var pagelast=$("#pagelast").val();
	            	  $('#remaining_page_div').jqPaginator({
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
	            			  var pageurl=$("#pageurl").val();
	            			  var voyage_id=$("select[name=voyage_id]").val();
	            			  var type_code=$("select[name=type_code]").val();
	            		
	            			  if(this_page==num){$("input#pag").val('fail');return false;}
	            			  $.ajax({
	            				  url:pageurl,
	            				  type:'POST',
	            				  data:{pag:num,voyage_id:voyage_id,type_code:type_code},
	            				  dataType:'json',
	            				  success:function(data){
	            					  if(data!=0){
	            					  var tmp = "{{each remaining}}";
	            			            var t="{{$index}}";
	            		  				tmp+="<tr>";
	            		  				tmp+="<td>{{$value.type_name}}</td>";
	            		  				tmp+="<td>{{$value.deck_num}}</td>";
	            		  				tmp+="<td>{{$value.quantity>='10'?'Enouge':$value.quantity}}</td>";
	            		  				tmp+="</tr>";
	            		  				tmp+="{{/each}}";
	            		  				var render = template.compile(tmp);
	            						var html = render({remaining:data});
	            						
	            		  	         	$("table#remaining_page_table > tbody").html(html);
	            					  }
	            					  else{
	            						  $("#count").html('0');
	            						$("table#remaining_page_table > tbody").html("");
	            					  }
	            				  } 
	            			  });
	            			  //showPage(num);
	            		  }
	            	  });
			  }
				else{
					 $("#count").html(d['count']);
					$("table#remaining_page_table > tbody").html("");
				}
			  
			  },
	        
		});
});
});
