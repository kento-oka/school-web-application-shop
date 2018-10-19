<?php

/**
 * サーバー変数からホストとポートを解決する
 *
 * @return  string
 *
 * @see https://github.com/fratily/http-message/blob/master/src/UriFactory.php
 */
function getResolveAuthority(){
    $host   = filter_input(INPUT_SERVER, "HTTP_HOST");

    if(is_string($host)){
        return $host;
    }

    $port   = filter_input(INPUT_SERVER, "REQUEST_PORT", FILTER_VALIDATE_INT);
    $name   = filter_input(INPUT_SERVER, "SERVER_NAME");

    if(false === $port){
        throw new \RuntimeException();
    }

    if(is_string($name)){
        return $name . (null === $port ? "" : (":" . $port));
    }

    $addrv4 = filter_input(INPUT_SERVER, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    $addrv6 = filter_input(INPUT_SERVER, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

    if(is_string($addrv4)){
        return $addrv4 . (null === $port ? "" : (":" . $port));
    }

    if(is_string($addrv6)){
        return "[" . $addrv6. "]" . (null === $port ? "" : (":" . $port));
    }

    throw new \RuntimeException;
}

/**
 * サーバー変数からパスを解決する
 *
 * @return  string
 *
 * @see https://github.com/fratily/http-message/blob/master/src/UriFactory.php
 */
function getResolvePathAndQuery(){
    $path   = filter_input(INPUT_SERVER, "REQUEST_URI");

    if(is_string($path)){
        return $path;
    }

    return "/";
}

if(PHP_SESSION_ACTIVE !== session_status()){
    session_start();
}

$userId     = $_SESSION["userId"] ?? null;
$userName   = $_SESSION["userName"] ?? null;

if(null === $userId || null === $userName){
    $cookieUserID   = filter_input(INPUT_COOKIE, "userId");
    $cookieUserName = filter_input(INPUT_COOKIE, "userName");

    if(null !== $cookieUserID && null !== $cookieUserName){
        $userId     = $cookieUserID;
        $userName   = $cookieUserName;
    }else{
        $userId     = (string)mt_rand(10000000, 99999999);
        $userName   = "ゲスト";

        setcookie("userId", $userId, time() + 60 * 60 * 24 * 14, "/");
        setcookie("userName", $userName, time() + 60 * 60 * 24 * 14, "/");
    }

    $_SESSION["userId"]     = $userId;
    $_SESSION["userName"]   = $userName;
}

$http_host  = "//" . getResolveAuthority();
$shopid     = mb_substr(getResolvePathAndQuery(), 1, 9);

$index_php          = $http_host . "/" . $shopid . "/index.php";
$cart_list_php      = $http_host . "/" . $shopid . "/cart/cart_list.php";
$order_history_php  = $http_host . "/" . $shopid . "/order/order_history.php";
$login_php          = $http_host . "/" . $shopid . "/user/login.php";
$logout_php         = $http_host . "/" . $shopid . "/user/logout.php";
$signup_php         = $http_host . "/" . $shopid . "/user/signup.php";
$shop_css           = $http_host . "/" . $shopid . "/css/shop.css";