<?php  
	
	define('MODE', 'DEVELOPMENT');
	
	define("APP_DIRECTORY", "localStore/"); // Application should run from a subfolder localStore
	// define("APP_DIRECTORY", "./"); // Application should run from the root folder

	define("URL_ROOT", "//localhost:8888/" . APP_DIRECTORY);
	define("APP_ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
	define('VIEW_ROOT', APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR); 

	define("SITE_NAME", "PV219: Local Store");

	// DATABASE
	define("SERVER", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "root");
	define("DB", "demo_store"); 

	// SEO
	define("META_DESC", "A demo web store.");
	define("META_KEYWORDS", "Most afforfable online store - apple, beer, free shipping");

	// CURRENCIES IN USE
	define("EURO", "€");

	// USER
	define("USER_ID_TAG", "user_id");
	define("USER_WALLET_TAG", "user_wallet");    

	// PRODUCT
	define("PRODUCT_RATING_ARR", "product_rate_arr"); 

	// CART
	define("USER_CART_TAG", "cart_id");

	// CHECK OUT DEFAULTS
	define("PICK_UP_COST", 0);
	define("UPS_SHIPPING_COST", 5);

	define("DEFAULT_WALLET_BALANCE", 100);

?>