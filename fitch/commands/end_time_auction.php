<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class EndTimeAuction extends FJF_CMD
{

    var $sessionModel = null;
    var $pageModel = null;

    function __construct()
    {
    }

    function execute()
    {
        try{
            FJF_BASE::capsuleOpen();
        }
        catch (Exception $e){
            return $e->getMessage();
        }
        catch (Throwable $e){
            return $e->getMessage();
        }
        $now = \Carbon\Carbon::now();
        $nowString =$now->format("Y-m-d H:i:s");
        $nowSec =$now->format("s");
        $nowStringAddMinute =$now->addMinute()->format("Y-m-d H:i");
//        echo $now->toDateTimeString()."\n";
//        echo $nowString."\n";
//        echo $nowStringAddMinute."\n";
//        echo date_default_timezone_get()."\n";
        $query = Capsule::table('auctions');

        $query
            ->where('auction_status', '=', 'Active');

        $queryUpdate = clone $query;
        $queryUpdate->whereRaw("DATE_FORMAT(`expiration_date`, '%Y-%m-%d %H:%i:%s') <= '" . $nowString . "'")
            ->update([
                'auction_status' => 'Canceled',
            ]);

        $queryNext = clone $query;
        $auctions = $queryNext
            ->whereRaw("DATE_FORMAT(`expiration_date`, '%Y-%m-%d %H:%i:%s') > '" . $nowString . "'")
            ->whereRaw("DATE_FORMAT(`expiration_date`, '%Y-%m-%d %H:%i') <= '" .$nowStringAddMinute . "'")
            ->select([
                'id',
                Capsule::raw("DATE_FORMAT(`expiration_date`, '%s') as sec")
            ])
            ->orderBy('sec', 'asc')
            ->get();

//        echo $auctions->count()."\n";

        if($auctions->count() > 0){
            $groupAuction = $auctions->groupBy('sec');
            $current = $nowSec;
            foreach ($groupAuction as $m => $group) {
                if($m < $current){
                    $m += 60;
                }
                $diff = $m - $current;
//                echo $diff;
                if($diff != 0) {
                    sleep($diff);
                }
                $queryUpdate = clone $query;
                $queryUpdate
                    ->whereIn('id', $group->pluck('id')->toArray())
                    ->update([
                        'auction_status' => 'Canceled',
                    ]);
                $current = $m;
            }
        }
    }

}