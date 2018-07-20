<?php

    require_once '../vendor/autoload.php';
    require_once '../ims-blti/blti.php';

    class LTIAck extends Exception
    {
    }

    $page_title = "BLTI Basic Launch";

    $debuggin_out = true;
    if (!empty($debuggin_out) AND $debuggin_out) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/dbgr.php");
        $page_title =  "$page_title - DEBUG";
    }


    if ($_POST) {
        dbb_msg("POST == TRUE");

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $lti = new BLTI("ltiiseasy", true, false);

        if ($lti->valid) {
            dbb_msg($lti->valid);
            session_start();
            if (isset($debuggin_out) and isset($debugbarRenderer)) {
                $user_id = $_POST['lis_person_sourcedid'];
                dbb_msg(["user_id" => $user_id]);
            } else {
                dbb_msg(["user_id" => false]);
            }
            $h1 = "Hey, it's a LTI LAUNCH!";


        } else {
            $err = $lti->message;
            $h1 = "Rats, it didn't work!";
            dbb_msg($err);
        }
    } else {
        $h1 = "Now try <a href='lti_launch_basic.php'>via POST</a>";
        dbb_msg("POST == FALSE");
    }


    $head = <<< EOD
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>$page_title</title>
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/jquery-ui-foundation/jquery-ui.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/foundation/foundation-icons/foundation-icons.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/foundation/css/foundation.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/css/dataTables.foundation.min.css">
<link rel="stylesheet" href="https://academicapps.temple.edu/libs/DataTables/extensions/Buttons/css/buttons.foundation.css">
EOD;

    $jabbscripts = <<< EOD
<script src="https://academicapps.temple.edu/libs/foundation/js/vendor/jquery.js"></script>
<script src="https://academicapps.temple.edu/libs/foundation/js/vendor/foundation.min.js"></script>

<script>
    $(document).foundation();
</script>
EOD;

    echo $head;
    echo "</head> <h1>$h1</h1><body>";


    if (isset($debuggin_out) and isset($debugbarRenderer)) {

    }


    if (isset($debuggin_out)) {
        echo $debugbarRenderer->renderHead();
    }

    if (isset($debuggin_out) and isset($debugbarRenderer)) {
        echo $debugbarRenderer->render();
    }


//    include 'tmpl_foundation_end.html';
//
    echo $jabbscripts;

    //post script loading stuff here


    echo "</body></html>";


    //echo($_SESSION['AUTOMATT']);

    //    array (size=42)
    //  'oauth_consumer_key' => string 'academicapps' (length=12)
    //  'oauth_signature_method' => string 'HMAC-SHA1' (length=9)
    //  'oauth_timestamp' => string '1498598000' (length=10)
    //  'oauth_nonce' => string 'aBbwBScxSnp9hpLPGBQ9QK9SD8wMGnjYiQYmARU' (length=39)
    //  'oauth_version' => string '1.0' (length=3)
    //  'context_id' => string 'a30b4a512c6b941558465b3ee08874a58c1b2e78' (length=40)
    //  'context_title' => string 'Temple University' (length=17)
    //  'custom_canvas_account_id' => string '1' (length=1)
    //  'custom_canvas_account_sis_id' => string '' (length=0)
    //  'custom_canvas_api_domain' => string 'templeu.instructure.com' (length=23)
    //  'custom_canvas_enrollment_state' => string '$Canvas.enrollment.enrollmentState' (length=34)
    //  'custom_canvas_user_id' => string '15' (length=2)
    //  'custom_canvas_user_image' => string '$Canvas.user.image' (length=18)
    //  'custom_canvas_user_login_id' => string 'phanley' (length=7)
    //  'custom_canvas_user_uuid' => string 'r666AdW8EmYtIgv70dBTeu3k1lVmTCe7mw9rjRb8' (length=40)
    //  'custom_debug' => string 'True' (length=4)
    //  'custom_user_sis_id' => string 'phanley' (length=7)
    //  'ext_roles' => string 'urn:lti:instrole:ims/lis/Administrator,urn:lti:instrole:ims/lis/Instructor,urn:lti:instrole:ims/lis/Student,urn:lti:sysrole:ims/lis/User' (length=136)
    //  'launch_presentation_document_target' => string 'iframe' (length=6)
    //  'launch_presentation_height' => string '400' (length=3)
    //  'launch_presentation_locale' => string 'en' (length=2)
    //  'launch_presentation_return_url' => string 'https://templeu.instructure.com/accounts/1/external_content/success/external_tool_redirect' (length=90)
    //  'launch_presentation_width' => string '800' (length=3)
    //  'lis_person_contact_email_primary' => string 'phanley@temple.edu' (length=18)
    //  'lis_person_name_family' => string 'Hanley' (length=6)
    //  'lis_person_name_full' => string 'Peter M. Hanley' (length=15)
    //  'lis_person_name_given' => string 'Peter M.' (length=8)
    //  'lis_person_sourcedid' => string 'phanley' (length=7)
    //  'lti_message_type' => string 'basic-lti-launch-request' (length=24)
    //  'lti_version' => string 'LTI-1p0' (length=7)
    //  'oauth_callback' => string 'about:blank' (length=11)
    //  'resource_link_id' => string 'a30b4a512c6b941558465b3ee08874a58c1b2e78' (length=40)
    //  'resource_link_title' => string 'LMS Tools' (length=9)
    //  'roles' => string 'urn:lti:instrole:ims/lis/Administrator' (length=38)
    //  'tool_consumer_info_product_family_code' => string 'canvas' (length=6)
    //  'tool_consumer_info_version' => string 'cloud' (length=5)
    //  'tool_consumer_instance_contact_email' => string 'notifications@instructure.com' (length=29)
    //  'tool_consumer_instance_guid' => string 'ndqgwsoafylHTTXdvHbgAfcLstsHCInrvmRfjLzU:canvas-lms' (length=51)
    //  'tool_consumer_instance_name' => string 'Temple University' (length=17)
    //  'user_id' => string 'bcd538aa0247dd82952e079bcd92c1637d073357' (length=40)
    //  'user_image' => string 'https://secure.gravatar.com/avatar/d2ab8bebe1da7969bf3fa6c1db8b9587?s=128&d=identicon' (length=85)
    //  'oauth_signature' => string 'Seo3i6kBzYaX2PV4b9eXbtxsaTc=' (length=28)