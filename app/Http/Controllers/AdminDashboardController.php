<?php

namespace App\Http\Controllers;

use App\Log;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Settings;
use DB;
use Common;
use Carbon;
use App\Gapi\Gapi;


class AdminDashboardController extends Controller
{
    //view home page
    public function index()
    {
        $settings = Settings::where("keyname", "setting")->first();
        $data = [
            'headTitle' => "Dashboard",
        ];
        return view('gwc.dashboard.index', ['data' => $data, 'settings' => $settings]);
    }


    //get unread contact us messages
    public static function getUnreadMessages()
    {
        $messages = Message::where('is_read', 0)->orderBy('created_at', 'DESC')->get();
        return $messages;
    }


    //get today logs
    public static function getTodayLogs()
    {
        $logs = Log::orderBy('created_at', 'DESC')->whereDate('created_at', Carbon::today())->get();
        return $logs;
    }



	
	
	
	
	
	
	
	



    ///get setting details
    public static function getSettingsDetails()
    {
        $settings = Settings::where('keyname', 'setting')->first();
        return $settings;
    }

    //get chart for sale
    public static function getChartvalues()
    {
        $v = '';
        for ($m = 1; $m <= 12; $m++) {
            $v .= self::Monthlysale($m) . ',';
        }
        return $v;
    }

    //Monthly sale
    public static function Monthlysale($m)
    {
        $amt = 0;
        if (strlen($m) == 1) {
            $m = "0" . $m;
        }
        $date = date("Y") . "-" . $m;
        $soldorders = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $date . '%')->get();
        if (!empty($soldorders)) {
            foreach ($soldorders as $soldorder) {
                $amt += self::getOrderAmounts($soldorder->id);
            }
        }
        return $amt;
    }

    //get orders
    //get chart for sale
    public static function getChartvalues_Orders()
    {
        $v = '';
        for ($m = 1; $m <= 12; $m++) {
            $v .= self::Monthlyorder($m) . ',';
        }
        return $v;
    }

    //Monthly order
    public static function Monthlyorder($m)
    {
        $amt = 0;
        if (strlen($m) == 1) {
            $m = "0" . $m;
        }
        $date = date("Y") . "-" . $m;
        $soldorders = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $date . '%')->get()->count();
        return $soldorders;
    }

    //to order amount
    public static function thisMonthGrow()
    {
        $cdate = date("Y-m");
        $pdate = date("Y-m", strtotime("-1 months"));
        $currentAmount = 0;
        $prevAmount = 0;
        $percentChange = 0;
        $soldorders_c = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $cdate . '%')->get();
        if (!empty($soldorders_c)) {
            foreach ($soldorders_c as $soldorder_c) {
                $currentAmount += self::getOrderAmounts($soldorder_c->id);
            }
        }
        //
        $soldorders_p = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $pdate . '%')->get();
        if (!empty($soldorders_p)) {
            foreach ($soldorders_p as $soldorder_p) {
                $prevAmount += self::getOrderAmounts($soldorder_p->id);
            }
        }
        //get percentage
        if (!empty($prevAmount) && !empty($currentAmount)) {
            $percentChange = (1 - $prevAmount / $currentAmount) * 100;
        } else {
            $percentChange = 0;
        }
        return $percentChange;
    }

    //order grow
    public static function thisMonthOrderGrow()
    {
        $cdate = date("Y-m");
        $pdate = date("Y-m", strtotime("-1 months"));
        $currentAmount = 0;
        $prevAmount = 0;
        $percentChange = 0;
        $soldorders_c = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $cdate . '%')->get();
        if (!empty($soldorders_c)) {
            $currentAmount = count($soldorders_c);
        }
        //
        $soldorders_p = OrdersDetails::where('order_status', 'completed')->where('created_at', 'LIKE', '%' . $pdate . '%')->get();
        if (!empty($soldorders_p)) {
            $prevAmount = count($soldorders_p);
        }
        //get percentage
        if (!empty($currentAmount)) {
            $percentChange = (1 - $prevAmount / $currentAmount) * 100;
        } else {
            $percentChange = 0;
        }
        return $percentChange;
    }

    //get total order amount
    public static function getOrderAmounts($id)
    {
        $totalAmt = 0;
        $orderDetails = OrdersDetails::Where('id', $id)->first();
        $listOrders = Orders::where('oid', $id)->get();
        if (!empty($listOrders) && count($listOrders) > 0) {
            foreach ($listOrders as $listOrder) {
                $totalAmt += ($listOrder->quantity * $listOrder->unit_price);
            }
            //apply coupon if its not free
            if (!empty($orderDetails->coupon_code) && empty($orderDetails->coupon_free)) {
                $totalAmt = $totalAmt - $orderDetails->coupon_amount;
            }
            //apply delivery charges if coupon is empty
            if (empty($orderDetails->coupon_free)) {
                $totalAmt = $totalAmt + $orderDetails->delivery_charges;
            }
        }

        return $totalAmt;
    }

    //google analytics
    public static function gareport()
    {
        //$p12 = public_path('/uploads/keys.p12');
        //$ga_profile_id = "236997161";
        //$ga = new Gapi("alrayahkw@al-rayahkw.iam.gserviceaccount.com", $p12);
        //$unique_id = "102058777958989704913";
        //$private_key_password = "notasecret";
        //$p12 = base_path('/public/uploads/keys.p12');
        $p12 = base_path('/public/uploads/theboxlab-55b7c8f0a711.p12');
        $ga = new Gapi("theboxlab@theboxlab.iam.gserviceaccount.com", $p12);
        $accessToken = $ga->getToken();
        return $accessToken;
    }

}
