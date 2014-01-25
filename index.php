<html>
	<head>
		<link rel="stylesheet" type="text/css" href="includes/main.css" />
    <script language="javascript" type="text/javascript" src="includes/jquery-1.8.2.min.js"></script>
    <script language="javascript" type="text/javascript" src="includes/main.js"></script>
  </head>
  <body>
  	<div id="home">
    	<div class="blurb_cont">I AM:<textarea type="text" id="blurb"></textarea></div>
	  	<!--input type="button" id="btnpingOn" value="" /-->
	  	<!--input type="button" id="btnpingOff" value="" /-->
      <div class="btnping" id="btnpingOn"><img src="images/im_free.png" /><br/>I'M FREE<br/><span style="font-size: 30px;">come and find me now!</span></div>
      <div class="btnping" id="btnpingOff"><img src="images/nevermind.png" /><br/>NEVER MIND<br/><span style="font-size: 30px;">maybe later...</span></div>
	    <div class="footer">
	    	<div class="half_footer" id="whos_free"><img src="images/whos_free.png" /><br/>Who's Free</div>
        <div class="footer_sep">&nbsp;</div>
        <div class="half_footer" id="chatters"><img src="images/chatters.png" /><br/>Today's Chats</div>
	    </div>
    </div>
    <div id="list">
      <div class="header">
      	<div id="back_home" class="half_footer"><img src="images/arrow_back.png"/>Home</div>
        <div class="footer_sep">&nbsp;</div>
        <div id="list_to_map" class="half_footer">Map<img src="images/arrow_forward.png"/></div>
      </div>
    	<div id="listcont">
      </div>
    </div>
    <div id="map">
      <div class="header">
      	<div id="back_home" class="half_footer"><img src="images/arrow_back.png"/>Home</div>
        <div class="footer_sep">&nbsp;</div>
        <div id="map_to_list" class="half_footer">List<img src="images/arrow_forward.png"/></div>
      </div>
	    <div id="map-canvas"></div>
    </div>
    <div id="chat">
      <div class="header">
        <div id="back_home" class="half_footer"><img src="images/arrow_back.png"/>Home</div>
        <div class="footer_sep">&nbsp;</div>
      	<div id="chat_to_map" class="half_footer">Map<img src="images/arrow_forward.png"/></div>
      </div>
    	<div id="chatroom">
      	<div id="chatTitle"></div>
      	<div id="messages">&nbsp;</div>
	    	<div id="sendercont">
	      	<div id="sender">
          	<div id="messagercont">
		        	<input type="text" id="messager" />
            </div>
	          <img id="send" src="images/btnsend.png" />
	        </div>
        </div>
      </div>
    </div>
    <div id="chattersdiv">
      <div class="header">
      	<div id="back_home" class="half_footer"><img src="images/arrow_back.png"/>Home</div>
        <div class="footer_sep">&nbsp;</div>
        <div id="chats_to_map" class="half_footer">Map<img src="images/arrow_forward.png"/></div>
      </div>
    	<div id="chatterscont">
    </div>
  </body>
</html>
