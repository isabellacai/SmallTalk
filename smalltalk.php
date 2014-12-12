<?php

require_once 'chatterbotapi.php';

session_start();

$body = $_REQUEST['Body'];

// Get the session:
$session = $_SESSION["session"];
if (!$session) 
{
	// Create a session:
	$factory = new ChatterBotFactory();
	$robot = $factory->create(ChatterBotType::CLEVERBOT);
	$session = $robot->createSession();
}

// Think:
$thought = $session->think($body);
if (strpos(strtolower($thought), "clever") !== false) 
{
	$thought = $session->think($body);
}

// Save the session:
$_SESSION["session"] = $session;

// Wait:
list($usec, $sec) = explode(' ', microtime());
srand((float) $sec + ((float) $usec * 100000));
sleep(rand(2,5));

// Print the header:
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
    <Message><?php echo $thought; ?></Message>
</Response>