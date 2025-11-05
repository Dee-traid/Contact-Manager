<?php

$jsonFile =  'data.json';
$Json_file = 'password.json';

function loadContact($jsonFile){
	if (file_exists($jsonFile)){
	$json = file_get_contents($jsonFile);// this is used to get data stored in a file
	$data = json_decode($json, true);// this will then read if the file exist and if data is stored in the file
		return $data ?: [];// this will store the data in an array
}else{
		return[];// if no data it returns an empty array
	}

}


function saveContact($jsonFile, $userDetails) {
    $dir = dirname($jsonFile);
    if (!is_dir($dir)) @mkdir($dir, 0777, true);
    $json = json_encode($userDetails, JSON_PRETTY_PRINT);
    return file_put_contents($jsonFile, $json) !== false;
}

function password($Json_file) {
    $dir = dirname($Json_file);
    if (!is_dir($dir)) @mkdir($dir, 0777, true);
	echo "==================================" .PHP_EOL;
		echo"    Wah gwaan!!  " . PHP_EOL;
	$pass = readline(" | Create a Passowrd: ");
	$confirm_pass = readline(" | Confirm password: ");
	echo "==================================" .PHP_EOL;
	while(true){
	if ($pass === $confirm_pass){
		$data = ['password' => password_hash($pass, PASSWORD_DEFAULT)];
	$json = json_encode($data, JSON_PRETTY_PRINT);
	return file_put_contents($Json_file, $json) !== false;
		exit();
	echo "Welcome Brethren! " . PHP_EOL;
		menu();

  }else {
		echo "Invalid password. Please try again. " .PHP_EOL;
		return password($Json_file);
		}
	}
}


 function authentication($Json_file){
	$Json_file = 'password.json';
	$data = json_decode(file_get_contents($Json_file), true);
	while(true){
	$password = readline(" | Enter your password: ");
	if(password_verify($password, $data['password'])){
		return true;
		menu();
}else{
		echo "Password Incorrect. Try again" . PHP_EOL;
	}	
}

}



function clearScreen() {
    if (strncasecmp(PHP_OS, 'WIN', 3) === 0){
	 system('cls'); 
}else{
 	system('clear');
   }

} 

 function confirm($prompt = "Continue? (y/n): ") {
    while (true) {
        $ans = strtolower(readLine($prompt));
        if (in_array($ans, ['y', 'yes'], true)) return true;
        if (in_array($ans, ['n', 'no'], true)) return false;
        echo "Please answer y or n" . PHP_EOL;
    }
}


//Delete all contact

function confirm_1($prompt = "Do you want to delete? (y/n): ") {
    while (true) {
        $ans = strtolower(readLine($prompt));
        if (in_array($ans, ['y', 'yes'], true)) return true;
        if (in_array($ans, ['n', 'no'], true)) return false;
        echo "Please answer y or n.\n";
    }
}
	function confirm_2($prompt = "Are you sure? (y/n): ") {
	while (true) {
        $ans2 = strtolower(readLine($prompt));
        if (in_array($ans2, ['y', 'yes'], true)) return true;
        if (in_array($ans2, ['n', 'no'], true)) return false;
        echo "Please answer y or n.\n";
    }

}

