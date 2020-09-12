<?php
date_default_timezone_set('Asia/Kolkata');
include('database.inc.php');

?>
<!DOCTYPE html>
<html lang="es">
   <head>
   
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
	  
      <title>PHP Chatbot</title>
	  
	  
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	  <link href="style.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="style.css">
	  <style type="text/css">
	  body,td,th {
	color: #0033FF;
}
      body {
	background-color: #999999;
	background:url(image/das.png) no-repeat center top; 
	background-size: cover;
	
	
	
}
p{
	color: #FF0000; 
}
input-group-append{
	background-color: #999999;
	 
}


      </style>
   </head>
  
   
   <body bgcolor="#00FF00" text="#0099FF">
   <div class="container">
   <div class="col">
         <div class="row justify-content-md-center mb-4">
		 
		 
		 
            <div class="col-md-6">
               
			   
			   
               <div class="card">
                  <div class="card-body messages-box ">
				  
				  
				  
				  <font color="navy" face="Comic Sans MS,arial">
				 
					 <ul class="list-unstyled messages-list">
					 
					<center><h2>CHATBOT</h2></center>
					
					
					
							<?php
							
							$res=mysqli_query($con,"select * from message");
							if(mysqli_num_rows($res)>0){
								$html='';
								while($row=mysqli_fetch_assoc($res)){
									$message=$row['message'];
									$added_on=$row['added_on'];
									$strtotime=strtotime($added_on);
									$time=date('h:i A',$strtotime);
									$type=$row['type'];
									if($type=='user'){
										$class="messages-me";
										$imgAvatar="user_avatar.png";
										$name="Usuario";
									}else{
										$class="messages-you";
										$imgAvatar="bot_avatar.png";
										$name="Alice";
									}
									$html.='<li class="'.$class.' clearfix"><span class="message-img"><img src="image/'.$imgAvatar.'" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">'.$name.'</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'.$time.'</span></small> </div><p class="messages-p">'.$message.'</p></div></li>';
								}
								echo $html;
							}else{
								?>
								
			           <li></li>
					   <?php
							}
							?>
				    </ul>
				  </div>
                  <div class="card-header">
                    <div class="input-group">
					
					   <input id="input-me" type="text" name="messages" class="form-control input-sm" placeholder="Escribe un mensaje..." />
				      <span class="input-group-append">
					   <input type="button" class="btn btn-outline-primary" value="Enviar" onClick="send_msg()">
					   
				      </span>
				      <label></label>
					  
                    </div> 
                  </div>
               </div>
                
            </div>
         </div>
   </div>
	  
      <script type="text/javascript">
		 function getCurrentTime(){
			var now = new Date();
			var hh = now.getHours();
			var min = now.getMinutes();
			var ampm = (hh>=12)?'PM':'AM';
			hh = hh%12;
			hh = hh?hh:12;
			hh = hh<10?'0'+hh:hh;
			min = min<10?'0'+min:min;
			var time = hh+":"+min+" "+ampm;
			return time;
			
		 }
		 function send_msg(){
			jQuery('.start_chat').hide();
			var txt=jQuery('#input-me').val();
			var html='<li class="messages-me clearfix"><span class="message-img"><img src="image/user_avatar.png" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Usuario</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p">'+txt+'</p></div></li>';
			jQuery('.messages-list').append(html);
			jQuery('#input-me').val('');
			if(txt){
				jQuery.ajax({
					url:'get_bot_message.php',
					type:'post',
					data:'txt='+txt,
					success:function(result){
						var html='<li class="messages-you clearfix"><span class="message-img"><img src="image/bot_avatar.png" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Alice</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p">'+result+'</p></div></li>';
						jQuery('.messages-list').append(html);
						jQuery('.messages-box').scrollTop(jQuery('.messages-box')[0].scrollHeight);
						
					}
				});
			}
		 }
      </script>
      <form name="form1" method="post" action="">
      </form>
	 
   

      </body>
   
</html>