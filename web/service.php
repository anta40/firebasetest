<?php
	require_once 'firebase.php';
    require_once 'push.php';

	$firebase = new Firebase();
    $push = new Push();

    // optional payload
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';

    // notification title
    $title = isset($_POST['title']) ? $_POST['title'] : '';
        
    // notification message
    $message = isset($_POST['message']) ? $_POST['message'] : '';
        
    // push type - single user / topic
    $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        
    // whether to include to image or not
    //$include_image = isset($_POST['include_image']) ? TRUE : FALSE;
	$include_image = '';
	
    $push->setTitle($title);
    $push->setMessage($message);
	$push->setIsBackground(FALSE);
    $push->setPayload($payload);

	$json = '';
    $response = '';

    if ($push_type == 'topic') {
        $json = $push->getPush();
        $response = $firebase->sendToTopic('news', $json);
    } 
	else if ($push_type == 'individual') {
		$json = $push->getPush();
        $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
        $response = $firebase->send($regId, $json);
    }
	
	if ($json != '') echo json_encode($json);
	if ($response != '') echo json_encode($response);
?>