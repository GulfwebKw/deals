<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Freelancer;
use App\Log;
use App\Message;
use App\Order;
use App\User;
use App\UserOrder;
use App\WorkshopOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Settings;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common;
use App\Gapi\Gapi;
use App\Http\Controllers\Controller;


class AdminDashboardController extends Controller
{
    //view home page
    public function index()
    {
        $settings = Settings::where("keyname", "setting")->first();
        $data = [
            'headTitle' => "Dashboard",
        ];

        $countUsers        = User::all();
        $countUser_today  = User::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countUser_week   = User::whereDate('created_at','>=', \Illuminate\Support\Carbon::now()->subWeeks(1))->get();
        $countUser_month  = User::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $Users =['total'=>count($countUsers),'today'=>count($countUser_today),'week'=>count($countUser_week),'month'=>count($countUser_month)];

        $countFreelancers        = Freelancer::all();
        $countFreelancers_today  = Freelancer::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countFreelancers_week   = Freelancer::whereDate('created_at','>=', Carbon::now()->subWeeks(1))->get();
        $countFreelancers_month  = Freelancer::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $Freelancers =['total'=>count($countFreelancers),'today'=>count($countFreelancers_today),'week'=>count($countFreelancers_week),'month'=>count($countFreelancers_month)];

        $countWorkshopOrder        = WorkshopOrder::all();
        $countWorkshopOrder_today  = WorkshopOrder::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countWorkshopOrder_week   = WorkshopOrder::whereDate('created_at','>=', Carbon::now()->subWeeks(1))->get();
        $countWorkshopOrder_month  = WorkshopOrder::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $WorkshopOrder =['total'=>count($countWorkshopOrder),'today'=>count($countWorkshopOrder_today),'week'=>count($countWorkshopOrder_week),'month'=>count($countWorkshopOrder_month)];

        $countUserOrders        = UserOrder::all();
        $countUserOrders_today  = UserOrder::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countUserOrders_week   = UserOrder::whereDate('created_at','>=', Carbon::now()->subWeeks(1))->get();
        $countUserOrders_month  = UserOrder::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $UserOrders =['total'=>count($countUserOrders),'today'=>count($countUserOrders_today),'week'=>count($countUserOrders_week),'month'=>count($countUserOrders_month)];

        $countOrders        = Order::all();
        $countOrders_today  = Order::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countOrders_week   = Order::whereDate('created_at','>=', Carbon::now()->subWeeks(1))->get();
        $countOrders_month  = Order::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $Orders =['total'=>count($countOrders),'today'=>count($countOrders_today),'week'=>count($countOrders_week),'month'=>count($countOrders_month)];

        $countCategories        = Category::all();
        $countCategories_today  = Category::whereDate('created_at', \Carbon\Carbon::today())->get();
        $countCategories_week   = Category::whereDate('created_at','>=', Carbon::now()->subWeeks(1))->get();
        $countCategories_month  = Category::whereDate('created_at','>=', Carbon::now()->subDays(30))->get();
        $Categories =['total'=>count($countCategories),'today'=>count($countCategories_today),'week'=>count($countCategories_week),'month'=>count($countCategories_month)];

        return view('gwc.dashboard.index', compact( 'settings', 'data', 'Users', 'Freelancers', 'Categories', 'UserOrders', 'Orders', 'WorkshopOrder'));
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
