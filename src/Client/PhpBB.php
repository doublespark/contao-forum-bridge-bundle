<?php

namespace Doublespark\ContaoForumBridgeBundle\Client;

use GuzzleHttp\Client;

/**
 * Class PhpBB
 *
 * @package Doublespark\ContaoForumBridgeBundle\Client
 */
class PhpBB {

    protected $httpClient;
    protected $apiUrl;
    protected $apiPath;
    protected $secretKey = '';

    /**
     * PhpBB constructor.
     *
     * @param Client $httpClient
     * @param string $apiUrl
     * @param string $apiPath
     */
    public function __construct(Client $httpClient, string $apiUrl, string $apiPath)
    {
        $this->httpClient = $httpClient;
        $this->apiUrl     = rtrim($apiUrl, '/'); // remove trailing space if there is one
        $this->apiPath    = $apiPath;
    }

    /**
     * Create a phpBB user
     * @param string $username
     * @param string $password
     * @param string $email
     * @param int $group_id
     * @return array
     */
    public function createUser(string $username, string $password, string $email, int $group_id) : array
    {
        // User data to send to phpBB
        $arrUserData = [
            'username' => $username,
            'password' => $password,
            'email'    => $email,
            'group_id' => $group_id
        ];

        return $this->callApi('POST', 'createUser', $arrUserData);
    }

    /**
     * Deletes a user from phpBB
     * @param int $id
     * @return array
     */
    public function deleteUser(int $id)
    {
        $arrData = [
            'user_id' => $id
        ];

        return $this->callApi('POST', 'deleteUser', $arrData);
    }

    /**
     * Changes a user's group
     * @param int $userId
     * @param int $groupId
     * @return array
     */
    public function changeUserGroup(int $userId, int $groupId)
    {
        $arrData = [
            'user_id'  => $userId,
            'group_id' => $groupId
        ];

        return $this->callApi('POST', 'changeUserGroup', $arrData);
    }

    /**
     * Set a key for API request tokens
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Generate a security token so that the API
     * knows that the request is coming from us
     * @return string
     */
    protected function createToken()
    {
        return md5('phpbbbridge'.date('d/m/Y').$_SERVER['SERVER_ADDR'].$this->secretKey);
    }

    /**
     * Make a call to the API
     * @param string $method
     * @param string $action
     * @param null $data
     * @return array
     */
    protected function callApi(string $method, string $action, $data=null) : array
    {
        $arrOptions = [];

        if($method === 'POST' AND is_array($data))
        {
            $arrOptions['form_params'] = $data;
        }

        $arrOptions['headers'] = [
            'User-Agent'     => 'contao-phpbb/1.0',
            'X-Contao-Token' => $this->createToken()
        ];

        $response = $this->httpClient->request($method,$this->apiUrl.$this->apiPath.'?act='.$action, $arrOptions);

        return json_decode($response->getBody()->getContents(),true);
    }
}