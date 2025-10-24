<?php
	
require_once "controllers/template.controller.php";
require_once "controllers/users.controller.php";
require_once "controllers/categories.controller.php";
require_once "controllers/products.controller.php";
require_once "controllers/customers.controller.php";
require_once "controllers/sales.controller.php";
require_once "controllers/vendors.controller.php";
require_once "controllers/purchases.controller.php";
require_once "controllers/returns.controller.php";
require_once "controllers/payment-audit.controller.php";
require_once "controllers/partial-payments.controller.php";
require_once "controllers/customer-notes.controller.php";

require_once "models/users.model.php";
require_once "models/categories.model.php";
require_once "models/products.model.php";
require_once "models/customers.model.php";
require_once "models/sales.model.php";
require_once "models/vendors.model.php";
require_once "models/purchases.model.php";
require_once "models/returns.model.php";
require_once "models/payment-audit.model.php";
require_once "models/partial-payments.model.php";
require_once "models/customer-notes.model.php";

require_once "extensions/vendor/autoload.php";

$template = new ControllerTemplate();
$template -> ctrTemplate();