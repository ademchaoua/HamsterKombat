<?php

/**
 * Class Hamster
 * 
 * A class to interact with the Hamster Kombat API. 
 * Provides methods to fetch user information and perform taps.
 */
class Hamster 
{
    public $userToken;

    /**
     * Constructor to initialize the Hamster class with a user token.
     *
     * @param string|null $userToken The user token for authentication.
     */
    public function __construct($userToken = null)
    {
        $this->userToken = $userToken;
    }

    /**
     * Fetches user information from the Hamster Kombat API.
     *
     * @return string JSON response from the API.
     */
    public function getInfo()
    {
        $headers = [
            'Authorization: Bearer '.$this->userToken,
            'Accept-Language: en-GB,en;q=0.9',
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 16_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        ];
        $ch = curl_init();

        curl_setopt_array($ch,[
            CURLOPT_URL => 'https://api.hamsterkombat.io/clicker/sync',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => null,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Performs a tap action on the Hamster Kombat API.
     *
     * @return string JSON response from the API.
     */
    public function tap()
    {
        $data = [
            "count" => 10,
            "availableTaps" => 1000000,
            "timestamp" => time(),
        ];
        $headers = [
            'Authorization: Bearer '.$this->userToken,
            'Accept-Language: en-GB,en;q=0.9',
            'Content-Type: application/json',
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 16_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        ];

        $ch = curl_init();

        curl_setopt_array($ch,[
            CURLOPT_URL => 'https://api.hamsterkombat.io/clicker/tap',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

// Prompt user for token
$userToken = readline('Enter your token: ');

// Create an instance of the Hamster class
$hamster = new Hamster($userToken);

// Fetch and decode user information
$info = json_decode($hamster->getInfo());

if(!isset($info->error_code))
{
    // Display user information
    $id = $info->clickerUser->id;
    $totalCoins = $info->clickerUser->totalCoins;
    $balanceCoins = $info->clickerUser->balanceCoins;
    $level = $info->clickerUser->level;
    $availableTaps = $info->clickerUser->availableTaps;
    $referralsCount = $info->clickerUser->referralsCount;
    
    echo "\033[32mLogin successful!\033[0m\n";
    echo "ID: \033[32m$id \033[0m\n";
    echo "Total Coins: \033[32m$totalCoins \033[0m\n";
    echo "Balance Coins: \033[32m$balanceCoins \033[0m\n";
    echo "Level: \033[32m$level \033[0m\n";
    echo "Available Taps: \033[32m$availableTaps \033[0m\n";
    echo "Referrals Count: \033[32m$referralsCount \033[0m\n\n\n";

    echo "\033[34mWhat would you like to do?\n1. Auto tap\n2. Stay online 24/7\n3. Both\033[0m\n\n";
    $event = readline("Enter number: ");

    if($event == '1')
    {
        // Auto tap functionality
        while(true)
        {
            $tap = json_decode($hamster->tap());
            $availableTaps = $tap->clickerUser->availableTaps;

            echo "Available Taps: \033[32m$availableTaps \033[0m\n";

            if($availableTaps == '0')
            {
                sleep(120); // Wait for 2 minutes if no taps are available
            }
            else
            {
                sleep(5); // Wait for 5 seconds between taps
            }
        }
    }
    elseif($event == '2')
    {
        // Stay online 24/7 functionality
        while(true)
        {
            echo "\033[32mYou will be online 24/7. Do not close this terminal!\033[0m\n";
            $hamster->getInfo();

            sleep(9000); // Wait for 2.5 hours
        }
    }
    elseif($event == '3')
    {
        // Both auto tap and stay online 24/7 functionality
        while(true)
        {
            $tap = json_decode($hamster->tap());
            $availableTaps = $tap->clickerUser->availableTaps;

            echo "Available Taps: \033[32m$availableTaps \033[0m\n";

            if($availableTaps == '0')
            {
                $hamster->getInfo();
                sleep(120); // Wait for 2 minutes if no taps are available
            }
            else
            {
                sleep(5); // Wait for 5 seconds between taps
            }
        }
    }
}
elseif($info->error_code == 'NotFound_Session')
{
    echo "Error: \033[31mInvalid token!\033[0m\n";
}
?>