<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/stripe_model.php");

class Register extends FJF_CMD
{
    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->pageModel = new PageModel();
        SessionModel::redirectUser();
    }

    function execute()
    {
        $this->pageModel->loadSettings("registration");
        $page = $this->pageModel->getSettings();

        $homepageInfo = FJF_BASE_RICH::getRecord("site_data", "name = 'homepage'");
        $homepageInfoData = json_decode($homepageInfo->data);
        $page->left_description = is_object($homepageInfoData) && $homepageInfoData != "" ? $homepageInfoData->hero_subtitle : "";

        $status = "";
        $hasError = false;

        $action = isset($_REQUEST["action"]) ? trim($_REQUEST["action"]) : "";
        $subaction = isset($_REQUEST["subaction"]) ? trim($_REQUEST["subaction"]) : "";

        if ($action == "verify") {
            $hash = isset($_REQUEST["hash"]) ? trim($_REQUEST["hash"]) : "";
            $userInfo = ($hash != "") ? FJF_BASE_RICH::getRecord("users", "verify_hash='HASH'", array("HASH" => $hash)) : null;
            if (!empty($userInfo)) {
                $userInfo->status = 1;
                $userInfo->verify_hash = "";
                FJF_BASE_RICH::saveRecord("users", get_object_vars($userInfo));
                $this->sessionModel->login($userInfo, true);
                FJF_BASE::redirect("/");
            } else {
                FJF_BASE::redirect("/");
            }
        }

        if ($action == "admin-verify") {
            $hash = isset($_REQUEST["hash"]) ? trim($_REQUEST["hash"]) : "";
            $userInfo = ($hash != "") ? FJF_BASE_RICH::getRecord("users", "verify_hash='HASH'", array("HASH" => $hash)) : null;
            if (!empty($userInfo)) {
                $userInfo->status = 1;
                $userInfo->verify_hash = "";
                FJF_BASE_RICH::saveRecord("users", get_object_vars($userInfo));
                include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
                MailModel::sendSuccessMessageToNewUser($userInfo);
                FJF_BASE_RICH::deleteRecords("workflow", "content_id='CONTENT_ID' AND content_type='CONTENT_TYPE'", array(
                    'CONTENT_ID' => $userInfo->id,
                    'CONTENT_TYPE' => "users"
                ));
            } else {
                FJF_BASE::redirect("/");
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = (isset($_POST["action"])) ? trim($_POST["action"]) : "";
            if ($action == "buyer-registration") {
                $buyerNameF = (isset($_POST["buyer_name_ind"])) ? htmlspecialchars(trim($_POST["buyer_name_ind"])) : "";
                $buyerNameS = (isset($_POST["buyer_name"])) ? htmlspecialchars(trim($_POST["buyer_name"])) : "";
                $fields["name"] = $buyerNameF . $buyerNameS;
                $fields["company_name"] = (isset($_POST["company_name"])) ? htmlspecialchars(trim($_POST["company_name"])) : "";
                $fields["discount_code"] = (isset($_POST["discount_code"])) ? htmlspecialchars(trim($_POST["discount_code"])) : "";
                $fields["url_title"] = strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $fields["name"]), "-"));
                $fields["email"] = (isset($_POST["buyer_email"])) ? trim($_POST["buyer_email"]) : "";
                $fields["address"] = (isset($_POST["address"])) ? trim($_POST["address"]) : "";
                $fields["mobile_number"] = (isset($_POST["mobile_number"])) ? trim($_POST["mobile_number"]) : "";
                $password = (isset($_POST["buyer_password"])) ? $_POST["buyer_password"] : "";
                $passwordConfirmation = (isset($_POST["buyer_verify_password"])) ? $_POST["buyer_verify_password"] : "";
                $fields["password"] = ($password != "") ? md5($password) : "";
                $fields["status"] = 0;
                $fields["zip"] = (isset($_POST["zip"])) ? $_POST["zip"] : "";
                $fields["buyer_type"] = (isset($_POST["type"])) ? trim($_POST["type"]) : "";

                $userInfo = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL'", array("EMAIL_VAL" => $fields["email"]));
                if (is_object($userInfo)) {
                    $hasError = true;
                    $status .= "Email already in use.<br />";
                }
                if ($fields["discount_code"] != '') {
                    $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $fields["discount_code"],'STATUS' => 1));
                    if($code){

                    }else{
                      $hasError = true;
                      $status .= "Discount code dose not exists.<br />";
                    }

                }


                if (!$fields["email"]) {
                    $hasError = true;
                    $status .= "Email is missing.<br />";
                } elseif (!preg_match("/^.+\@.+\..{2,}$/", $fields["email"])) {
                    $hasError = true;
                    $status .= "Invalid Email format.<br />";
                }

                if ($fields["buyer_type"] == "dealer") {
                    if (!$fields["company_name"]) {
                        $hasError = true;
                        $status .= "Dealership Name is missing.<br/>";
                    }
                    if (!$fields["name"]) {
                        $hasError = true;
                        $status .= "Contact Name is missing.<br/>";
                    }
                } else {
                    if (!$fields["name"]) {
                        $hasError = true;
                        $status .= "Name is missing.<br/>";
                    }
                }

                if (!$fields["zip"]) {
                    $hasError = true;
                    $status .= "Zip Code is missing.<br/>";
                }

                if ($password == "") {
                    $hasError = true;
                    $status .= "Password is missing.<br/>";
                } elseif (strlen($password) < 8) {
                    $hasError = true;
                    $status .= "Password must contain at least 8 characters.<br/>";
                } elseif (!preg_match('/[^a-zA-Z]+/', $password)) {
                    $hasError = true;
                    $status .= "Password must include at least one number or special character.<br/>";
                } elseif (!preg_match('/[a-zA-Z]/', $password)) {
                    $hasError = true;
                    $status .= "Password must include at least one letter.<br/>";
                } elseif ($password != $passwordConfirmation) {
                    $hasError = true;
                    $status .= "Your passwords don't match.<br/>";
                }

                if (!$hasError) {
                    $_SESSION["account_info"] = $fields;
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;
                $output["buyer_type_value"] = $fields["buyer_type"];

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            }
            elseif ($action == "buyer-verifying-type") {
                $fields["name"] = (isset($_SESSION["account_info"]["name"])) ? trim($_SESSION["account_info"]["name"]) : "";
                $fields["discount_code"] = (isset($_SESSION["account_info"]["discount_code"])) ? trim($_SESSION["account_info"]["discount_code"]) : "";
                $fields["company_name"] = (isset($_SESSION["account_info"]["company_name"])) ? trim($_SESSION["account_info"]["company_name"]) : "";
                $fields["url_title"] = (isset($_SESSION["account_info"]["url_title"])) ? trim($_SESSION["account_info"]["url_title"]) : "";
                $fields["email"] = (isset($_SESSION["account_info"]["email"])) ? trim($_SESSION["account_info"]["email"]) : "";
                $fields["address"] = (isset($_SESSION["account_info"]["address"])) ? trim($_SESSION["account_info"]["address"]) : "";
                $fields["mobile_number"] = (isset($_SESSION["account_info"]["mobile_number"])) ? trim($_SESSION["account_info"]["mobile_number"]) : "";
                $fields["password"] = (isset($_SESSION["account_info"]["password"])) ? trim($_SESSION["account_info"]["password"]) : "";
                $fields["status"] = (isset($_SESSION["account_info"]["status"])) ? trim($_SESSION["account_info"]["status"]) : "";
                $fields["zip"] = (isset($_SESSION["account_info"]["zip"])) ? trim($_SESSION["account_info"]["zip"]) : "";
                $fields["buyer_type"] = (isset($_SESSION["account_info"]["buyer_type"])) ? trim($_SESSION["account_info"]["buyer_type"]) : "";
                $fields["drivers_license_number"] = (isset($_POST["individual_dl_number"])) ? trim($_POST["individual_dl_number"]) : "";
                $fields["drivers_license_state"] = (isset($_POST["individual_state"])) ? trim($_POST["individual_state"]) : "";
                $dateOfBirth = (isset($_POST["individual_date_of_birth"])) ? trim($_POST["individual_date_of_birth"]) : "";
                $licenseIssueDate = (isset($_POST["individual_issure_date"])) ? trim($_POST["individual_issure_date"]) : "";
                $licenseExpirationDate = (isset($_POST["individual_expiration_date"])) ? trim($_POST["individual_expiration_date"]) : "";
                $fields["drivers_license_photo"] = (isset($_POST["drivers_license_photo"])) ? intval($_POST["drivers_license_photo"]) : 0;
                $fields["dealers_license_issued_to"] = (isset($_POST["dealers_license_issued_to"])) ? trim($_POST["dealers_license_issued_to"]) : "";
                $fields["dealers_license_state"] = (isset($_POST["dealers_license_state"])) ? trim($_POST["dealers_license_state"]) : "";
                $fields["dealers_license_number"] = (isset($_POST["dealers_license_number"])) ? trim($_POST["dealers_license_number"]) : "";
                $dealersLicenseIssueDate = (isset($_POST["dealers_license_issue_date"])) ? trim($_POST["dealers_license_issue_date"]) : "";
                $dealersLicenseExpirationDate = (isset($_POST["dealers_license_expiration_date"])) ? trim($_POST["dealers_license_expiration_date"]) : "";
                $fields["dealers_license_photo"] = (isset($_POST["dealers_license_photo"])) ? intval($_POST["dealers_license_photo"]) : 0;
                $fields["uid"] = FJF_BASE::getRandToken(32);

                if ($fields["buyer_type"] == "individual") {
                    if (!$fields["drivers_license_number"]) {
                        $hasError = true;
                        $status .= "DL number is missing.<br/>";
                    } else {
                        $fields["drivers_license_number"] = FJF_BASE::encrypt($fields["drivers_license_number"], "drivers_license_number");
                    }
                    if (!$fields["drivers_license_state"]) {
                        $hasError = true;
                        $status .= "State is missing.<br/>";
                    }
                    if (!$dateOfBirth) {
                        $hasError = true;
                        $status .= "Date Of Birth is missing.<br/>";
                    }
                    if (isset($dateOfBirth) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dateOfBirth)) {
                        $hasError = true;
                        $status .= "'Date Of Birth' invalid date format.<br/>";
                    } else {
                        $birthDateFormat = date_create_from_format('m.d.Y', $dateOfBirth);
                        $fields["date_of_birth"] = date_format($birthDateFormat, 'Y-m-d H:i:s');
                    }
                    if (!$licenseIssueDate) {
                        $hasError = true;
                        $status .= "Issue Date is missing.<br/>";
                    }
                    if (isset($licenseIssueDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $licenseIssueDate)) {
                        $hasError = true;
                        $status .= "'Issue Date' invalid date format.<br/>";
                    } else {
                        $licenseIssueDateFormat = date_create_from_format('m.d.Y', $licenseIssueDate);
                        $fields["license_issue_date"] = date_format($licenseIssueDateFormat, 'Y-m-d H:i:s');
                    }
                    if ($licenseIssueDate && strtotime($fields["license_issue_date"]) > time()) {
                        $hasError = true;
                        $status .= "Issue Date must be in the past.<br/>";
                    }

                    if (!$licenseExpirationDate) {
                        $hasError = true;
                        $status .= "Expiration Date is missing.<br/>";
                    }
                    if (isset($licenseExpirationDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $licenseExpirationDate)) {
                        $hasError = true;
                        $status .= "'Expiration Date' invalid date format.<br/>";
                    } else {
                        $licenseExpirationDateFormat = date_create_from_format('m.d.Y', $licenseExpirationDate);
                        $fields["license_expiration_date"] = date_format($licenseExpirationDateFormat, 'Y-m-d H:i:s');
                    }
                    if (isset($fields["license_expiration_date"]) && strtotime($fields["license_expiration_date"]) < time()) {
                        $hasError = true;
                        $status .= "Expiration Date must be in the future.<br/>";
                    }
                    if (!$fields["drivers_license_photo"]) {
                        $hasError = true;
                        $status .= "Drivers License is missing.<br/>";
                    }

                } elseif ($fields["buyer_type"] == "dealer") {
                    if (!$fields["dealers_license_issued_to"]) {
                        $hasError = true;
                        $status .= "Dealers License Issued To is missing.<br/>";
                    }
                    if (!$fields["dealers_license_state"]) {
                        $hasError = true;
                        $status .= "Dealers License State is missing.<br/>";
                    }
                    if (!$fields["dealers_license_number"]) {
                        $hasError = true;
                        $status .= "Dealers License Number is missing.<br/>";
                    } else {
                        $fields["dealers_license_number"] = FJF_BASE::encrypt($fields["dealers_license_number"], "dealers_license_number");
                    }
                    if (!$dealersLicenseIssueDate) {
                        $hasError = true;
                        $status .= "Dealers Issue Date is missing.<br/>";
                    }
                    if (isset($dealersLicenseIssueDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseIssueDate)) {
                        $hasError = true;
                        $status .= "'Dealers Issue Date' invalid date format.<br/>";
                    } else {
                        $dealersLicenseIssueDateFormat = date_create_from_format('m.d.Y', $dealersLicenseIssueDate);
                        $fields["dealers_license_issue_date"] = date_format($dealersLicenseIssueDateFormat, 'Y-m-d H:i:s');
                    }
                    if (isset($fields["dealers_license_issue_date"]) && strtotime($fields["dealers_license_issue_date"]) > time()) {
                        $hasError = true;
                        $status .= "Issue Date must be in the past.<br/>";
                    }

                    if (!$dealersLicenseExpirationDate) {
                        $hasError = true;
                        $status .= "Dealers Expiration Date is missing.<br/>";
                    }
                    if (isset($dealersLicenseExpirationDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseExpirationDate)) {
                        $hasError = true;
                        $status .= "'Dealers Expiration Date' invalid date format.<br/>";
                    } else {
                        $dealersLicenseExpirationDateFormat = date_create_from_format('m.d.Y', $dealersLicenseExpirationDate);
                        $fields["dealers_license_expiration_date"] = date_format($dealersLicenseExpirationDateFormat, 'Y-m-d H:i:s');
                    }
                    if (isset($fields["dealers_license_expiration_date"]) && strtotime($fields["dealers_license_expiration_date"]) < time()) {
                        $hasError = true;
                        $status .= "Dealers Expiration Date must be in the future.<br/>";
                    }

                    if (!$fields["dealers_license_photo"]) {
                        $hasError = true;
                        $status .= "Dealers License is missing.<br/>";
                    }
                }

                if (!$hasError) {
                    $_SESSION["account_info"] = $fields;
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            } elseif ($action == "credit-card-info") {
                $fields["cc_exp_month"] = (isset($_POST["card_month"])) ? trim($_POST["card_month"]) : "";
                $fields["cc_exp_year"] = (isset($_POST["card_year"])) ? trim($_POST["card_year"]) : "";

                $buyerTerms = isset($_POST["buyer_terms"]) ? 1 : 0;
                if (!$buyerTerms) {
                    $hasError = true;
                    $status .= "You must agree to the terms & conditions in order to complete registration.<br/>";
                }

                if (!$hasError) {
                    $fields = $_SESSION["account_info"];
                    $fields["verify_hash"] = SessionModel::getRandString(8) . md5($_SESSION["account_info"]["email"]);
                    $stripeTokenID = (isset($_POST["stripe_id"])) ? trim($_POST["stripe_id"]) : "";

                    $fields["datetime_register"] = date("Y-m-d H:i:s");
                    $fields["user_type"] = "Buyer";
                    $fields["user_type_origin"] = "Buyer";

                    if ($fields["zip"] != "") {
                        $location = RecordsModel::getCityStateByZip($fields["zip"]);
                        if (!empty($location)) {
                            $fields["lat"] = $location["lat"];
                            $fields["lon"] = $location["lon"];
                            $fields["city"] = $location["city"];
                            $fields["state"] = $location["state"];
                            $fields["timezone"] = RecordsModel::getTimeZone($location["lat"] . "," . $location["lon"]);
                        }
                    } else {
                        $fields["lat"] = "";
                        $fields["lon"] = "";
                        $fields["city"] = "";
                        $fields["state"] = "";
                        $fields["timezone"] = "";
                    }

                    if ($stripeTokenID != '') {
                        $metadata["email"] = $fields["email"];
                        $nameArr = explode(" ", $fields["name"]);
                        $metadata["first_name"] = $nameArr[0];
                        $metadata["last_name"] = (count($nameArr) > 1) ? $nameArr[1] : "";
                        $metadata["zip"] = $fields["zip"];

                        try {
                            \Stripe\Stripe::setVerifySslCerts(false);
                            StripeModel::setApiKey();
                            $fields["stripe_id"] = StripeModel::createCustomer(
                                $stripeTokenID,
                                $metadata["email"],
                                $metadata
                            );
                        } catch (Exception $e) {
                            $hasError = true;
                            $status .= $e->getMessage();
                        }
                    }

                    if (!$hasError && FJF_BASE_RICH::saveRecord("users", $fields)) {
                        $response["status"] = true;
                        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
                        if ($fields["email"]) {
                            $message = "";
                            $message .= "<b>Name:</b> " . $fields["name"] . "<br />";
                            $message .= "<b>Email:</b> " . $fields["email"] . "<br /><br />";
                            $message .= "<b>Please enter the link for verifying your account.</b><br />";
                            $message .= "http://" . $_SERVER["SERVER_NAME"] . "/registration/verify/" . $fields["verify_hash"];

                            MailModel::sendEmail(
                                $fields["email"],
                                "Registration Confirmation",
                                $message,
                                $fields["email"],
                                "Bid To Drive"
                            );
                        }
                    }
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            } elseif ($action == "seller-registration") {
                $fields["name"] = (isset($_POST["seller_name"])) ? htmlspecialchars(trim($_POST["seller_name"])) : "";
                $fields["discount_code"] = (isset($_POST["discount_code"])) ? htmlspecialchars(trim($_POST["discount_code"])) : "";
                $fields["url_title"] = strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $fields["name"]), "-"));
                $fields["email"] = (isset($_POST["seller_email"])) ? trim($_POST["seller_email"]) : "";
                $fields["address"] = (isset($_POST["address"])) ? trim($_POST["address"]) : "";
                $fields["mobile_number"] = (isset($_POST["mobile_number"])) ? trim($_POST["mobile_number"]) : "";
                $password = (isset($_POST["seller_password"])) ? $_POST["seller_password"] : "";
                $passwordConfirmation = (isset($_POST["seller_verify_password"])) ? $_POST["seller_verify_password"] : "";
                $fields["password"] = ($password != "") ? md5($password) : "";
                $fields["status"] = 0;
                $fields["zip"] = (isset($_POST["zip"])) ? $_POST["zip"] : "";

                $userInfo = FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL'", array("EMAIL_VAL" => $fields["email"]));
                if (is_object($userInfo)) {
                    $hasError = true;
                    $status .= "Email already in use.<br />";
                }
                if ($fields["discount_code"] != '') {
                    $code = FJF_BASE_RICH::getRecord("coupon", "code = 'CODE' And `limit` > 0 And status = 'STATUS' limit 1", array('CODE' => $fields["discount_code"],'STATUS' => 1));
                    if($code){

                    }else{
                      $hasError = true;
                      $status .= "Discount code dose not exists.<br />";
                    }

                }
                if (!$fields["email"]) {
                    $hasError = true;
                    $status .= "Email is missing.<br />";
                } elseif (!preg_match("/^.+\@.+\..{2,}$/", $fields["email"])) {
                    $hasError = true;
                    $status .= "Invalid Email format.<br />";
                }
                if (!$fields["name"]) {
                    $hasError = true;
                    $status .= "Name is missing.<br/>";
                }
                if (!$fields["zip"]) {
                    $hasError = true;
                    $status .= "Zip Code is missing.<br/>";
                }
                if ($password == "") {
                    $hasError = true;
                    $status .= "Password is missing.<br/>";
                } elseif (strlen($password) < 8) {
                    $hasError = true;
                    $status .= "Password must contain at least 8 characters.<br/>";
                } elseif (!preg_match('/[^a-zA-Z]+/', $password)) {
                    $hasError = true;
                    $status .= "Password must include at least one number or special character.<br/>";
                } elseif (!preg_match('/[a-zA-Z]/', $password)) {
                    $hasError = true;
                    $status .= "Password must include at least one letter.<br/>";
                } elseif ($password != $passwordConfirmation) {
                    $hasError = true;
                    $status .= "Your passwords don't match.<br/>";
                }

                if (!$hasError) {
                    $_SESSION["account_info"] = $fields;
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            }
            elseif ($action == "seller-confirmation") {
                $fields["name"] = (isset($_SESSION["account_info"]["name"])) ? trim($_SESSION["account_info"]["name"]) : "";
                $fields["discount_code"] = (isset($_SESSION["account_info"]["discount_code"])) ? trim($_SESSION["account_info"]["discount_code"]) : "";
                $fields["url_title"] = (isset($_SESSION["account_info"]["url_title"])) ? trim($_SESSION["account_info"]["url_title"]) : "";
                $fields["email"] = (isset($_SESSION["account_info"]["email"])) ? trim($_SESSION["account_info"]["email"]) : "";
                $fields["address"] = (isset($_SESSION["account_info"]["address"])) ? trim($_SESSION["account_info"]["address"]) : "";
                $fields["mobile_number"] = (isset($_SESSION["account_info"]["mobile_number"])) ? trim($_SESSION["account_info"]["mobile_number"]) : "";
                $fields["password"] = (isset($_SESSION["account_info"]["password"])) ? trim($_SESSION["account_info"]["password"]) : "";
                $fields["status"] = (isset($_SESSION["account_info"]["status"])) ? trim($_SESSION["account_info"]["status"]) : "";
                $fields["zip"] = (isset($_SESSION["account_info"]["zip"])) ? trim($_SESSION["account_info"]["zip"]) : "";
                $fields["dealers_license_issued_to"] = (isset($_POST["dealers_license_issued_to"])) ? trim($_POST["dealers_license_issued_to"]) : "";
                $fields["dealers_license_state"] = (isset($_POST["dealers_license_state"])) ? trim($_POST["dealers_license_state"]) : "";
                $fields["dealers_license_number"] = (isset($_POST["dealers_license_number"])) ? trim($_POST["dealers_license_number"]) : "";
                $dealersLicenseIssueDate = (isset($_POST["dealers_license_issue_date"])) ? trim($_POST["dealers_license_issue_date"]) : "";
                $dealersLicenseExpirationDate = (isset($_POST["dealers_license_expiration_date"])) ? trim($_POST["dealers_license_expiration_date"]) : "";
                $fields["dealers_license_photo"] = (isset($_POST["dealers_license_photo"])) ? intval($_POST["dealers_license_photo"]) : 0;
                $fields["uid"] = FJF_BASE::getRandToken(32);

                if (!$fields["dealers_license_issued_to"]) {
                    $hasError = true;
                    $status .= "Dealers License Issued To is missing.<br/>";
                }
                if (!$fields["dealers_license_state"]) {
                    $hasError = true;
                    $status .= "Dealers License State is missing.<br/>";
                }
                if (!$fields["dealers_license_number"]) {
                    $hasError = true;
                    $status .= "Dealers License Number is missing.<br/>";
                } else {
                    $fields["dealers_license_number"] = FJF_BASE::encrypt($fields["dealers_license_number"], "dealers_license_number");
                }
                if (!$dealersLicenseIssueDate) {
                    $hasError = true;
                    $status .= "Dealers Issue Date is missing.<br/>";
                }
                if (isset($dealersLicenseIssueDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseIssueDate)) {
                    $hasError = true;
                    $status .= "'Dealers Issue Date' invalid date format.<br/>";
                } else {
                    $dealersLicenseIssueDateFormat = date_create_from_format('m.d.Y', $dealersLicenseIssueDate);
                    $fields["dealers_license_issue_date"] = date_format($dealersLicenseIssueDateFormat, 'Y-m-d H:i:s');
                }
                if (isset($fields["dealers_license_issue_date"]) && strtotime($fields["dealers_license_issue_date"]) > time()) {
                    $hasError = true;
                    $status .= "Issue Date must be in the past.<br/>";
                }

                if (!$dealersLicenseExpirationDate) {
                    $hasError = true;
                    $status .= "Dealers Expiration Date is missing.<br/>";
                }
                if (isset($dealersLicenseExpirationDate) && !preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1]).([0-9]{4})$/", $dealersLicenseExpirationDate)) {
                    $hasError = true;
                    $status .= "'Dealers Expiration Date' invalid date format.<br/>";
                } else {
                    $dealersLicenseExpirationDateFormat = date_create_from_format('m.d.Y', $dealersLicenseExpirationDate);
                    $fields["dealers_license_expiration_date"] = date_format($dealersLicenseExpirationDateFormat, 'Y-m-d H:i:s');
                }
                if (isset($fields["dealers_license_expiration_date"]) && strtotime($fields["dealers_license_expiration_date"]) < time()) {
                    $hasError = true;
                    $status .= "Dealers Expiration Date must be in the future.<br/>";
                }

                if (!$fields["dealers_license_photo"]) {
                    $hasError = true;
                    $status .= "Dealers License is missing.<br/>";
                }

                $sellerTerms = isset($_POST["seller_terms"]) ? 1 : 0;
                if (!$sellerTerms) {
                    $hasError = true;
                    $status .= "You must agree to the terms & conditions in order to complete registration.<br/>";
                }
                if (!$hasError) {
                    if ($fields["zip"] != "") {
                        $location = RecordsModel::getCityStateByZip($fields["zip"]);
                        if (!empty($location)) {
                            $fields["lat"] = $location["lat"];
                            $fields["lon"] = $location["lon"];
                            $fields["city"] = $location["city"];
                            $fields["state"] = $location["state"];
                            $fields["timezone"] = RecordsModel::getTimeZone($location["lat"] . "," . $location["lon"]);
                        }
                    } else {
                        $fields["lat"] = "";
                        $fields["lon"] = "";
                        $fields["city"] = "";
                        $fields["state"] = "";
                        $fields["timezone"] = "";
                    }

                    $fields["verify_hash"] = SessionModel::getRandString(8) . md5($fields["email"]);
                    $fields["datetime_register"] = date("Y-m-d H:i:s");
                    $fields["user_type"] = "Seller";
                    $fields["user_type_origin"] = "Seller";
                    $fields["status_upgrade"] = "1";

                    if ($userID = FJF_BASE_RICH::saveRecord("users", $fields)) {

                        $response["status"] = true;
                        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/mail_model.php");
                        MailModel::sendConfirmMessageToUser($fields);
                        MailModel::sendNotifyingMessageToAdmin($fields);
                        $workflowData["content_id"] = $userID;
                        $workflowData["content_revision_id"] = 0;
                        $workflowData["content_title"] = $fields["name"];
                        $workflowData["content_type"] = "users";
                        $workflowData["user_id"] = 0;
                        $workflowData["datetime"] = date("Y-m-d H:i:s");
                        FJF_BASE_RICH::saveRecord("workflow", $workflowData);
                    }
                }

                $output["status"] = $status;
                $output["has_error"] = $hasError;

                header("Content-type: application/json; charset=utf-8");
                print_r(json_encode($output));
                exit;
            } elseif ($action == "profile_photo") {
                $result = array("error" => false, "status" => "", "file" => "", "file_name" => "");
                $folder = SiteMediaModel::getFolder("licenses");
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"]) {
                    try {
                        $file = SiteMediaModel::uploadFile($folder, "file");
                        if ($file) {
                            $result["file"] = $file->id;
                            $result["file_name"] = $file->name_orig;
                        }
                    } catch (Exception $e) {
                        $result["error"] = true;
                        $result["status"] = $e->getMessage();
                    }
                }

                echo json_encode($result);
                return false;
            }
            if ($this->isAjax()) {
                $result["error"] = true;
                $result["status"] = "Error: Something went wrong!";
                echo json_encode($result);
                return false;
            }
        }

        $states = FJF_BASE_RICH::getRecords("states");

        return $this->displayTemplate("register.tpl", array(
            "page" => $page,
            "states" => $states,
            "subaction" => (isset($subaction) ? $subaction : null),
        ));
    }

}

?>
