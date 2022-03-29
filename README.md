MyCow SDK
=========

This library allow you to manipulate MyCow's REST API.

1- Setup
========

Use composer 

    composer req ludicat/mycow-sdk

2- Usage
========

In your code, instantiate the Core Class 

    $baseUrl = 'https://www.mycow.eu';
    $myToken = 'xxxxxxxxxxxxxx'; // Your token was provide by MyCow's team.
    $adapter = new MyCow\SDK\Adapter\Curl(); // Depend on your system. If none provide, CURL will be used.
    $sdk = new MyCow\SDK\Core($baseUrl, $myToken, $adapter);

Then call for the expected endpoint and use related methods :

    $response = $sdk->getUser()->get($username);
    if ($response->isError()) {
        throw new \Exception(sprintf('MyCow API ERROR %d: ', $response->getCode(), $response->getMessage()));
    }

    print_r($response->getBody());

Contribute
==========

Create a `.env.local` file and set your GITHUB_TOKEN variable

    # .env.local
    GITHUB_TOKEN=MyToken

Build 
    
    make build

Start container (you will have to start from here on further usages) 
    
    make build

Connect to docker with ssh

    make ssh
    
Then dump autoloader

    composer dump-autoload
