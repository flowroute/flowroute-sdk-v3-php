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
$e911_list = listE911s($client);
echo "--List all E911 Records\n";
var_dump($e911_list);

// List E911 Record Details
echo "--List detail information for an E911 Record\n";
$detail_id = $e911_list[0]->id;
$detail_record = $client->getE911s()->get_e911_details($detail_id);
var_dump($detail_record);

// Validate an E911 Address
echo "--Validate an E911 Address\n";

$body = new Models\E911Record();
$body->attributes->street_name = 'N Vassault';
$body->attributes->street_number = '3901';
$body->attributes->city = 'Tacoma';
$body->attributes->state = 'WA';
$body->attributes->country = 'US';
$body->attributes->zipcode = '98407';
$body->attributes->first_name = 'Dan';
$body->attributes->last_name = 'Smith';
$body->attributes->label = 'Home';

$result = $client->getE911s()->validate_address($body);
var_dump($result);

// Create an E911 Address
echo "--Create an E911 Address\n";
$result = $client->getE911s()->create_address($body);
var_dump($result);
$detail_id = $result->body->data->id;

// Update an E911 Address
echo "Update an E911 Address\n";
$body->attributes->label = 'Work';
$result = $client->getE911s()->update_address($body, $detail_id);
var_dump($result);

// Associate an E911 Address with a DID
echo "Associate an E911 Address with a DID\n";
$our_numbers = $client->getNumbers()->getAccountPhoneNumbers();
$did_id = $our_numbers->data[0]->id;
echo "Did id " . $did_id . "\n";
$result = $client->getE911s()->associate_did($did_id, $detail_id);
var_dump($result);

// List all DIDs associated with an E911 address
echo "List all DIDs associated with an E911 Address\n";
$result = $client->getE911s()->list_dids_for_address($detail_id);
var_dump($result);

// Un-associate an E911 Address from a DID
echo "Un-associate and E911 Address from a DID\n";
$result = $client->getE911s()->unassociate_did($did_id);
var_dump($result);

// Delete an E911 Address
echo "Delete an E911 Address\n";
$result = $client->getE911s()->delete_address($detail_id);
var_dump($result);



// Helper Functions ------------------------------------------------------------
function listE911s($client)
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

