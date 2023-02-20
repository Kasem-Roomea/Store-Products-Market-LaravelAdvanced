<?php
    return [
        "user"=>[
            "2"=>[
                "login"=>[
                "phone"=>"required|string,min:11|max:20",
                'password'=>"required|min:6|max:20",
                "lang"     =>"required|string[ar,en]",
                "type"     =>"required|string:[users,providers]",
            ]
        ],
        "3"=>[
            "register"=>[
                "name"     =>"required|min:3",
                "type"     =>"required|string:[users,providers]",
                "phone"    =>"required|string|min:11|max:20",
                'image'    =>"required|string",
                "password" =>"required|min:6",
                "lang"     =>"required|string[ar,en]",
                "isAndroid"=>"required|string[0,1]"
            ],
        ],
        "4"=>[
            "validateCdoe"=>[
                "phone"=>"string|min:11|max:20",
                "code" => 'required|min:6|max:20',
            ],
        ],
        "6"=>[
            "forgetPassword"=>[
                "email"    =>"string",
                "phone"=>"string,min:11|max:20",
            ],
        ],
        "7"=>[
            "validateCdoe"=>[
                "tmpToken" => 'string',
                "code" => 'required|min:6|max:20',
            ],
        ],
        "8"=>[
                "changePassword"=>[
                "tmpToken"    =>"required",
                "newPassword" =>"required|string|min:6",
            ],
        ],
        "10"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int ?",
                'location'  =>"location{}",
                'search'    =>'string|min:1 ?',
                "page"      =>"required|int",
                'sortBy'    =>"string['distance','rate'] ?",           
            ]
        ],
        "11"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int?",
                'location'  =>"location{}",
                'search'    =>'string|min:1 ?',
                "page"      =>"required|int",
                'sortBy'    =>"string['distance','rate'] ?",           
            ]
        ],
        "12"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                'location'  =>"location{}",
                'search'    =>'string|min:1',
                "page"      =>"required|int",
                'sortBy'    =>"string['distance','rate']",           
            ]
        ],
        "13"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                'location'  =>"location{}",
                'search'    =>'string|min:1',
                "page"      =>"required|int",
                'sortBy'    =>"string['distance','rate']",           
            ]
        ],
        "14"=>[
            "getServices"=>[
                "apiToken"    =>"required",
                "storeId"     =>"int?",
                "categoryId"  =>"int?",
                "page"        =>"required|int"
            ],
            "addFavourite"=>[
                "apiToken"   =>"required",
                "storeId"    =>"required|int",
            ]
        ],
        "15"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                "page"        =>"required|int|0"
            ],
            "addFavourite"=>[
                "apiToken"   =>"required",
                "storeId"    =>"required|int",
            ]
        ],
        "16"=>[ 
            "addOrder"=>[
                "apiToken"    =>"required",
                "services"    =>"required|service{}[]",
                "orderDate"   =>"date_format:Y-m-d H:i:s",
                "phone"       =>"numeric|between:100000000000,99999999999999999999",
            ]
        ],
        "18"=>[ 
            "rateStore"=>[
                "apiToken"    =>"required",
                "storeId"    =>"required|int",
                "rate"       =>"required|numeric|min:1|max:5",
                "comment"    =>"nullable?"
            ]
        ],
        "20"=>[ 
            "myFavourites"=>[
                "apiToken"  =>"required",
                "page"      =>"required|int"
            ]
        ],
        "21"=>[ 
            "notifications"=>[
                "apiToken"  =>"required",
                "page"      =>"required|int"
            ]
        ],
        "25"=>[ 
            "getOrders"=>[
                "apiToken"  =>"required",
                'status'    =>"string [waiting,accepted]?",
                'totalPrice'=>"numeric?",
                "date"      =>"date?",
                "page"      =>"required|int",
            ]
        ],
        "26"=>[ 
            "getOrders"=>[
                "apiToken"  =>"required",
                'status'    =>"string [finished,cancelled]?",
                "orderId"   =>"int?",
                "page"      =>"required|int?"
            ]
        ],
        "27"=>[ 
            "getOrders"=>[
                "apiToken"  =>"required",
                "orderId"   =>"int",
                "page"      =>"required|int|0"
            ]
        ],
        "28"=>[ 
                "changeLang"=>[
                "apiToken" =>"required",
                "lang"     =>"required|string[ar,en]",
            ]
        ],
        "29"=>[ 
            "appInfo"=>[
            ]
        ],
        "30"=>[ 
            "updateUserProfile"=>[
                "apiToken" =>"required",
                "name"     =>"string|min:3",
                "phone"    =>"string|string|min:11|max:20",
                'image'    =>"string",
            ]
        ],
        "31"=>[ 
                "contacts"=>[
                "apiToken" =>"required",
                "message"  =>"required|string|min:3",
            ]
        ]
    ],
    "provider"=>[
        "2"=>[
            "login"=>[
                "phone"=>"required|string,min:11|max:20",
                'password'=>"required|min:6|max:20",
                "lang"     =>"required|string[ar,en]",
                "type"     =>"required|string:[users,providers]",
            ]
        ],
        "3"=>[
            "register"=>[
                "name"     =>"required|min:3",
                "type"     =>"required|string:[users,providers]",
                "phone"    =>"required|string|min:11|max:20",
                'image'    =>"required|string",
                "password" =>"required|min:6",
                "lang"     =>"required|string[ar,en]",
                "isAndroid"=>"required|string[0,1]"
            ],
        ],
        "4"=>[
            "addEditStore"=>[
                "apiToken"           =>"required",
                "storeId"            =>"int",
                "logo"               =>"required|string",
                "images"             =>"required|array|min:4|max:6",
                "phones"             =>"required|array|min:1|max:3",
                "name"               =>"required|string|min:2|max:50",
                "description"        =>"required|string|min:5|max:200",
                "categoryId"         =>"required|int",
                "fromDay"            =>"required|int",
                "toDay"              =>"required|int",
                "fromTime"           =>"required|date_format:H:i:s",
                "toTime"             =>"required|date_format:H:i:s|after:fromTime",
                "facebook"           =>"required|string",
                "twitter"            =>"required|string",
                "instagram"          =>"required|string",
                "location"           =>"required|location{}",
            ]
        ],
        "6"=>[
            "addEditServices"=>[
                "apiToken"   =>"required",
                "storeId"    =>"required|int",
                "services"   =>"required|service{}[]",
            ],
        ],
        "7"=>[
            "validateCdoe"=>[
                "phone"=>"string|min:11|max:20",
                "code" => 'required|min:6|max:20',
            ],
        ],
        "9"=>[
            "forgetPassword"=>[
                "email"    =>"string",
                "phone"=>"string,min:11|max:20",
            ],
        ],
        "10"=>[
            "validateCdoe"=>[
                "tmpToken" => 'string',
                "code" => 'required|min:6|max:20',
            ],
        ],
        "11"=>[
            "changePassword"=>[
                "tmpToken"    =>"required",
                "newPassword" =>"required|string|min:6",
            ],
        ],
        "13"=>[ 
            "notifications"=>[
                "apiToken"  =>"required",
                "page"      =>"required|int"
            ]
        ],
        "15"=>[ 
            "getOrders"=>[
                "apiToken"  =>"required",
                'status'    =>"string [accepted.finished,cancelled]?",
                'totalPrice'=>"numeric?",
                "date"      =>"date?",
                "orderId"   =>"int?",
                "page"      =>"required|int",
                ]
        ],
        "16"=>[ 
            "getOrders"=>[
                "apiToken"  =>"required",
                'status'    =>"string [waiting]?",
                'totalPrice'=>"numeric?",
                "date"      =>"date?",
                "page"      =>"required|int",
            ]
        ],
        "17"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                "page"      =>"required|int|0"
            ]
        ],
        "19"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                "page"      =>"required|int|0"
            ]
        ],
        "20"=>[
            "getStores"=>[
                "apiToken"  =>"required",
                'storeId'   =>"int",
                "page"      =>"required|int|0"
            ]
        ],
        "21"=>[ 
            "appInfo"=>[
            ]
        ],
        "22"=>[ 
            "changeLang"=>[
                "apiToken" =>"required",
                "lang"     =>"required|string[ar,en]",
            ]
        ],
        "23"=>[ 
            "contacts"=>[
                "apiToken" =>"required",
                "message"  =>"required|string|min:3",
            ]
        ],
        "4"=>[
            "addEditStore"=>[
                "apiToken"           =>"required",
                "storeId"            =>"int",
                "logo"               =>"required|string",
                "images"             =>"required|array|min:4|max:6",
                "phones"             =>"required|array|min:1|max:3",
                "name"               =>"required|string|min:2|max:50",
                "description"        =>"required|string|min:5|max:200",
                "categoryId"         =>"required|int",
                "fromDay"            =>"required|int",
                "toDay"              =>"required|int",
                "fromTime"           =>"required|date_format:H:i:s",
                "toTime"             =>"required|date_format:H:i:s|after:fromTime",
                "facebook"           =>"required|string",
                "twitter"            =>"required|string",
                "instagram"          =>"required|string",
                "location"           =>"required|location{}",
            ]
        ],
        "26"=>[ 
            "updateProviderProfile"=>[
                "apiToken" =>"required",
                "name"     =>"string|min:3",
                "phone"    =>"string|string|min:11|max:20",
                'image'    =>"string",
            ]
        ]
    ]  
];
