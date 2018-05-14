<?php

require_once "../vendor/autoload.php";
require_once "../src/Configuration.php";
use FlowrouteNumbersAndMessagingLib\Models;

// Access your Flowroute API credentials as local environment variables
$username = getenv('FR_ACCESS_KEY', true) ?: getenv('FR_ACCESS_KEY');
$password = getenv('FR_SECRET_KEY', true) ?: getenv('FR_SECRET_KEY');

// create our client object
$client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($username, $password);

// List all our CNAM Records
$our_cnams = GetCNAMs($client);

// Create a CNAM Record
$new_record = $client->getCNAMS()->createCNAM('Flowroute');
var_dump($new_record);

$new_record = $new_record->data;
$new_record = $new_record->id;

wait_for_user("New Record Created");
// Associate a CNAM Record with a DID
$result = $client->getCNAMS()->associateCNAM($new_record, '12066417659');
var_dump($result);

wait_for_user("New Record Associated");
$result = $client->getCNAMS()->unassociateCNAM('12066417659');
var_dump($result);

wait_for_user("New Record Unassociated");
$result = $client->getCNAMS()->deleteCNAM($new_record);
var_dump($result);

wait_for_user("New Record Deleted");


// Helper Functions
function wait_for_user($prompt)
{
    echo $prompt;
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    fclose($handle);
}

function GetCNAMs($client)
{
    $startsWith = NULL;
    $contains = NULL;
    $endsWith = NULL;
    $is_approved = NULL;

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
