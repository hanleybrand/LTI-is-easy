<?php

require_once __DIR__ . '/vendor/autoload.php';

    use IMSGlobal\LTI\ToolProvider;
    use DebugBar\StandardDebugBar;

    class ImsToolProvider extends ToolProvider\ToolProvider {

        function onLaunch() {

            // Initialise the user session
            $_SESSION['userId'] = $this->user->getId();
            $_SESSION['isInstructor'] = $this->user->isStaff();
            $_SESSION['firstname'] = $this->user->firstname;
            $_SESSION['lastname'] = $this->user->lastname;
            $_SESSION['consumerKey'] = $this->resourceLink->getKey();
            $_SESSION['resourceLinkId'] = $this->resourceLink->getId();

            $this->redirectUrl = 'welcome.php';

        }

        function onError() {

            $this->isOK = empty($this->returnUrl);
            $this->redirectUrl = 'error.php';

            return false;

        }

    }


    ini_set('display_errors', 'On');
error_reporting(E_ALL);
    $page_title = "LTI PROVIDER (BASIC)";
$debuggin_out = true;


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
</head>
<body>
<h1>Hi There!</h1>

<?php


  // Cancel any existing session
  session_start();
  $_SESSION = array();
  session_destroy();
  session_start();

  $db = new PDO(DB_NAME, DB_USERNAME, DB_PASSWORD);  // Database constants not defined here
  $data_connector = ToolProvider\DataConnector\DataConnector::getDataConnector(DB_TABLENAME_PREFIX, $db);
  $tool = new ImsToolProvider($data_connector);
  $tool->setParameterConstraint('user_id');
  $tool->setParameterConstraint('roles');
  $tool->handleRequest();

?>



</body>