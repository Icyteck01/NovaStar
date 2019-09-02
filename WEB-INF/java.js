$(function() {
$( ".center-pane" ).hide();

$(".overlay").hide();	
$(".fakeloader").fakeLoader();
var ischatVisible = false;
var flushLines = 100;
var totalChatLines = 0;
var lastLines = 0;

$('html').bind('keypress', function(e)
{
   if(e.keyCode == 13)
   {
	   if(!ischatVisible)
	   {
		return false;
	   }else{
	var input = $("#directChatInputMsg").val();
	if(input.length <= 1)
	{
		return;
	}
	var theForm = new FormData();	
	theForm.append('msg', $("#directChatInputMsg").val());								
	$.ajax({
	url: "php_exe/insertChat",
	type: "POST",
	data: theForm,
	processData: false,
	contentType: false,
	success: function (data)
	{
	if(data && data.result)
	{	
		$("#direct-chat-messages").html("");//Clear
		totalChatLines = 0;
		$.each(data, function(i, item) {
			if(item && item.img)
			{
				var $other = '<div class="direct-chat-msg">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-left">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-right">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					 '</div>'+
					'</div>';
				var $me = '<div class="direct-chat-msg right">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-right">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-left">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					  '</div>'+
					'</div>';
				totalChatLines++;
				if(ischatVisible)
				{
					lastLines = totalChatLines;
					$("#showHideDirectChat").html('<i class="fa fa-comments"></i>');
				}
				$("#directChatInputMsg").val("");
				if(item.isMe)
				{
					$("#direct-chat-messages").append($me);
				}else{
					$("#direct-chat-messages").append($other);
				}
			}
		});
		
	}else{
		
		showerror2(data.msg);
	}

	},
	error: function (xhr, desc, err)
	{
		showerror2($err.FEPCAGSD);	
	}		
});
return false;
	   }
   }
});


$("#showHideDirectChat,#showHideDirectChat2").click(function(e) {
	
	if(ischatVisible)
	{
		$( ".center-pane" ).fadeOut(400);
		ischatVisible = false;
		
	}else{
		$( ".center-pane" ).fadeIn(200);
			ischatVisible = true;
			lastLines = totalChatLines;
			$("#showHideDirectChat").html('<i class="fa fa-comments"></i>');
	}

});


var updateChatData = function(){
$.post( "php_exe/getChat", function( data ) {
	if(data)
	{	

			$("#direct-chat-messages").html("");//Clear

		totalChatLines = 0;
		$.each(data, function(i, item) {
				var $other = '<div class="direct-chat-msg">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-left">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-right">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					 '</div>'+
					'</div>';
				var $me = '<div class="direct-chat-msg right">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-right">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-left">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					  '</div>'+
					'</div>';
				totalChatLines++;
				if(ischatVisible)
				{
					lastLines = totalChatLines;
					$("#showHideDirectChat").html('<i class="fa fa-comments"></i>');
				}
				if(item.isMe)
				{
					$("#direct-chat-messages").append($me);
				}else{
					$("#direct-chat-messages").append($other);
				}
				if(!ischatVisible && lastLines < totalChatLines)
				{
					var todas = totalChatLines - lastLines;
					$("#showHideDirectChat").html('<i class="fa fa-comments"></i> <span class="label label-info">'+todas+'</span>');
				}
		});
	}
});
}
$("#directChatSendInputMsg").click(function(e) {
	var input = $("#directChatInputMsg").val();
	if(input.length <= 1)
	{
		return;
	}
	var theForm = new FormData();	
	theForm.append('msg', $("#directChatInputMsg").val());								
	$.ajax({
	url: "php_exe/insertChat",
	type: "POST",
	data: theForm,
	processData: false,
	contentType: false,
	success: function (data)
	{
	if(data && data.result)
	{	
		$("#direct-chat-messages").html("");//Clear
		totalChatLines = 0;
		$.each(data, function(i, item) {
			if(item && item.img)
			{
				var $other = '<div class="direct-chat-msg">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-left">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-right">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					 '</div>'+
					'</div>';
				var $me = '<div class="direct-chat-msg right">'+
					  '<div class="direct-chat-info clearfix">'+
						'<span class="direct-chat-name pull-right">'+item.name+'</span>'+
						'<span class="direct-chat-timestamp pull-left">'+item.timestamp+'</span>'+
					  '</div>'+
					  '<img class="direct-chat-img" src="user_img/'+item.img+'" alt="message user image">'+
					  '<div class="direct-chat-text">'+
						''+item.text+''+
					  '</div>'+
					'</div>';
				totalChatLines++;
				if(ischatVisible)
				{
					lastLines = totalChatLines;
					$("#showHideDirectChat").html('<i class="fa fa-comments"></i>');
				}
				$("#directChatInputMsg").val("");
				if(item.isMe)
				{
					$("#direct-chat-messages").append($me);
				}else{
					$("#direct-chat-messages").append($other);
				}
			}
		});
		
	}else{
		
		showerror2(data.msg);
	}

	},
	error: function (xhr, desc, err)
	{
		showerror2($err.FEPCAGSD);	
	}		
});
});


window.setInterval(function(){
	updateChatData();
}, 20000);


var showfakeLoaderBoll = false;
var timed;

var loadNotificationsF =  function(){
	$.post( "loadNotifications", function( data ) {
		var datax = data.split('|');
		
		
		if(parseInt(datax[0]) == 1)
		{	
			clearTimeout(timed);
			if(showfakeLoaderBoll){
				$(".fakeloader").hidefakeLoader();
			}
			var val = JSON.parse(datax[1]);
			if(val.calendarANDtaskCount > 0)
			{
				$('.calendarUpdate').html(val.calendarANDtaskCount);
			}
		}
		if(parseInt(datax[0]) == 2)
		{
			clearTimeout(timed);
			if(showfakeLoaderBoll){
				$(".fakeloader").hidefakeLoader();
			}
		}
		
	});
}


$.post( "loadMailbox", function( data ) {
	var datax = data.split('|');
	if(parseInt(datax[0]) == 1)
	{
		loadNotificationsF();
	}
	if(parseInt(datax[0]) == 2)
	{
		loadNotificationsF();
	}	
	
});

	
$('[data-toggle="tooltip"]').tooltip(); 
$( 'input' ).on('input',function() {
  var pat = $(this).attr('pattern');
   if( pat ) {
	   //alert(pat);
	   var str = $(this).val();
	   var regex = new RegExp(pat , "g");
	   var newstr = str.replace(regex, "");
		$(this).val(newstr);
   } 	
	
  var capital = $(this).attr('capital');
   if( capital ) { 
	 $(this).val($(this).val().toString().toUpperCase());  
   }
});

var showerror2 = function(msg)
{
	bootbox.dialog({
	  message: msg,
	  title: "<i class='fa fa-warning'></i> "+$cfg.ERR,
	  className: "modal-danger"
	});
}
var showsucess2 = function(msg = "")
{
	bootbox.dialog({
	  message: msg,
	  title: "<i class='fa fa-check'></i> "+$cfg.SUCCESS,
	  className: "modal-success"
	});
}

var showwarning2 = function(msg = "")
{
	bootbox.dialog({
	  message: msg,
	  title: "<i class='fa fa-frown-o'></i> "+$cfg.WRONG,
	  className: "modal-warning",
		buttons: {
			success: {
			  label: "<i class='fa fa-smile-o'></i> "+$cfg.TAE,
			  className: "btn-success",
			  callback: function() {
				
			  }
			}
		}	
	});
}
	
$(".remove_car_from_transit").click(function(e) {
	var id = $(this).attr("data-vak");
	var cureentKM = $(this).attr("data-vax");
	var carid = $(this).attr("data-carid");
	var type = $(this).attr("data-type");
	bootbox.prompt({
		title: $cfg.HMIC,
		buttons: {
			confirm: {
				label: $cfg.NEXT,
				className: "btn-success",
			},
			cancel: {
				label: $cfg.CANCEL,
				className: "btn-warning",
			}	
		},
		callback:function(result){
			if (result != null && result.length > 0) {
				
				result = result.replace(/\D/g,'');
				if(result.length > 0)
				{
					bootbox.prompt({
						title: $cfg.HMICZXC,
						value: cureentKM,
						buttons: {
							confirm: {
								label: $cfg.NEXT,
								className: "btn-success",
							},
							cancel: {
								label: $cfg.CANCEL,
								className: "btn-warning",
							}	
						},
						callback:function(resultxy){
							if (resultxy != null && resultxy.length > 0) {
								
								resultxy = resultxy.replace(/\D/g,'');
								if(resultxy.length > 0)
								{
									bootbox.prompt({
										title: $cfg.HMICZXCX,
										buttons: {
											confirm: {
												label: $cfg.SAVEANDREMOVE,
												className: "btn-success",
											},
											cancel: {
												label: $cfg.CANCEL,
												className: "btn-warning",
											}	
										},
										callback:function(resultx){
											if (resultx != null && resultx.length > 0) {
												
												resultx = resultx.replace(/\D/g,'');
												if(resultx.length > 0)
												{
													var theForm = new FormData();	
													theForm.append('moneySpent', result);	
													theForm.append('kmOnBoard', resultxy);								
													theForm.append('fuelTank', resultx);								
													theForm.append('cureentKM', cureentKM);								
													theForm.append('carid', carid);								
													theForm.append('id', id);								
													theForm.append('type', type);								
														
														$.ajax({
														url: "php_exe/remove_from_transit",
														type: "POST",
														data: theForm,
														processData: false,
														contentType: false,
														success: function (data)
														{
															var value = data.split('|')[0];
															var msg = data.split('|')[1];
															switch(parseInt(value))
															{
																case 1:
																	$('#transit_can_hide_'+id).hide();
																	showsucess2($cfg.Adatahbs);
																break;				
																default:
																	showwarning2(msg);
																break;
															}
					
														},
														error: function (xhr, desc, err)
														{
															showerror($err.FEPCAGSD);	
														}		
													});									
													
												}
												
											}
										}
									});								
									
								}
								
							}
						}
					});
				}
				
			}
		}
	});
});	


$(".sendToServiceCar").click(function(e) {
	e.preventDefault();
	var id=$(this).attr("data-id");
	var plate=$(this).attr("data-plate");
	bootbox.dialog({
		 message: $cfg.ARE_YOU_SURE_YOU_WANT_TO.replace("@", plate),
		title: $cfg.INFO,
		 className: "modal-warning",
		buttons: {
			confirm: {
				label: "<i class='fa fa-check'></i> "+$cfg.AREYOOUYE,
				className: "btn-success",
				  callback: function() {
					var theForm = new FormData();	
					theForm.append('uid', id);
					theForm.append('type', 0);
					$(".overlay").show();
						$.ajax({
						url: "php_exe/add_from_transit",
						type: "POST",
						data: theForm,
						processData: false,
						contentType: false,
						success: function (data)
						{
							var value = data.split('|')[0];
							var msg = data.split('|')[1];
							switch(parseInt(value))
							{
								case 1:
									$('#all_can_hide_'+id).hide();
									showsucess2($cfg.Adatahbs);
									$(".overlay").hide();
								break;				
								default:
									showwarning2(msg);
									$(".overlay").hide();
								break;
							}
							
						},
						error: function (xhr, desc, err)
						{
							showerror($err.FEPCAGSD);
							$(".overlay").hide();
						}		
					});
				  }				
			},
			cancel: {
				label: $cfg.CANCEL + " <i class='fa fa-arrow-circle-left'></i>",
				className: "btn-default",
			}	
		}
	});
	
});	


$(".SendToTransit").click(function(e) {
	e.preventDefault();
	var id=$(this).attr("data-id");
	var plate=$(this).attr("data-plate");
	bootbox.dialog({
		 message: $cfg.ARE_YOU_SURE_YOU_WANT_TOT.replace("@", plate),
		title: $cfg.INFO,
		 className: "modal-info",
		buttons: {
			confirm: {
				label: "<i class='fa fa-check'></i> "+$cfg.AREYOOUYE,
				className: "btn-success",
				  callback: function() {
					  $(".overlay").show();
					var theForm = new FormData();	
					theForm.append('uid', id);
					theForm.append('type', 1);
						$.ajax({
						url: "php_exe/add_from_transit",
						type: "POST",
						data: theForm,
						processData: false,
						contentType: false,
						success: function (data)
						{
							var value = data.split('|')[0];
							var msg = data.split('|')[1];
							switch(parseInt(value))
							{
								case 1:
									$('#all_can_hide_'+id).hide();
									showsucess2($cfg.Adatahbs);
									$(".overlay").hide();
								break;				
								default:
									showwarning2(msg);
									$(".overlay").hide();
								break;
							}
							$(".overlay").hide();
						},
						error: function (xhr, desc, err)
						{
							showerror($err.FEPCAGSD);	
							$(".overlay").hide();
						}		
					});
				  }				
			},
			cancel: {
				label: $cfg.CANCEL + " <i class='fa fa-arrow-circle-left'></i>",
				className: "btn-default",
			}	
		}
	});
});	

$(".DELETECONTACT").click(function(e) {
	e.preventDefault();
	var id=$(this).attr("data-zxc");
	var plate=$(this).attr("data-xxy");
	bootbox.dialog({
		 message: $cfg.DELETE_USER_CONFIRM_DIALOG.replace("@", plate),
		title: $cfg.INFO,
		 className: "modal-danger",
		buttons: {
			confirm: {
				label: "<i class='fa fa-check'></i> "+$cfg.AREYOOUYE,
				className: "btn-danger",
				  callback: function() {
					  $(".overlay").show();
					var theForm = new FormData();	
					theForm.append('uid', id);
						$.ajax({
						url: "php_exe/deleteUser",
						type: "POST",
						data: theForm,
						processData: false,
						contentType: false,
						success: function (data)
						{
							var value = data.split('|')[0];
							var msg = data.split('|')[1];
							switch(parseInt(value))
							{
								case 1:
									$('#all_can_hide_'+id).hide();
									showsucess2($cfg.Adatahbs);
									$(".overlay").hide();
								break;				
								default:
									showwarning2(msg);
									$(".overlay").hide();
								break;
							}
							$(".overlay").hide();
						},
						error: function (xhr, desc, err)
						{
							showerror($err.FEPCAGSD);	
							$(".overlay").hide();
						}		
					});
				  }				
			},
			cancel: {
				label: $cfg.CANCEL + " <i class='fa fa-arrow-circle-left'></i>",
				className: "btn-success",
			}	
		}
	});
});	


$(".DELETEEmployee").click(function(e) {
	e.preventDefault();
	var id=$(this).attr("data-zxc");
	var plate=$(this).attr("data-xxy");
	bootbox.dialog({
		 message: $cfg.DELETE_USER_CONFIRM_DIALOG.replace("@", plate),
		title: $cfg.INFO,
		 className: "modal-danger",
		buttons: {
			confirm: {
				label: "<i class='fa fa-check'></i> "+$cfg.AREYOOUYE,
				className: "btn-danger",
				  callback: function() {
					  $(".overlay").show();
					var theForm = new FormData();	
					theForm.append('uid', id);
						$.ajax({
						url: "php_exe/deleteEmployee",
						type: "POST",
						data: theForm,
						processData: false,
						contentType: false,
						success: function (data)
						{
							var value = data.split('|')[0];
							var msg = data.split('|')[1];
							switch(parseInt(value))
							{
								case 1:
									$('#all_can_hide_'+id).hide();
									showsucess2($cfg.Adatahbs);
									$(".overlay").hide();
								break;				
								default:
									showwarning2(msg);
									$(".overlay").hide();
								break;
							}
							$(".overlay").hide();
						},
						error: function (xhr, desc, err)
						{
							showerror($err.FEPCAGSD);	
							$(".overlay").hide();
						}		
					});
				  }				
			},
			cancel: {
				label: $cfg.CANCEL + " <i class='fa fa-arrow-circle-left'></i>",
				className: "btn-success",
			}	
		}
	});
});	


$(".remove_car_from_rent").click(function(e) {
	var id = $(this).attr("data-vak");
	var cureentKM = $(this).attr("data-vax");
	var carid = $(this).attr("data-carid");
	var type = $(this).attr("data-type");
	bootbox.prompt({
		title: $cfg.HMICZXC,
		buttons: {
			confirm: {
				label: $cfg.NEXT,
				className: "btn-success",
			},
			cancel: {
				label: $cfg.CANCEL,
				className: "btn-warning",
			}	
		},
		callback:function(resultxy){
			if (resultxy != null && resultxy.length > 0) {
				
				resultxy = resultxy.replace(/\D/g,'');
				if(resultxy.length > 0)
				{
					bootbox.prompt({
						title: $cfg.HMICZXCX,
						buttons: {
							confirm: {
								label: $cfg.SAVEANDREMOVE,
								className: "btn-success",
							},
							cancel: {
								label: $cfg.CANCEL,
								className: "btn-warning",
							}	
						},
						callback:function(resultx){
							if (resultx != null && resultx.length > 0) {
								
								resultx = resultx.replace(/\D/g,'');
								if(resultx.length > 0)
								{
									var theForm = new FormData();	
									theForm.append('moneySpent', 0);	
									theForm.append('kmOnBoard', resultxy);								
									theForm.append('fuelTank', resultx);								
									theForm.append('cureentKM', cureentKM);								
									theForm.append('carid', carid);								
									theForm.append('id', id);								
									theForm.append('type', type);								
									
										$.ajax({
										url: "php_exe/remove_from_transit",
										type: "POST",
										data: theForm,
										processData: false,
										contentType: false,
										success: function (data)
										{
											var value = data.split('|')[0];
											var msg = data.split('|')[1];
											switch(parseInt(value))
											{
												case 1:
													$('#transit_can_hide_'+id).hide();
													showsucess2($cfg.Adatahbs);
												break;				
												default:
													showwarning2(msg);
												break;
											}
	
										},
										error: function (xhr, desc, err)
										{
											showerror($err.FEPCAGSD);	
										}		
									});									
									
								}
								
							}
						}
					});								
					
				}
				
			}
		}
	});
});				
$(".DELETECONTRACTBYID").click(function(e) {
	e.preventDefault();
	var id=$(this).attr("data-zxc");
	var plate=$(this).attr("data-xxy");
	bootbox.dialog({
		 message: $cfg.DELETE_USER_CONFIRM_DIALOG.replace("@", plate),
		title: $cfg.INFO,
		 className: "modal-danger",
		buttons: {
			confirm: {
				label: "<i class='fa fa-check'></i> "+$cfg.AREYOOUYE,
				className: "btn-danger",
				  callback: function() {
					  $(".overlay").show();
					var theForm = new FormData();	
					theForm.append('uid', id);
						$.ajax({
						url: "php_exe/deleteContract",
						type: "POST",
						data: theForm,
						processData: false,
						contentType: false,
						success: function (data)
						{
							var value = data.split('|')[0];
							var msg = data.split('|')[1];
							switch(parseInt(value))
							{
								case 1:
									$('#all_can_hide_'+id).hide();
									showsucess2($cfg.Adatahbs);
									$(".overlay").hide();
								break;				
								default:
									showwarning2(msg);
									$(".overlay").hide();
								break;
							}
							$(".overlay").hide();
						},
						error: function (xhr, desc, err)
						{
							showerror($err.FEPCAGSD);	
							$(".overlay").hide();
						}		
					});
				  }				
			},
			cancel: {
				label: $cfg.CANCEL + " <i class='fa fa-arrow-circle-left'></i>",
				className: "btn-success",
			}	
		}
	});
});	

});