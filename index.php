<?php 
require("global.config.php");

//-------------------- make ---------------------------------
if(isset($_POST["make"])):
	
	$name=$_POST["name"];
	$theme=$_POST["theme"];
	$music=$_POST["music"];
	$msg=$_POST["msg"];
	
	$n=new LiveWish();
	$n->setParams(array(
		"theme" => $theme,
		"sound" => $music,
		"name" => $name,
		"message" => $msg 
	));
	$makeid=$n->makeLiveWish("data/xml/");
	
	header("Location:index.php?done=$makeid");

endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo(LW_APP_NAME); ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.js"></script>
</head>

<body>
	<div class="wrapper">
   	  <div class="head">
        	
      </div>
      
        <div class="content">
        <?php if(!isset($_GET["done"])): ?>
          <form action="<?php echo($_SERVER['PHP_SELF']); ?>" onsubmit="return validateMakerForm();" method="post">
              <div class="label">Select Theme</div>
                <input type="hidden" id="jtheme" name="theme" />
              <div class="bg-image-sel">
              		<?php
						$images=glob("data/themes/*.{png,jpg,gif}",GLOB_BRACE);
						foreach($images as $image):
						?>
                            <div class="dummy-bg" data-name="<?php echo(basename($image)) ?>">
                                <div class="image" style="background-image:url(<?php echo($image); ?>)"></div>
                            </div> 
                        <?php	
						endforeach;
					?>
                </div>
              <div class="label">Select Music</div>  
              <select id="jmusic" name="music">
              		<option value="0">Select File...</option>
              		<?php
						$sounds=glob("data/sounds/*.mp3",GLOB_BRACE);
						foreach($sounds as $sound):
						?>
                            <option value="<?php echo(basename($sound)); ?>"><?php echo(basename($sound)); ?></option>
                        <?php	
						endforeach;
					?>
              </select>
              
              <div class="mp-player">
                <a href="javascript:mp.play();">Play</a>
                <a href="javascript:mp.stop();">Stop</a>
                <audio src="" id="mp" preload="auto"></audio>
              </div>
              
              <div class="label">Poem/Message</div>
              
              <textarea id="jmsg" style="height:200px;" name="msg"><?php echo("Text Line 1\r\nText Line 2\r\nText Line 3\r\n........"); ?></textarea>
              
              <div class="label">Your Name</div>
              <input type="text" id="jname" name="name" value="Shalitha Suranga" />
              <div class="line"></div>
              <input type="submit" id="jmake" value="Make Live Wish!" class="make" name="make" />
          </form>
          <?php else: ?>
          	<div>
            	Congratulations!. your Live Wish is ready. Share it using following URL.. <a href="<?php echo(LW_APP_URL."play/".$_GET["done"]); ?>" target="_blank">Play It!!</a>
                <div class="line"></div>
                	<input type="text" value="<?php echo(LW_APP_URL."play/".$_GET["done"]); ?>" />
                <div class="line"></div>
                	<input type="button" id="jmakeanother" value="Make Another Live Wish!" onclick="window.location='index.php'"/>
                <div class="line"></div>
            </div>
          <?php endif; ?>
        </div>
        
	<div class="footer">Developed by <a href="https://github.com/codeforce" target="_blank">CodeForce</a></div>
        
    </div>
    
    
</body>
<script>

var validateMakerForm=function(){
	if($('#jtheme').val()==''){
	alert('Select a Theme!');
		return false;
		
	}
	else if($('#jmusic').val()=='0'){
		alert('Select a Music File!');
		return false;
	}
	else if($('#jmsg').val()==''){
		alert('Type Your Message/Poem!');
		return false;
	}
	else if($('#jname').val()==''){
		alert('Enter Your Name!');
		return false;
	}
	else {
		return true;
	}
};

$('.dummy-bg').click(function(){
	$('.dummy-bg').removeClass('dummy-bg-s');
	$(this).addClass('dummy-bg-s');
	$('#jtheme').val($(this).attr('data-name'));
});

var mp={
	
	play : function(){
		document.getElementById('mp').play();
	},
	
	stop : function(){
		document.getElementById('mp').pause();
	}


};

$('#jmusic').change(function(){
	document.getElementById('mp').src='data/sounds/'+$(this).val();
});

</script>
</html>
