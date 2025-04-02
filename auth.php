<?php

  define("OAUTH2_SITE", 'https://api.shop-pro.jp');
  define("OAUTH2_CLIENT_ID",'c4b83c3c20f56b5d24b4bf9624230ad9d0b88969d8a356a314c7c65e74279a4f'); // xxxにクライアントIDを入力
  define("OAUTH2_CLIENT_SECRET", '636ac0ee239d9ca29a95b8409d7d156512cfdbec9381dddeac5759bdbdb36149'); // yyyにクライアントシークレットを入力
  define("OAUTH2_REDIRECT_URI", 'https://jgame.web.fc2.com/auth.php'); // リダイレクトURIを入力

$code = $_GET['code'];
// 認可前
if (empty($code)) {
    $params = array(
        'client_id'     => OAUTH2_CLIENT_ID,
        'redirect_uri'  => OAUTH2_REDIRECT_URI,
        'response_type' => 'code',
        'scope'         => 'read_products','read_sales'
    );
    $auth_url = OAUTH2_SITE . '/oauth/authorize?' . http_build_query($params);
    header('Location: ' . $auth_url);
    exit;
}

// 認可後
$params = array(
    'client_id'     => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'code'          => $code,
    'grant_type'    => 'authorization_code',
    'redirect_uri'  => OAUTH2_REDIRECT_URI
);
$request_options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => http_build_query($params)
    )
);
$context = stream_context_create($request_options);

$token_url = OAUTH2_SITE . '/oauth/token';
$response_body = file_get_contents($token_url, false, $context);
$response_json = json_decode($response_body);

echo $response_body;