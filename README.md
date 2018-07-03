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
        
        *   [E911 Address Management](#e911-address-management)
            *   [listE911s](#liste911sclient)
            *   [get_e911_details](#get_e911_detailsdetail_id)
            *   [validate_address](#validate_addresse911_object)
            *   [create_address](#create_addresse911_object)
            *   [update_address](#update_addressbody-detail_id)
            *   [associate_did](#associate_diddid_id-detail_id)
            *   [list_dids_for_address](#list_dids_for_addressdetail_id)
            *   [unassociate_did](#unassociate_diddid_id)
            *   [delete_address](#delete_addressdetail_id)
        
        *   [CNAM Record Management](#cnam-record-management)
            *   [GetCNAMs](#getcnamsclient-approval_status)
            *   [getCNAMdetails](#get_cnamcnam_id)
            *   [createCNAM](#create_cnam_recordcnam_value)
            *   [associateCNAM](#associate_cnamcnam_id-did)
            *   [unassociateCNAM](#unassociate_cnamnumber_id)
            *   [deleteCNAM](#remove_cnamcnam_id)

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

In Flowroute's approach to building the PHP library v3, HTTP requests are handled by an API client object accessed by functions defined in **testSDK.php** which interacts with the **Numbers**, **Routes**, and **Messages** API resources,  **e911_demo.php** which interacts with the **E911s** resource, and **cnam_demo.php** which interacts with the **CNAMs** resouce. All demo files are located within the **test** subdirectory. First, switch to the **test** directory and open the demo file that you need to test.

###### Change directory

    cd test

###### Open test file

The following shows an example of a single PHP file that imports the Flowroute API client and all the required modules. The PHP Library v3 comes with three example demo files &mdash; **testSDK.php**, **e911_demo.php**, **cnam_demo.php** &mdash; files that you can edit and run for demonstration and testing purposes.

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

The following section will demonstrate the capabilities of Numbers v2, Messages v2.1, E911s v2, and CNAMs v2 that are wrapped in our PHP library. Note that the example responses may not show the expected results from the function calls within **testSDK.php**, **e911_demo.php**, and **cnam_demo.php**. These examples have been formatted using Mac's <span class="code-variable">pbpaste</span> and <span class="code-variable">jq</span>. To learn more, see [Quickly Tidy Up JSON from the Command Line](http://onebigfunction.com/vim/2015/02/02/quickly-tidying-up-json-from-the-command-line-and-vim/).

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

The function declares the route object in JSON format as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/create-an-inbound-route/). In the following example, we declare a test route with <span class="code-variable">route\_type</span> "host".

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

#### GetInboundRoutes($client, $DID, $route\_id)

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

`204 No Content`

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

`204 No Content`

### Messaging

The Flowroute PHP Library v3 allows you to make HTTP requests to the <span class="code-variable">messages</span> resource of Flowroute API v2.1: <span class="code-variable">https://api.flowroute.com/v2.1/messages</span>

#### SendSMS($client, $from_did)

The function declares a message object in JSON format as a parameter which you can learn more about in the API References for [MMS](https://developer.flowroute.com/api/messages/v2.1/send-an-mms/) and [SMS](https://developer.flowroute.com/api/messages/v2.1/send-an-sms/). In the following example, we are sending an SMS from the previously declared <span class="code-variable">from_did</span> to your mobile number.

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

### E911 Address Management

The Flowroute PHP Library v3 allows you to make HTTP requests to the <span class="code-variable">e911s</span> resource of Flowroute API v2: <span class="code-variable">https://api.flowroute.com/v2/e911s</span>

All of the E911 address management methods are encapsulated in `e911_demo.php`.

| API Reference Pages |
| ------------------- |
| The E911 and CNAM API reference pages are currently restricted to our beta customers, which means that all API reference links below currently return a `404 Not Found`. They will be publicly available during our E911 and CNAM APIs GA launch in a few weeks. |


#### listE911s($client)

The function declares <span class="code-variable">limit</span>, <span class="code-variable">offset</span>, and <span class="code-variable">state</span> as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-account-e911-addresses/).

##### Function Declaration
```
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
```
##### Example Response

On success, the HTTP status code in the response header is <span class="code-variable">200 OK</span> and the response body contains an array of e911 objects in JSON format. Note that this demo function iterates through all the E911 records on your account filtered by the parameters that you specify. The following example response has been clipped for brevity's sake.

```
E911 Records:
{'data': [{'attributes': {'address_type': 'Lobby',
                          'address_type_number': '12',
                          'city': 'Seattle',
                          'country': 'USA',
                          'first_name': 'Maria',
                          'label': 'Example E911',
                          'last_name': 'Bermudez',
                          'state': 'WA',
                          'street_name': '20th Ave SW',
                          'street_number': '7742',
                          'zip': '98106'},
           'id': '20930',
           'links': {'self': 'https://api.flowroute.com/v2/e911s/20930'},
           'type': 'e911'},
          {'attributes': {'address_type': 'Apartment',
                          'address_type_number': '12',
                          'city': 'Seattle',
                          'country': 'US',
                          'first_name': 'Something',
                          'label': '5th E911',
                          'last_name': 'Someone',
                          'state': 'WA',
                          'street_name': 'Main St',
                          'street_number': '645',
                          'zip': '98104'},
           'id': '20707',
           'links': {'self': 'https://api.flowroute.com/v2/e911s/20707'},
           'type': 'e911'}],
 'links': {'next': 'https://api.flowroute.com/v2/e911s?limit=10&offset=10',
           'self': 'https://api.flowroute.com/v2/e911s?limit=10&offset=0'}}
```

#### get\_e911\_details($detail\_id)

The function declares a variable, `detail_id`, as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-account-e911-addresses/). The value that gets assigned to `detail_id` is the first resulting item of the returned array from the `listE911s` function call.

##### Function Declaration
```
// List E911 Record Details
echo "--List detail information for an E911 Record\n";
$detail_id = $e911_list[0]->id;
$detail_record = $client->getE911s()->get_e911_details($detail_id);
var_dump($detail_record);
```
##### Example Response

On success, the HTTP status code in the response header is `200 OK` and the response body contains a detailed e911 object in JSON format. 

```
--List detail information for an E911 Record
{
  "data": {
    "attributes": {
      "address_type": "Suite",
      "address_type_number": "333",
      "city": "Seattle",
      "country": "US",
      "first_name": "Albus",
      "label": "Office Space III",
      "last_name": "Rasputin, Jr.",
      "state": "WA",
      "street_name": "Main St",
      "street_number": "666",
      "zip": "98101"
    },
    "id": "21845",
    "links": {
      "self": "https://api.flowroute.com/v2/e911s/21845"
    },
    "type": "e911"
  }
}
```

#### validate\_address($e911_object)

In the following example request, we instantiate `body` as an `E911Record` object, then initialize its different attributes with example values. The different attributes that an `E911Record` object can have include `label`, `first_name`, `last_name`, `street_name`, `street_numbe     r`, `address_type`, `address_type_number`, `city`, `state`, `country`, and `zipcode`. Learn more about the different body parameters in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-account-e911-addresses/). We then pass `body` as a parameter for the `validate_address` function.

    
##### Example Request
```
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
```

##### Example Response

On success, the HTTP status code in the response header is `204 No Content` which means that the server successfully processed the request and is not returning any content. On error, a printable representation of the detailed API response is displayed.

```
["rawBody":"FlowrouteNumbersAndMessagingLib\Http\HttpResponse":private]=>
  string(171)
"{
  "errors": [
    {
      "detail": {
        "data": {
          "attributes": {
            "zip": [
              "ZIP code must be at least 4 and at most 7 digits long"
            ]
          }
        }
      },
      "id": "15eb464e-d717-49e2-a6cc-e97af67c1930",
      "status": 422
    }
  ]
}
"
```
#### create_address($e911_object)

The method accepts an E911 object with its different attributes as a parameter. Learn more about the different E911 attributes in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/create-and-validate-new-e911-address/). In the following example request, we pass our `E911Record` object, `body`, as a parameter to the `create_address` method.
    
##### Example Request
```
echo "--Create an E911 Address\n";
$result = $client-&gt;getE911s()-&gt;create&gt;address($body);
var_dump($result);
```

##### Example Response

On success, the HTTP status code in the response header is `201 Created` and the response body contains the newly created e911 object in JSON format. On error, a printable representation of the detailed API response is displayed.

```
--Create an E911 Address
{
  "data": {
    "attributes": {
      "address_type": "Apartment",
      "address_type_number": "601",
      "city": "Tacoma",
      "country": "US",
      "first_name": "Dan",
      "label": "Home",
      "last_name": "Smith",
      "state": "WA",
      "street_name": "N Vassault",
      "street_number": "3901",
      "zip": "98407"
    },
    "id": "21907",
    "links": {
      "self": "https://api.flowroute.com/v2/e911s/21907"
    },
    "type": "e911"
  }
}
```
#### update_address($e911_object, $detail_id)

The method accepts an E911 object and an E911 record ID. Learn more about the different E911 attributes that you can update in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/update-and-validate-existing-e911-address/). In the following example, we will retrieve the record ID of our newly created E911 address and assign it to a variable, `detail_id`. We then update the `label` of our selected E911 address to "Work".
    
##### Example Request
```
$detail_id = $result->body->data->id;

// Update an E911 Address
echo "Update an E911 Address\n";
$body->attributes->label = 'Work';
$result = $client->getE911s()->update_address($body, $detail_id);
var_dump($result);
```
##### Example Response
On success, the HTTP status code in the response header is `200 OK` and the response body contains the newly updated e911 object in JSON format. On error, a printable representation of the detailed API response is displayed.

```
{
  "data": {
    "attributes": {
      "city": "Tacoma",
      "country": "US",
      "first_name": "Dan",
      "label": "Work",
      "last_name": "Smith",
      "state": "WA",
      "street_name": "N Vassault",
      "street_number": "3901",
      "zip": "98407"
    },
    "id": "21907",
    "links": {
      "self": "https://api.flowroute.com/v2/e911s/21907"
    },
    "type": "e911"
  }
}
```

#### associate_did($did_id, $detail_id)

The method accepts a phone number and an E911 record ID as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/assign-valid-e911-address-to-phone-number/). In the following example, we call the [getAccountPhoneNumbers](#getnumbersclient) function covered under Number Management to extract the value of the first item in the returned JSON array into variable `did_id`, pass our previously declared `detail_id` for the E911 record ID, and then make the association between them.
    
##### Example Request
```
// Associate an E911 Address with a DID
echo "Associate an E911 Address with a DID\n";
$our_numbers = $client->getNumbers()->getAccountPhoneNumbers();
$did_id = $our_numbers->data[0]->id;
echo "Did id " . $did_id . "\n";
$result = $client->getE911s()->associate_did($did_id, $detail_id);
var_dump($result);
```
##### Example Response

On success, the HTTP status code in the response header is `204 No Content` which means that the server successfully processed the request and is not returning any content.

```
Associate an E911 Address with a DID
Did id 12062011682
204 No Content
```

#### list_dids_for_address($detail_id)

The method accepts an E911 record id as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-phone-numbers-associated-with-e911-record/). In the following example, we retrieve the list of phone numbers associated with our previously assigned `detail_id`.
    
##### Example Request
```
// List all DIDs associated with an E911 address
echo "List all DIDs associated with an E911 Address\n";
$result = $client->getE911s()->list_dids_for_address($detail_id);
var_dump($result);
```
##### Example Response
On success, the HTTP status code in the response header is `200 OK` and the response body contains an array of related number objects in JSON format.
```
List all DIDs associated with an E911 Address
{
  "data": [
    {
      "attributes": {
        "alias": null,
        "value": "12062011682"
      },
      "id": "12062011682",
      "links": {
        "self": "https://api.flowroute.com/v2/numbers/12062011682"
      },
      "type": "number"
    }
  ],
  "links": {
    "self": "https://api.flowroute.com/v2/e911s/21907/relationships/numbers?limit=10&offset=0"
  }
}
```

#### unassociate_did($did_id)

The method accepts a phone number as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/deactivate-e911-service-for-phone-number/). In the following example, we deactivate the E911 service for our previously assigned `did_id`.

##### Example Request
```
Un-associate an E911 Address from a DID
echo "Un-associate an E911 Address from a DID\n";
$result = $client->getE911s()->unassociate_did($did_id);
var_dump($result);
```
##### Example Response
On success, the HTTP status code in the response header is `204 No Content` which means that the server successfully processed the request and is not returning any content.

```
Un-associate an E911 Address from a DID
204 No Content
```
#### delete_address($detail_id)

The method accepts an E911 record ID as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/remove-e911-address-from-account/). Note that all phone number associations must be removed first before you are able to delete the specified `detail_id`. In the following example, we will attempt to delete the previously assigned `detail_id`.

##### Example Request
```
// Delete an E911 Address
echo "Delete an E911 Address\n";
$result = $client->getE911s()->delete_address($detail_id);
var_dump($result);
```

##### Example Response
On success, the HTTP status code in the response header is `204 No Content` which means that the server successfully processed the request and is not returning any content.

```
Delete an E911 Address
204 No Content
```

### CNAM Record Management

The Flowroute PHP Library v3 allows you to make HTTP requests to the `cnams` resource of Flowroute API v2: `https://api.flowroute.com/v2/cnams`.

All of the CNAM record management methods are encapsulated in `cnam_demo.php`.

| API Reference Pages |
| ------------------- |
| The E911 and CNAM API reference pages are currently restricted to our beta customers, which means that all API reference links below currently return a `404 Not Found`. They will be publicly available during our E911 and CNAM APIs GA launch in a few weeks. |

#### GetCNAMs($client, approval_status)

The method accepts a client object and all the different CNAM query parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-account-cnam-records/). In the following example request, we will only retrieve approved CNAM records. Note that this demo function iterates through all the E911 records on your account filtered by the parameters t     hat you specify. The following example response has been clipped for brevity's sake.
    
##### Function Declaration
```
function GetCNAMs($client, $is_approved=False, $startsWith=NULL,
                  $endsWith=NULL, $contains=NULL, $limit=10, $offset=0)
{
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
```
##### Example Request
```
echo "Listing only Approved CNAM Records";
// List approved CNAM records
$our_cnams = GetCNAMs($client, True);

if (count($our_cnams) == 0)
{
    echo "No currently approved CNAM records. This is as far as the demo can run until you have some records ready for use.";
    exit();
}
```

##### Example Response

On success, the HTTP status code in the response header is `200 OK` and the response body contains an array of cnam objects in JSON format.

```
Listing only Approved CNAM Records
{'data': [{'attributes': {'approval_datetime': None,
                          'creation_datetime': None,
                          'is_approved': True,
                          'rejection_reason': '',
                          'value': 'TEST, MARIA'},
           'id': '17604',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/17604'},
           'type': 'cnam'},
          {'attributes': {'approval_datetime': '2018-04-16 '
                                               '16:20:32.939166+00:00',
                          'creation_datetime': '2018-04-12 '
                                               '19:08:39.062539+00:00',
                          'is_approved': True,
                          'rejection_reason': None,
                          'value': 'REGENCE INC'},
           'id': '22671',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/22671'},
           'type': 'cnam'},
          {'attributes': {'approval_datetime': '2018-04-23 '
                                               '17:04:30.829341+00:00',
                          'creation_datetime': '2018-04-19 '
                                               '21:03:04.932192+00:00',
                          'is_approved': True,
                          'rejection_reason': None,
                          'value': 'BROWN BAG'},
           'id': '22790',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/22790'},
           'type': 'cnam'},
          {'attributes': {'approval_datetime': '2018-05-23 '
                                               '18:58:46.052602+00:00',
                          'creation_datetime': '2018-05-22 '
                                               '23:38:27.794911+00:00',
                          'is_approved': True,
                          'rejection_reason': None,
                          'value': 'LEATHER REBEL'},
           'id': '23221',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/23221'},
           'type': 'cnam'},
          {'attributes': {'approval_datetime': '2018-05-23 '
                                               '18:58:46.052602+00:00',
                          'creation_datetime': '2018-05-22 '
                                               '23:39:24.447054+00:00',
                          'is_approved': True,
                          'rejection_reason': None,
                          'value': 'LEATHER REBELZ'},
           'id': '23223',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/23223'},
           'type': 'cnam'},
          {'attributes': {'approval_datetime': '2018-05-23 '
                                               '18:58:46.052602+00:00',
                          'creation_datetime': '2018-05-22 '
                                               '23:42:00.786818+00:00',
                          'is_approved': True,
                          'rejection_reason': None,
                          'value': 'MORBO'},
           'id': '23224',
           'links': {'self': 'https://api.flowroute.com/v2/cnams/23224'},
           'type': 'cnam'}],
 'links': {'self': 'https://api.flowroute.com/v2/cnams?limit=10&offset=0'}}
```
#### get_cnam($cnam_id)

The method accepts a CNAM record ID as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/list-cnam-record-details/). In the following example, we query for approved CNAM records on your account and then extract the ID of the first record returned and retrieve the details of that specific CNAM record. 
    
##### Example Request
```
// CNAM Details
echo "List CNAM Details " . $our_cnams[0]->id . "\n";
$result = $client->getCNAMS()->getCNAMdetails($our_cnams[0]->id);
var_dump($result);
```
##### Example Response

On success, the HTTP status code in the response header is `200 OK` and the response body contains a detailed cnam object in JSON format.

```
List CNAM Details 17604
{'data': {'attributes': {'approval_datetime': None,
                         'creation_datetime': None,
                         'is_approved': True,
                         'rejection_reason': '',
                         'value': 'TEST, MARIA'},
          'id': '17604',
          'links': {'self': 'https://api.flowroute.com/v2/cnams/17604'},
          'type': 'cnam'}}
```
#### create_cnam_record($cnam_value)

The method accepts a Caller ID value as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/create-a-new-cnam-record/). In the following example, we include a `generateRandomString` function to generate a four-character random string which we will concatenate with Flowroute and assign as our CNAM value. Note that you can enter up to 15 characters for your CNAM value.
    
##### Example Request
```
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Create a CNAM Record
$cnam_value = 'Flowroute' . generateRandomString(4);
$new_record = $client->getCNAMS()->createCNAM($cnam_value);
var_dump($new_record);
```

##### Example Response

On success, the HTTP status code in the response header is `201 Created` and the response body contains the newly created cnam object in JSON format. This demo includes a `wait_for_user()` function which gives you a confirmation of the CNAM record creation then prompts you to press "Enter". Afterwards, you should see a message on the limitation around CNAM record and phone number association.

```
{
  "data": {
    "attributes": {
      "approval_datetime": null,
      "creation_datetime": "2018-06-27 20:44:01.543801+00:00",
      "is_approved": false,
      "rejection_reason": null,
      "value": "FLOWROUTEVMKM"
    },
    "id": "23922",
    "links": {
      "self": "https://api.flowroute.com/v2/cnams/23922"
    },
    "type": "cnam"
  }
}
New Record Created - Please press Enter to continue.

CNAM Records cannot be associated with DIDs until they have been approved.  Typically within 24 hours.
```
#### associate_cnam($cnam_id, $did)

The method accepts a CNAM record ID and a phone number as parameters which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/assign-cnam-record-to-phone-number/). In the following example, we will call `getNumbers()` and `getCNAMs()` then associate the first number with the first CNAM record in the resulting numbers and CNAMs arrays. This demo includes a `wait_for_user()` function which gives you a confirmation of the CNAM record association with the phone number and prompts you to press "Enter" to continue.
    
##### Example Request
```
$cnam_value = $our_cnams[0]->attributes->value;
$cnam_id =  $our_cnams[0]->id;
echo "CNAM ID " . $cnam_id . "\n";
echo "DID ID " . $did . "\n";
$result = $client->getCNAMS()->associateCNAM($cnam_id, $did);
var_dump($result);

wait_for_user("New Record Associated");
```

##### Example Response
On success, the HTTP status code in the response header is `202 Accepted` and the response body contains an attributes dictionary containing the `date_created` field and the assigned cnam object in JSON format. This request will fail if the CNAM you are trying to associate has not yet been approved.
```
CNAM ID 22790
DID ID 12062011682
{'data': {'attributes': {'date_created': 'Fri, 01 Jun 2018 00:17:52 GMT'},
          'id': 22790,
          'type': 'cnam'}}
New Record Associated - Please press Enter to continue.
```
#### unassociate_cnam($number_id)

The method accepts a phone number as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/unassign-a-cnam-record-from-phone-number/). In the following example, we will disassociate the same phone number that we've used in `associate_cnam()`. This demo includes a `wait_for_user()` function which gives you a confirmation of the CNAM record disassociation from the phone number and prompts you to press "Enter" to continue.
    
##### Example Request
```
// Un-associate the new CNAM Record from our DID
$did = $ourDIDs[0]->id;
$result = $client->getCNAMS()->unassociateCNAM($did);
var_dump($result);
```
##### Example Response
On success, the HTTP status code in the response header is `202 Accepted` and the response body contains an attributes object with the date the CNAM was requested to be deleted, and the updated cnam object in JSON format. 

```
{'data': {'attributes': {'date_created': 'Wed, 27 Jun 2018 20:59:36 GMT'},
          'id': None,
          'type': 'cnam'}}
New Record Unassociated - Please press Enter to continue.
```
#### remove_cnam($cnam_id)

The method accepts a CNAM record ID as a parameter which you can learn more about in the [API reference](https://developer.flowroute.com/api/numbers/v2.0/remove-cnam-record-from-account/). In the following example, we will be deleting our previously extracted `cnam_id` from the "List Approved CNAM Records" function call. This demo includes a `wait_for_user()` function which gives you a confirmation of the CNAM record deletion and prompts you to press "Enter" to continue.
    
##### Example Request
```
// Delete the CNAM Record used
$result = $client->getCNAMS()->deleteCNAM($cnam_id);
var_dump($result);
```

##### Example Response
On success, the HTTP status code in the response header is `204 No Content` which means that the server successfully processed the request and is not returning any content.

```
204 No Content
New Record Deleted - Please press Enter to continue.
```

#### Errors

In cases of method errors, the PHP Library v3 raises an exception which includes an error message and the HTTP body that was received in the request. 

##### Example Error
```
{
  "errors": [
    {
      "detail": "The method is not allowed for the requested URL.",
      "id": "a72cab15-2511-43d3-92e2-d77bfbdc5776",
      "status": 405,
      "title": "Method Not Allowed"
    }
  ]
}
```
 
## Testing

Once you are done configuring your Flowroute API credentials and updating the function parameters, you can run any of the demo files to see them in action. The Flowroute library demo files are named after the resource they represent: <resource_name>_demo.php.

`php e911_demo.php`
