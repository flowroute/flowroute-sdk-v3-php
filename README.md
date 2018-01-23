Flowroute PHP Library v3
=====================

The Flowroute PHP Library v3 provides methods for interacting with [Numbers v2](https://developer.flowroute.com/api/numbers/v2.0/) and [Messages v2.1](https://developer.flowroute.com/api/messages/v2.1/) of the [Flowroute](https://www.flowroute.com) API.

**Topics**

*   [Requirements](#requirements)
*   [Installation](#installation)
*   [Usage](#usage)
    *   [Configuration](#configuration)
        *   [Credentials](#credentials)
        *   [API Client and Controllers](#instantiate-the-api-client)
    *   [Functions](#functions)
        *   [Number Management](#number-management)
            *   [GetAvailableAreaCodes](#getavailableareacodesclient)
            *   [GetAvailableExchangeCodes](#getavailableexchangecodesclient)
            *   [GetAvailableNumbers](#getavailablenumbersclient)
            *   [GetNumbers](#getnumbersclient)
            *   [GetNumberDetails](#getnumberdetailsclient-string-id)

        *   [Route Management](#route-management)
            *   [CreateInboundRoute](#createinboundrouteclient)
            *   [GetInboundRoutes](#getinboundroutesclient-did-route_id)
            *   [UpdatePrimaryRoute](#updateprimaryrouteclient-did-route_id)
            *   [UpdateFailoverRoute](#updatefailoverrouteclient-did-route_id)

        *   [Messaging](#messaging)
            *   [SendSMS](#sendsmsclient-from_did)
            *   [GetMessages](#getmessagesclient)
            *   [GetMDRDetail](#getmdrdetailclient-id)

    *   [Errors](#errors)
    *   [Testing](#testing)

* * *

## Requirements

*   Flowroute [API credentials](https://manage.flowroute.com/accounts/preferences/api/)
*   [PHP](http://php.net/downloads.php) 5.4.0 or higher
*   [Composer](https://getcomposer.org/download/) 1.1.6 or higher

* * *

## Installation

1.  First, start a shell session and clone the SDK:

    #### via HTTPS:

        git clone https://github.com/flowroute/flowroute-sdk-v3-php.git

    #### via SSH:

        git@github.com:flowroute/flowroute-sdk-v3-php.git

2.  Switch to the newly-created <span class="code-variable">flowroute-sdk-v3-php</span> directory.

3.  Download [Composer](https://getcomposer.org/download/) in the same directory. PHP Library v3 comes with a **composer.json** listing the project dependencies and other metadata. Run the following:

        php composer.phar install

* * *

## Usage

In Flowroute's approach to building the PHP library v3, HTTP requests are handled by an API client object accessed by functions defined in **testSDK.php** located within the **test** subdirectory. First, switch to the **test** directory and open the demo file.

###### Change directory

    cd test

###### Open test file

    vim testSDK.php

## Configuration

### Credentials

In **testSDK.php**, check that the required files are included at the top. Replace <span class="code-variable">username</span> with your API Access Key and <span class="code-variable">password</span> with your API Secret Key from the [Flowroute Manager](https://manage.flowroute.com/accounts/preferences/api/). Note that in our example, we are accessing your Flowroute credentials as environment variables. To learn more about setting environment variables, see [How To Read and Set Environmental and Shell Variables](https://www.digitalocean.com/community/tutorials/how-to-read-and-set-environmental-and-shell-variables-on-a-linux-vps).

    <?php
    require_once "../vendor/autoload.php";
    require_once "../src/Configuration.php";
    use FlowrouteNumbersAndMessagingLib\Models;

    // Access your Flowroute API credentials as local environment variables
    $username = getenv('FR_ACCESS_KEY', true) ?: getenv('FR_ACCESS_KEY');
    $password = getenv('FR_SECRET_KEY', true) ?: getenv('FR_SECRET_KEY');

### Instantiate the API Client

    // Instantiate API client and authenticate
    $client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($username, $password);

## Functions

The following section will demonstrate the capabilities of Numbers v2 and Messages v2.1 that are wrapped in our PHP library. Note that the example responses may not show the expected results from the function calls within **testSDK.php**. These examples have been formatted using Mac's <span class="code-variable">pbpaste</span> and <span class="code-variable">jq</span>. To learn more, see [Quickly Tidy Up JSON from the Command Line](http://onebigfunction.com/vim/2015/02/02/quickly-tidying-up-json-from-the-command-line-and-vim/).

### Number Management

Flowroute PHP Library v3 allows you to make HTTP requests to the <span class="code-variable">numbers</span> resource of Flowroute API v2: <span class="code-variable">https://api.flowroute.com/v2/numbers</span>

#### GetAvailableAreaCodes($client)

The function declares <span class="code-variable">limit</span>, <span class="code-variable">offset</span>, and <span class="code-variable">maxSetupCost</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-available-area-codes/).

##### Function Declaration

    function GetAvailableAreaCodes($client)
    {
        $return_list = array();

        $limit = 2;
        $offset = 0;
        $maxSetupCost = 10.00;

        // User the Numbers Controller from our Client
        $numbers = $client-<getNumbers();

        do
        {
            echo "Offset is " . $offset;
            $areacode_data = $numbers-<ListAvailableAreaCodes($limit, $offset, $maxSetupCost);
            var_dump($areacode_data);

            foreach ($areacode_data as $item)
            {
                echo "---------------------------\nAvailable Area Code:\n";
                var_dump($item);
                $return_list[] = $item;
            }

            // See if there is more data to process
            $links = $areacode_data-<links;
            if (isset($links-<next))
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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of area code objects in JSON format.

    {
      "data": [
        {
          "type": "areacode",
          "id": "201",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available/exchanges?areacode=201"
          }
        },
        {
          "type": "areacode",
          "id": "202",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available/exchanges?areacode=202"
          }
        },
        {
          "type": "areacode",
          "id": "203",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available/exchanges?areacode=203"
          }
        }
      ],
      "links": {
        "self": "https://api.flowroute.com/v2/numbers/available/areacodes?max_setup_cost=3&limit=3&offset=0",
        "next": "https://api.flowroute.com/v2/numbers/available/areacodes?max_setup_cost=3&limit=3&offset=3"
      }
    }

#### GetAvailableExchangeCodes($client)

The function declares <span class="code-variable">limit</span>, <span class="code-variable">offset</span>, <span class="code-variable">maxSetupCost</span>, and <span class="code-variable">areacode</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-available-exchanges/).

##### Function Declaration

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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of exchange objects in JSON format.

    {
      "data": [
        {
          "type": "exchange",
          "id": "347215",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available?starts_with=1347215"
          }
        },
        {
          "type": "exchange",
          "id": "347325",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available?starts_with=1347325"
          }
        },
        {
          "type": "exchange",
          "id": "347331",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/available?starts_with=1347331"
          }
        }
      ],
      "links": {
        "self": "https://api.flowroute.com/v2/numbers/available/exchanges?areacode=347&limit=3&offset=0",
        "next": "https://api.flowroute.com/v2/numbers/available/exchanges?areacode=347&limit=3&offset=3"
      }
    }

#### GetAvailableNumbers($client)

The function declares <span class="code-variable">startsWith</span>, <span class="code-variable">contains</span>, <span class="code-variable">endsWith</span>, <span class="code-variable">rateCenter</span>, <span class="code-variable">state</span>, <span class="code-variable">limit</span>, and <span class="code-variable">offset</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/search-for-purchasable-phone-numbers/).

##### Function Declaration

    function GetAvailableNumbers($client)
    {
        $startsWith = "206";
        $contains = NULL;
        $endsWith = NULL;
        $rateCenter = NULL;
        $state = NULL;

        $limit = 2;
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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of phone number objects in JSON format.

    {
      "data": [
        {
          "attributes": {
            "rate_center": "nwyrcyzn01",
            "value": "16463439507",
            "monthly_cost": 1.25,
            "state": "ny",
            "number_type": "standard",
            "setup_cost": 1
          },
          "type": "number",
          "id": "16463439507",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/16463439507"
          }
        },
        {
          "attributes": {
            "rate_center": "nwyrcyzn01",
            "value": "16463439617",
            "monthly_cost": 1.25,
            "state": "ny",
            "number_type": "standard",
            "setup_cost": 1
          },
          "type": "number",
          "id": "16463439617",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/16463439617"
          }
        },
        {
          "attributes": {
            "rate_center": "nwyrcyzn01",
            "value": "16463439667",
            "monthly_cost": 1.25,
            "state": "ny",
            "number_type": "standard",
            "setup_cost": 3.99
          },
          "type": "number",
          "id": "16463439667",
          "links": {
            "related": "https://api.flowroute.com/v2/numbers/16463439667"
          }
        }
      ],
      "links": {
        "self": "https://api.flowroute.com/v2/numbers/available?contains=3&ends_with=7&starts_with=1646&limit=3&offset=0",
        "next": "https://api.flowroute.com/v2/numbers/available?contains=3&ends_with=7&starts_with=1646&limit=3&offset=3"
      }
    }

#### GetNumbers($client)

The function declares <span class="code-variable">startsWith</span>, <span class="code-variable">contains, <span class="code-variable">endsWith</span>, <span class="code-variable">rateCenter</span>, <span class="code-variable">state</span>, <span class="code-variable">limit</span>, and <span class="code-variable">offset</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-account-phone-numbers/).</span>

##### Function Declaration

    function GetNumbers($client)
    {
        $return_list = array();

        // List all phone numbers in our account paging through them 1 at a time
        //  If you have several phone numbers, change the 'limit' variable below
        //  This example is intended to show how to page through a list of resources

        // create a numbers instance
        $numbers = $client->getNumbers();

        // query all our numbers
        $startsWith = 1646;
        $endsWith = NULL;
        $contains = NULL;
        $limit = 3;
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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of phone number objects in JSON format.

    {
      "data": [
        {
          "attributes": {
            "rate_center": "oradell",
            "value": "12012673227",
            "alias": null,
            "state": "nj",
            "number_type": "standard",
            "cnam_lookups_enabled": true
          },
          "type": "number",
          "id": "12012673227",
          "links": {
            "self": "https://api.flowroute.com/v2/numbers/12012673227"
          }
        },
        {
          "attributes": {
            "rate_center": "jerseycity",
            "value": "12014845220",
            "alias": null,
            "state": "nj",
            "number_type": "standard",
            "cnam_lookups_enabled": true
          },
          "type": "number",
          "id": "12014845220",
          "links": {
            "self": "https://api.flowroute.com/v2/numbers/12014845220"
          }
        }
      ],
      "links": {
        "self": "https://api.flowroute.com/v2/numbers?starts_with=1201&limit=3&offset=0"
      }
    }

#### GetNumberDetails($client, string id)

The function declares the <span class="code-variable">id</span> as a variable which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-phone-number-details/). In the following example, we request the details of the first phone number returned after calling the <span class="code-variable">list_account_phone_numbers</span> method.

##### Function Declaration

    function GetNumberDetails($client, $id)
    {
        // User the Numbers Controller from our Client
        $numbers = $client->getNumbers();
        echo "Calling gnd with " . $id;
        $result = $numbers->getPhoneNumberDetails($id);
        var_dump($result);
        return $result;
    }

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains a phone number object in JSON format.

    {
      "included": [
        {
          "attributes": {
            "route_type": "sip-reg",
            "alias": "sip-reg",
            "value": null
          },
          "type": "route",
          "id": "0",
          "links": {
            "self": "https://api.flowroute.com/v2/routes/0"
          }
        }
      ],
      "data": {
        "relationships": {
          "cnam_preset": {
            "data": null
          },
          "e911_address": {
            "data": null
          },
          "failover_route": {
            "data": null
          },
          "primary_route": {
            "data": {
              "type": "route",
              "id": "0"
            }
          }
        },
        "attributes": {
          "rate_center": "millbrae",
          "value": "16502390214",
          "alias": null,
          "state": "ca",
          "number_type": "standard",
          "cnam_lookups_enabled": true
        },
        "type": "number",
        "id": "16502390214",
        "links": {
          "self": "https://api.flowroute.com/v2/numbers/16502390214"
        }
      },
      "links": {
        "self": "https://api.flowroute.com/v2/numbers/16502390214"
      }
    }

### Route Management

The Flowroute PHP Library v3 allows you to make HTTP requests to the <span class="code-variable">routes</span> resource of Flowroute API v2: <span class="code-variable">https://api.flowroute.com/v2/routes</span>

#### CreateInboundRoute($client)

The function declares the route object in JSON format as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/create-an-inbound-route/). In the following example, we declare a test route with <span class="code-variable">route_type</span> "host".

##### Function Declaration

    function CreateInboundRoute($client)
    {
        $routes = $client->getRoutes();
        $body = new Models\NewRoute();
        $body->data = new Models\Data61();
        $body->data->attributes = new Models\Attributes62();
        $body->data->attributes->alias = "Test Route";
        $body->data->attributes->routeType = Models\RouteTypeEnum::HOST;
        $body->data->attributes->value = "www.flowroute.com";

        $result = $routes->CreateAnInboundRoute($body);
        var_dump($result);
    }

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">201 Created</span> and the response body contains a route object in JSON format.

    {
      "data": {
        "attributes": {
          "alias": "Test Route",
          "route_type": "host",
          "value": "www.flowroute.com"
        },
        "id": "98396",
        "links": {
          "self": "https://api.flowroute.com/routes/98396"
        },
        "type": "route"
      },
      "links": {
        "self": "https://api.flowroute.com/routes/98396"
      }
    }

#### GetInboundRoutes($client, $DID, $route_id)

The function declares <span class="code-variable">limit</span> and <span class="code-variable">offset</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-inbound-routes/).

##### Function Declaration

    function GetInboundRoutes($client)
    {
        $return_list = array();

        $limit = 3;
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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of route objects in JSON format.

    {
      "data": [
        {
          "attributes": {
            "route_type": "sip-reg",
            "alias": "sip-reg",
            "value": null
          },
          "type": "route",
          "id": "0",
          "links": {
            "self": "https://api.flowroute.com/v2/routes/0"
          }
        },
        {
          "attributes": {
            "route_type": "number",
            "alias": "PSTNroute1",
            "value": "12065551212"
          },
          "type": "route",
          "id": "83834",
          "links": {
            "self": "https://api.flowroute.com/v2/routes/83834"
          }
        }
      ],
      "links": {
        "self": "https://api.flowroute.com/v2/routes?limit=2&offset=0",
        "next": "https://api.flowroute.com/v2/routes?limit=2&offset=2"
      }
    }

#### UpdatePrimaryRoute($client, $DID, $route_id)

The function updates a <span class="code-variable">DID</span> with the <span class="code-variable">route_id</span> parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/update-number-primary-voice-route/).

##### Function Declaration

    function UpdatePrimaryRoute($client, $DID, $route_id)
    {
        $routes = $client->getRoutes();
        $result = $routes->UpdatePrimaryVoiceRouteForAPhoneNumber($DID, $route_id);
        var_dump($result);
    } 

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">204 No Content</span> which means that the server successfully processed the request and is not returning any content.

    204: No Content

#### UpdateFailoverRoute($client, $DID, $route_id)

The function updates a <span class="code-variable">DID</span> with the <span class="code-variable">route_id</span> parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/update-number-failover-voice-route/).

##### Function Declaration

    function UpdateFailoverRoute($client, $DID, $route_id)
    {
        $routes = $client->getRoutes();
        $result = $routes->UpdateFailoverVoiceRouteForAPhoneNumber($DID, $route_id);
        var_dump($result);
    }

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">204 No Content</span> which means that the server successfully processed the request and is not returning any content.

    204: No Content

### Messaging

The Flowroute PHP Library v3 allows you to make HTTP requests to the <span class="code-variable">messages</span> resource of Flowroute API v2.1: <span class="code-variable">https://api.flowroute.com/v2.1/messages</span>

#### SendSMS($client, $from_did)

The function declares a message object in JSON format as a parameter which you can learn more about in the API References for [MMS](https://developer.flowroute.com/api/messages/v2.1/send-an-mms/) and [SMS](https://developer.flowroute.com/api/messages/v2.1/send-an-sms/). In the following example, we are sending an SMS with a from the previously declared <span class="code-variable">from_did</span> to your mobile number.

##### Function Declaration

    function SendSMS($client, $from_did)
    {
        $msg = new Message();
        $msg->From = $from_did;
        $msg->To = "YOUR_MOBILE_NUMBER"; // Replace with your mobile number to receive messages from your Flowroute account
        $msg->Body = "Hi Chris";

        $messages = $client->getMessages;
        $result = $messages->CreateSendAMessage($msg);
        echo $result;
    }

Note that this function call is currently commented out. Uncomment to test the <span class="code-variable">SendSMS</span> function.

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">202 Accepted</span> and the response body contains the message record ID with <span class="code-variable">mdr2</span> prefix.

    {
      "data": {
        "links": {
          "self": "https://api.flowroute.com/v2.1/messages/mdr2-39cadeace66e11e7aff806cd7f24ba2d"
        },
        "type": "message",
        "id": "mdr2-39cadeace66e11e7aff806cd7f24ba2d"
      }
    }

#### GetMessages($client)

The function declares <span class="code-variable">startDate</span>, <span class="code-variable">endDate</span>, <span class="code-variable">limit</span>, and <span class="code-variable">offset</span> as parameters which you can learn more about in the [API Reference](https://developer.flowroute.com/api/messages/v2.1/look-up-set-of-messages/).

##### Function Declaration

    function GetMessages($client)
    {
        $return_list = array();
        $limit = 1;
        $offset = 0;

        // Find all messages since January 1, 2017
        $startDate = new DateTime('2018-01-01', new DateTimeZone('Pacific/Nauru'));
        $endDate = NULL;

        do
        {
            $messages = $client->getMessages();
            $message_data = $messages->getLookUpASetOfMessages($startDate, $endDate, $limit, $offset);

            // Iterate through each number item
            foreach ($message_data->data as $item)
            {
                echo "---------------------------\nSMS MDR:\n";
                echo "Attributes:" . $item->attributes . "\nId:" . $item->id . "\nLinks:" . $item.links . "\nType:" . $item->type . "\n";
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

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of message objects in JSON format.

    {
      "data": [
        {
          "attributes": {
            "body": "Hello are you there? ",
            "status": "delivered",
            "direction": "inbound",
            "amount_nanodollars": 4000000,
            "to": "12012673227",
            "message_encoding": 0,
            "timestamp": "2017-12-22T01:52:39.39Z",
            "delivery_receipts": [],
            "amount_display": "$0.0040",
            "from": "12061231234",
            "is_mms": false,
            "message_type": "longcode"
          },
          "type": "message",
          "id": "mdr2-ca82be46e6ba11e79d08862d092cf73d"
        },
        {
          "attributes": {
            "body": "test sms on v2",
            "status": "message buffered",
            "direction": "outbound",
            "amount_nanodollars": 4000000,
            "to": "12061232634",
            "message_encoding": 0,
            "timestamp": "2017-12-21T16:44:34.93Z",
            "delivery_receipts": [
              {
                "status": "message buffered",
                "status_code": 1003,
                "status_code_description": "Message accepted by Carrier",
                "timestamp": "2017-12-21T16:44:35.00Z",
                "level": 2
              },
              {
                "status": "smsc submit",
                "status_code": null,
                "status_code_description": "Message has been sent",
                "timestamp": "2017-12-21T16:44:35.00Z",
                "level": 1
              }
            ],
            "amount_display": "$0.0040",
            "from": "12012673227",
            "is_mms": false,
            "message_type": "longcode"
          },
          "type": "message",
          "id": "mdr2-39cadeace66e11e7aff806cd7f24ba2d"
        }
      ],
      "links": {
        "next": "https://api.flowroute.com/v2.1/messages?limit=2&start_date=2017-12-01T00%3A00%3A00%2B00%3A00&end_date=2018-01-08T00%3A00%3A00%2B00%3A00&offset=2"
      }
    }

#### GetMDRDetail($client, $id)

The function declares a message <span class="code-variable">id</span> in MDR2 format as a variable which you can learn more about in the [API Reference](https://developer.flowroute.com/api/messages/v2.1/look-up-a-message-detail-record/). In the following example, we retrieve the details of the first message in our <span class="code-variable">look_up_a_set_of_messages</span> search result.

##### Function Declaration

    function GetMDRDetail($client, $id)
    {
        $messages = $client->Messages;

        $mdr_data = $messages->GetLookUpAMessageDetailRecord($id);
        echo $mdr_data;
    }  

##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains the message object for our specified message <span class="code-variable">id</span>.

    {
      "data": {
        "attributes": {
          "body": "Hello are you there? ",
          "status": "delivered",
          "direction": "inbound",
          "amount_nanodollars": 4000000,
          "to": "12012673227",
          "message_encoding": 0,
          "timestamp": "2017-12-22T01:52:39.39Z",
          "delivery_receipts": [],
          "amount_display": "$0.0040",
          "from": "12061232634",
          "is_mms": false,
          "message_type": "longcode"
        },
        "type": "message",
        "id": "mdr2-ca82be46e6ba11e79d08862d092cf73d"
      }
    }

## Errors

In cases of HTTP errors, the PHP library displays a pop-up window with an error message next to the line of code that caused the error. You can add more error logging if necessary.

### Example Error

    PHP Fatal error:  Uncaught FlowrouteNumbersAndMessagingLib\Exceptions\ErrorException: Unauthorized – There was an issue with your API credentials.

## Testing

Once you are done configuring your Flowroute API credentials and updating the function parameters, run the file to see the demo in action:
`php testSDK.php`
