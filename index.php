<?php

$getvar = $_GET["q"];
$questionsandanswers = array();
$questionsandanswers[1] = 1;
$questionsandanswers[2] = 1;
$questionsandanswers[3] = 0;
$questionsandanswers[4] = 1;
$questionsandanswers[5] = 1;
$marker = "";
$here = "";
$whatif = "?q=".str_replace("/submit","",$getvar)."/whatif";
//default URL for the Continue button - altered below occasionally
$next = "?q=".$getvar."/submit";
$isquestion = "";
$correct = "";
$mousetext = "<p>Move your mouse over the message to see clues that can help you tell if it is a phishing email.</p>";

$correctphish = "<div role='alert' class='alert alert-success'>
          
            		<p><b>Correct. It's a phishing attempt!</b> You avoided the trap.</p>";
$correctnotaphish = "<div role='alert' class='alert alert-success'>
          
            		<p><b>Correct. This is not a phishing attempt.</b></p>";
$wrongphish = "<div role='alert' class='alert alert-danger'>
          
            		<p><b>Oh, no! This is a phishing attempt! You took the bait.</b></p>";
$wrongnotaphish = "<div role='alert' class='alert alert-danger'>
          
            		<p>This is a legitimate email message. <b>It's not a phishing attempt.</b></p>";
$subtext = ": Is it Phishy?";
$bgimg = "";
if (!$getvar) {$bgimg = "1-forestfish.jpg";}
else if ($getvar == "train/pre") {$bgimg = "2-intros-PhishingGamePictures.jpg";}
else if ($getvar == "1") {$bgimg = "Walleyebackground.jpg";}
else if ($getvar == "1/submit") {$bgimg = "water-2.jpg";}
else if ($getvar == "2") {$bgimg = "2-res-correct.jpg";}
else if ($getvar == "2/submit") {$bgimg = "Fishermen.jpg";}
else if ($getvar == "3") {$bgimg = "4-res-RiverTrout.jpg";}
else if ($getvar == "3/submit") {$bgimg = "Sturgeon.jpg";}
else if ($getvar == "4") {$bgimg = "Water3.jpg";}
else if ($getvar == "4/submit") {$bgimg = "3-res-lakewater.jpg";}
else if ($getvar == "thankyou") {$bgimg = "end-WaterBackground2.jpg";}
//Main_Backgound_Image.jpg
else {$bgimg = "Water3.jpg";}


//if there's no _GET, we're assuming they're at the intro page
if (!$getvar) {
$here = "intro";
$next="?q=train/pre";
$questionmarkup = "<div class='col-md-6 '>
            
  <div class='row'>
    <div class='col-md-1 '>
    </div>
    <div class='col-md-10 '>
      <div class='WelcomeText' id='InstructionsDIV' style='margin-top:40px;'>";
$questionend = "</div>
    </div>
    <div class='col-md-1 '>
    </div>
  </div>
 </div>   
          <div class='col-md-6'>
            
  <div style='margin:40px;'>
    <img src='resources/fish.png' class='img-responsive center-block' alt='Welcome Page Fish Image' height='100%'>
  </div>
<div class='row' style='margin-bottom:40px'>
    <div class='col-xs-3 '>
    </div>
    <div class='col-xs-6 '>
      <a id='StartBtn' href='$next' class='btn btn-lg btn-success' style='width:200px;'>Start</a>
    </div>
    <div class='col-xs-3 '>
    </div>
  </div>
";


}

//if there is _GET, it's a question
else {

if (is_numeric(substr($getvar,0,1)) && !is_int(strpos($getvar, 'whatif')) ) {$isquestion = "yes";}
	else {$isquestion = "no";}
	
	$here = $getvar;
$questionmarkup = "<div class='row'>
    <div class='col-md-2 '>
    </div>
    <div class='col-md-8 '>
      <div class='WelcomeText' id='InstructionsDIV' style='margin-top:40px;'>   ";
	  
$questionend = "</div>
    </div>
    <div class='col-md-2 '>
    </div>
  </div>";
}


if (strpos($here, 'whatif')) {
	$review = "?q=".substr($getvar,0,1)."/submit&rev=1";
	
	if (substr($getvar,0,1) == 5) {$next = "?q=thankyou";}
	else {$next = "?q=".(substr($getvar,0,1)+1);}

	$marker = "<div class='row'>
      				<div class='col-xs-2'>
     			 </div>
      			<div class='col-xs-8'>";
		if (substr($getvar,0,1) != 3) {
		$marker .= $wrongphish;
		}
		else {
			$marker .= $wrongnotaphish;
		}
	$marker .= "</div>
      				</div>
      			<div class='col-xs-2'>
      			</div>
    			</div>";		
}


$disabled = "";

if($_GET['rev']) {
	$disabled = 'disabled';
	$next = "?q=".(substr($getvar,0,1)+1);
	if ($here == "5/submit") {$next="?q=thankyou";}
}

if (strpos($here, 'submit') && !$_GET['rev']) {
	$correct="no";
	//if we're at a submit page, disable the buttons
	$disabled = 'disabled';
	//if we're at a submit page, make the form move to the next question
	if ($here == "1/submit") {$next="?q=train/intro";}
	if ($here == "5/submit") {$next="?q=thankyou";}
	else {
		$next = "?q=".(intval($_POST['question'])+1);
		}
	
	//if we're at a submit page, check the answer
	$marker = "<div class='row'>
      				<div class='col-xs-2'>
     			 </div>
      			<div class='col-xs-8'>";
	if ($_POST['answer'] == $questionsandanswers[$_POST['question']]) {
		$correct="yes";
		if ($_POST['question'] != 3) {
		$marker .= $correctphish;
		}
		else {
		$marker .= $correctnotaphish;	
		}
	}
	else {
		if ($_POST['question'] != 3) {
			header("Location: $whatif");
		$marker .= $wrongphish;
		}
		else {
			header("Location: $whatif");
			$marker .= $wrongnotaphish;
		}
}
	$marker .= "</div>
      				</div>
      			<div class='col-xs-2'>
      			</div>
    			</div>";
}

?>

<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">

    <link rel="shortcut icon" type="image/png" href="blockm.png">
	<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
    <title>Welcome to the Training Module!</title>
    
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Bootstrap theme -->
    <link href="resources/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="resources/ie10-viewport-bug-workaround.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this project -->
    <link href="resources/project.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="resources/jquery.mCustomScrollbar.css" type="text/css" />

    <link rel="stylesheet" href="resources/jquery-ui.css" type="text/css" />

  </head>

  <body role="document" style="background-image:url('resources/<?php echo $bgimg; ?>')">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/main/phishing_alerts/">
            <img src="resources/university-of-michigan-logo.png" alt="University of Michigan Logo" width="301px" height="46px" style="max-width:301px; margin-top: -13px;">
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        

    
      </div>
    </nav>



  <?php if ($getvar == "thankyou"): ?>
    <!--<div id="GoldenFish">
      <img src="resources/kpani_to12246_59408070.gif" alt="Smiley Fish Swiming" height="156" width="182">
    </div>-->

    <script type="text/javascript">
      //var windowWidth = $( window ).width() + 160;
      //var windowHeight = $( window ).height() + 160;
      //$( "#GoldenFish" ).animate({
        //left: "+=" + windowWidth.toString(),
      //}, 13000, function() {
        // Animation complete.
      //});
    </script>
    
  <?php endif; ?>


  

  

    <div class="container theme-showcase" role="main">
      
      <div class="container-fluid">
        <div class="row transBackground">

        
        
        
<!-- START TEMPLATE -->		


<?php echo $questionmarkup; ?>

<?php if ($here == "intro") : ?>

<h1>Test Your Phishing Knowledge!</h1>

<p>Can you recognize phishing emails that try to steal your password and personal information and compromise your U-M account?</p>

<p>Will you take the bait and get hooked?</p>

<p>Or will you avoid the trap and swim free?</p>









<?php elseif($here == "train/pre") : ?>
<h1>About this Training</h1>

            <p>Phishing happens all the time, including at the University of Michigan. It's a daily occurrence. Many people fall for phishing scams&mdash;even the leaders and the best.</p>
            
            <p>Can you recognize phishing emails? Do you want to be able to help your friends, family, and colleagues recognize them?</p>
            
            <p>Play this game to test your knowledge and learn to identify phishing clues. You will start with a practice email that shows you some clues to watch for. Then you will test your phish detection skills on three emails. Good luck!</p>
</div>

<div class="row" style="margin-bottom:40px">
    <div class="col-xs-5 ">
    </div>
    <div class="col-xs-2 ">
      <a id="Continue" href="?q=1" class="btn btn-lg btn-success">Continue</a>
    </div>
    <div class="col-xs-5 ">
    </div>
  </div>
  
  







<?php elseif($here == "train/intro") : ?>
<h1>Now Test Your Skills</h1>
            <p><b>Can You Identify Phishing Emails?</b></p>
            <p>Next, you will examine three emails and decide if they are phishing attempts.</p>
            <?php echo $mousetext; ?>
</div>

<div class="row" style="margin-bottom:40px">
    <div class="col-xs-5 ">
    </div>
    <div class="col-xs-2 ">
      <a id="Continue" href="?q=2" class="btn btn-lg btn-success">Continue</a>
    </div>
    <div class="col-xs-5 ">
    </div>
  </div>








<?php elseif($here == "1" || $here == "1/submit") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Practice Email</h1>
  
<?php 
 	echo $marker;
?>  
            
        
          <div style="margin-bottom:19px">
            <?php echo $mousetext; ?>
            <div class="center-block" style="position:relative;background:#fff;padding:1em;">      
            

<p><strong>From:</strong>  U-M Dearborn &lt;<a href="mailto:choph430@newschool.edu" aria-describedby="tip1" id="from" class="LinkAnchor DoNotOpen">choph430@newschool.edu</a>&gt;

<span id="tip1" class="tip hidden"><strong>Clue:</strong> This is not a U-M address.<br>It doesn't make sense for a message about your U-M mail to come from outside the university.</span>

<br><span id="subject" tabindex="0" aria-describedby="tip2" class="LinkAnchor DoNotOpen"><strong>Subject:</strong>  Update To Your Secure Account</span><span id="tip2" class="tip hidden"><strong>Clue:</strong> U-M will never ask you to update or validate your account to secure it.<br>You keep your U-M account as long as you are affiliated with the university.</span></p>

<p style="color: #cd232c;margin-bottom:0px;" id="gbs" tabindex="0" aria-describedby="tip3" class="LinkAnchor DoNotOpen">Your mailbox is almost full and out dated.</p>
<span id="tip3" class="tip hidden" style="margin-top:10px;"><strong>Clue:</strong> <nobr>U-M</nobr> Google mailboxes have unlimited storage, so your mailbox cannot become full.</span>
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="width: 139.5pt; border: solid black 1.0pt; border-right: none; background: #ffcc00; padding: .75pt .75pt .75pt .75pt;" width="186">
<p style="color: #cd232c;padding-bottom:0;margin-bottom:0;">1.93GB</p>
</td>
<td style="width: 10.5pt; border: solid black 1.0pt; border-left: none; padding: .75pt .75pt .75pt .75pt;" width="14">&nbsp;</td>
<td style="padding: .75pt .75pt .75pt .75pt;">
<p style="color: #cd232c;padding-bottom:0;margin-bottom:0;"><strong>2.01</strong>GB</p>
</td>
</tr>
</tbody>
</table>


<p style="color: #cd232c;">This is to inform you that our webmail Admin Server is currently congested, and your Mailbox is out of date. We are currently deleting all inactive accounts so please confirm that your e-mail account is still active by updating your current and correct details by <strong><a href="http://universityofmichigan.esy.es" id="link4" aria-describedby="tip4" class="LinkAnchor DoNotOpen">CLICKING HERE</a></strong><span id="tip4" class="tip hidden"><strong>Clue:</strong> Hover over (or tab to) the link to see the actual URL listed in the lower left corner of your window. This is not a U-M URL. U-M Dearborn URLs typically contain "umdearborn.edu." U-M Ann Arbor URLs typically contain "umich.edu."</span></p>


<p><span style="color: #cd232c;">Regards, <br><span id="fakedept" tabindex="0" aria-describedby="tip5" class="LinkAnchor DoNotOpen">Thanks, <br>Admin Department <br></span><span id="tip5" class="tip hidden"><strong>Clue:</strong> A search of the U-M website reveals that there is no department with this name at U-M.</span>©2014-2015 University of Michigan, All rights reserved.</span></p>               

            </div>          








<?php elseif($here == "1/whatif") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Practice Email</h1>
  
<?php 
 	echo $marker;
?>  
                  <p>If you clicked the link in the email, you would be taken to the web page shown here:</p>
        <img src="http://safecomputing.umich.edu/main/phishing_alerts/images/2015-08-10-2.jpg" alt="Enter your U-M personal information." class="img-responsive center-block">
        <p>Any information you entered would be stolen and could be used to compromise your U-M account, access your emails, change your personal information in Wolverine Access, and more.</p>

















<?php elseif($here == "2" || $here == "2/submit") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 1 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
            
        
          <div style="margin-bottom:19px">

<?php if (strpos($here, 'submit')) {echo $mousetext;} ?>			
            
            <div class="center-block" style="position:relative;background:#fff;padding:1em;">


<p><strong>From:</strong>  University of Michigan &lt;<a class="LinkAnchor DoNotOpen" href="mailto:naki9@hawaii.edu" aria-describedby="2tip1" id="from2">naki9@hawaii.edu</a>&gt;

<span id="2tip1" class="tip"><strong>Clue:</strong> This is not a U-M address.<br>It doesn't make sense for a message about your U-M mail to come from outside the university.</span>

<br /><strong>Subject:</strong>  University of Michigan Notice</p>
                
<p>Dear Web User,</p>
<p><span id="grammar" aria-describedby="2tip2" tabindex="0" class="LinkAnchor DoNotOpen">On Our recent check on The University of Michigan database records, its indicate that your account has not been updated as a part of our regular account maintenance.</span> <span id="2tip2" class="tip"><strong>Clue:</strong> Notice the capitalization mistakes and the grammatical errors.</span> <span id="verification" aria-describedby="tip3" tabindex="0" class="LinkAnchor DoNotOpen">Our new SSL servers check each account for activity and your information has been randomly chosen for verification</span><span id="tip3" class="tip"><strong>Clue:</strong> U-M will not ask you to verify or update your account.<br>You keep your account as long as you have an affiliation with U-M.</span>. <span id="emc" aria-describedby="tip9" tabindex="0" class="LinkAnchor DoNotOpen">Email Management Center</span> <span id="tip9" class="tip"><strong>Clue:</strong> There is no such center at <span style="white-space: nowrap">U-M.</span> Search the <span style="white-space: nowrap">U-M</span> website to check the names of departments, colleges, centers, and so on.</span>strives to serve their email user with better and secure email service.<br /> <a href="http://webmaster.ic.cz" id="2link4" aria-describedby="2tip4" class="LinkAnchor DoNotOpen">Please Click Here For Verification</a><span id="2tip4" class="tip"><strong>Clue:</strong> Notice that the link goes to this URL: webmaster.ic.cz. That is not a <span style="white-space: nowrap">U-M</span> URL. The .cz at the end indicates it is the Czech Republic.</span></p>

<p>Notification: Failure to update your account information may result in account limitation.Thank you very much for your cooperation!</p>
<p id="fakedept2" aria-describedby="2tip5" tabindex="0" class="LinkAnchor DoNotOpen">Thank you. <br />Webmail System, <br />University of Michigan. <span id="2tip5" class="tip"><strong>Clue:</strong> There are no services offered at the University of Michigan with this name.<br>Search the U-M website to check for service names.</span></p>            
                             

            </div>    












<?php elseif($here == "2/whatif") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 1 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
<p>If you clicked the link in the email, you would be taken to the web page shown here:</p>
        <img src="http://safecomputing.umich.edu/main/phishing_alerts/images/2015-08-21.jpg" alt="Enter your U-M personal information." class="img-responsive center-block">
        <p>Any information you entered would be stolen and could be used to compromise your U-M account, access your emails, change your personal information in Wolverine Access, and more.</p>













<?php elseif($here == "3" || $here == "3/submit") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 2 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
            
        
          <div style="margin-bottom:19px">

 			<?php if (strpos($here, 'submit')) {echo $mousetext;} ?>

            

            <div class="center-block" style="position:relative;background:#fff;padding:1em;">


<p>Hello staff on the Ann Arbor campus,</p>

<p>You may have heard about the <a href="http://safecomputing.umich.edu/heartbleed/" id="link1" aria-describedby="tip1" class="LinkAnchor DoNotOpen">Heartbleed bug,</a><span id="tip1" class="tip"><strong>Clue:</strong> This is a real U-M URL. safecomputing.umich.edu is U-M's IT security website.</span> a serious security flaw in the software used to secure Internet traffic. The university responded quickly to this threat, and U-M’s critical and core services are protected.</p>

<p>As a further safeguard, Information and Technology Services (ITS) is now advising those on the Ann Arbor campus to change their UMICH passwords. The U-M Health System, Flint, and Dearborn are asking the same of their campus communities.</p>

<p id="yourself" aria-describedby="tip2" tabindex="0" class="LinkAnchor DoNotOpen"><strong>Please Change Your UMICH Password</strong><span id="tip2" class="tip"><strong>Clue:</strong> Note that you are being asked to change your password yourself.<br>There are no threats about lost access or requests for your password or other personal information.</span></p>

<p>If you changed your UMICH password on or after April 11, you do not need to change it again. In addition, faculty who receive this email may wait until after term end to change their password. Faculty who opt to wait will receive another UMICH password change email on May 8.</p>

<ol>
	<li>Begin by visiting <a href="http://safecomputing.umich.edu/heartbleed/pwdchangetips.php" id="3link2" aria-describedby="tip3" class="LinkAnchor DoNotOpen">UMICH Password Change Tips</a><span id="tip3" class="tip"><strong>Clue:</strong> This is a legitimate U-M URL. It takes you to a page with tips and information about changing your UMICH password. It gives you information you need to take action. It does not ask for personal information.</span> for information about updating mobile devices and more. Here you will find a direct link to the Change UMICH Password webpage, or you can search the web for "Change UMICH Password." You can set security questions to let you reset your UMICH password yourself if you forget it later. If you don't want to set questions, you can close your web browser after changing your password.</li>
	<li>Contact the <a href="http://its.umich.edu/help/" id="3link3" aria-describedby="tip4" class="LinkAnchor DoNotOpen">ITS Service Center</a><span id="tip4" class="tip"><strong>Clue:</strong> You are directed to a U-M phone number you can call if you have questions or want to verify the authenticity of the message. If you search the U-M website for "ITS Service Center," you will find contact information you can verify. This is a legitimate U-M help desk with real people who can answer your questions.</span> at 734-764-HELP (764-4357), if you have questions or need help changing your password.</li>
</ol>

<p><strong>Concerned About the Authenticity of this Email?</strong></p>

<p id="sotrue" aria-describedby="tip5" tabindex="0" class="LinkAnchor DoNotOpen">This email request is not a phishing attempt. U-M will NEVER ask you to provide your UMICH password in email. Instead, U-M is asking you to change your password yourself. <span id="tip5" class="tip"><strong>Clue:</strong> So true. U-M will never ask you to provide or validate your password in email.</span></p>

<p>To verify the authenticity of this message, visit the Heartbleed Bug page on the U-M Safe Computing website: <a href="http://safecomputing.umich.edu/heartbleed/" id="3link4" aria-describedby="tip6" class="LinkAnchor DoNotOpen">http://safecomputing.umich.edu/heartbleed/</a>. <span id="tip6" class="tip"><strong>Clue:</strong> This is a legitimate U-M URL. And the page provides you with information rather than asking you to provide your password or your personal information.</span> You will see a Quick Link to an archive of all the emails we are sending.</p>          
                             

            </div>    
















<?php elseif($here == "3/whatif") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 2 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
     

<p>This message was went in 2014 to urge members of the U-M community to change their passwords as a precaution because of the Heartbleed bug.</p>

<p>Note that it told people to change their passwords themselves. It did not ask for passwords or personal information.</p>
















<?php elseif($here == "4" || $here == "4/submit") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 3 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
            
        
          <div style="margin-bottom:19px">

 			
            <?php if (strpos($here, 'submit')) {echo $mousetext;} ?>
            

            <div class="center-block" style="position:relative;background:#fff;padding:1em;">


<p><span id="from4" aria-describedby="4tip1" tabindex="0" class="LinkAnchor DoNotOpen"><strong>From:</strong> Jensen, Barbara &lt;mailto:bjensen@alumni.umich.edu&gt;</span>
<span id="4tip1" class="tip"><strong>Clue:</strong> Do you know this person? Are you expecting them to share a document with you?<br>If not, contact them and check.</span>

<br />
<strong>Subject:</strong> NOTICE: View shared document</p>

<div style="padding: 5px; line-height: 1.5; max-width: 650px; background-color: #dbf0cc;">
<div style="line-height: 1.5; padding-bottom: 4px; font-weight: bold; margin-top: 0px;">
<table style="margin-top: 1px; display: inline;">
<tbody>
<tr>
<td style="padding: 0px 5px 0px 0px; text-align: center;" width="32" height="35">&nbsp;</td>
<td style="padding: 0px;" valign="middle" height="32" id="grammar4" aria-describedby="tip2" tabindex="0" class="LinkAnchor DoNotOpen">You have a pending incoming Doc shared with you via Google doc. I have shared an important document login your username to view. <span id="tip2" class="tip" style="font-weight:normal;"><strong>Clue:</strong> Note the awkward grammar here. Also, legitimate Google Document invitations do not ask you to log in to view. Compare this to legitimate Google Doc invitations that you have received in the past.</span></td>
</tr>
</tbody>
</table>
</div>
<div style="padding: 10px 7px 7px; line-height: 1.5; font-size: 13px; margin-top: 0px; background-color: #ffffff;">Click to:&nbsp;<span style="padding-bottom: 4px; font-size: 14px; font-weight: bold; margin-top: 0px; min-height: 36px;"><a style="line-height: 1.5; margin-top: 0px; color: #0066cc;" href="http://www.ishraqi.com/images/body/dropbox/dropbox/dropbox" aria-describedby="tip3" id="4link1" class="LinkAnchor DoNotOpen">REVIEW DOC</a></span> <span id="tip3" class="tip"><strong>Clue:</strong> This is not how Google refers to Google Documents. Google lists the document name. Look at the actual URL for this link (revealed below when you hover over it). This is not a Google URL.</span>&nbsp;<br /><br /><span style="color: #898989;">Google Docs makes it easy to create, store and share online documents, spreadsheets and presentations.</span></div>
</div>       
                             

            </div>    










<?php elseif($here == "4/whatif") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 3 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
<p>If you clicked the link in the email, you would be taken to the page shown here. If you logged in, your password would be stolen, and your U-M account could be compromised.</p>
        <img src="/main/phishing_alerts/images/2016-03-30-1.jpg" alt="Enter your email and password." class="img-responsive center-block">
        
        
        
        
        
        




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
















<?php elseif($here == "5" || $here == "5/submit") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 4 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
            
        
          <div style="margin-bottom:19px">

 			
            <?php if (strpos($here, 'submit')) {echo $mousetext;} ?>
<p><span id="from4" aria-describedby="4tip1" tabindex="0" class="LinkAnchor DoNotOpen"><strong>From:</strong> UMHS &lt;<a href="mailto:info@med.umich.edu"aria-describedby="tip1" id="5link1" class="LinkAnchor DoNotOpen">info@med.umich.edu</a><span id="tip1" class="tip"><strong>Clue:</strong> This is not a valid UMHS address. This is not a valid UMHS address. UMHS Outlook/Exchange users can check addresses in the Global Address List by typing the address in the address bar in Outlook.</span>&gt;
</span>


<br />
<span id="staffportal" aria-describedby="5tip2" tabindex="0" class="LinkAnchor DoNotOpen"><strong>Subject:</strong> Message from staff portal</span><span id="5tip2" class="tip"><strong>Clue:</strong> The Health System does not have anything called "staff portal." You can search UMHS websites to check the accuracy of service and other names.</span></p>
            

            <div class="center-block" style="position:relative;background:#fff;padding:1em;">
<p id="5grammar1" aria-describedby="5tip3" tabindex="0" class="LinkAnchor DoNotOpen" style="margin-bottom:15px;">You have new important message from the Staff portal</p>
<span id="5tip3" class="tip" style="width:310px;margin-top:0;"><strong>Clue:</strong> Note the capitalization error - Staff should not have a capital "S" - and the lack of a period at the end of the sentence.</span>
<p><a href="http://trielogestao.com.br/build/email.med.umich.edu/email.med.umich.edu.htm" aria-describedby="5tip4" id="5link2" class="LinkAnchor DoNotOpen">Click here to read</a> <span id="5tip4" class="tip" style="width:310px;margin-top:0;"><strong>Clue:</strong> Hover over the link - or tab to it - to reveal the actual URL. The URL begins with trielogestao.com.br/build/. It is clearly not a <nobr>U-M</nobr> URL.</span></p>

<p id="5sig1" aria-describedby="5tip5" tabindex="0" style="margin-bottom:15px;">Thank you <br />University of Michigan Health System <br />All rights reserved.</p>
<span id="5tip5" class="tip" style="width:310px;margin-top:0;"><strong>Clue:</strong> UMHS emails are not signed this way. Instead, emails are typically signed by individuals or teams.</span>                             

            </div>    



<?php elseif($here == "5/whatif") : ?>
<div class="WelcomeText" id="InstructionsDIV" style="margin-top:40px;">
          
          <h1>Email 4 of 4<?php echo $subtext; ?></h1>
  
<?php 
 	echo $marker;
?>  
<p>If you clicked the link in the email, you would be taken to the page shown here. This looks like the UMHS login page, but the URL is not a UMHS URL. If you logged in with your Level-2 password, your UMHS account could be compromised. </p>
        <img src="/main/phishing_alerts/images/2016-08-09-2.jpg" alt="UMHS Fake Login page" class="img-responsive center-block">













<?php elseif($here == "thankyou") : ?>
<h1>Thanks For Playing!</h1>

        <h2>Stay Alert</h2>
        <p>Stay alert, and you won't be tricked by phishing emails.</p>

        <ul>
          <li>Check your own email for clues that indicate phishing attempts.</li>
          <li>Don't click suspicious links.</li>
          <li>Don't open suspicious documents, files, or attachments.</li>
        </ul>

        <h2>If You Get Caught</h2>
        <p>If you get caught, take action immediately to minimize the damage.</p>

        <ul>
          <li>Change your UMICH password</li>
          <li>Contact the ITS Service Center (<a href="mailto:4help@umich.edu">4help@umich.edu</a>) to report the incident so your U-M account can be checked for signs of compromise.</li>
        </ul>



    <div class="row" style="margin-bottom:40px;margin-top:20px">
      <div class="col-xs-2">
      </div>
      <div class="col-xs-4" >
        <a id="ReviewButton" class="btn btn-lg center-block  btn-primary <?php echo $disabled; ?>  btn-answer" type="submit" href="/be-aware/phishing-and-suspicious-email/dont-fall-for-phish/" style="width:180px;">Play Again</a>
      </div>
      <div class="col-xs-4">
        <a id="ContinueButton" class="btn btn-lg center-block btn-primary <?php echo $disabled; ?> btn-answer" type="submit" href="/" style="width:150px;">Quit</a>
      </div>
      <div class="col-xs-2">
      </div>
    </div>



 
  

<?php endif; ?>





<?php 
if ($isquestion == "yes") : 
?>  
<?php if ($disabled !== 'disabled') : ?>  
<p style="margin-top:1em;">Is this email a phish?</p>            
  <?php endif; ?>          
          </div>
        
      </div>


<form id="PretestForm" action="<?php echo $next; ?>" method="post">
    <input type="hidden" name="question" id="question" value="<?php echo substr($getvar,0,1); ?>">
    <input type="hidden" name="answer" id="answer" value="0">

<?php if ($disabled !== 'disabled') : ?>     
    <div class="row" style="margin-bottom:40px">
      <div class="col-xs-3">
      </div>
      <div class="col-xs-2">
        <button id="YesButton" class="btn btn-lg center-block  btn-success <?php echo $disabled; ?>  btn-answer" type="submit">Yes</button>
      </div>
      <div class="col-xs-2">
      </div>
      <div class="col-xs-2">
        <button id="NoButton" class="btn btn-lg center-block btn-danger <?php echo $disabled; ?> btn-answer" type="submit">No</button>
      </div>
      <div class="col-xs-3">
      </div>
    </div>
<?php endif; ?>
    
<?php if (strpos($here, 'submit') !== FALSE) : ?>  
    <div class="row AnswerDescription">
      <div class="col-xs-2">
      </div>
      <div class="col-xs-8">
      
        <button id="Continue" class="btn btn-lg btn-success center-block" type="submit">Continue</button>
      </div>
      <div class="col-xs-2">
      </div>
    </div>
    
    
    
<?php endif; ?>

  </form>  



<?php elseif (strpos($here, 'whatif') !== FALSE) : ?>      
          </div>
        
      </div>

    <div class="row" style="margin-bottom:40px;margin-top:20px">
      <div class="col-xs-2">
      </div>
      <div class="col-xs-4" >
        <a id="ReviewButton" class="btn btn-lg center-block  btn-primary <?php echo $disabled; ?>  btn-answer" type="submit" href="<?php echo $review; ?>" style="width:180px;">Review the Clues</a>
      </div>
      <div class="col-xs-4">
        <a id="ContinueButton" class="btn btn-lg center-block btn-success <?php echo $disabled; ?> btn-answer" type="submit" href="<?php echo $next; ?>" style="width:150px;">Continue</a>
      </div>
      <div class="col-xs-2">
      </div>
    </div>


<?php endif; ?>






<?php echo $questionend; ?>






<!-- END TEMPLATE -->		        
        
        
        
        
        
        
        
        
      
      


        </div>
        <div class="row">
          <br><br>
        </div>
      </div>
      

      <div class="navbar navbar-inverse navbar-fixed-bottom">
        <p>&copy; University of Michigan <?php echo date("Y"); ?></p>
      </div>

    </div>
    <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
   
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- <script src="bootstrap-3.3.6-dist/js/docs.min.js"></script> -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="resources/ie10-viewport-bug-workaround.js"></script>

    <script src="resources/jquery.mCustomScrollbar.concat.min.js"></script>

  

  

    <script type="text/javascript">
      (function($){
          $(window).load(function(){
              $(".transBackground").mCustomScrollbar({
                scrollButtons:{enable:true},
                theme:"3d",
                scrollbarPosition:"outside"
              });

        

          });
      })(jQuery);
    </script>

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>





<script>
// open the dialog 
$(document).ready(function(){

//disable phish link clicking	
$("#from, #from2, #from4, #link4, #link1, #3link2, #3link3, #3link4, #4link1, #2link4, #5link1, #5link2").click(function( event ) {event.preventDefault()});
	

	 $("#tip1").addClass("hidden");
	 
  $("#from").focus(function(){
		$("#tip1").removeClass("hidden");
		
  });
    $("#from").mouseover(function(){
		$("#tip1").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#from").blur(function(){
		$("#tip1").addClass("hidden");
  });
  
    $("#from").mouseleave(function(){
		$("#tip1").addClass("hidden");
  });
		
		$("#from").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip1").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });
  
  



	 $("#tip2").addClass("hidden");
	 
  $("#subject").focus(function(){
		$("#tip2").removeClass("hidden");
		
  });
    $("#subject").mouseover(function(){
		$("#tip2").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#subject").blur(function(){
		$("#tip2").addClass("hidden");
  });
  
    $("#subject").mouseleave(function(){
		$("#tip2").addClass("hidden");
  });
		
		$("#subject").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip2").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  





	 $("#tip3").addClass("hidden");
	 
  $("#gbs").focus(function(){
		$("#tip3").removeClass("hidden");
		
  });
    $("#gbs").mouseover(function(){
		$("#tip3").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#gbs").blur(function(){
		$("#tip3").addClass("hidden");
  });
  
    $("#gbs").mouseleave(function(){
		$("#tip3").addClass("hidden");
  });
		
		$("#gbs").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip3").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  
  
  
  
  
  
  
  

	 $("#tip4").addClass("hidden");
	 
  $("#link4").focus(function(){
		$("#tip4").removeClass("hidden");
		
  });
    $("#link4").mouseover(function(){
		$("#tip4").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#link4").blur(function(){
		$("#tip4").addClass("hidden");
  });
  
    $("#link4").mouseleave(function(){
		$("#tip4").addClass("hidden");
  });
		
		$("#link4").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip4").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
    
  
  
  
  




	 $("#tip5").addClass("hidden");
	 
  $("#fakedept").focus(function(){
		$("#tip5").removeClass("hidden");
		
  });
    $("#fakedept").mouseover(function(){
		$("#tip5").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#fakedept").blur(function(){
		$("#tip5").addClass("hidden");
  });
  
    $("#fakedept").mouseleave(function(){
		$("#tip5").addClass("hidden");
  });
		
	$("#fakedept").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip5").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });    
  
//moving addClass("hidden"); up so things stay hidden

$("#2tip1").addClass("hidden");
$("#2tip2").addClass("hidden");
$("#2tip4").addClass("hidden");
$("#2tip5").addClass("hidden");
$("#tip3").addClass("hidden");
$("#tip4").addClass("hidden");  
$("#tip5").addClass("hidden");  
$("#tip6").addClass("hidden");
$("#4tip1").addClass("hidden");
$("#tip9").addClass("hidden");
$("#5tip2").addClass("hidden");
$("#5tip3").addClass("hidden");
$("#5tip4").addClass("hidden");
$("#5tip5").addClass("hidden");


<?php if (strpos($here, 'submit')) : ?>
//Q2


  $("#from2").focus(function(){
		$("#2tip1").removeClass("hidden");
		
  });
    $("#from2").mouseover(function(){
		$("#2tip1").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#from2").blur(function(){
		$("#2tip1").addClass("hidden");
  });
  
    $("#from2").mouseleave(function(){
		$("#2tip1").addClass("hidden");
  });
		
		$("#from2").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#2tip1").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });




	 
  $("#grammar").focus(function(){
		$("#2tip2").removeClass("hidden");
		
  });
    $("#grammar").mouseover(function(){
		$("#2tip2").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#grammar").blur(function(){
		//$("#tip2").attr("aria-hidden","true");
		$("#2tip2").addClass("hidden");
  });
  
    $("#grammar").mouseleave(function(){
		$("#2tip2").addClass("hidden");
  });
		
		$("#grammar").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#2tip2").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 
  
  
  
  
	 //$("#tip2").attr("aria-hidden","true");
	 
	 
  $("#verification").focus(function(){
		$("#tip3").removeClass("hidden");
		
  });
    $("#verification").mouseover(function(){
		$("#tip3").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#verification").blur(function(){
		$("#tip3").addClass("hidden");
  });
  
    $("#verification").mouseleave(function(){
		$("#tip3").addClass("hidden");
  });
		
		$("#verification").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip3").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 
  
  

	 
	 
  $("#emc").focus(function(){
		$("#tip9").removeClass("hidden");
		
  });
    $("#emc").mouseover(function(){
		$("#tip9").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#emc").blur(function(){
		$("#tip9").addClass("hidden");
  });
  
    $("#emc").mouseleave(function(){
		$("#tip9").addClass("hidden");
  });
		
		$("#emc").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip9").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });   
 
 
 
 
 
 
 
   $("#2link4").focus(function(){
		$("#2tip4").removeClass("hidden");
		
  });
    $("#2link4").mouseover(function(){
		$("#2tip4").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#2link4").blur(function(){
		$("#2tip4").addClass("hidden");
  });
  
    $("#2link4").mouseleave(function(){
		$("#2tip4").addClass("hidden");
  });
		
		$("#2link4").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#2tip4").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
 
 
 
 
 
 


	 
  $("#fakedept2").focus(function(){
		$("#2tip5").removeClass("hidden");
		
  });
    $("#fakedept2").mouseover(function(){
		$("#2tip5").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#fakedept2").blur(function(){
		$("#2tip5").addClass("hidden");
  });
  
    $("#fakedept2").mouseleave(function(){
		$("#2tip5").addClass("hidden");
  });
		
		$("#fakedept2").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#2tip5").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });   
 
 
 
 
 
 
 
 
//Q3
	 
	 
  $("#link1").focus(function(){
		$("#tip1").removeClass("hidden");
		
  });
    $("#link1").mouseover(function(){
		$("#tip1").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#link1").blur(function(){
		$("#tip1").addClass("hidden");
  });
  
    $("#link1").mouseleave(function(){
		$("#tip1").addClass("hidden");
  });
		
		$("#link1").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip1").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 
  
  
  
	 
	 
  $("#yourself").focus(function(){
		$("#tip2").removeClass("hidden");
		
  });
    $("#yourself").mouseover(function(){
		$("#tip2").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#yourself").blur(function(){
		$("#tip2").addClass("hidden");
  });
  
    $("#yourself").mouseleave(function(){
		$("#tip2").addClass("hidden");
  });
		
		$("#yourself").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip2").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  
  
  
  
	 
	 
  $("#3link2").focus(function(){
		$("#tip3").removeClass("hidden");
		
  });
    $("#3link2").mouseover(function(){
		$("#tip3").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#3link2").blur(function(){
		$("#tip3").addClass("hidden");
  });
  
    $("#3link2").mouseleave(function(){
		$("#tip3").addClass("hidden");
  });
		
		$("#3link2").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip3").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  

  

	 
  $("#3link3").focus(function(){
		$("#tip4").removeClass("hidden");
		
  });
    $("#3link3").mouseover(function(){
		$("#tip4").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#3link3").blur(function(){
		$("#tip4").addClass("hidden");
  });
  
    $("#3link3").mouseleave(function(){
		$("#tip4").addClass("hidden");
  });
		
		$("#3link3").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip4").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  
  

	 
  $("#sotrue").focus(function(){
		$("#tip5").removeClass("hidden");
		
  });
    $("#sotrue").mouseover(function(){
		$("#tip5").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#sotrue").blur(function(){
		$("#tip5").addClass("hidden");
  });
  
    $("#sotrue").mouseleave(function(){
		$("#tip5").addClass("hidden");
  });
		
		$("#sotrue").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip5").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  

	 
  $("#3link4").focus(function(){
		$("#tip6").removeClass("hidden");
		
  });
    $("#3link4").mouseover(function(){
		$("#tip6").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#3link4").blur(function(){
		$("#tip6").addClass("hidden");
  });
  
    $("#3link4").mouseleave(function(){
		$("#tip6").addClass("hidden");
  });
		
		$("#3link4").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip6").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  
  
  
//Q4  

  $("#from4").focus(function(){
		$("#4tip1").removeClass("hidden");
		
  });
    $("#from4").mouseover(function(){
		$("#4tip1").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#from4").blur(function(){
		$("#4tip1").addClass("hidden");
  });
  
    $("#from4").mouseleave(function(){
		$("#4tip1").addClass("hidden");
  });
		
		$("#from4").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#4tip1").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });



  $("#grammar4").focus(function(){
		$("#tip2").removeClass("hidden");
		
  });
    $("#grammar4").mouseover(function(){
		$("#tip2").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#grammar4").blur(function(){
		$("#tip2").addClass("hidden");
  });
  
    $("#grammar4").mouseleave(function(){
		$("#tip2").addClass("hidden");
  });
		
		$("#grammar4").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip2").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 
  
  
  

  
  $("#4link1").focus(function(){
		$("#tip3").removeClass("hidden");
		
  });
    $("#4link1").mouseover(function(){
		$("#tip3").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#4link1").blur(function(){
		$("#tip3").addClass("hidden");
  });
  
    $("#4link1").mouseleave(function(){
		$("#tip3").addClass("hidden");
  });
		
		$("#4link1").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip3").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  
  
  
  
  
  
  
//Q5
  $("#5link1").focus(function(){
		$("#tip1").removeClass("hidden");
		
  });
    $("#5link1").mouseover(function(){
		$("#tip1").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#5link1").blur(function(){
		$("#tip1").addClass("hidden");
  });
  
    $("#5link1").mouseleave(function(){
		$("#tip1").addClass("hidden");
  });
		
		$("#5link1").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#tip1").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 
  
  


  $("#5link2").focus(function(){
		$("#5tip4").removeClass("hidden");
		
  });
    $("#5link2").mouseover(function(){
		$("#5tip4").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#5link2").blur(function(){
		$("#5tip4").addClass("hidden");
  });
  
    $("#5link2").mouseleave(function(){
		$("#5tip4").addClass("hidden");
  });
		
		$("#5link2").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#5tip4").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });    
  





  $("#staffportal").focus(function(){
		$("#5tip2").removeClass("hidden");
		
  });
    $("#staffportal").mouseover(function(){
		$("#5tip2").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#staffportal").blur(function(){
		$("#5tip2").addClass("hidden");
  });
  
    $("#staffportal").mouseleave(function(){
		$("#5tip2").addClass("hidden");
  });
		
		$("#staffportal").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#5tip2").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  }); 


  $("#5grammar1").focus(function(){
		$("#5tip3").removeClass("hidden");
		
  });
    $("#5grammar1").mouseover(function(){
		$("#5tip3").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#5grammar1").blur(function(){
		$("#5tip3").addClass("hidden");
  });
  
    $("#5grammar1").mouseleave(function(){
		$("#5tip3").addClass("hidden");
  });
		
		$("#5grammar1").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#5tip3").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });  


  $("#5sig1").focus(function(){
		$("#5tip5").removeClass("hidden");
		
  });
    $("#5sig1").mouseover(function(){
		$("#5tip5").removeClass("hidden");
  });
   // repeat for the keyboard accessibility for all buttons, enter makes it click...
		 $("#5sig1").blur(function(){
		$("#5tip5").addClass("hidden");
  });
  
    $("#5sig1").mouseleave(function(){
		$("#5tip5").addClass("hidden");
  });
		
		$("#5sig1").keydown(function(ev){
		if (ev.which ==27)  {
						 $("#5tip5").addClass("hidden");
						 ev.preventDefault(); 
						 return false;
						 }
  });    
   
  




           
<?php endif; ?>
});
 </script>
<!--end schleif additions-->


  <!-- JavaScript code for this project -->
  <script>
    $(document).ready(function(){


      $( "#NoButton" ).click(function( event ) {
        // Stop form from submitting normally
        event.preventDefault();

        if (!$(this).hasClass("disabled")) {
          // Get some values from elements on the page:
          $("#answer").val(0);

          $( "#PretestForm" ).submit();
        }
      });

      $( "#YesButton" ).click(function( event ) {
        // Stop form from submitting normally
        event.preventDefault();

        if (!$(this).hasClass("disabled")) {
          // Get some values from elements on the page:
          $("#answer").val(1);

          $( "#PretestForm" ).submit();
        }
      });	  
	  



      $(".LinkAnchor").mousedown(function(event) {
          switch (event.which) {
              case 1:
                  event.preventDefault();
                  var url = $(this).attr('href');
                  $("#questionclicked").val("1");
                  // window.location.href = url;
                  if (!$(this).hasClass("DoNotOpen")) {
                    window.open(url, '_blank');
                  }
                  break;
              default:
                  $("#questionrightclicked").val("1");
          }
      });
      $(".LinkAnchor").hover(
        function(){       
          $(this).data('inTime', new Date().getTime());
          $("#questionhovered").val("1");
        },    
        function(){       
          var outTime = new Date().getTime();       
          var hoverTime = (outTime - $(this).data('inTime'))/1000;        
          $("#questionhoveredseconds").val(hoverTime);
        });
    });
  </script>
<?php include "../ga.php"; ?>


  </body>
</html>