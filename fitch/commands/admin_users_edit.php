<?php

include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");

class AdminUsersEdit extends FJF_CMD
{
    var $sessionModel = null;
    var $recordsModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->recordsModel = new RecordsModel();
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        $mode = isset($_GET['mode']) && in_array($_GET['mode'], array('users', 'administrators')) ? $_GET['mode'] : null;
        if (!$mode) FJF_BASE::redirect($header["return"] ? $header["return"] : "/admin/");

        if (!$header["return"]) {
            $header["return"] = "/admin/" . $mode . "/";
        }

        $id = isset($_GET["id"]) ? trim($_GET["id"]) : "";
        $record = $id ? FJF_BASE_RICH::getRecordBy("users", $id) : (object)array(
            'is_admin' => $mode == 'administrators' ? 1 : 0,
            'status' => 1,
            'password' => null,
            'datetime_register' => null,
            'datetime_login' => null,
            'datetime_create' => null,
            'datetime_update' => null
        );

        if (!$record) FJF_BASE::redirect($header["return"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record->name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
            $record->email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
            $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
            $record->status = isset($_POST["status"]) ? intval($_POST["status"]) : 0;
            $record->user_type = isset($_POST["user_type"]) ? trim($_POST["user_type"]) : "";
            $record->upgrade_seller_note = isset($_POST["upgrade_seller_note"]) ? trim($_POST["upgrade_seller_note"]) : "";
            $record->address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
            $record->buyer_type = (isset($_POST["buyer_type"]) && $_POST["buyer_type"] == "Dealer") ? "Dealer" : "Individual";
            $record->drivers_license_number = isset($_POST["drivers_license_number"]) ? trim($_POST["drivers_license_number"]) : "";
            $record->date_of_birth = isset($_POST["date_of_birth"]) && $_POST["date_of_birth"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["date_of_birth"]))) : null;
            $record->license_issue_date = isset($_POST["license_issue_date"]) && $_POST["license_issue_date"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["license_issue_date"]))) : null;
            $record->license_expiration_date = isset($_POST["license_expiration_date"]) && $_POST["license_expiration_date"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["license_expiration_date"]))) : null;
            $record->drivers_license_photo = isset($_POST["drivers_license_photo"]) ? intval($_POST["drivers_license_photo"]) : 0;
            $record->dealers_license_issued_to = isset($_POST["dealers_license_issued_to"]) && $_POST["dealers_license_issued_to"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["dealers_license_issued_to"]))) : null;
            $record->dealers_license_number = isset($_POST["dealers_license_number"]) ? trim($_POST["dealers_license_number"]) : "";
            $record->dealers_license_issue_date = isset($_POST["dealers_license_issue_date"]) && $_POST["dealers_license_issue_date"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["dealers_license_issue_date"]))) : null;
            $record->dealers_license_expiration_date = isset($_POST["dealers_license_expiration_date"]) && $_POST["dealers_license_expiration_date"] ? date("Y-m-d H:i:s", strtotime(trim($_POST["dealers_license_expiration_date"]))) : null;
            $record->dealers_license_photo = isset($_POST["dealers_license_photo"]) ? intval($_POST["dealers_license_photo"]) : 0;
            $record->profile_photo = isset($_POST["profile_photo"]) ? intval($_POST["profile_photo"]) : 0;
            $record->drivers_license_state = isset($_POST["drivers_license_state"]) ? trim($_POST["drivers_license_state"]) : "";
            $record->dealers_license_state = isset($_POST["dealers_license_state"]) ? trim($_POST["dealers_license_state"]) : "";
            $record->city = isset($_POST["city"]) ? trim($_POST["city"]) : "";
            $record->state = isset($_POST["state"]) ? trim($_POST["state"]) : "";
            $record->zip = isset($_POST["zip"]) ? trim($_POST["zip"]) : "";
            $record->mobile_number = isset($_POST["mobile_number"]) ? trim($_POST["mobile_number"]) : "";
            $record->company_name = isset($_POST["company_name"]) ? trim($_POST["company_name"]) : "";
            $record->notification_type_2 = isset($_POST["notification_type_2"]) ? intval($_POST["notification_type_2"]) : 0;
            $record->notification_type_4 = isset($_POST["notification_type_4"]) ? intval($_POST["notification_type_4"]) : 0;
            $record->notification_type_8 = isset($_POST["notification_type_8"]) ? intval($_POST["notification_type_8"]) : 0;
            $record->notification_type_18 = isset($_POST["notification_type_18"]) ? intval($_POST["notification_type_18"]) : 0;
            $record->notification_type_5 = $record->notification_type_4;
            $record->notification_type_6 = $record->notification_type_4;
            $record->notification_type_20 = $record->notification_type_2;
            $record->notification_type_9 = (isset($_POST["notification_type_9"])) ? intval($_POST["notification_type_9"]) : 0;
            $record->notification_type_10 = $record->notification_type_9;
            $record->notification_type_11 = $record->notification_type_9;
            $record->notification_type_13 = (isset($_POST["notification_type_13"])) ? intval($_POST["notification_type_13"]) : 0;
            $record->notification_type_12 = (isset($_POST["notification_type_12"])) ? intval($_POST["notification_type_12"]) : 0;
            $record->notification_type_3 = (isset($_POST["notification_type_3"])) ? intval($_POST["notification_type_3"]) : 0;
            $record->notification_type_19 = $record->notification_type_3;
            $record->notification_type_23 = (isset($_POST["notification_type_23"])) ? intval($_POST["notification_type_23"]) : 1;
            $record->notification_channel = isset($_POST["notification_channel"]) ? trim($_POST["notification_channel"]) : "both";
            $record->buyer_fee = isset($_POST["buyer_fee"]) ? intval($_POST["buyer_fee"]) : null;
            $record->uid = FJF_BASE::getRandToken(32);

            if ($record->zip != "") {
                $location = RecordsModel::getCityStateByZip($record->zip);
                if (!empty($location)) {
                    $record->lat = $location["lat"];
                    $record->lon = $location["lon"];
                    $record->city = isset($record->city) && $record->city != "" ? $record->city : $location["city"];
                    $record->state = isset($record->state) && $record->state != "" ? $record->state : $location["state"];
                }
            } else {
                $record->lat = "";
                $record->lon = "";
            }

            if ($record->lat != "" && $record->lon != "") {
                $record->timezone = RecordsModel::getTimeZone($record->lat . "," . $record->lon);
            }

            if ($record->is_admin <= $this->sessionModel->user->is_admin) {
                $record->is_admin = min(isset($_POST["is_admin"]) ? intval($_POST["is_admin"]) : 0, $this->sessionModel->user->is_admin);
            }

            if (!$record->name) {
                $hasError = true;
                $status .= "Name cannot be blank.\n";
            }

            if (!$record->email) {
                $hasError = true;
                $status .= "Email cannot be blank.\n";
            } elseif (!preg_match("/^.+\@.+\..+$/", $record->email)) {
                $hasError = true;
                $status .= "Invalid Email format.\n";
            } elseif (FJF_BASE_RICH::getRecord("users", "email='EMAIL_VAL' AND id<>'ID_VAL'", array(
                'EMAIL_VAL' => $record->email,
                'ID_VAL' => $id
            ))) {
                $hasError = true;
                $status .= "Email is already in use.\n";
            }

            if (!$record->password && !$password) {
                $hasError = true;
                $status .= "Password cannot be blank.\n";
            } elseif ($password && strlen($password) < 6) {
                $hasError = true;
                $status .= "Password must contain at least 6 characters.\n";
            }

            if ($mode != "administrators") {
                if (!$record->user_type) {
                    $hasError = true;
                    $status .= "User Type cannot be blank.\n";
                }

                if ($record->user_type == "Buyer") {
                    if ($record->buyer_type == "Individual") {
                        if ($record->drivers_license_number == "") {
                            $hasError = true;
                            $status .= "Drivers License Number cannot be blank.\n";
                        } else {
                            $record->drivers_license_number = FJF_BASE::encrypt($record->drivers_license_number, "drivers_license_number");
                        }
                        if ($record->drivers_license_state == "") {
                            $hasError = true;
                            $status .= "Drivers License State cannot be blank.\n";
                        }
                        if ($record->date_of_birth == "") {
                            $hasError = true;
                            $status .= "Date Of Birth cannot be blank.\n";
                        }
                        if ($record->license_issue_date == "") {
                            $hasError = true;
                            $status .= "License Issue Date cannot be blank.\n";
                        }
                        if ($record->license_expiration_date == "") {
                            $hasError = true;
                            $status .= "License Expiration Date cannot be blank.\n";
                        }
                        if ($record->drivers_license_photo == 0) {
                            $hasError = true;
                            $status .= "Drivers License Photo cannot be blank.\n";
                        }
                    } elseif ($record->buyer_type == "Dealer") {
                        if ($record->dealers_license_issued_to == "") {
                            $hasError = true;
                            $status .= "Dealers License Issued To cannot be blank.\n";
                        }
                        if ($record->dealers_license_number == "") {
                            $hasError = true;
                            $status .= "Dealers License Number cannot be blank.\n";
                        } else {
                            $record->dealers_license_number = FJF_BASE::encrypt($record->dealers_license_number, "dealers_license_number");
                        }
                        if ($record->dealers_license_state == "") {
                            $hasError = true;
                            $status .= "Dealers License State cannot be blank.\n";
                        }
                        if ($record->dealers_license_issue_date == "") {
                            $hasError = true;
                            $status .= "Dealers License Issue Date cannot be blank.\n";
                        }
                        if ($record->dealers_license_expiration_date == "") {
                            $hasError = true;
                            $status .= "Dealers License Expiration Date cannot be blank.\n";
                        }
                        if ($record->dealers_license_photo == 0) {
                            $hasError = true;
                            $status .= "Dealers License Photo cannot be blank.\n";
                        }
                    }
                } elseif ($record->user_type == "Seller") {
                    if ($record->dealers_license_issued_to == "") {
                        $hasError = true;
                        $status .= "Dealers License Issued To cannot be blank.\n";
                    }
                    if ($record->dealers_license_number == "") {
                        $hasError = true;
                        $status .= "Dealers License Number cannot be blank.\n";
                    } else {
                        $record->dealers_license_number = FJF_BASE::encrypt($record->dealers_license_number, "dealers_license_number");
                    }
                    if ($record->dealers_license_state == "") {
                        $hasError = true;
                        $status .= "Dealers License State cannot be blank.\n";
                    }
                    if ($record->dealers_license_issue_date == "") {
                        $hasError = true;
                        $status .= "Dealers License Issue Date cannot be blank.\n";
                    }
                    if ($record->dealers_license_expiration_date == "") {
                        $hasError = true;
                        $status .= "Dealers License Expiration Date cannot be blank.\n";
                    }
                    if ($record->dealers_license_photo == 0) {
                        $hasError = true;
                        $status .= "Dealers License Photo cannot be blank.\n";
                    }
                }
            }

            if (!$hasError) {
                $record->url_title = strtolower(trim(preg_replace("/[^a-z\d]+/i", "-", $record->name), "-"));
                $data = get_object_vars($record);
                if ($password) {
                    $data["password"] = md5($password);
                }
                if ($result = FJF_BASE_RICH::saveRecord("users", $data)) {
                    $status = "Data was saved successfully.";
                    if (!isset($_GET["id"])) {
                        FJF_BASE::status($status);
                        FJF_BASE_RICH::redirectWithReturn("/admin/" . $mode . "/" . $result . "/");
                    }
                } else {
                    $hasError = true;
                    $status = "An error occurred while saving record to DB.";
                }
            }
        }

        $states = FJF_BASE_RICH::getList("states", "country='United States'", null, "abbr", "name");

        $record->drivers_license_number = isset($record->drivers_license_number) && $record->drivers_license_number != "" ? FJF_BASE::decrypt($record->drivers_license_number, "drivers_license_number") : "";
        $record->dealers_license_number = isset($record->dealers_license_number) && $record->dealers_license_number != "" ? FJF_BASE::decrypt($record->dealers_license_number, "dealers_license_number") : "";

        $this->setToolTitle(trim(ucfirst($mode)));
        $this->setRecord($record);
        $this->addParentBreadCrumb($mode);

        return $this->displayTemplate("admin_users_edit.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "record" => $record,
            "states" => $states
        ));
    }

}

?>