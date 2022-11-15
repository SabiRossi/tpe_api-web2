<?php
require_once './app/views/api.view.php';
require_once './app/helpers/auth-api.helper.php';
require_once './app/models/user.model.php';

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}



class AuthApiController
{

    private $model;
    private $view;
    private $authHelper;

    private $data;

    public function __construct()
    {
        $this->model = new userModel;
        $this->view = new apiView();
        $this->authHelper = new authApiHelper();

        $this->data = file_get_contents("php://input"); // body del request

    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getToken($params = null)
    {
        //obtengo "Basic base64 y usserpass
        $basic = $this->authHelper->getAuthHeader();

        if (empty($basic)) {
            $this->view->response('No esta autorizado', 401);
            return;
        }
        $basic = explode(" ", $basic); // "basic" y base64 con userpass
        if ($basic[0] != "Basic") {
            $this->view->response("la autenticacion debe ser Basic", 401);
            return;
        }
        //valido userpass
        $userpass = base64_decode($basic[1]); //guardo el userpass en variable
        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];

        $userDb = $this->model->getUser($user);

        $name = $userDb ? $userDb->email : null;

        if (isset($name) && (password_verify($pass, $userDb->password))) { // puedo crear el token
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => 1,
                'name' => $name,
                'exp' => time() + 3600

            );



            $secretKey = $this->authHelper->getSecretKey();
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", $secretKey, true); //construyo la firma
            $signature = base64url_encode($signature);




            $token = "$header.$payload.$signature"; //concateno el token

            $this->view->response($token, 201);
        } else {
            $this->view->response('no esta autorizado', 401);
        }
    }
}
