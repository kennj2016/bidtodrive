<?php
/*include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");*/

class GetUshipHtml extends FJF_CMD
{

    function __construct()
    {
    }

    function execute()
    {
        try {
            $auctionID = (isset($_REQUEST["id"])) ? intval($_REQUEST["id"]) : 0;
            $userID = $_REQUEST['user_id'];
            $userInfo = ($userID > 0) ? FJF_BASE_RICH::getRecordBy("users", $userID) : null;

            //  Get Uship
            $sql = "SELECT year, make, model, created_by";
            $sql .= " FROM auctions";
            $sql .= " WHERE id = " . $auctionID;
            $auction = FJF_BASE_RICH::selectRecords($sql, null, true);
            $saller = FJF_BASE_RICH::getRecordBy("users", $auction->created_by);
            $uship = $this->getUship($saller, $userInfo, $auction);
            // echo "<pre>";
            // print_r( $userInfo);
            // echo "</pre>";
            // die;
            if (!is_object($uship)) {
                echo '<div class="from-to"><strong>Unknown address</strong></div>';
            } else {
                $html = '<div class="from-to"><span><strong>From:</strong> '.@$uship->route->items[0]->address->label.' </span><span><strong>To:</strong> '.@$uship->route->items[1]->address->label.'</span></div>';
                $html .= '<div class="length"><strong>Distance:</strong> '.@$uship->route->distance->label.'</div>';
                $html .= '<div class="uship-price"><strong>Estimate:</strong> '.@$uship->price->label.'</div>';
                echo $html;
            }
        } catch (Exception $ex) {
            echo '<div class="from-to"><strong>Unknown address</strong></div>';
        }
        exit;
    }

    public function getUship($saller, $buyer, $car) {
        try {
            $grant_type = 'client_credentials';
            $client_id = 'b8xj2d8wkpk6ygwjm38t5tze';
            $client_secret = 'TgsaZgRvwm';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apistaging.uship.com/oauth/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "grant_type=". $grant_type ."&client_id=". $client_id ."&client_secret=" . $client_secret,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    "postman-token: d6fcd518-ec1a-463d-ff03-f414d56e4dd9"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if (!$err) {
                $response = json_decode($response);
                $access_token = $response->access_token;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://apistaging.uship.com/v2/estimate",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\n      route: {\n        items: [\n          {\n            address: {\n              postalCode: \"$saller->zip\",\n              country: \"US\"\n            }\n          },\n          {\n            address: {\n              postalCode: \"$buyer->zip\",\n              country: \"US\"\n            }\n          }\n        ]\n      },\n      items: [\n        {\n          commodity: \"CarsLightTrucks\",\n          year: \"$car->year\",\n          makeName: \"$car->make\",\n          modelName: \"$car->model\"\n        }\n      ]\n    }",
                    CURLOPT_HTTPHEADER => array(
                        "Accept: */*",
                        "Accept-Encoding: gzip, deflate",
                        "Authorization: Bearer " . $access_token,
                        "Cache-Control: no-cache",
                        "Connection: keep-alive",
                        "Content-Length: 472",
                        "Content-Type: application/json",
                        "Host: apistaging.uship.com",
                        "Postman-Token: 7f0db0e8-1ff2-4a32-abef-e226cf848283,78887ff5-4ead-4803-80f0-fe784661642a",
                        "User-Agent: PostmanRuntime/7.15.2",
                        "cache-control: no-cache"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if (!$err) {
                    return json_decode($response);
                }
            }
            return (object)[];
        } catch (Exception $ex) {
            return (object)[];
        }
    }
}

?>
