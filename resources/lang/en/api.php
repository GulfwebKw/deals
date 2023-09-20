<?php

return [
    'user' =>[
        'booked' => [
            'service' => 'Your service is successfully booked.',
            'meeting' => 'your meeting appointment is successfully booked.',
            'workshop' => 'Workshop is successfully booked.',
        ],
        'cancellation' => [
            'service' => 'Your service cancellation is successful.',
            'meeting' => 'your meeting appointment cancellation is successful.',
        ],
        'reschedule' => [
            'service' => 'Your service rescheduling is successful',
        ]
    ] ,
    'freelancer' => [
        'booked' => [
            'service' => 'Hey, there is new service booking.',
            'meeting' => 'Hey, there is new meeting appointment.',
            'workshop' => 'Your workshop is fully booked.',
        ],
        'cancellation' => [
            'service' => 'Your service cancellation is successful.',
            'workshopBooked' => 'You cannot delete a workshop once somebody has reserved it.',
            'workshop' => 'Your workshop cancellation is successful.',
            'serviceFromUser' => 'your service cancellation is successful.',
            'meeting' => 'your meeting appointment cancellation is successful.',
        ],
        'reschedule' => [
            'service' => 'Your service rescheduling is successful',
        ],
        'delete' => [
            'workshop' => 'Your workshop has been deleted successfully.',
        ],
        'pending' => 'Please wait until we review your information',
        'reject' => 'Unfortunately, your information was not verified.',
    ],
    'models' => [
        "Aboutus" => "The requested information was not found.",
        "Address" => "The desired address could not be found!",
        "Admin" => "The requested information was not found.",
        "Area" => "The requested information was not found.",
        "Attr_group" => "The requested information was not found.",
        "Attribute" => "The requested information was not found.",
        "Bill" => "The required bill could not be found!",
        "Category" => "The requested information was not found.",
        "Category_blog" => "The requested information was not found.",
        "Category_blog_translation" => "The requested information was not found.",
        "ChangePasswordOtp" => "The code could not be found!",
        "City" => "The requested information was not found.",
        "Country" => "The requested information was not found.",
        "Coupon" => "The requested information was not found.",
        "Duration" => "The requested information was not found.",
        "Faq" => "The requested information was not found.",
        "Filter" => "The requested information was not found.",
        "Freelancer" => "Active freelancer with the given specifications could not be found!",
        "FreelancerAddress" => "The address you requested could not be found!",
        "FreelancerHighlight" => "The requested information was not found.",
        "FreelancerHighlightImage" => "The requested information was not found.",
        "FreelancerNotification" => "The requested information was not found.",
        "FreelancerQuotation" => "The quote you requested could not be found!",
        "FreelancerServices" => "No active service with the specifications you are looking for!",
        "FreelancerUserMessage" => "No message found!",
        "FreelancerWorkshop" => "There is no active workshop with the specifications you want!",
        "FreelancerWorkshopTranslation" => "There is no active workshop with the specifications you want!",
        "HowItWork" => "The requested information was not found.",
        "HowItWork_translation" => "The requested information was not found.",
        "Language" => "The requested information was not found.",
        "Log" => "The requested information was not found.",
        "Meeting" => "The appointment you requested could not be found!",
        "Menus" => "The requested information was not found.",
        "Message" => "The requested information was not found.",
        "Newsletter" => "The requested information was not found.",
        "NotifyEmail" => "The requested information was not found.",
        "OTP" => "The requested information was not found.",
        "OauthAccessToken" => "The requested information was not found.",
        "Order" => "Your order could not be found!",
        "Package" => "The package you are looking for was not found!",
        "PushDevices" => "The requested information was not found.",
        "Quotation" => "The quote you requested could not be found!",
        "QuotationInstallment" => "The requested information was not found.",
        "QuotationOrder" => "The requested information was not found.",
        "QuotationService" => "The requested information was not found.",
        "Rate" => "The requested information was not found.",
        "ReportMessage" => "The requested information was not found.",
        "Resume" => "The requested information was not found.",
        "Role" => "The requested information was not found.",
        "ServiceUserOrders" => "Your order could not be found!",
        "Settings" => "The requested information was not found.",
        "Shipping" => "The requested information was not found.",
        "Singlepage" => "The requested information was not found.",
        "Slideshow" => "The requested information was not found.",
        "Sms" => "The requested information was not found.",
        "Subject" => "The requested information was not found.",
        "TimeCalender" => "Imported time is not available!",
        "Transaction" => "The transaction could not be found!",
        "User" => "Active user not found with the information you are looking for!",
        "UserFreelancer" => "The requested information was not found.",
        "UserNotification" => "The requested information was not found.",
        "UserOrder" => "Your order could not be found!",
        "UserPayment" => "The transaction could not be found!",
        "UserQuotation" => "The requested information was not found.",
        "UserWaiting" => "The requested information was not found.",
        "WebPush" => "The requested information was not found.",
        "WebPushMessage" => "The requested information was not found.",
        "WorkshopOrder" => "The requested information was not found.",
        "blog" => "The requested information was not found.",
        "blog_category" => "The requested information was not found.",
        "blog_translations" => "The requested information was not found.",
        "category_translation" => "The requested information was not found.",
        "product_translation" => "The requested information was not found.",
        "shipping_translation" => "The requested information was not found."
    ],
    'slotIsNotFree' => 'You can’t change a booked time slot',
    'incorrectLogin' => 'Email Or Password is Incorrect',
    'incorrectLogin2' => 'Mobile Or Password is Incorrect',
    'incorrectMobile' => 'Mobile number is incorrect',
    'incorrectOldPassword' => 'Old password is incorrect!',
    'otpRequired' => 'otp verification is required',
    'unknownError' => 'unknown error!',
    'LoginSuccessfully' => 'Login successfully.',
    'LogoutSuccessfully' => 'You Are Successfully Logout',
    'success' => 'success',
    'UserNotExist' => 'User Not Exist!',
    'IncorrectCode' => 'This Code Is Incorrect!',
    'passChange' => 'Password Successfully Changed',
    'UserNotFound' => 'User Not Found',
    'FreelancerDeactivate' => 'Freelancer is deactivate!',
    'canNotMakeLink' => 'can not make payment link!',
    'billMade' => 'Bill Link Generate successfully.',
    'billUpdate' => 'Bill Link updated successfully.',
    'billDeleted' => 'Bill Link deleted successfully.',
    'freelancerAddToBookmark' => 'Freelancer add to bookmark successfully.',
    'freelancerAddOrRemoveToBookmark' => 'Freelancer Add/Remove to bookmark successfully.',
    'freelancerRemoveToBookmark' => 'Freelancer remove to bookmark successfully.',
    'messageSend' => 'Your message send successfully.',
    'notAccess' => 'you dont have access!',
    'hasRate' => 'this service of order has rate!',
    'sendRate' => 'Thank you for rating this freelancer.',
    'deactivateMeeting' => 'Freelancer deactivate meeting!',
    'selectLocation' => 'Please select location.',
    'selectLocationOtherArea' => 'This address out of freelancer service area!',
    'canNotSetMeeting' => 'can not set meeting now!',
    'canNotRescheduleMeeting' => 'can not reschedule meeting now!',
    'canNotSetMeeting12H' => 'Can not cancel meeting for less than 12 hour!',
    'rescheduleMeeting12H' => "its too late for reschedule meeting!",
    'rescheduleMeeting' => 'Your meeting rescheduling is successful.',
    'freelancerBlockYou' => 'Freelancer blocked you!',
    'UserBlockYou' => 'User blocked you!',
    'userBlocked' => 'User Blocked/Unblock!',
    'reportSend' => 'Report sent. thanks for helping us.',
    'anythingNotFound' => 'anything not found',
    'areaAdded' => 'Your support area updated.',
    'addressAdded' => 'Address added successfully.',
    'addressUpdated' => 'Address updated successfully.',
    'sendQuotation' => 'Quotation saved successfully.',
    'addressDeleted' => 'Address deleted successfully.',
    'deactivateQuotation' => 'Freelancer deactivate Quotation!',
    'rescheduleService12H' => 'Can not reschedule service for less than 12 hour!',
    'canNotRescheduleService' => 'can not reschedule service now!',
    'deactivateService' => 'Service is deactivate!',
    'selectSlot' => 'Please select booking time.',
    'addWaiting12H' => 'Can not add to waiting list for less than 12 hour!',
    'getOrderDate' => 'Freelancer can not get order for :date !',
    'hasFreeTime' => 'Freelancer has free time on :date !',
    'notOrderNow' => 'can not order now!',
    'deactivateWorkshop' => 'Workshop is deactivated.',
    'workshopFull' => 'workshop is full reserved!',
    'canNotCancelService' => 'Can not cancel service for less than 12 hour!',
    'canNotCancelWorkshop' => 'Can not cancel workshop for less than 12 hour!',
    'CancelWorkshop' => 'Your workshop cancellation is successful.',
    'PackageExpired' => 'Your Package has been expired. Please login to your account from website and renew your package first.',
    'slotTime' => 'slot should between :min and :max min!',
    'errorSaveTime' => 'Error happened in save times!',
    'slotInSlot' => 'can not make slot on other slot!',
    'slotMade' => 'Slot saved successfully.',
    'slotDelete' => 'Slot deleted successfully.',
    'numCat' => 'parent category should be lower than 2 items.',
    'catSaved' => 'Your categories saved.',
    'activeService' => 'you have active order in services!',
    'activeWorkshops' =>'you have active order in workshops!',
    'activeMeetings' =>'you have active order in meetings!',
    'hasOrder' =>'you have active order in this service!',
];