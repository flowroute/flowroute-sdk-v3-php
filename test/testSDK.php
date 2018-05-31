<?php

require_once "../vendor/autoload.php";
require_once "../src/Configuration.php";
use FlowrouteNumbersAndMessagingLib\Models;

// Access your Flowroute API credentials as local environment variables
$username = getenv('FR_ACCESS_KEY', true) ?: getenv('FR_ACCESS_KEY');
$password = getenv('FR_SECRET_KEY', true) ?: getenv('FR_SECRET_KEY');

// create our client object
$client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($username, $password);

// ---------------- Numbers --------------------

// List all our numbers
$our_numbers = GetNumbers($client);

// Find details for a specific number
$number_details = GetNumberDetails($client, $our_numbers[0]->attributes->value);

// Find purchasable numbers
$available_numbers = GetAvailableNumbers($client);

// List Available Area Codes
//$available_areacodes = GetAvailableAreaCodes($client);

// List available Exchange Codes
//$available_exchange_codes = GetAvailableExchangeCodes($client);

// Purchase a DID
$client->getNumbers()->createPurchaseAPhoneNumber($available_numbers[0][0]->id);

// Release a purchased DID
$client->getNumbers()->releaseDid($available_numbers[0][0]->id);

// ---------------- Messaging --------------------
$test_number = "YOUR MOBILE NUMBER HERE";

// List all our SMS Messages
$our_messages = GetMessages($client);

// Set Account Level SMS Callback URL
SetSMSCallback($client, "http://www.example.com");

// Send an SMS Message from our account
SendSMS($client, $our_numbers[0]);

// Send an MMS Message from out account
SendMMS($client, $our_numbers[0]);

// Look up a specific MDR
GetMDRDetail($client, $our_messages[0]);

// Set Account Level MMS Callback
SetMMSCallback($client, "http://www.example.com");

// Set Account Level DLR Callback
SetDLRCallback($client, "http://www.example.com");

// Set a Callback for a Specific DID
SetDIDCallback($client, $our_numbers[0]->id, "http://www.example.com/test");

// Send an SMS Message with a Callback
SendSMS($client, $our_numbers[0], "http://www.example.com/sms");

// ---------------- Routes --------------------

// List available PoPs
$pops = GetAvailablePops($client);

// List Inbound Routes
$inbound_routes = GetInboundRoutes($client);

// Create an Inbound Route
CreateInboundRoute($client);

// Update Primary Route for a DID
$route_id = "";
foreach($inbound_routes as $item)
{
    if($item->attributes->route_type == "host") {
        $route_id = $item->id;
        break;
    }
}
echo "Route ID: " . $route_id . "\n";
UpdatePrimaryRoute($client, $our_numbers[0]->id, $route_id);

// Update the Failover Route for a DID
for ($i = 1; $i < count($inbound_routes); $i++ )
{
    $item = $inbound_routes[$i];
    if($item->attributes->route_type == "host") {
        $route_id = $item->id;
        break;
    }
}
UpdateFailoverRoute($client, $our_numbers[1]->id, $route_id);

// ---------------- Portability --------------------

// Check number portability
CheckPortability($client);

echo "\n\nAll Tests Completed\n";

// ---------------------- Helper Functions -------------------------------
function CreateInboundRoute($client)
{
    $routes = $client->getRoutes();
    $body = new Models\NewRoute();
    $body->data = new Models\Data61();
    $body->data->attributes = new Models\Attributes62();
    $body->data->attributes->alias = "Test Route";
    $body->data->attributes->routeType = Models\RouteTypeEnum::HOST;
    $body->data->attributes->value = "www.flowroute.com";
    $boyd->data->attributes->edge_strategy_id = 2;

    $result = $routes->CreateAnInboundRoute($body);
    var_dump($result);
}
 
function UpdatePrimaryRoute($client, $DID, $route_id)
{
    $routes = $client->getRoutes();
    $result = $routes->UpdatePrimaryVoiceRouteForAPhoneNumber($DID, $route_id);
}

function UpdateFailoverRoute($client, $DID, $route_id)
{
    $routes = $client->getRoutes();
    $result = $routes->UpdateFailoverVoiceRouteForAPhoneNumber($DID, $route_id);
}

function GetInboundRoutes($client)
{
    $return_list = array();

    $limit = 10;
    $offset = 0;

    $routes = $client->getRoutes();

    do
    {
        $route_data = $routes->ListInboundRoutes($limit, $offset);
        var_dump($route_data);

        foreach ($route_data->data as $item)
        {
            echo "---------------------------\nInbound Routes:\n";
            var_dump($item);
            $return_list[] = $item;
        }

        // See if there is more data to process
        $links = $route_data->links;
        if (isset($links->next))
        {
            // more data to pull
            $offset += $limit;
        }
        else
        {
            break;   // no more data
        }
    }
    while (true);

    return $return_list;
}

function GetAvailableExchangeCodes($client)
{
    $return_list = array();

    $limit = 10;
    $offset = 0;
    $maxSetupCost = 174.40;
    $areacode = "206";

    // User the Numbers Controller from our Client
    $numbers = $client->getNumbers();

    do
    {
        $exchanges_data = $numbers->ListAvailableExchangeCodes($limit, $offset, $maxSetupCost, $areacode);
        var_dump($exchanges_data);

        foreach ($exchanges_data as $item)
        {
            echo "---------------------------\nAvailable Exchange:\n";
            var_dump($item);
            $return_list[] = $item;
        }

        // See if there is more data to process
        $links = $exchanges_data->links;
        if (isset($links->next))
        {
            // more data to pull
            $offset += $limit;
        }
        else
        {
            break;   // no more data
        }
    }
    while (true);

    return $return_list;
}

function GetAvailableAreaCodes($client)
{
    $return_list = array();

    $limit = 10;
    $offset = 0;
    $maxSetupCost = 10.00;

    // User the Numbers Controller from our Client
    $numbers = $client->getNumbers();

    do
    {
        echo "Offset is " . $offset;
        $areacode_data = $numbers->ListAvailableAreaCodes($limit, $offset, $maxSetupCost);
        var_dump($areacode_data);

        foreach ($areacode_data as $item)
        {
            echo "---------------------------\nAvailable Area Code:\n";
            var_dump($item);
            $return_list[] = $item;
        }

        // See if there is more data to process
        $links = $areacode_data->links;
        if (isset($links->next))
        {
            // more data to pull
            $offset += $limit;
        }
        else
        {
            break;   // no more data
        }
    } while (true);

    return $return_list;
}
 

function GetAvailableNumbers($client)
{
    $startsWith = "206";
    $contains = NULL;
    $endsWith = NULL;
    $rateCenter = NULL;
    $state = NULL;

    $limit = 10;
    $offset = 0;

    $return_list = array();
    // User the Numbers Controller from our Client
    $numbers = $client->getNumbers();
    do
    {
        $number_data = $numbers->SearchForPurchasablePhoneNumbers($startsWith, $contains,
                $endsWith, $limit, $offset, $rateCenter, $state);
        var_dump($number_data);
        // Iterate through each number item
        foreach ($number_data as $item)
        {
            echo "---------------------------\nAvailable Area Codes:\n";
            var_dump($item);
            $return_list[] = $item;
        }

        // See if there is more data to process
        $links = $number_data->links;
        if (isset($links->next))
        {
            // more data to pull
            $offset += $limit;
        }
        else
        {
            break;   // no more data
        }
    } while (true);

    return $return_list;
}

function GetMDRDetail($client, $id)
{
    $messages = $client->getMessages();
    var_dump($id);

    $mdr_data = $messages->GetLookUpAMessageDetailRecord($id);
    var_dump($mdr_data);
}
 
function SendSMS($client, $from_did, $callback_url=NULL)
{
    global $test_number;

    $msg = new Models\Message();
    var_dump($from_did);
    $msg->from = $from_did->id;
    $msg->to = $test_number; // Replace with your mobile number to receive messages from your Flowroute account
    $msg->body = "This is a Test Message";
    if($callback_url != NULL)
    {
        $msg->dlr_callback = $callback_url;
    }
    $messages = $client->getMessages();
    $result = $messages->CreateSendAMessage($msg);
    var_dump($result);
}

function SendMMS($client, $from_did)
{
    global $test_number;

    $msg = new Models\MMS_Message();
    $msg->from = $from_did->id;
    // TODO: Replace the number below
    $msg->to = $test_number;
    $msg->body = "This is a Test MMS Message";
    $msg->is_mms = True;
    $msg->mediaUrls[] = 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png';

    $messages = $client->getMessages();
    $result = $messages->CreateSendAMessage($msg);
    var_dump($result);
}

function SetSMSCallback($client, $url)
{
    $body = new Models\MessageCallback();
    $body->callback_url = $url;

    $messages = $client->getMessages();
    $result = $messages->setAccountSMSCallback($body);

    return($result);
}

function SetMMSCallback($client, $url)
{
    $body = new Models\MessageCallback();
    $body->callback_url = $url;

    $messages = $client->getMessages();
    $result = $messages->setAccountMMSCallback($body);

    return($result);
}

function SetDLRCallback($client, $url)
{
    $body = new Models\MessageCallback();
    $body->callback_url = $url;

    $messages = $client->getMessages();
    $result = $messages->setAccountDLRCallback($body);

    return($result);
}

function SetDIDCallback($client, $did, $url)
{
    $body = array(
        "data" => array(
        )
    );

    $body['data'] = array("attributes" => array("callback_url" => $url));

    $messages = $client->getMessages();
    $result = $messages->setDIDSMSCallback($did, $body);

    return($result);
}

function GetMessages($client)
{
    $return_list = array();
    $limit = 10;
    $offset = 0;

    // Find all messages since January 1, 2018
    $startDate = new DateTime('2018-01-01', new DateTimeZone('Pacific/Nauru'));

    $endDate = NULL;

    do
    {
        $messages = $client->getMessages();
        echo "calling lookup on ";
        var_dump($startDate);
        var_dump($endDate);
        var_dump($limit);
        var_dump($offset);
        $message_data = $messages->getLookUpASetOfMessages($startDate, $endDate, $limit, $offset);

        // Iterate through each number item
        foreach ($message_data->data as $item)
        {
            echo "---------------------------\nSMS MDR:\n";
            var_dump($item);
            $return_list[] = $item->id;
        }

        // See if there is more data to process
        $links = $message_data->links;
        if (isset($links->next))
        {
            // more data to pull
            $offset += $limit;
        }
        else
        {
            break;   // no more data
        }
    }
    while (true);

    return $return_list;
}
 
function GetNumbers($client)
{
    $return_list = array();

    // List all phone numbers in our account paging through them 1 at a time
    //  If you have several phone numbers, change the 'limit' variable below
    //  This example is intended to show how to page through a list of resources

    // create a numbers instance
    $numbers = $client->getNumbers();

    // query all our numbers
    $startsWith = NULL;
    $endsWith = NULL;
    $contains = NULL;
    $limit = 10;
    $offset = 0;

    $result = $numbers->getAccountPhoneNumbers($startsWith, $endsWith, $contains, $limit, $offset);
    //var_dump($result);

    foreach($result as $item) {
        foreach($item as $entry) {
            var_dump($entry);
            echo "--------------------------------------\n";
            $return_list[] = $entry;
        }
        echo "--------------------------------------\n";
    }

    return $return_list;
}

function GetNumberDetails($client, $id)
{
    // User the Numbers Controller from our Client
    $numbers = $client->getNumbers();
    $result = $numbers->getPhoneNumberDetails($id);
    var_dump($result);
    return $result;
}

function GetAvailablePops($client)
{
    $routes = $client->getRoutes();
    $result = $routes->listPops();
    echo "Available Edge Pops";
    echo "--------------------------------------\n";
    var_dump($result);
    echo "\n--------------------------------------\n";
    return $result;
}

function CheckPortability($client)
{
    $portability = $client->getPorting();
    echo "\nChecking Portability\n";
    echo "--------------------------------------\n";
    $porting_numbers = new Models\Portability(array('+14254445555', '+14254446666'));

    $result = $portability->checkPortability($porting_numbers->jsonSerialize());
    var_dump($result);
    echo "\n--------------------------------------\n";
    return $result;
}

?>
