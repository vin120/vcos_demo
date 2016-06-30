<?php

namespace app\modules\wifibillingmanagement\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionTestibs()
    {
        $xml_data = "<xml><FOX>
        <hello>world</hello>
        </FOX></xml>";
        $url = 'http://127.0.0.1/vcos/backend/web/?r=wifibilling/default/index';
        $header[] = "Content-type: text/xml";//定义content-type为xml

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        print_r($response);
        exit;
        curl_close($ch);
    }

    public function  actionTestxml()
    {
        $xml_data ='<AATAvailReq1>'.
            '<Agency>'.
            '<Iata>1234567890</Iata>'.
            '<Agent>lgsoftwares</Agent>'.
            '<Password>mypassword</Password>'.
            '<Brand>phpmind.com</Brand>'.
            '</Agency>'.
            '<Passengers>'.
            '<Adult AGE="" ID="1"></Adult>'.
            '<Adult AGE="" ID="2"></Adult>'.
            '</Passengers>'.
            '<HotelAvailReq1>'.
            '<DestCode>JHM</DestCode>'.
            '<HotelCode>OGGSHE</HotelCode>'.
            '<CheckInDate>101009</CheckInDate>'.
            '<CheckOutDate>101509</CheckOutDate>'.
            '<UseField>1</UseField>'.
            '</HotelAvailReq1>'.
            '</AATAvailReq1>';

        $URL = 'http://127.0.0.1/vcos/backend/web/?r=wifibilling/default/index';

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }
    public  function actionPay()
    {
        $xml = "<?xml version='1.0' encoding='utf-8' ?><message></message>"; ;
        $setting = array(
            'http' => array(
                'method' => 'POST',
                'user_agent' => '<Client Application Name>',
                'header' => "Content-type: application/x-www-form-urlencoded",
                'content' => $xml
            )
        );
        $context = stream_context_create($setting);
        $url = 'http://127.0.0.1/vcos/backend/web/?r=wifibilling/default/index';
        $response = file_get_contents($url, null, $context);
        echo $response;
//            $setting = array(
//                'http' =array(
//                    'method' =$amp;>amp;$nbsp;'POST',
//                'user_agent' =$amp;>amp;$nbsp;'<Client Application Name$amp;>apos;$,
//                'header' =$amp;>amp;$nbsp;"Content-type: application/x-www-form-urlencoded",
//                'content' =$amp;>amp;$nbsp;$xml
//                )
//            );
//            $context = stream_context_create($setting);
//            $url = 'http://localhost/'. $_SERVER['REQUEST_URI'];
//            $response = file_get_contents($url, null, $context);
//
//            echo $response;
    }
    public function actionIndex()
    {

        echo 1234;exit;
//        if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
            // 接收
            $content = file_get_contents('php://input');
            $xml = simplexml_load_string($content);
            echo "来自XML接收方的响应\n";
            print_r(get_object_vars($xml) );
//        }

    }
}
