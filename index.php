<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	
	session_start();
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$startapp 			= $json->result->parameters->startapp;
	$firstname 			= $json->result->parameters->firstname;
	$lastname 			= $json->result->parameters->lastname;
	$age 				= $json->result->parameters->age;
	$householdincome 	= $json->result->parameters->householdincome;
	$householdnumber 	= $json->result->parameters->householdnumber;
	$applicationnumber  = "1 1 2 2 3 4 5 1";
	
	
	if(isset($startapp) && ($startapp=="YES" || $startapp=="yes" )  )
	{
		$speech = "Great, please tell me your first Name?";
	}
	else if(isset($firstname))
	{
		$speech = "Got it".' '.$firstname.' '."what is your last Name?";
		$_SESSION["firstname"]=$firstname;
		setcookie('firstname', $firstname, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	
	else if(isset($lastname))
	{
		$speech = "What is your age?".' '.$_COOKIE[$firstname];
	}	
	else if(isset($age))
	{
		
		$speech = "Ok".' '.$_COOKIE[$firstname].' '."what is your annual household income?";
		$_SESSION["age"]=$age;
		setcookie('age', $age, time() + (86400 * 30), "/"); // 86400 = 1 day
		
	}
	else if(isset($householdincome))
	{
		
		$speech = "how many members do you have  in your household, including you?";
		$_SESSION["householdincome"]=$householdincome;
		setcookie('householdincome', $householdincome, time() + (86400 * 30), "/"); // 86400 = 1 day
		
	}
	else if(isset($householdnumber))
	{
		$speech	= "Thanks".' ' .$_SESSION["firstname"].' '. "based on the information provided by you, you have a".' ' .$_SESSION["householdnumber"]."member household with".' ' . $_SESSION["householdincome"].' ' ."$ annual income, Your application has been created, for future references, your application number is".$applicationnumber. "Someone from our office will connect with you soon. Have a great day ahead!";
		
	}
	else{
	
		$speech = "Sorry, I didnt get that. Please ask me something else.";
	
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>