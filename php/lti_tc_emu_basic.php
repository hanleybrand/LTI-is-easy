<?php
    # ------------------------------
    # SRC: https://gist.github.com/matthanger/1171921
    #
    # ------------------------------
    # START CONFIGURATION SECTION
    #

    $launch_url = "http://localhost:8080/basic_launch/lti_launch_db.php";
    $key = "ltiiseasy";
    $secret = "ltiiseasy";

    // LTIISEASY = 122009091905011925
    // ltiiseasy = 122009091905011925

    $launch_data = array(
        "user_id" => "122009091905011925",
        "roles" => "Instructor",
        "resource_link_id" => "1301250205141520051420091805122505011925",
        "resource_link_title" => "LTI IS EASY",
        "resource_link_description" => "More of an assertion than a resource",
        "lis_person_name_full" => "Elti I. Iseasy",
        "lis_person_name_family" => "Iseasy",
        "lis_person_name_given" => "Elti",
        "lis_person_contact_email_primary" => "lti@easy.edu",
        "lis_person_sourcedid" => "ltiiseasy",
        "context_id" => "456434513",
        "context_title" => "Design of Easy Peasy Stuff",
        "context_label" => "LIE101",
        "tool_consumer_instance_guid" => "lmsing.easy.edu",
        "tool_consumer_instance_description" => "University of LMSing"
    );

    #
    # END OF CONFIGURATION SECTION
    # ------------------------------

    $now = new DateTime();

    $launch_data["lti_version"] = "LTI-1p0";
    $launch_data["lti_message_type"] = "basic-lti-launch-request";

    # Basic LTI uses OAuth to sign requests
    # OAuth Core 1.0 spec: http://oauth.net/core/1.0/

    $launch_data["oauth_callback"] = "about:blank";
    $launch_data["oauth_consumer_key"] = $key;
    $launch_data["oauth_version"] = "1.0";
    $launch_data["oauth_nonce"] = uniqid('', true);
    $launch_data["oauth_timestamp"] = $now->getTimestamp();
    $launch_data["oauth_signature_method"] = "HMAC-SHA1";
    $launch_data["submit"] = "Launch";

    # In OAuth, request parameters must be sorted by name
    $launch_data_keys = array_keys($launch_data);
    sort($launch_data_keys);

    $launch_params = array();
    foreach ($launch_data_keys as $key) {
        array_push($launch_params, $key . "=" . rawurlencode($launch_data[$key]));
    }

    $base_string = "POST&" . urlencode($launch_url) . "&" . rawurlencode(implode("&", $launch_params));
    $secret = urlencode($secret) . "&";
    $signature = base64_encode(hash_hmac("sha1", $base_string, $secret, true));

?>

<html>
<head></head>
<!-- <body onload="document.ltiLaunchForm.submit();"> -->
<body>
<form id="ltiLaunchForm" name="ltiLaunchForm" method="POST" action="<?php printf($launch_url); ?>">
    <?php foreach ($launch_data as $k => $v ) { ?>
        <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>">
    <?php } ?>
    <input type="hidden" name="oauth_signature" value="<?php echo $signature ?>">
    <button type="submit">Launch</button>
</form>
<body>
</html>