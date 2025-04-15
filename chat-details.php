<?php
session_start();
include('database/dbcon.php');
$conn = Connect();

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

require_once 'vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

$config = [];
DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
$botman = BotManFactory::create($config);

function showMainOptions(BotMan $bot) {
    $question = Question::create("What would you like to ask?")
        ->addButtons([
            Button::create('💸 What are the shipping costs?')->value('shipping'),
            Button::create('📦 How do I track my order?')->value('tracking'),
            Button::create('📏 What sizes are available?')->value('sizes'),
            Button::create('✅ Is this product in stock?')->value('stock'),
            Button::create('💰 What is the price?')->value('price'),
            Button::create('📞 How to contact support?')->value('contact'),
            Button::create('📍 Where is your location?')->value('location'),
        ]);
    $bot->reply($question);
}

$botman->hears('start', function (BotMan $bot) use ($product) {
    if ($product) {
        $bot->reply("👋 Hi! I can help you with '{$product['name']}'.");
    } else {
        $bot->reply("👋 Hi! I’m here to assist you.");
    }
    showMainOptions($bot);
});

$botman->hears('shipping', function(BotMan $bot) {
    $bot->reply('🚚 Shipping costs are based on weight and destination. You’ll see the estimate during checkout.');
    showMainOptions($bot);
});

$botman->hears('tracking', function(BotMan $bot) {
    $bot->reply('📦 After your order is shipped, you will get a tracking number via email. Use it on our website or with the courier.');
    showMainOptions($bot);
});

$botman->hears('sizes', function(BotMan $bot) use ($product) {
    if ($product) {
        $bot->reply("📏 Sizes for '{$product['name']}': " . $product['description']);
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});

$botman->hears('stock', function(BotMan $bot) use ($product) {
    if ($product) {
        if ((int)$product['quantity'] > 0) {
            $bot->reply("✅ Yes, '{$product['name']}' is in stock. Quantity available: {$product['quantity']}.");
        } else {
            $bot->reply("❌ Sorry, '{$product['name']}' is currently out of stock.");
        }
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});

$botman->hears('.*(info|information|details|description|about|product).*', function(BotMan $bot) use ($product) {
    if ($product) {
        $name = $product['name'];
        $desc = $product['description'];
        $price = number_format($product['price'], 2);
        
        $bot->reply("🛍 *{$name}*\n\n📄 *Description:* {$desc}\n💰 *Price:* RM {$price}");
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});


$botman->hears('.*(price|cost|how much|rate).*', function(BotMan $bot) use ($product) {
    if ($product) {
        $price = number_format($product['price'], 2);
        $bot->reply("💰 The price of '{$product['name']}' is RM {$price}.");
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});

$botman->hears('contact', function(BotMan $bot) {
    $bot->reply('📞 You can contact our support team at support@cyformstudio.com or call +60-123-456789.');
    showMainOptions($bot);
});

$botman->hears('location', function(BotMan $bot) {
    $bot->reply('📍 Our studio is located in Cyberjaya. Feel free to drop by!');
    showMainOptions($bot);
});

$botman->fallback(function($bot) {
    $bot->reply("❗ Sorry, I didn't understand that. Try asking about stock, size, shipping, or price.");
    showMainOptions($bot);
});

$botman->listen();