<?php
session_start();
include('database/dbcon.php');
$conn = Connect();

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
            Button::create('🛍 Tell me more about a product')->value('product_info'),
            Button::create('💰 What is the product price?')->value('price'),
            Button::create('📞 How to contact support?')->value('contact'),
            Button::create('📍 Where is your location?')->value('location'),
        ]);
    $bot->reply($question);
}

$botman->hears('start', function (BotMan $bot) {
    $bot->reply("👋 Hi there! I'm here to help you with our products.");
    showMainOptions($bot);
});

$botman->hears('shipping', function(BotMan $bot) {
    $bot->reply('🚚 Shipping costs are calculated based on weight and destination. You can view estimated cost during checkout.');
    showMainOptions($bot);
});

$botman->hears('tracking', function(BotMan $bot) {
    $bot->reply('📦 You’ll receive a tracking number via email after your order ships. Use it on our site or the courier’s site.');
    showMainOptions($bot);
});

$botman->hears('sizes', function(BotMan $bot) {
    $bot->reply('📏 Sizes are mentioned in the product description. Check the product page for details.');
    showMainOptions($bot);
});

$botman->hears('stock', function(BotMan $bot) use ($conn) {
    $query = "SELECT id, name FROM products WHERE status = 'Available'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $question = Question::create("Which product do you want to check stock for?");
        while ($row = mysqli_fetch_assoc($result)) {
            $question->addButtons([
                Button::create($row['name'])->value('check_stock_' . $row['id'])
            ]);
        }
        $bot->reply($question);
    } else {
        $bot->reply("❌ No available products to check stock.");
        showMainOptions($bot);
    }
});

$botman->hears('check_stock_{id}', function(BotMan $bot, $id) use ($conn) {
    $stmt = $conn->prepare("SELECT name, quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ((int)$row['quantity'] > 0) {
            $bot->reply("✅ '{$row['name']}' is in stock. Quantity: {$row['quantity']}");
        } else {
            $bot->reply("❌ '{$row['name']}' is currently out of stock.");
        }
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});

$botman->hears('.*(info|information|details|description|about|product).*', function(BotMan $bot) use ($conn) {
    $query = "SELECT id, name FROM products WHERE status = 'Available'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $question = Question::create("Which product would you like to know more about?");
        while ($row = mysqli_fetch_assoc($result)) {
            $question->addButtons([
                Button::create($row['name'])->value('product_info_' . $row['id'])
            ]);
        }
        $bot->reply($question);
    } else {
        $bot->reply("Sorry, there are no available products right now.");
        showMainOptions($bot);
    }
});

$botman->hears('product_info_{id}', function(BotMan $bot, $id) use ($conn) {
    $stmt = $conn->prepare("SELECT name, description, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $desc = $row['description'];
        $price = number_format($row['price'], 2);

        $bot->reply("🛍 *{$name}*\n\n📄 *Description:* {$desc}\n💰 *Price:* RM {$price}");
    } else {
        $bot->reply("❗ Product not found.");
    }
    showMainOptions($bot);
});

$botman->hears('.*(price|cost|how much|rate).*', function(BotMan $bot) use ($conn) {
    $message = strtolower($bot->getMessage()->getText());

    $query = "SELECT id, name, price FROM products WHERE status = 'Available'";
    $result = mysqli_query($conn, $query);

    $found = false;
    while ($row = mysqli_fetch_assoc($result)) {
        $productName = strtolower($row['name']);
        if (strpos($message, $productName) !== false) {
            $price = number_format($row['price'], 2);
            $bot->reply("💰 The price of *{$row['name']}* is RM {$price}.");
            $found = true;
            break;
        }
    }

    if (!$found) {
        $res = mysqli_query($conn, "SELECT id, name FROM products WHERE status = 'Available'");
        if (mysqli_num_rows($res) > 0) {
            $question = Question::create("Sure! Which product's price would you like to know?")
                ->addButtons([]);

            while ($row = mysqli_fetch_assoc($res)) {
                $question->addButtons([
                    Button::create($row['name'])->value('product_price_' . $row['id'])
                ]);
            }
            $bot->reply($question);
        } else {
            $bot->reply("❌ Sorry, no products found.");
        }
    }

    showMainOptions($bot);
});

$botman->hears('product_price_{id}', function(BotMan $bot, $id) use ($conn) {
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $price = number_format($row['price'], 2);
        $bot->reply("💰 The price of *{$row['name']}* is RM {$price}.");
    } else {
        $bot->reply("❗ Product not found.");
    }

    showMainOptions($bot);
});

$botman->hears('contact', function(BotMan $bot) {
    $bot->reply('📞 Contact us at support@cyformstudio.com or +60-123-456789.');
    showMainOptions($bot);
});

$botman->hears('location', function(BotMan $bot) {
    $bot->reply('📍 Our studio is located in Cyberjaya. Feel free to drop by!');
    showMainOptions($bot);
});

$botman->fallback(function($bot) {
    $bot->reply("❗ Sorry, I didn’t understand that.");
    showMainOptions($bot);
});

$botman->listen();