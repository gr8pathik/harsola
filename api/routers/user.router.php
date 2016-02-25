<?php

// Get user
$app->get('/user', function () use ($app) {	
	$oLaboratory = new \models\User ();
	$users = $oLaboratory->getUsers();
	$app->contentType('application/json');
	echo json_encode($users);
});

//Create user
$app->post('/user', function () use ($app) {
	$userData = $app->request->post();
	// $user['password'] = hash("sha1", $user['password']);	
	$oUser = new \models\User ();
	if(!$oUser->checkUniqueUser($userData['email'], $userData['phoneNumber'])){
		$userId = $oUser->insertUser($userData);
		echo json_encode(array(
            "status" => true,
            "message" => "User added successfully!",
            'userId' => $userId
        ));
	}else{
		echo json_encode(array(
            "status" => false,
            "message" => "User already exist!"
        ));
	}
});

// LOGIN GET user by email and passwordS
$app->post('/login', function () use ($app) {
	//var_dump($app->request()->post('data'));
	$data = json_decode($app->request()->post('data'), true);
	
	//echo $data['password'];
	$email = $data['email'];
	$pass = hash("sha1", $data['password']);
	//echo "  despues: ".$pass. "   ";

	$oUser = new \models\User();
	
	echo json_encode($oUser->getUserByLogin($email, $pass), true);
});

// PUT route
$app->put('/user', function () {
	echo 'This is a PUT route';
});

// DELETE route
$app->delete('/user', function () {
    echo 'This is a DELETE route';
});