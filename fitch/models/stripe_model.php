<?php

require_once(FJF_ROOT . '/settings_stripe.php');
require_once($GLOBALS['WEB_APPLICATION_CONFIG']["app_web_path"] . '/resources/stripe-php-6.10.0/init.php');

class StripeModel
{

    static function setApiKey()
    {
        \Stripe\Stripe::setApiKey($GLOBALS['WEB_APPLICATION_CONFIG']["stripe"]["secret_key"]);
    }

    static function getPublicKey()
    {
        return $GLOBALS['WEB_APPLICATION_CONFIG']["stripe"]["public_key"];
    }

    static function createCharge($customer, $amount)
    {
        if ($stripeReponse = \Stripe\Charge::create(array(
            "customer" => $customer,
            "amount" => $amount * 100,
            "currency" => "usd"
        ))) {
            if (isset($stripeReponse->id) && $stripeReponse->id && isset($stripeReponse->paid) && $stripeReponse->paid == 1) {
                return $stripeReponse->id;
            }
        }

        throw new Exception("Your card was declined.");
    }

    static function getCharge($id)
    {
        if ($id && $stripeReponse = \Stripe\Charge::retrieve($id)) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse;
            }
        }
        return false;
    }

    static function createRefund($id, $data)
    {
        $ch = self::getCharge($id);
        if ($ch && $stripeReponse = $ch->refunds->create($data)) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse->id;
            }
        }
        return false;
    }

    static function createCustomer($card, $email, $metadata = array())
    {
        if ($stripeReponse = \Stripe\Customer::create(array(
            "card" => $card,
            "description" => "Customer for " . $email,
            "email" => $email,
            "metadata" => $metadata
        ))) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse->id;
            }
        }
        return false;
    }

    static function subscribeCustomer($id, $data)
    {
        $cu = self::getCustomer($id);
        if ($cu && $stripeReponse = $cu->subscriptions->create($data)) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse->id;
            }
        }
        return false;
    }

    static function getCustomer($id)
    {
        if ($id && $stripeReponse = \Stripe\Customer::retrieve($id)) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse;
            }
        }
        return false;
    }

    static function updateCustomer($id, $card = null, $email = null, $metadata = array())
    {
        if ($cu = self::getCustomer($id)) {
            if ($card) $cu->card = $card;
            if ($email) $cu->email = $email;
            if ($metadata) $cu->metadata = $metadata;
            $cu->save();
            return true;
        }
        return false;
    }

    static function getCustomerCard($id, $cardId = null)
    {
        if ($customer = self::getCustomer($id)) {
            if (!$cardId && isset($customer->default_source)) {
                $cardId = $customer->default_source;
            }
            if ($card = $customer->sources->retrieve($cardId)) {
                return $card;
            }
        }
        return false;
    }

    /*static function checkCustomerSubscribe($id, $subscriptionId){
        if($customer = self::getCustomer($id)){
            if($subscription = $customer->subscriptions->retrieve($subscriptionId)){
                if($subscription->status == 'trialing' || $subscription->status == 'active'){
                    return true;
                }
            }
        }
        return false;
    }*/

    static function getCustomerSubscribe($id, $subscriptionId)
    {
        if ($customer = self::getCustomer($id)) {
            if ($subscription = $customer->subscriptions->retrieve($subscriptionId)) {
                return $subscription;
            }
        }
        return false;
    }

    /*static function updateCustomerSubscribe($id, $subscriptionId, $data){
        if($customer = self::getCustomer($id)){
            if($subscription = $customer->subscriptions->retrieve($subscriptionId)){
                if($data && is_array($data)){
                    foreach($data as $key => $value){
                        $subscription->{$key} = $value;
                    }
                    return $subscription->save();
                }
            }
        }
        return false;
    }*/

    //????
    static function cancelCustomerSubscribe($id, $subscriptionId)
    {
        if ($customer = self::getCustomer($id)) {
            $data = array();
            if ($subscription = self::getCustomerSubscribe($id, $subscriptionId)) {
                $data['current_period']['start'] = $subscription->current_period_start;
                $data['current_period']['end'] = $subscription->current_period_end;
                if ($reponse = self::getInvoicesList(array(
                    "customer" => $id,
                    "limit" => 1
                ))) {
                    if (isset($reponse->data)
                        && $reponse->data[0]
                        && $reponse->data[0]->paid
                        && $reponse->data[0]->subscription == $subscriptionId
                    ) {
                        $data['payment']['total'] = $reponse->data[0]->total;
                        $data['payment']['date'] = $reponse->data[0]->date;
                        $data['payment']['charge_id'] = $reponse->data[0]->charge;
                    }
                }
                if ($reponse = $subscription->cancel()) {
                    if ($reponse->status == 'canceled') {
                        $amount = 0;
                        if (isset($data['payment']) && isset($data['current_period'])) {
                            if ($data['payment']['charge_id']
                                && $data['current_period']['start'] <= $data['payment']['date']
                                && $data['current_period']['end'] >= $data['payment']['date']
                            ) {
                                $amount = ($data['current_period']['end'] - time()) / ($data['current_period']['end'] - $data['current_period']['start']) * $data['payment']['total'];
                                if ($amount = intval($amount)) {
                                    //
                                    self::createRefund($data['payment']['charge_id'], array("amount" => $amount));
                                    $amount = $amount / 100;
                                }
                            }
                        }
                        return array("amount" => $amount);
                    }
                }
            }
        }
        return false;
    }

    /*static function createCoupon($data){
        if($stripeReponse = Stripe_Coupon::create($data)){
            if(isset($stripeReponse->id) && $stripeReponse->id){
                return $stripeReponse->id;
            }
        }
        return false;
    }*/

    static function getCoupon($id)
    {
        if ($id && $stripeReponse = \Stripe\Coupon::retrieve($id)) {
            if (isset($stripeReponse->id) && $stripeReponse->id) {
                return $stripeReponse;
            }
        }
        return false;
    }

    /*static function deleteCoupon($id){
        if($coupon = self::getCoupon($id)){
            $coupon->delete();
            return true;
        }
        return false;
    }*/

    /*static function saveCoupon($data){
        if(isset($data['id'])){
            try{
                $coupon = self::getCoupon($data['id']);
            }catch(Exception $e){
                $coupon = false;
            }
            if($coupon) $coupon->delete();
        }
        return self::createCoupon($data);
    }*/

    /*static function getCustomersList($data = array()){
        if(is_array($data) && $stripeReponse = Stripe_Customer::all($data)){
            return $stripeReponse;
        }
        return false;
    }*/

    /*static function getAllCustomersData($data = array(), $result = array()){
        if(is_array($data)){
            $data['limit'] = 10;
            try{
                $reponse = self::getCustomersList($data);
            }catch(Exception $e){
                $reponse = false;
            }
            if($reponse){
                if(isset($reponse->data) && $reponse->data){
                    $result = array_merge($result, $reponse->data);
                    if(isset($reponse->has_more) && $reponse->has_more){
                        if($lastItem = end($result)){
                            $data['starting_after'] = $lastItem->id;
                            $result = self::getAllCustomersData($data, $result);
                        }
                    }
                }
            }
        }
        return $result;
    }*/

    static function getInvoicesList($data = array())
    {
        if (is_array($data) && $stripeReponse = \Stripe\Invoice::all($data)) {
            return $stripeReponse;
        }
        return false;
    }

    /*static function getAllInvoicesData($data = array(), $result = array()){
        if(is_array($data)){
            $data['limit'] = 100;
            try{
                $reponse = self::getInvoicesList($data);
            }catch(Exception $e){
                $reponse = false;
            }
            if($reponse){
                if(isset($reponse->data) && $reponse->data){
                    $result = array_merge($result, $reponse->data);
                    if(isset($reponse->has_more) && $reponse->has_more){
                        if($lastItem = end($result)){
                            $data['starting_after'] = $lastItem->id;
                            $result = self::getAllInvoicesData($data, $result);
                        }
                    }
                }
            }
        }
        return $result;
    }*/

    /*static function getUpcomingInvoice($data = array()){
        if(is_array($data) && $stripeReponse = Stripe_Invoice::upcoming($data)){
            return $stripeReponse;
        }
        return false;
    }*/

    /*static function createPlan($data){
        if($stripeReponse = Stripe_Plan::create($data)){
            if(isset($stripeReponse->id) && $stripeReponse->id){
                return $stripeReponse->id;
            }
        }
        return false;
    }*/

    /*static function getPlan($id){
        if($id && $stripeReponse = Stripe_Plan::retrieve($id)){
            if(isset($stripeReponse->id) && $stripeReponse->id){
                return $stripeReponse;
            }
        }
        return false;
    }*/

    /*static function deletePlan($id){
        if($plan = self::getPlan($id)){
            $plan->delete();
            return true;
        }
        return false;
    }*/

    /*static function savePlan($data){
        if(isset($data['id'])){
            try{
                $plan = self::getPlan($data['id']);
            }catch(Exception $e){
                $plan = false;
            }
            if($plan) $plan->delete();
        }
        return self::createPlan($data);
    }*/

}

?>