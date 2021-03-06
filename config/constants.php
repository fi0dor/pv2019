<?php  
	
	define("MODE", "DEVELOPMENT");
	
	define("APP_DIRECTORY", "localStore/"); // Application should run from a subfolder /localStore
	// define("APP_DIRECTORY", "./"); // Application should run from the root folder

	define("URL_ROOT", "//localhost:8888/" . APP_DIRECTORY);
	define("APP_ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
	define("VIEW_ROOT", APP_ROOT . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR); 

	define("SITE_NAME", "PV219: Local Store");

	// DATABASE
	define("SERVER", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "root");
	define("DB", "demo_store"); 

	// SEO
	define("META_DESC", "A demo web store.");
	define("META_KEYWORDS", "Most afforfable online store - apple, beer, free pick up");

	// CURRENCIES IN USE
	define("EURO", "€");

	// USER
	define("USER_ID_TAG", "user_id");
	define("USER_WALLET_TAG", "user_wallet");    

	// PRODUCT
	define("PRODUCT_RATING_ARR", "product_rate_arr"); 

	// CART
	define("USER_CART_TAG", "cart_id");
	define("USER_CART_PROMO_CODE", "cart_promo_code");
	define("USER_CART_SHIPPING_TYPE", "cart_shipping_type");

	// CHECK OUT DEFAULTS
	define("SHIPPING_TYPES", array(
		"PICK_UP" => array(
			"description" => "Pick Up",
			"cost"        => "0"
		),
		"UPS" => array(
			"description" => "United Parcel Service",
			"cost"        => "5"
		),
		"CONTAINER_SHIP" => array(
			"description" => "Container ship delivery",
			"cost"        => "500"
		)
	));

	define("PROMO_CODES", array(
		"BLACKFRIDAY22" => array(
			"description" => "Black Friday 2022",
			"cost"        => "-5"
		),
		"BIGSALE" => array(
			"description" => "Big Summer Sale!",
			"cost"        => "-10 %"
		),
		"SUPPORT2UKRAINE" => array(
			"description" => "Ukraine ♥",
			"cost"        => "+50 %"
		)
	));

	define("DEFAULT_WALLET_BALANCE", 100);

?>