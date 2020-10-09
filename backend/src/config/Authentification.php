<?php
namespace MyApp\Config;
require "../config.php";
use \Firebase\JWT\JWT;
use Exception;

class Authentification{
    protected $secret_key;
    protected $jwt;
    protected $authHeader;

    public function __construct(){
        $this->secret_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H 4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t 0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4 ehde/zUxo6UvS7UrBQIDAQAB";
        $this->jwt = null;
        $this->authHeader = $this->getToken();
    }

    public function getToken(){
        $headers = apache_request_headers();
        foreach ($headers as $header => $value) {
            if($header == 'Authorization'){
                $token = $value;
            }
            
        }
        return $token;
    }

    public function createTokenAuthentification(){
         /*-- jwt-auth --*/
         $issuedat_claim = time(); // issued at
         $notbefore_claim = $issuedat_claim + 10; //not before in seconds
         $expire_claim = $issuedat_claim + 6000; // expire time in seconds
         $token = array(
             // "iss" => $issuer_claim,
             // "aud" => $audience_claim,
             "iat" => $issuedat_claim,
             // "nbf" => $notbefore_claim,
             "exp" => $expire_claim,
             "jti" => "63aeec8b-1630-4441-8f0c-e4120834b0ee",
             "data" => array(
                 "Id" => $result['user']['id'],
                 "Pseudo" => $result['user']['pseudo'],
                 "Email" => $result['user']['email'],
                 "Date_Creation" => $result['user']['date_creation'],
                 "Rôle" => $result['user']['role_id']
         ));
         $jwt = JWT::encode($token, $secret_key);
         $data['message'] = "Successful login.";
         $data['user'] = $result['user'];
         $data['sessionConnected'] = true;
         $data['jwt'] = $jwt;
         $data['expireAt'] = $expire_claim;
         /*---*/
    }

    public function checkAuthentification(){
        $arr = explode(" ", $this->authHeader);
        $arr2 = str_replace("\"","", $arr[1]);
        $this->jwt = $arr2;
        if($this->jwt){
            try {
                $decoded = JWT::decode($this->jwt, $this->secret_key, ['HS256']);
                // Access is granted. Add code of the operation here 
                echo json_encode(array(
                    "access" => true,
                    "message" => "Access granted:"
                ));
            }catch (Exception $e){
                http_response_code(401);
                echo json_encode(array(
                    "message" => "Access denied."
                ));
            }
        }
    }

}

?>