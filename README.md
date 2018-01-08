# Getting started

The Flowroute APIs are organized around REST. Our APIs have resource-oriented URLs, support HTTP Verbs, and respond with HTTP Status Codes. All API requests and responses, including errors, will be represented as JSON objects. You can use the Flowroute APIs to manage your Flowroute phone numbers including setting primary and failover routes for inbound calls, and sending text messages (SMS and MMS) using long-code or toll-free numbers in your account.

## How to Build

The generated code has dependencies over external libraries like UniRest. These dependencies are defined in the ```composer.json``` file that comes with the SDK. 
To resolve these dependencies, we use the Composer package manager which requires PHP greater than 5.3.2 installed in your system. 
Visit [https://getcomposer.org/download/](https://getcomposer.org/download/) to download the installer file for Composer and run it in your system. 
Open command prompt and type ```composer --version```. This should display the current version of the Composer installed if the installation was successful.

* Using command line, navigate to the directory containing the generated files (including ```composer.json```) for the SDK. 
* Run the command ```composer install```. This should install all the required dependencies and create the ```vendor``` directory in your project directory.

![Building SDK - Step 1](https://apidocs.io/illustration/php?step=installDependencies&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

### [For Windows Users Only] Configuring CURL Certificate Path in php.ini

CURL used to include a list of accepted CAs, but no longer bundles ANY CA certs. So by default it will reject all SSL certificates as unverifiable. You will have to get your CA's cert and point curl at it. The steps are as follows:

1. Download the certificate bundle (.pem file) from [https://curl.haxx.se/docs/caextract.html](https://curl.haxx.se/docs/caextract.html) on to your system.
2. Add curl.cainfo = "PATH_TO/cacert.pem" to your php.ini file located in your php installation. “PATH_TO” must be an absolute path containing the .pem file.

```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
;curl.cainfo =
```

## How to Use

The following section explains how to use the FlowrouteNumbersAndMessaging library in a new project.

### 1. Open Project in an IDE

Open an IDE for PHP like PhpStorm. The basic workflow presented here is also applicable if you prefer using a different editor or IDE.

![Open project in PHPStorm - Step 1](https://apidocs.io/illustration/php?step=openIDE&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Click on ```Open``` in PhpStorm to browse to your generated SDK directory and then click ```OK```.

![Open project in PHPStorm - Step 2](https://apidocs.io/illustration/php?step=openProject0&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)     

### 2. Add a new Test Project

Create a new directory by right clicking on the solution name as shown below:

![Add a new project in PHPStorm - Step 1](https://apidocs.io/illustration/php?step=createDirectory&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Name the directory as "test"

![Add a new project in PHPStorm - Step 2](https://apidocs.io/illustration/php?step=nameDirectory&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)
   
Add a PHP file to this project

![Add a new project in PHPStorm - Step 3](https://apidocs.io/illustration/php?step=createFile&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Name it "testSDK"

![Add a new project in PHPStorm - Step 4](https://apidocs.io/illustration/php?step=nameFile&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Depending on your project setup, you might need to include composer's autoloader in your PHP code to enable auto loading of classes.

```PHP
require_once "../vendor/autoload.php";
```

It is important that the path inside require_once correctly points to the file ```autoload.php``` inside the vendor directory created during dependency installations.

![Add a new project in PHPStorm - Step 4](https://apidocs.io/illustration/php?step=projectFiles&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

After this you can add code to initialize the client library and acquire the instance of a Controller class. Sample code to initialize the client library and using controller methods is given in the subsequent sections.

### 3. Run the Test Project

To run your project you must set the Interpreter for your project. Interpreter is the PHP engine installed on your computer.

Open ```Settings``` from ```File``` menu.

![Run Test Project - Step 1](https://apidocs.io/illustration/php?step=openSettings&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Select ```PHP``` from within ```Languages & Frameworks```

![Run Test Project - Step 2](https://apidocs.io/illustration/php?step=setInterpreter0&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Browse for Interpreters near the ```Interpreter``` option and choose your interpreter.

![Run Test Project - Step 3](https://apidocs.io/illustration/php?step=setInterpreter1&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

Once the interpreter is selected, click ```OK```

![Run Test Project - Step 4](https://apidocs.io/illustration/php?step=setInterpreter2&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

To run your project, right click on your PHP file inside your Test project and click on ```Run```

![Run Test Project - Step 5](https://apidocs.io/illustration/php?step=runProject&workspaceFolder=Flowroute%20Numbers%20and%20Messaging-PHP)

## How to Test

Unit tests in this SDK can be run using PHPUnit. 

1. First install the dependencies using composer including the `require-dev` dependencies.
2. Run `vendor\bin\phpunit --verbose` from commandline to execute tests. If you have 
   installed PHPUnit globally, run tests using `phpunit --verbose` instead.

You can change the PHPUnit test configuration in the `phpunit.xml` file.

## Initialization

### Authentication
In order to setup authentication and initialization of the API client, you need the following information.

| Parameter | Description |
|-----------|-------------|
| basicAuthUserName | The username to use with basic authentication |
| basicAuthPassword | The password to use with basic authentication |



API client can be initialized as following.

```php
$basicAuthUserName = 'basicAuthUserName'; // The username to use with basic authentication
$basicAuthPassword = 'basicAuthPassword'; // The password to use with basic authentication

$client = new FlowrouteNumbersAndMessagingLib\FlowrouteNumbersAndMessagingClient($basicAuthUserName, $basicAuthPassword);
```


# Class Reference

## <a name="list_of_controllers"></a>List of Controllers

* [MessagesController](#messages_controller)
* [NumbersController](#numbers_controller)
* [RoutesController](#routes_controller)

## <a name="messages_controller"></a>![Class: ](https://apidocs.io/img/class.png ".MessagesController") MessagesController

### Get singleton instance

The singleton instance of the ``` MessagesController ``` class can be accessed from the API Client.

```php
$messages = $client->getMessages();
```

### <a name="get_look_up_a_set_of_messages"></a>![Method: ](https://apidocs.io/img/method.png ".MessagesController.getLookUpASetOfMessages") getLookUpASetOfMessages

> Retrieves a list of Message Detail Records (MDRs) within a specified date range. Date and time is based on Coordinated Universal Time (UTC).


```php
function getLookUpASetOfMessages(
        $startDate,
        $endDate = null,
        $limit = null,
        $offset = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| startDate |  ``` Required ```  | The beginning date and time, in UTC, on which to perform an MDR search. The DateTime can be formatted as YYYY-MM-DDor YYYY-MM-DDTHH:mm:ss.SSZ. |
| endDate |  ``` Optional ```  | The ending date and time, in UTC, on which to perform an MDR search. The DateTime can be formatted as YYYY-MM-DD or YYYY-MM-DDTHH:mm:ss.SSZ. |
| limit |  ``` Optional ```  | The number of MDRs to retrieve at one time. You can set as high of a number as you want, but the number cannot be negative and must be greater than 0 (zero). |
| offset |  ``` Optional ```  | The number of MDRs to skip when performing a query. The number must be 0 (zero) or greater, but cannot be negative. |



#### Example Usage

```php
$startDate = date("D M d, Y G:i");
$endDate = date("D M d, Y G:i");
$limit = 154;
$offset = 154;

$result = $messages->getLookUpASetOfMessages($startDate, $endDate, $limit, $offset);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="create_send_a_message"></a>![Method: ](https://apidocs.io/img/method.png ".MessagesController.createSendAMessage") createSendAMessage

> Sends an SMS or MMS from a Flowroute long code or toll-free phone number to another valid phone number.


```php
function createSendAMessage($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | The SMS or MMS message to send. |



#### Example Usage

```php
$body = new Message();

$result = $messages->createSendAMessage($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 403 | Forbidden – You don't have permission to access this resource. |
| 404 | The specified resource was not found |
| 422 | Unprocessable Entity - You tried to enter an incorrect value. |



### <a name="get_look_up_a_message_detail_record"></a>![Method: ](https://apidocs.io/img/method.png ".MessagesController.getLookUpAMessageDetailRecord") getLookUpAMessageDetailRecord

> Searches for a specific message record ID and returns a Message Detail Record (in MDR2 format).


```php
function getLookUpAMessageDetailRecord($id)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| id |  ``` Required ```  | The unique message detail record identifier (MDR ID) of any message. When entering the MDR ID, the number should include the mdr2- preface. |



#### Example Usage

```php
$id = 'id';

$result = $messages->getLookUpAMessageDetailRecord($id);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



[Back to List of Controllers](#list_of_controllers)

## <a name="numbers_controller"></a>![Class: ](https://apidocs.io/img/class.png ".NumbersController") NumbersController

### Get singleton instance

The singleton instance of the ``` NumbersController ``` class can be accessed from the API Client.

```php
$numbers = $client->getNumbers();
```

### <a name="get_account_phone_numbers"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.getAccountPhoneNumbers") getAccountPhoneNumbers

> Returns a list of all phone numbers currently on your Flowroute account. The response includes details such as the phone number's rate center, state, number type, and whether CNAM Lookup is enabled for that number.


```php
function getAccountPhoneNumbers(
        $startsWith = null,
        $endsWith = null,
        $contains = null,
        $limit = null,
        $offset = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| startsWith |  ``` Optional ```  | Retrieves phone numbers that start with the specified value. |
| endsWith |  ``` Optional ```  | Retrieves phone numbers that end with the specified value. |
| contains |  ``` Optional ```  | Retrieves phone numbers containing the specified value. |
| limit |  ``` Optional ```  | Limits the number of items to retrieve. A maximum of 200 items can be retrieved. |
| offset |  ``` Optional ```  | Offsets the list of phone numbers by your specified value. For example, if you have 4 phone numbers and you entered 1 as your offset value, then only 3 of your phone numbers will be displayed in the response. |



#### Example Usage

```php
$startsWith = 245;
$endsWith = 245;
$contains = 245;
$limit = 245;
$offset = 245;

$result = $numbers->getAccountPhoneNumbers($startsWith, $endsWith, $contains, $limit, $offset);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="get_phone_number_details"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.getPhoneNumberDetails") getPhoneNumberDetails

> Lists all of the information associated with any of the phone numbers in your account, including billing method, primary voice route, and failover voice route.


```php
function getPhoneNumberDetails($id)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| id |  ``` Required ```  | Phone number to search for which must be a number that you own. Must be in 11-digit E.164 format; e.g. 12061231234. |



#### Example Usage

```php
$id = 245;

$result = $numbers->getPhoneNumberDetails($id);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized |
| 404 | Not Found |



### <a name="create_purchase_a_phone_number"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.createPurchaseAPhoneNumber") createPurchaseAPhoneNumber

> Lets you purchase a phone number from available Flowroute inventory.


```php
function createPurchaseAPhoneNumber($id)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| id |  ``` Required ```  | Phone number to purchase. Must be in 11-digit E.164 format; e.g. 12061231234. |



#### Example Usage

```php
$id = 245;

$result = $numbers->createPurchaseAPhoneNumber($id);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="search_for_purchasable_phone_numbers"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.searchForPurchasablePhoneNumbers") searchForPurchasablePhoneNumbers

> This endpoint lets you search for phone numbers by state or rate center, or by your specified search value.


```php
function searchForPurchasablePhoneNumbers(
        $startsWith = null,
        $contains = null,
        $endsWith = null,
        $limit = null,
        $offset = null,
        $rateCenter = null,
        $state = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| startsWith |  ``` Optional ```  | Retrieve phone numbers that start with the specified value. |
| contains |  ``` Optional ```  | Retrieve phone numbers containing the specified value. |
| endsWith |  ``` Optional ```  | Retrieve phone numbers that end with the specified value. |
| limit |  ``` Optional ```  | Limits the number of items to retrieve. A maximum of 200 items can be retrieved. |
| offset |  ``` Optional ```  | Offsets the list of phone numbers by your specified value. For example, if you have 4 phone numbers and you entered 1 as your offset value, then only 3 of your phone numbers will be displayed in the response. |
| rateCenter |  ``` Optional ```  | Filters by and displays phone numbers in the specified rate center. |
| state |  ``` Optional ```  | Filters by and displays phone numbers in the specified state. Optional unless a ratecenter is specified. |



#### Example Usage

```php
$startsWith = 245;
$contains = 245;
$endsWith = 245;
$limit = 245;
$offset = 245;
$rateCenter = 'rate_center';
$state = 'state';

$result = $numbers->searchForPurchasablePhoneNumbers($startsWith, $contains, $endsWith, $limit, $offset, $rateCenter, $state);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="list_available_area_codes"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.listAvailableAreaCodes") listAvailableAreaCodes

> Returns a list of all Numbering Plan Area (NPA) codes containing purchasable phone numbers.


```php
function listAvailableAreaCodes(
        $limit = null,
        $offset = null,
        $maxSetupCost = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| limit |  ``` Optional ```  | Limits the number of items to retrieve. A maximum of 400 items can be retrieved. |
| offset |  ``` Optional ```  | Offsets the list of phone numbers by your specified value. For example, if you have 4 phone numbers and you entered 1 as your offset value, then only 3 of your phone numbers will be displayed in the response. |
| maxSetupCost |  ``` Optional ```  | Restricts the results to the specified maximum non-recurring setup cost. |



#### Example Usage

```php
$limit = 245;
$offset = 245;
$maxSetupCost = 245.883938372547;

$numbers->listAvailableAreaCodes($limit, $offset, $maxSetupCost);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="list_available_exchange_codes"></a>![Method: ](https://apidocs.io/img/method.png ".NumbersController.listAvailableExchangeCodes") listAvailableExchangeCodes

> Returns a list of all Central Office (exchange) codes containing purchasable phone numbers.


```php
function listAvailableExchangeCodes(
        $limit = null,
        $offset = null,
        $maxSetupCost = null,
        $areacode = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| limit |  ``` Optional ```  | Limits the number of items to retrieve. A maximum of 200 items can be retrieved. |
| offset |  ``` Optional ```  | Offsets the list of phone numbers by your specified value. For example, if you have 4 phone numbers and you entered 1 as your offset value, then only 3 of your phone numbers will be displayed in the response. |
| maxSetupCost |  ``` Optional ```  | Restricts the results to the specified maximum non-recurring setup cost. |
| areacode |  ``` Optional ```  | Restricts the results to the specified area code. |



#### Example Usage

```php
$limit = 245;
$offset = 245;
$maxSetupCost = 245.883938372547;
$areacode = 245;

$numbers->listAvailableExchangeCodes($limit, $offset, $maxSetupCost, $areacode);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



[Back to List of Controllers](#list_of_controllers)

## <a name="routes_controller"></a>![Class: ](https://apidocs.io/img/class.png ".RoutesController") RoutesController

### Get singleton instance

The singleton instance of the ``` RoutesController ``` class can be accessed from the API Client.

```php
$routes = $client->getRoutes();
```

### <a name="list_inbound_routes"></a>![Method: ](https://apidocs.io/img/method.png ".RoutesController.listInboundRoutes") listInboundRoutes

> Returns a list of your inbound routes. From the list, you can then select routes to use as the primary and failover routes for a phone number, which you can do via "Update Primary Voice Route for a Phone Number" and "Update Failover Voice Route for a Phone Number".


```php
function listInboundRoutes(
        $limit = null,
        $offset = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| limit |  ``` Optional ```  | Limits the number of routes to retrieve. A maximum of 200 items can be retrieved. |
| offset |  ``` Optional ```  | Offsets the list of routes by your specified value. For example, if you have 4 inbound routes and you entered 1 as your offset value, then only 3 of your routes will be displayed in the response. |



#### Example Usage

```php
$limit = 245;
$offset = 245;

$routes->listInboundRoutes($limit, $offset);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized |
| 404 | Not Found |



### <a name="create_an_inbound_route"></a>![Method: ](https://apidocs.io/img/method.png ".RoutesController.createAnInboundRoute") createAnInboundRoute

> Creates a new inbound route which can then be associated with phone numbers. Please see "List Inbound Routes" to review the route values that you can associate with your Flowroute phone numbers.


```php
function createAnInboundRoute($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | The new inbound route to be created. |



#### Example Usage

```php
$body = new NewRoute();

$result = $routes->createAnInboundRoute($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="update_primary_voice_route_for_a_phone_number"></a>![Method: ](https://apidocs.io/img/method.png ".RoutesController.updatePrimaryVoiceRouteForAPhoneNumber") updatePrimaryVoiceRouteForAPhoneNumber

> Use this endpoint to update the primary voice route for a phone number. You must create the route first by following "Create an Inbound Route". You can then assign the created route by specifying its value in a PATCH request.


```php
function updatePrimaryVoiceRouteForAPhoneNumber(
        $numberId,
        $body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| numberId |  ``` Required ```  | The phone number in E.164 11-digit North American format to which the primary route for voice will be assigned. |
| body |  ``` Required ```  | The primary route to be assigned. |



#### Example Usage

```php
$numberId = 245;
$body = ;

$result = $routes->updatePrimaryVoiceRouteForAPhoneNumber($numberId, $body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



### <a name="update_failover_voice_route_for_a_phone_number"></a>![Method: ](https://apidocs.io/img/method.png ".RoutesController.updateFailoverVoiceRouteForAPhoneNumber") updateFailoverVoiceRouteForAPhoneNumber

> Use this endpoint to update the failover voice route for a phone number. You must create the route first by following "Create an Inbound Route". You can then assign the created route by specifying its value in a PATCH request.


```php
function updateFailoverVoiceRouteForAPhoneNumber(
        $numberId,
        $body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| numberId |  ``` Required ```  | The phone number in E.164 11-digit North American format to which the failover route for voice will be assigned. |
| body |  ``` Required ```  | The failover route to be assigned. |



#### Example Usage

```php
$numberId = 245;
$body = ;

$result = $routes->updateFailoverVoiceRouteForAPhoneNumber($numberId, $body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 401 | Unauthorized – There was an issue with your API credentials. |
| 404 | The specified resource was not found |



[Back to List of Controllers](#list_of_controllers)



