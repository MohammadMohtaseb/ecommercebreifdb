<?php
include 'connection.php';

session_start();

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}

$userPageUrl = isUserSignedIn() ? 'user-dashboard.php' : 'account.php';
$userPageUrlFavList = isUserSignedIn() ? 'wishlist.php' : 'fav-list.php';
$userPageUrlCart = isUserSignedIn() ? 'cart.php' : 'cart-Guest.php';
$userPageUrlcheckout = isUserSignedIn() ? 'billing-information.php' : 'account.php';


$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

// Handle quantity update via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['product_id'];

    if ($action == 'update_quantity') {
        $quantity = $_POST['quantity'];

        if (isset($_SESSION['cart_quantities'][$productId])) {
            $_SESSION['cart_quantities'][$productId] = $quantity;
        } else {
            $_SESSION['cart'][] = $productId;
            $_SESSION['cart_quantities'][$productId] = $quantity;
        }
    } elseif ($action == 'remove_from_cart') {
        if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            unset($_SESSION['cart_quantities'][$productId]);
        }
    }

    // Return a JSON response
    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog -Cart</title>
    <link rel="stylesheet" href="dist/main.css">
    <link rel="stylesheet" href="dist/aseel.css">
    <style>
        .thingstothinkabout {
            /* visibility: hidden; */
            display: none;

        }

        .quantity {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header Area Start -->
    <header class="header">

        <div class="header-bottom">
            <div class="container">
                <div class="d-none d-lg-block">
                    <nav class="menu-area d-flex align-items-center">
                        <div class="logo">
                            <a href="index.php"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <ul class="main-menu d-flex align-items-center">
                            <!-- <li><a class="active" href="index.php">Home</a></li> -->
                            <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                            <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                            <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=T-Shirt"; ?>">T-Shirt</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shoes"; ?>">Shoes</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Hoodies"; ?>">Hoodies</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Jeans"; ?>">Jeans</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Casual"; ?>">Casual</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Pajamas"; ?>">Pajamas</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shorts"; ?>">Shorts</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)">Sales</a></li>
                        </ul>

                        <div class="search-bar">
                            <input type="text" placeholder="Search for product..." id="searchInput" oninput="performSearch(this)"> <!-- //fdfdsfdsfdsf -->
                            <div id="suggestions"></div>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="menu-icon ml-auto">
                            <ul>
                                <li>
                                    <a href="<?php echo $userPageUrlFavList; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart" id="wishlist-count"><?php echo isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrlCart; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart" id="cart-count">0</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrl; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Mobile Menu -->
                <aside class="d-lg-none">
                    <div id="mySidenav" class="sidenav">
                        <div class="close-mobile-menu">
                            <a href="javascript:void(0)" id="menu-close" class="closebtn" onclick="closeNav()">&times;</a>
                        </div>
                        <div class="search-bar">
                            <input type="text" placeholder="Search for product...">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                        <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                        <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                        <li>
                            <a href="javascript:void(0)">Category
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=T-Shirt"; ?>">T-Shirt</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shoes"; ?>">Shoes</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Hoodies"; ?>">Hoodies</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Jeans"; ?>">Jeans</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Casual"; ?>">Casual</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Pajamas"; ?>">Pajamas</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shorts"; ?>">Shorts</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Sales</a></li>
                    </div>
                    <div class="mobile-nav d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.php"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <div class="search-bar">
                            <input type="text" placeholder="Search for product...">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="menu-icon">
                            <ul>
                                <li>
                                    <a href="<?php echo $userPageUrlFavList; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart" id="wishlist-count"><?php echo isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrlCart; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart" id="cart-count">0</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrl; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg></a>
                                </li>

                            </ul>
                        </div>
                        <div class="hamburger-menu">
                            <a style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</a>
                        </div>
                    </div>
                </aside>
                <!-- Body overlay -->
                <div class="overlay" id="overlayy"></div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    <!-- BreadCrumb Start-->
    <section class="breadcrumb-area mt-15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                    <h5>Cart</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->

    <!-- Cart Area Start -->
    <section class="cart-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Dashboard-Nav  Start-->
                    <div class="dashboard-nav">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="user-dashboard.php">Account
                                    settings</a></li>
                            <li class="list-inline-item"><a href="deliver-info.php">Billing information</a></li>
                            <li class="list-inline-item"><a href="wishlist.php">My wishlist</a></li>
                            <li class="list-inline-item"><a href="cart.php" class="active">My cart</a></li>
                            <li class="list-inline-item"><a href="order.php">Order</a></li>
                            <li class="list-inline-item"><a href="account.php" class="mr-0">Log-out</a></li>
                        </ul>
                    </div>
                    <!-- Dashboard-Nav  End-->
                </div>
            </div>
            <div class="rows">
                <div class="cart-items">
                    <div class="header">
                        <div class="image">
                            Image
                        </div>
                        <div class="name">
                            Details
                        </div>
                        <div style="text-align: center;" class="price">
                            Quantity
                        </div>
                        <div style="visibility:hidden;" class="rating">

                        </div>
                        <div class="info">
                            Total
                        </div>
                    </div>
                    <div class="body">
                        <?php
                        if (count($cartItems) > 0) {
                            $cartIds = implode(',', $cartItems);
                            $cartQuery = "SELECT * FROM products WHERE product_id IN ($cartIds)";
                            $result = $conn->query($cartQuery);

                            if ($result && $result->num_rows > 0) {
                                while ($product = $result->fetch_assoc()) {
                                    $product_id = $product['product_id'];
                                    $quantity = isset($_SESSION['cart_quantities'][$product_id]) ? $_SESSION['cart_quantities'][$product_id] : 1;
                                    $unitPrice = $product['price'];
                                    $totalPrice = $unitPrice * $quantity;
                        ?>
                                    <div class="item" data-product-id="<?php echo $product_id; ?>">
                                        <div class="image">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                                        </div>
                                        <div class="name">
                                            <div class="name-text">
                                                <p><?php echo $product['product_name']; ?></p>
                                            </div>
                                            <!-- <div class="button">
                                                <div class="product-pricelist-selector-button">
                                                    <form method="post" action="cartAction.php" target="cart-frame-<?php echo $product['product_id']; ?>" style="display:inline;">
                                                        <input type="hidden" name="action" value="add_to_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="btn cart-bg">CHECKOUT NOW
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                                    <g id="Icon" transform="translate(0 1)">
                                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                                    <form method="post" style="display:inline;" onsubmit="return removeFromCart(event, <?php echo $product['product_id']; ?>)">
                                                        <input type="hidden" name="action" value="remove_from_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="del">Remove</button>
                                                    </form>
                                                    <iframe name="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="price">
                                            <span class="unit-price"><?php echo 'JD' . number_format($unitPrice, 2); ?></span>
                                        </div>

                                        <div class="quantity">
                                            <div class="product-pricelist-selector-quantity">
                                                <h6>Quantity</h6>
                                                <div class="wan-spinner wan-spinner-4">
                                                    <a href="javascript:void(0)" class="minus" onclick="updateQuantity(<?php echo $product_id; ?>, -1)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                            <path id="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1473.296 -25.41)" fill="none" stroke="#989ba7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                        </svg>
                                                    </a>
                                                    <input type="number" value="<?php echo $quantity; ?>" min="1" class="quantity-input" onchange="updateQuantity(<?php echo $product_id; ?>, 0, this.value)">
                                                    <a href="javascript:void(0)" class="plus" onclick="updateQuantity(<?php echo $product_id; ?>, 1)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                            <g id="Arrow" transform="translate(10.99 5.7) rotate(180)">
                                                                <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                            </g>
                                                        </svg>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="info">
                                            <div class="size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6 class="thingstothinkabout">Sizes</h6>
                                                    <div class="thingstothinkabout sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color ">
                                                    <h6 class="thingstothinkabout">Colors</h6>
                                                    <div class="colors thingstothinkabout" id="colors">
                                                        <li class="thingstothinkabout colorall color-1 active"></li>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total">
                                            <span class="total-price"><?php echo 'JD' . $totalPrice; ?></span>
                                            <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                            <form method="post" style="display:inline;" onsubmit="return removeFromCart(event, <?php echo $product['product_id']; ?>)">
                                                <input type="hidden" name="action" value="remove_from_cart">
                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <button type="submit" class="del">Remove</button>
                                            </form>
                                            <iframe name="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                        </div>

                                    </div>
                        <?php
                                }
                            } else {
                                echo "<p>Your cart is empty.</p>";
                            }
                        } else {
                            echo "<p>Your cart is empty.</p>";
                        }
                        ?>
                    </div>
                </div>



            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="apply-coupon">
                        <h6>Apply Coupon</h6>
                        <form id="coupon-form" method="post" action="applyCoupon.php">
                            <div class="form__div">
                                <input type="text" class="form__input" name="coupon_code" placeholder=" ">
                                <label for="" class="form__label">Coupon Code</label>
                            </div>
                            <button class="btn bg-primary" type="submit">apply COUPON</button>
                        </form>
                        <div id="coupon-message"></div>
                    </div>
                    <!-- <div class="apply-coupon">
                        <h6>Apply Coupon</h6>
                        <form action="#">
                            <div class="form__div">
                                <input type="text" class="form__input" placeholder=" ">
                                <label for="" class="form__label">Coupon Code</label>
                            </div>
                            <button class="btn bg-primary" type="submit">apply COUPON</button>
                        </form>
                    </div> -->
                </div>
                <div class="col-lg-6">
                    <div class="card-price">
                        <h6>Check Summary</h6>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p id="item-count">0 items</p>
                            </div>
                            <div class="price">
                                <p id="item-total-price">$0.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Shipping Cost</p>
                            </div>
                            <div class="price">
                                <p id="shipping-cost">JD3.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Discount</p>
                            </div>
                            <div class="price">
                                <p id="discount">0%</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Taxes</p>
                            </div>
                            <div class="price">
                                <p id="taxes">JD0.00</p>
                            </div>
                        </div>
                        <div class="card-price-subtotal d-flex justify-content-between align-items-center">
                            <div class="total-text">
                                <p>Total Price</p>
                            </div>
                            <div class="total-price">
                                <p id="total-price">JD0.00</p>
                            </div>
                        </div>
                        <form action="#">
                            <a href="<?php echo $userPageUrlcheckout; ?>" class="btn bg-primary" type="submit" style="width: 100%;">Checkout Now</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Cart Area End -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center newsletter-area">
                <div class="col-lg-5">
                    <div class="newsletter-area-text">
                        <h4 class="text-white">Subscribe to get notification.</h4>
                        <p>
                            Receive our weekly newsletter.
                            For dietary content, fashion insider and the best offers.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="newsletter-area-button">
                        <form action="#">
                            <div class="form">
                                <input type="email" name="email" id="mail" placeholder="Enter your email address" class="form-control">
                                <button class="btn bg-secondary border text-capitalize">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright d-flex justify-content-between align-items-center">
                        <div class="copyright-text order-2 order-lg-1">
                            <p>&copy; 2024. All rights reserved. </p>
                        </div>
                        <div class="copyright-links order-1 order-lg-2">
                            <a href="soon.php" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                            <a href="soon.php"><i class="fab fa-twitter"></i></a>
                            <a href="soon.php"><i class="fab fa-youtube"></i></a>
                            <a href="soon.php"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->


    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/scss/vendors/plugin/js/jquery.nice-select.min.js"></script>
    <script src="dist/main.js"></script>
    <script>
        function openNav() {

            document.getElementById("mySidenav").style.width = "350px";
            $('#overlayy').addClass("active");
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            $('#overlayy').removeClass("active");
        }


        function toggleWishlist(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`wishlist-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/ecommercebreifdb/index.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Toggle the heart icon
                    const icon = document.getElementById(`wishlist-icon-${productId}`);
                    const actionInput = form.querySelector('input[name="action"]');
                    if (actionInput.value === 'add_to_wishlist') {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        actionInput.value = 'remove_from_wishlist';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        actionInput.value = 'add_to_wishlist';
                    }
                })
                .catch(error => console.error('Error:', error));

            return false;
        }

        function toggleCart(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`cart-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/ecommercebreifdb/cart.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Toggle the cart icon
                    const icon = document.getElementById(`cart-icon-${productId}`);
                    const actionInput = form.querySelector('input[name="action"]');
                    updateCartCount(); // Update the cart count
                    if (actionInput.value === 'add_to_cart') {
                        // If you want to change the icon, add class manipulation here
                        actionInput.value = 'remove_from_cart';
                    } else {
                        // If you want to change the icon, add class manipulation here
                        actionInput.value = 'add_to_cart';
                    }
                })
                .catch(error => console.error('Error:', error));

            return false;
        }

        function updateCartCount() {
            fetch("http://localhost/ecommercebreifdb/api/get_cart_count.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').innerText = data.count;
                })
                .catch(error => console.error('Error:', error));
        }

        // Call updateCartCount on page load to set the initial cart count
        document.addEventListener('DOMContentLoaded', updateCartCount);

        // function updateQuantity(productId, delta, quantity = null) {
        //     const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);
        //     const quantityInput = itemElement.querySelector('.quantity-input');
        //     let currentQuantity = parseInt(quantityInput.value);
        //     if (quantity === null) {
        //         currentQuantity = Math.max(1, currentQuantity + delta);
        //     } else {
        //         currentQuantity = Math.max(1, parseInt(quantity));
        //     }
        //     quantityInput.value = currentQuantity;

        //     const unitPriceElement = itemElement.querySelector('.unit-price');
        //     const totalPriceElement = itemElement.querySelector('.total-price');
        //     const unitPrice = parseFloat(unitPriceElement.textContent.replace('$', ''));
        //     const totalPrice = (unitPrice * currentQuantity).toFixed(2);
        //     totalPriceElement.textContent = '$' + totalPrice;

        //     // Update quantity in session via AJAX
        //     const formData = new FormData();
        //     formData.append('action', 'update_quantity');
        //     formData.append('product_id', productId);
        //     formData.append('quantity', currentQuantity);

        //     fetch("http://localhost/ecommercebreifdb/cart.php", { // Use the current page URL
        //             method: "POST",
        //             body: formData
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 updateCartCount();
        //             }
        //         })
        //         .catch(error => console.error('Error:', error));
        // }

        // function removeFromCart(event, productId) {
        //     event.preventDefault();
        //     const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);

        //     // Remove item from session via AJAX
        //     const formData = new FormData();
        //     formData.append('action', 'remove_from_cart');
        //     formData.append('product_id', productId);

        //     fetch("http://localhost/ecommercebreifdb/cart-Guest.php", { // Use the current page URL
        //             method: "POST",
        //             body: formData
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 itemElement.remove();
        //                 updateCartCount();
        //             }
        //         })
        //         .catch(error => console.error('Error:', error));
        // }


        // the cart coupon funcitionality
        function updateCardPrice() {
            fetch('http://localhost/ecommercebreifdb/api/get_cart_summary.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('item-count').innerText = data.itemCount + ' items';
                    document.getElementById('item-total-price').innerText = 'JD' + data.itemTotalPrice.toFixed(2);
                    document.getElementById('discount').innerText = data.discount + '%';
                    document.getElementById('taxes').innerText = 'JD' + data.taxes.toFixed(2);
                    document.getElementById('total-price').innerText = 'JD' + data.totalPrice.toFixed(2);
                });
        }

        // Call updateCardPrice initially to populate data
        updateCardPrice();

        document.getElementById('coupon-form').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch('http://localhost/ecommercebreifdb/api/applyCoupon.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            document.getElementById('coupon-message').innerHTML = result.message;
            if (result.success) {
                document.getElementById('coupon-message').classList.add('success');
            } else {
                document.getElementById('coupon-message').classList.add('error');
            }
            updateCardPrice();
        }

        function updateQuantity(productId, delta, quantity = null) {
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);
            const quantityInput = itemElement.querySelector('.quantity-input');
            let currentQuantity = parseInt(quantityInput.value);
            if (quantity === null) {
                currentQuantity = Math.max(1, currentQuantity + delta);
            } else {
                currentQuantity = Math.max(1, parseInt(quantity));
            }
            quantityInput.value = currentQuantity;

            const unitPriceElement = itemElement.querySelector('.unit-price');
            const totalPriceElement = itemElement.querySelector('.total-price');
            const unitPrice = parseFloat(unitPriceElement.textContent.replace('JD', ''));
            const totalPrice = (unitPrice * currentQuantity).toFixed(2);
            totalPriceElement.textContent = 'JD' + totalPrice;

            // Update quantity in session via AJAX
            const formData = new FormData();
            formData.append('action', 'update_quantity');
            formData.append('product_id', productId);
            formData.append('quantity', currentQuantity);

            fetch("http://localhost/ecommercebreifdb/cart.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        updateCardPrice(); // Update the card price summary
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function removeFromCart(event, productId) {
            event.preventDefault();
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);

            // Remove item from session via AJAX
            const formData = new FormData();
            formData.append('action', 'remove_from_cart');
            formData.append('product_id', productId);

            fetch("http://localhost/ecommercebreifdb/cart-Guest.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        itemElement.remove();
                        updateCartCount();
                        updateCardPrice(); // Update the card price summary
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>