<?php
    require_once __DIR__ . '/vendor/autoload.php';
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    // if this is called as a page, it will explain itself
    if (__FILE__ == get_included_files()[0]) {
        session_start();

        $debuggin_out = true;
        $page_title = "DBGR ref";
        include_once($_SERVER["DOCUMENT_ROOT"] .  "/tmpl/tmpl_foundation_top.php");
        echo <<< EOD

        <div class="row small-up-2 large-up-2" style="margin-top:3em;">
            <div class="column">
                <h4>How to use</h4>
                <p class="lead">Set a debug variable, and then if it's true, include this page.</p>
            </div>
            <div class="column">
                <pre>    
    &dollar;debuggin_out = true;
    if (!empty(&dollar;debuggin_out)) {
        include_once(\$_SERVER["DOCUMENT_ROOT"] . "/dbgr.php");
        &dollar;page_title = "awesome new page - DEBUG";
        include "tmpl_foundation_top.php";
    }
            </pre>
            </div>
        </div>
        <div class="row small-up-2 large-up-2" style="margin-top:3em;">
            <div class="column">
                <p class="lead">Right before closing the body, execute <pre>echo_debug_bar_scripts()</pre></p>
            </div>
            <div class="column">
                <pre>
    if (!empty(&dollar;debuggin_out)) {
        echo_debug_bar_scripts();
    }
    // other scripts (won't conflict with jquery, etc.)
    echo "&lt;/body>&lt;/html>";
            </pre>
            </div>
        </div>
        <div class="row small-up-2 large-up-2" style="margin-top:3em;">
            <div class="column">
                <p  class="lead">Send yourself messages like this</p>
            </div>
            <div class="column">
                <pre> 
    dbb_msg(['results' => &dollar;api->results()]);
    dbb_msg(['message' =>  
       'All this technology and all I got was this message']);                
            </pre>
            </div>
        </div>
EOD;

        dbb_msg(['results' => ['some fake api' => '[didn\'t produce] these results']]);
        dbb_msg(['message' => 'All this technology and all I got was this message']);
//        dbb_msg(['realpath' => realpath(__FILE__)]);
//        dbb_msg(['PHP_SELF' => $_SERVER['PHP_SELF']]);
        echo "\n<!-- &dollar;debugbarRenderer->renderHead(); -->\n";
        echo $debugbarRenderer->renderHead();
        echo "\n<!-- &dollar;debugbarRenderer->render(); -->\n";
        echo $debugbarRenderer->render();
        echo "\n<!-- end &dollar;debugbarRenderer stuff -->\n";
        echo "</body></html>";
        exit;
    }

    use DebugBar\StandardDebugBar;
    $debugbar = new StandardDebugBar();
    $debugbarRenderer = $debugbar->getJavascriptRenderer();

    function dbb_msg($message)
    {
        global $debuggin_out, $debugbar;
        if ($message and $debuggin_out and isset($debugbar)) {
            $debugbar['messages']->info($message);
        }
    }
    function echo_debug_bar_scripts(){
        global $debugbarRenderer;
        echo $debugbarRenderer->renderHead();
        echo $debugbarRenderer->render();
    }


