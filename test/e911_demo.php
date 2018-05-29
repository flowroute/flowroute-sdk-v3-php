<?php

require_once "../vendor/autoload.php";
require_once "../src/Configuration.php";
use FlowrouteNumbersAndMessagingLib\Models;

// Access your Flowroute API credentials as local environment variables
$username = getenv('FR_ACCESS_KEY', true) ?: getenv('FR_ACCESS_KEY');
$password = getenv('FR_SECRET_KEY', true) ?: getenv('FR_SECRET_KEY');

// create our client object
$client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($username, $password);

// List all our E911 Records
$e911_list = getE911s($client);
echo "--List all E911 Records\n";
var_dump($e911_list);

// List E911 Record Details
echo "--List detail information for an E911 Record\n"
$detail_id = $e911_list[0]->id;
$detail_record = $client->getE911s()->get_e911_details($detail_id);
var_dump($detail_record);

// Validate an E911 Address
echo "--Validate an E911 Address\n"


// Validate an E911 Address

// Create an E911 Address

// Update an E911 Address

// Associate an E911 Address with a DID

// Un-associate an E911 Address from a DID

// Delete an E911 Address




// Helper Functions ------------------------------------------------------------
function getE911s($client)
{
    $limit = 10;
    $offset = 0;
    $state = NULL;

    $return_list = array();
    // User the E911 Controller from our Client
    $controller = $client->getE911s();

    do
    {
        $e911_data = $controller->listE911s($limit, $offset, $state);
        // Iterate through each number item
        foreach ($e911_data as $entry)
        {
            foreach ($entry as $item) {
                echo "---------------------------\nE911 Records:\n";
                var_dump($item);
                $return_list[] = $item;
            }
        }

        // See if there is more data to process
        $links = $e911_data->links;
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

