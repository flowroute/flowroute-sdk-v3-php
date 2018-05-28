<?php

require_once "../vendor/autoload.php";
require_once "../src/Configuration.php";
use FlowrouteNumbersAndMessagingLib\Models;

// Access your Flowroute API credentials as local environment variables
$username = getenv('FR_ACCESS_KEY', true) ?: getenv('FR_ACCESS_KEY');
$password = getenv('FR_SECRET_KEY', true) ?: getenv('FR_SECRET_KEY');

// create our client object
$client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($username, $password);

// Get a list of our DIDs to work with
echo "Grab our DIDs so we have something to work with";
$numbers = $client->getNumbers();

// query all our numbers
$startsWith = NULL;
$endsWith = NULL;
$contains = NULL;
$limit = 10;
$offset = 0;

$ourDIDs = GetNumbers($client);
var_dump($our_DIDs);

// List all our CNAM Records
echo "Now list all our CNAM Records regardless of status.";
$our_cnams = GetCNAMs($client, False);

// Create a CNAM Record
//$cnam_value = 'Flowroute' . generateRandomString(4);
//$new_record = $client->getCNAMS()->createCNAM($cnam_value);
//var_dump($new_record);
//
//wait_for_user("New Record Created");
//echo "CNAM Records cannot be associated with DIDs until they have been approved.  Typically within 24 hours.";

echo "Listing only Approved CNAM Records";
// List approved CNAM records
$our_cnams = GetCNAMs($client, True);

if (count($our_cnams) == 0)
{
    echo "No currently approved CNAM records. This is as far as the demo can run until you have some records ready for use.";
    exit();
}

// CNAM Details
echo "List CNAM Details " . $our_cnams[0]->id . "\n";
$result = $client->getCNAMS()->getCNAMdetails($our_cnams[0]->id);
var_dump($result);

// Associate a CNAM Record with a DID
echo "Associate a CNAM record with one of our DIDs.";
$did = $ourDIDs[0]->id;
$cnam_value = $our_cnams[0]->attributes->value;
$cnam_id =  $our_cnams[0]->id;
echo "CNAM ID " . $cnam_id . "\n";
echo "DID ID " . $did . "\n";
$result = $client->getCNAMS()->associateCNAM($cnam_id, $did);
var_dump($result);

wait_for_user("New Record Associated");

// Un-associate the new CNAM Record from our DID
$result = $client->getCNAMS()->unassociateCNAM($did);
var_dump($result);

wait_for_user("New Record Unassociated");

// Delete the CNAM Record used
$result = $client->getCNAMS()->deleteCNAM($cnam_id);
var_dump($result);

wait_for_user("New Record Deleted");


// Helper Functions -----------------------------------------------------------
function wait_for_user($prompt)
{
    echo $prompt . " - Please press Enter to continue.";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    fclose($handle);
}

function GetCNAMs($client, $approved)
{
    $startsWith = NULL;
    $contains = NULL;
    $endsWith = NULL;
    $is_approved = $approved;

    $limit = 10;
    $offset = 0;

    $return_list = array();
    // User the CNAM Controller from our Client
    $cnams = $client->getCNAMS();
    do
    {
        $cnam_data = $cnams->listCNAMs($limit, $offset, $is_approved,
                                       $startsWith, $contains, $endsWith);
        // Iterate through each number item
        foreach ($cnam_data as $entry)
        {
            foreach ($entry as $item) {
                echo "---------------------------\nCNAM Records:\n";
                var_dump($item);
                $return_list[] = $item;
            }
        }

        // See if there is more data to process
        $links = $cnam_data->links;
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


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
