<?php
return [
    "Ar"=>[
        "register"=>[
            "200"=>"تم الإشتراك بنجاح"
        ],
        "validateAccount"=>[
            "415"=>"هذا الهاتف غير مسجل",
            "416"=>"هذا البريد غير مسجل",
            "417"=>"تيمب توكن غير صحيح",            
            "403"=>"توكن غير صحيح",    
            "418"=>"تم مسح هذا الحساب",
            "402"=>"تم الغاء تنشيط هذا الحساب",
            "419"=>"لم يتم التحقق من الحساب",        
        ],
        "login"=>[
            "200"=>"تم تسجيل الدخول بنجاح",
            "406"=>"الرقم السري غير صحيح",
            "408"=>"هذا الرقم غير موجود",
            "416"=>"لم يتم الموافقة علي السائق",
        ],
        "validateCode"=>[
            "200"=>"تمت العملية بنجاح",
            "410"=>"تم انتهاء صلاحية هذا الكود",
        ],
        "updatePassword"=>[
            '414'=>"كلمة المرور القديمة غير صحيحة"
        ],
        "resendCode"=>[
            '200'=>"تم ارسال رمز التفعيل",
            '416'=>"فشل بسبب إرسال الكود الأخير قبل أقل من دقيقتين"
        ],
        "updateProfile"=>[
            "200"=>"تم تحديث الملف الشخصي بنجاح"
        ],
        'contact'=>[
            "200"=>" تم ارسال رسالتك بنجاح"
        ],
        "order"=>[
            '200'=>"لقد تم طلبك بنجاح , برجاء الانتظار لحين إرسال إشعار آخر"
        ],
        "gender"=>[
            "male"=>"رجالي",
            "female"=>"نسائي", 
            "female"=>"الكل",
        ],
        "stores"=>[
           "403"=> "هذا المتجر ليس لك "
        ],
        'favourite'=>[
            "fav"=>"تمت الاضافة من المفضة ",
            "unfav"=>"تم الازالة من المفضلة"
        ],
        "rate"=>[
            "200"=>"تمت إضاقة تقييمك بنجاح"
        ],
        'order'=>[
            "waiting"=>"تمت إضافة طلبك بنجاح , طلب قيد الإنتظار الان ",
            "accepted"=>" تمت الموافقة علي طلبك ",
            "finished"=>"تم الإنتهاء من طلبك",
            "cancelled"=>"تم إلغاء طلبك بنجاح",
            "403"      =>"هذا الطلب ليس من حقك",
            "406"      =>"لا يمكن قبول هذا الطلب",
            "407"      =>"لا يمكن رفض هذا الطلب",
            "430"      =>'الكمية غير متوفرة',
            "425"      =>"رصيدك غير كافي لاستكمال الطلب",
            "426"      =>"نقاطك غير كافية لاستكمال الطلب",
            "427"      =>"نقاطك غير كافي لتحويلها لرصيد",
            "430"      =>"  طلب غير موجود ",
            "store"      =>" لديك طلب جديد في انتظار الموافقة عليه  ",
            "titleMakeOrder"=>" طلبات جديدة ",
            "435"      =>" الحد الادني للطلبات يجب ان يكون اكثر من 3 دينار  ",
            "418"      =>" تم قبول الطلب من فرع أخر ",

        ],
        "cart"=>[
            '200'=>'تم إضافة المنتج الي العربة بنجاح.'
        ],
        "notifications"=>[
            "rate"=>"تمت إضافة تقييم لك  من قبل ",
            "newOrder"=>"لديك طلبات جديدة في انتظار الموافقة عليها",
            "acceptOrder"=>"تم قبول طلبك بنجاح من قبل المتجر",
            "waitingOrderForAccepting"=>" تم اﻻرسال للمندوبين",
            "finishedOrder"=>"تم الانتهاء من الطلب بنجاح",
            "cancelledOrder"=>"تم إلغاء الطلب ",
            "refueseOrder"=>"تم رفض الطلب من قبل السائق ",
            "sendToDeliveries"=>"لديك طلبات جديدة",
            "acceptedByDriver"=>"تم قبول الطلب من قبل السائق",
            "rateOrder"       =>"يريد ترولي عمان معرفة تقييمك للمنتجات االتي اشتريتها"
        ],
        "deleteService"=>[
            "403"=>"ليس من حقك مسح هذه الخدمة "
        ],
        "address"=>[
            "200"=>"تم إضافة العنوان بنجاح",
            "201"=>"تم حذف العنوان بنجاح",
            "202"=>"تم تعديل العنوان بنجاح",
        ]
              
    ],
    "En"=>[
        "register"=>[
            "200"=>"registered successfully"
        ],
        "validateAccount"=>[
            "415"=>"this phone is not registered",
            "416"=>"this email is not registered",
            "417"=>"error in tmpToken",            
            "403"=>"error in apiToken",            
            "418"=>"this account has been deleted",
            "402"=>"this account has been deactivate",
            "419"=>"this account hasn't been verified",        
        ],
        "login"=>[
            "200"=>"login successfully",
            "406"=>"incorrect password",
            "408"=>"incorrect phone",
            "416"=>"The driver has not been approved",

        ],
        "validateCode"=>[
            "200"=>"done successfully",
            "410"=>"code is expired",
        ],
        "updatePassword"=>[
            '414'=>"old pasword is incorrect"
        ],
        "resendCode"=>[
            '200'=>"code has been sent",
            '416'=>"failed ,wait 2 minutes and try again"
        ],
        "updateProfile"=>[
            "200"=>"profile updated successfully"
        ],
        'contact'=>[
            "200"=>"your message has been send successfully"
        ],"order"=>[
            '200'=>"your order has been submitted successfully "
        ],
        "gender"=>[
            "male"=>"male",
            "female"=>"female",
            "all"=>"all",
        ],
         "stores"=>[
            "403"=> "it's not your store"
         ],
         'favourite'=>[
            "fav"=>"Added to favorites ",
            "unfav"=>"Removed from favorites"
        ] ,
        "rate"=>[
            "200"=>"Your rating has been added successfully"
        ],
        'order'=>[
            "waiting"=>"your order has been submitted successfully , and added in waiting",
            "accepted"=>" your order has been accepted",
            "finished"=>"your order has been finished",
            "cancelled"=>"your order has been cancelled",
            "403"      =>"it's not your order",
            "406"      =>"can't accept this order",
            "407"      =>"can't refuese this order",
            "430"      =>"quantity not available",
            "425"      =>"Your balance is insufficient to complete the order",
            "426"      =>"Your points is insufficient to complete the order",
            "427"      =>"Your points is not enough to convert it to a balance",
            "430"      =>" there is no order  ",
            "435"      =>" The minimum order must be more than 3 riyals  ",
            "store"      =>" You have a new order awaiting approval. ",
            "titleMakeOrder"      =>" New orders ",
            "418"      =>" The request was accepted from another branch ",

        ],
        "cart"=>[
            '200'=>'The product has been successfully added to the cart.',
        ],

        "notifications"=>[
            "rate"              =>"new ratedad to you from  ",
            "newOrder"          =>"You have new requests awaiting approval",
            "acceptOrder"       =>"Your order was successfully accepted by the store",
            "finishedOrder"     =>"The order was successfully completed",
            "waitingOrderForAccepting"=>"The drivers were sent your order.",
            "cancelledOrder"    =>"the order has been canceled ",
            "sendToDeliveries"  =>"you have new order",
           "acceptedByDriver"   =>" your order has been accepted by driver",
            "refueseOrder"      =>"your order has been refuese by driver ",
            "rateOrder"         =>"Trolley Omman wants to know your rating of the products you have purchased"
        ],
        "deleteService"=>[
            "403"=>"it's not your service"
        ],
        "address"=>[
            "200"=>"location added successfully",
            "201"=>"location deleted successfully",
            "202"=>"location updated successfully",
        ]     
    ]
];