<?php

require_once 'functions.php';

$cls = clearScreen();
$jsonFile = 'data.json';
$uniqueId = uniqid() . random_int(1, 1000); 
$index = 1;

 
password($Json_file);
echo PHP_EOL;

function menu(){
$jsonFile = 'data.json';
$Json_file = 'password.json';
echo "------------------------------" . PHP_EOL;
echo "  Welcome to My Contact Manager! " . PHP_EOL; // first screen

while(true){
	echo "| 1:  List Contacts " .  PHP_EOL;
	echo "| 2:  Add a Contact " .  PHP_EOL;
	echo "| 3:  Delete all Contacts" .  PHP_EOL;
	echo "| 0:  Exit the App " .  PHP_EOL;
	$userInput = readline("Enter an Option: ");
	echo "-----------------------------------" . PHP_EOL;
	
if ($userInput == 1){
	authentication($Json_file);
	listAllContact($jsonFile);

}elseif($userInput == 2 ) {
	add_contact($jsonFile); 

} elseif($userInput == 3){
	authentication($Json_file);
	deleteAllContact($jsonFile);


} elseif($userInput == 0){

	echo "App Closed " . PHP_EOL;
		break;
}else{
	break;
  }

}
$cls = clearScreen();
echo $cls;
echo PHP_EOL;
}

menu();

// add contact
function add_contact($jsonFile){
$uniqueId = uniqid();
while (true){
	$name = readline("| Name: ");
	if (strlen($name) < 3){
	echo "it must have min of 3 character " . PHP_EOL;
		continue;
}else{
		break;
	}

	echo PHP_EOL;

}
while(true){
	$phoneNo = readline ("| Phone Number: "); 
	if (!preg_match('/[\d\s\+\-\(\)]+$/', $phoneNo) || preg_match_all('/\d/', $phoneNo, $length) < 7 ){
	echo "Please enter a valid phone number with at least 7 digits" . PHP_EOL;
		continue;
}else{
		break;
	}
	 echo PHP_EOL;
	
}

while(true){
$email = readline ("| Email(Optional): ") ;
	if ($email == ''){
	   break;
}elseif (!preg_match ('/@/' , $email)){
		echo "Invalid email. " . PHP_EOL;
}else{ 
	   break;
	}
	
}


$country = strtoupper(readline ("| Country/ State of residence(Optional): "));

$note = readline ("| Description(Optional): ");

$confirmation = confirm($prompt = "Continue? (y/n): ");

if ($confirmation){
	$userDetails = loadContact($jsonFile);// this will load the json file 

	$userDetails[] = [
	"id" => $uniqueId,
	"name" => trim($name),
	"country" => trim($country),
	"phoneNo" => $phoneNo,
	"email" => $email,
	"note" => trim($note)
];// stores the details entered in an associative array

 saveContact($jsonFile, $userDetails);
echo "Contact Saved! " . PHP_EOL;
	menu();
	
}else{
		echo "Failed! " . PHP_EOL;
	}

	$cls = clearScreen();
	echo PHP_EOL;
	echo $cls;

	
}




// Delete all contacts

function deleteAllContact($jsonFile){
$cls = clearScreen();
$jsonFile = 'data.json';
$Json_file = 'password.json';
echo "Delete all Contacts. " . PHP_EOL;

$confirm_1 = confirm($prompt = "Do you want to delete? (y/n): ");
$confirm_2 = confirm($prompt = "Are you sure? (y/n): ");

	if( $confirm_1 && $confirm_2 == true){
	 if (file_exists($jsonFile)){
		unlink($jsonFile);
	echo "File Deleted Successfully! " . PHP_EOL;
	authentication($Json_file);
	$cls = clearScreen();
	echo PHP_EOL;
	echo $cls;

	
	menu();		
}else{
	echo "File not found! ";
}

}else{
	echo "Deletion Cancelled " . PHP_EOL;
	$cls = clearScreen();
}
	authentication($Json_file);
	$cls = clearScreen();
	echo PHP_EOL;
	echo $cls;
	menu();
}



// List all contact

function listAllContact($jsonFile){
	$index = 1;
	$data = loadContact($jsonFile);

	if ($data == true){ 
		if (!empty($data)){
		foreach($data as $contact){
		echo  "| ".  $index . " " . $contact['name'] . " (" . $contact['phoneNo'] . ")" . " [" . $contact['country'] . "] " .PHP_EOL;// this is to display the name and phone number of every record in the json file
			$index = $index + 1;// this for auto increment
	}
			
}else{
		echo " -- No record found -- " . PHP_EOL;
	}		
	
}
		echo " | 0 <- Go Back " . PHP_EOL;
		$option = readline(" | Enter an option: ");
		$cls = clearScreen();
		echo PHP_EOL;
		echo $cls;

if ($option == 0){
	menu();
	
}elseif(is_numeric($option) && $option > 0 && $option <= count($data)){
	$option = (int)$option - 1;
	echo PHP_EOL;

}else{
	echo "Invalid option! ";
}

echo PHP_EOL;

if(isset($data[$option])){
	$contact = $data[$option];
	echo "---------------------------------". PHP_EOL;
	echo "| Contact: " . PHP_EOL;
	echo "| id: " . $contact['id'] . PHP_EOL;
	echo "| Name: " . $contact['name'] . PHP_EOL;
	echo "| Phone: " . $contact['phoneNo'] . PHP_EOL;
	echo "| Email: " . $contact['email'] . PHP_EOL;
	echo "| Description: " . $contact['note'] . PHP_EOL;
	echo "---------------------------------". PHP_EOL;
}

	echo PHP_EOL;
		echo "E.  Edit " . PHP_EOL;
		echo "D.  Delete " . PHP_EOL;
		echo "0. <- Go Back " . PHP_EOL;
		$action = readline("Enter an option: ");

	if ($action == 0){
		menu();
}elseif($action == 'E'){
	editContact($jsonFile, $option);

}elseif($action == 'D'){
	delete_contact($jsonFile, $option);
}else{
		echo "Program Closed ";
	}

	$cls = clearScreen();
	echo $cls;
	echo PHP_EOL;
}

// delete contact 	

function delete_contact($jsonFile, $option){
	echo "-----------------------------------" . PHP_EOL;
	$data = loadContact($jsonFile);
		$confirm_1 = confirm($prompt = "Do you want to delete? (y/n): ") . PHP_EOL;
	if(!empty($data)){
		if ($confirm_1){
		if(isset($data[$option])){
		unset($data[$option]);
		$data = array_values($data); 
		$json = json_encode($data, JSON_PRETTY_PRINT);// this is to restore the values that are not deleted back into the json file 
		file_put_contents($jsonFile, $json);
		echo "Contact deleted Successfully!! " . PHP_EOL;

}else{
		echo "File not found" . PHP_EOL;
	}
}else{
		echo "Failed to delete ";
	}

}else{
	echo "Contact not deleted";
}
	echo PHP_EOL;
	echo "-----------------------------------" . PHP_EOL;
}


// edit a contact

function editContact($jsonFile, $option){
	$cls = clearscreen();
	echo "-----------------------------------" . PHP_EOL;
	$data = loadContact($jsonFile);
	if (!empty($data)){
		
		if (isset($data[$option])){
	echo "Press enter to keep current value " . PHP_EOL;
		 
	$data[$option]['name'] = readline("Name (". $data[$option]['name'] ."): ") ?: $data[$option]['name'];

	$data[$option]['phoneNo'] = readline("Phone ( ". $data[$option]['phoneNo'] . "): ") ?: $data[$option]['phoneNo'];
	
	$data[$option]['email'] = readline("Email (" . $data[$option]['email'] ."): ") ?: $data[$option]['email'] ;	
	$data[$option]['note'] = readline("Description (" . $data[$option]['note'] . "): ") ?: $data[$option]['note'];	
	
	$confirm_1 = confirm($prompt = "Do you want to save? (y/n): ") . PHP_EOL;

	if ($confirm_1){
	$json = json_encode($data, JSON_PRETTY_PRINT);
	file_put_contents ($jsonFile, $json);
	echo "-----------------------------------" . PHP_EOL;
		echo "Contact Saved.! ";
}else{
		echo "Invalid option." . PHP_EOL;
	}
}else{
		echo "No contact found! " . PHP_EOL;
	}
	echo PHP_EOL;
}else{
		echo "Contact not saved". PHP_EOL;
	}
		echo $cls;
}