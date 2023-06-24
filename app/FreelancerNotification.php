<?php

namespace App;

use App\Events\NotificationSavedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FreelancerNotification extends Model
{
    private $defaultValue = ['id' ,'freelancer_id','image','description_en', 'description_ar','user_id','data','created_at','updated_at'];
    private $imageValue = [
        'cancellation' => 'img/close_n.png',
        'reminder' => 'img/history_n.png',
        'subscription' => 'img/history_n.png',
        'reschedule' => 'img/history_n.png',
        'cancellationMeetingMySelf' => 'img/close_n.png',
        'cancellationServiceMySelf' => 'img/close_n.png',
        'bookingWorkshop' => 'img/deals_n.png',
        'bookingMeeting' => 'img/deals_n.png',
        'bookingService' => 'img/deals_n.png',
        'workshopBooked' => 'img/deals_n.png',
        'newMessage' => 'img/deals_n.png',
        'billPaid' => 'img/deals_n.png',
        'cancellationMeeting' => 'img/close_n.png',
        'workshopCancel' => 'img/close_n.png',
    ];
    private static $descriptionValue = [
        'cancellation' => [
            'en' => "<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong>.</p>",
            'ar' => "<p>تم إلغاء الخدمة المحجوزة مسبقاً مع <strong>:name</strong> في الساعة <strong>:time</strong> في تاريخ <strong>:date</strong>.</p>",
        ],
        'cancellationMeeting' => [
            'en' => "<p>Your appointment with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong> by the user.</p>",
            'ar' => "<p> موعدك مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> تم <strong> إلغاءه </strong> من قبل المستخدم. </p>",
        ],
        'reminder' => [
            'en' => "<p>Reminder you have appointment with <strong>:name</strong> at :time on the <strong>:date.</strong></p>",
            'ar' => "<p>تذكير! لديك موعد مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong>.</p>",
        ],
        'subscription' => [
            'en' => '<p>Reminder! your subscriptions with Deals App is due in two days. If you would like to renew visit the website <a href="http://www.dealsco.app">www.dealsco.app</a>.</p>',
            'ar' => '<p>تذكير! اشتراكك مع تطبيق ديلز سيتم انتهاؤه خلال يومين. اذا كنت ترغب في تجديد الاشتراك قم بزيارة موقعنا <a href="http://www.dealsco.app">www.dealsco.app</a></p>',
        ],
        'bookingService' => [
            'en' => '<p>Hey, there is new service booking.</p>',
            'ar' => '<p>مرحبا، لديك خدمة جديدة</p>',
        ],
        'bookingMeeting' => [
            'en' => '<p>Hey, there is new meeting appointment.</p>',
            'ar' => '<p>مرحباً، لديك موعد اجتماع جديد</p>',
        ],
        'bookingWorkshop' => [
            'en' => '<p>Your workshop is fully booked.</p>',
            'ar' => '<p>تم اكتمال عدد المقاعد لورشة العمل الخاصة بك</p>',
        ],
        'receiveNotification' => [
            'en' => '<p>Hey, there is new quotation request.</p>',
            'ar' => '<p>مرحباً، لديك طلب عرض سعر جديد</p>',
        ],
        'cancellationServiceMySelf' => [
            'en' => '<p>You have canceled your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong>.</p>',
            'ar' => '<p>لقد ألغيت حجزك باستخدام <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong>. </p>',
        ],
        'cancellationMeetingMySelf' => [
            'en' => '<p>You have canceled your appointment with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong>.</p>',
            'ar' => '<p> لقد ألغيت موعدك مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong>. </p>',
        ],
        'reschedule' => [
            'en' => '<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>rescheduled</strong> by the :name to <strong>:newDate</strong> on the <strong>:newTime</strong>.</p>',
            'ar' => '<p>تمت إعادة جدولة حجزك باستخدام <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> بواسطة :name في <strong>:newDate</strong> في <strong>:newTime</strong>. </p>',
        ],
        'billPaid' => [
            'en' => '<p><strong>:name</strong> is paid a bill of <strong>:amount</strong> towards <strong>:description</strong>.</p>',
            'ar' => '<p><strong>:name</strong> يدفع فاتورة <strong>:amount</strong> تجاه <strong>:description</strong>.</p>',
        ],
        'workshopBooked' => [
            'en' => '<p>A workshop has been booked by a <strong>:name</strong>.</p>',
            'ar' => '<p>تم حجز ورشة عمل من قبل <strong>:name</strong>.</p>',
        ],
        'workshopCancel' => [
            'en' => '<p>A workshop has been canceled by <strong>:name</strong>.</p>',
            'ar' => '<p>تم إلغاء ورشة عمل بواسطة  <strong>:name</strong>.</p>',
        ],
        'newMessage' => [
            'en' => '<p>You have a new message from <strong>:name</strong>.</p>',
            'ar' => '<p>لديك رسالة جديدة من <strong>:name</strong>.</p>',
        ],
    ];

    protected $dispatchesEvents = [
        'saved' => NotificationSavedEvent::class
    ];

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setAttribute($key, $value)
    {
        if ( ! in_array($key , $this->defaultValue) ){
            $data = parent::getAttribute('data');
            $data = json_decode($data,true) ?? [];
            $variables = array_merge($data , [$key=>$value]);
            $value = json_encode($variables);
            $key = 'data';
        }
        if ($key == "image" and isset($this->imageValue[$value]) )
            if ( Str::startsWith( $this->imageValue[$value] , 'img/'))
                $value = asset($this->imageValue[$value]) ;
            else
                $value = $this->imageValue[$value] ;
        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if ( ! in_array($key , $this->defaultValue) ){
            $data = parent::getAttribute('data');
            $data = json_decode($data,true) ?? [];
            if ( isset($data[$key]) )
                return $data[$key];
            if ( $key == "description_html_en")
                return parent::getAttribute($key);
            if ( $key == "description_html_ar")
                return parent::getAttribute($key);
        }
        if ( $key == "description_en")
            return strip_tags(parent::getAttribute($key));
        if ( $key == "description_ar")
            return strip_tags(parent::getAttribute($key));
        return parent::getAttribute($key);
    }

    public function toArray()
    {
        $allData = parent::toArray();
        $allData['description_html_en'] = $allData['description_en'];
        $allData['description_html_ar'] = $allData['description_ar'];
        $allData['description_en'] = strip_tags($allData['description_en']);
        $allData['description_ar'] = strip_tags($allData['description_ar']);
        $data = json_decode($allData['data'],true) ?? [];
        foreach ($data as $key => $value )
            $allData[$key] = $value;
        unset($allData['data']);
        return $allData;
    }

    public static function add($user_id , $freelancer_id , $description , $image , $data = []){
        $notification = new FreelancerNotification();
        $notification->freelancer_id = $freelancer_id;
        $notification->image = $image;
        if ( ! isset( $description['en']) and ! isset( $description['ar']) ){
            $description = call_user_func_array([$notification,'description'] , $description);
        }
        $notification->description_en = $description['en'];
        $notification->description_ar = $description['ar'];
        $notification->user_id = $user_id;
        if ( is_array($data))
            foreach ($data  as $key => $value)
                $notification->$key = $value;
        $notification->save();
    }

    public static function description($message , $name = null , $date = null , $data = [] , $newDate = null , $name2 = null ){
        $find = [':name' , ':time' , ':date' , ':dateTime' , ':newTime' , ':newDate' , ':newDateTime' , ':name2'];
        $replace = [
            (is_array($name) ? implode(' ',$name) : $name),
            Carbon::parse($date)->format('H:i A'),
            Carbon::parse($date)->format('j\<\s\u\p\>S\<\/\s\u\p\> M. Y'),
            Carbon::parse($date)->format('H:i A j\<\s\u\p\>S\<\/\s\u\p\> M. Y'),
            Carbon::parse($newDate)->format('H:i A'),
            Carbon::parse($newDate)->format('j\<\s\u\p\>S\<\/\s\u\p\> M. Y'),
            Carbon::parse($newDate)->format('H:i A j\<\s\u\p\>S\<\/\s\u\p\> M. Y'),
            (is_array($name2) ? implode(' ',$name2) : $name2),
        ];
        if ( is_array($data))
            foreach ($data  as $key => $value){
                $find[] = ':'.$key;
                $replace[] = $value;
            }
        if ( isset(self::$descriptionValue[$message]) ){
            $description['en'] = str_replace($find ,$replace , self::$descriptionValue[$message]['en'] );
            $description['ar'] = str_replace($find ,$replace , self::$descriptionValue[$message]['ar'] );
        } else {
            if ( is_array($message) ){
                $description['en'] = str_replace($find ,$replace , $message['en'] );
                $description['ar'] = str_replace($find ,$replace , $message['ar'] );
            } else {
                $description['ar'] = $description['en'] = str_replace($find ,$replace , $message );
            }
        }
        return $description;
    }
}
