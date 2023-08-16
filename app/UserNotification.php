<?php

namespace App;

use App\Events\NotificationSavedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserNotification extends Model
{
    private $defaultValue = ['id' ,'freelancer_id','image','description_en', 'description_ar','user_id','data','created_at','updated_at'];
    private $imageValue = [
        'waitingList' => 'img/history_n.png',
        'newBill' => 'img/history_n.png',
        'cancellationWithPay' => 'img/close_n.png',
        'cancellation' => 'img/close_n.png',
        'reminder' => 'img/history_n.png',
        'reschedule' => 'img/history_n.png',
        'newMessage' => 'img/deals_n.png',
        'sendQuotation' => 'img/deals_n.png',
        'cancellationMySelf' => 'img/close_n.png',
        'cancellationMeeting' => 'img/close_n.png',
        'cancellationMeetingByFreelancer' => 'img/close_n.png',
    ];
    private static $descriptionValue = [
        'waitingList' => [
            'en' => "<p>There is <strong>availability</strong> with <strong>:name</strong> on <strong>:date</strong>. Visit :name'S profile <strong>NOW</strong> to book for the available appointment.</p>",
            'ar' => "<p>يوجد موعد <strong>متاح </strong>مع <strong>:name</strong> في تاريخ <strong>:date</strong>. قم بزيارة صفحة :name الآن لحجز الموعد المتاح.</p>",
        ],
        'cancellationWithPay' => [
            'en' => "<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong>. For new service booking search for another freelancer now! Meanwhile, Deals team will contact you soon for the refund.</p>",
            'ar' => "<p>تم إلغاء الخدمة المحجوزة مسبقاً مع <strong>:name</strong> في الساعة <strong>:time</strong> في تاريخ <strong>:date</strong>. لحجز خدمة جديدة قم بالبحث عن مقدم خدمة آخر الآن! سوف يقوم فريق ديلز بالتواصل معكم لاسترداد المبلغ في أقرب وقت.</p>",
        ],
        'cancellation' => [
            'en' => "<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong>. For new service booking search for another freelancer now!</p>",
            'ar' => "<p>تم إلغاء الخدمة المحجوزة مسبقاً مع <strong>:name</strong> في الساعة <strong>:time</strong> في تاريخ <strong>:date</strong>. لحجز خدمة جديدة قم بالبحث عن مقدم خدمة آخر الآن!</p>",
        ],
        'reminder' => [
            'en' => "<p>Reminder! you have appointment with <strong>:name</strong> at <strong>:time</strong> on the <strong>:date.</strong></p>",
            'ar' => "<p>تذكير! لديك موعد مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong>.</p>",
        ],
        'reschedule' => [
            'en' => "<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>rescheduled</strong> by the :name to <strong>:newDate</strong> on the <strong>:newTime</strong>.</p>",
            'ar' => "<p> تمت إعادة جدولة حجزك باستخدام <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> بواسطة :name في <strong>:newDate</strong> في <strong>:newTime</strong>. </p>",
        ],
        'cancellationMySelf' => [
            'en' => "<p>Your booking with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong> by the :name. Deals team will contact you soon for the refund.</p>",
            'ar' => "<p>حجزك مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> بواسطة :name. سيتصل بك فريق الصفقات قريبًا لاسترداد الأموال.</p>",
        ],
        'cancellationMeeting' => [
            'en' => "<p>Your appointment with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong></p>",
            'ar' => "<p>موعدك مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> تم <strong> إلغاءه </strong> </p>",
        ],
        'cancellationMeetingByFreelancer' => [
            'en' => "<p>Your appointment with <strong>:name</strong> on the <strong>:time</strong> on <strong>:date</strong> was <strong>Cancelled</strong> by the :name. Search for another freelancer now!</p>",
            'ar' => "<p> موعدك مع <strong>:name</strong> في <strong>:time</strong> في <strong>:date</strong> تم <strong> إلغاؤه </strong> بواسطة :name. ابحث عن مترجم آخر الآن! </p>",
        ],
        'newBill' => [
            'en' => "<p>You have received a billing statement of <strong>:priceKWD</strong>. Check your inbox.</p>",
            'ar' => "<p>لقد تلقيت فاتورة بقيمة <strong>:price</strong> دينار كويتي. يرجى التحقق من صندوق الوارد الخاص بك</p>",
        ],

        'newMessage' => [
            'en' => '<p>You have a new message from <strong>:name</strong>.</p>',
            'ar' => '<p>لديك رسالة جديدة من <strong>:name</strong>.</p>',
        ],

        'sendQuotation' => [
            'en' => '<p>Hello, you have received new quotation.</p>',
            'ar' => '<p>مرحباً، لديك عرض سعر جديد.</p>',
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
        $notification = new UserNotification();
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

    public static function description($message , $name = null , $date = null , $data = [] , $newDate = null , $name2=null){
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
