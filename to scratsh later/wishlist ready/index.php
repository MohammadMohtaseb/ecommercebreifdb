<?php
include 'connection.php';

session_start();

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}

$userPageUrl = isUserSignedIn() ? 'user-dashboard.html' : 'account.php';
$userPageUrlFavList = isUserSignedIn() ? 'wishlist.html' : 'fav-list.html';
$userPageUrlCart = isUserSignedIn() ? 'cart.html' : 'fav-list.html';


$query = 'SELECT * FROM products where product_id < 5';
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }

    if ($_POST['action'] == 'add_to_wishlist') {
        if (!in_array($product_id, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $product_id;
        }
    } elseif ($_POST['action'] == 'remove_from_wishlist') {
        if (($key = array_search($product_id, $_SESSION['wishlist'])) !== false) {
            unset($_SESSION['wishlist'][$key]);
            // Re-index the array to maintain proper indexing
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Home</title>
    <link rel="stylesheet" href="dist/main.css">
    <link rel="stylesheet" href="dist/aseel.css">

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
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="shop.html">Men</a></li>
                            <li><a href="shop.html">Women</a></li>
                            <li><a href="shop.html">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="javascript:void(0)">Category 1</a></li>
                                    <li><a href="javascript:void(0)">Category 2</a></li>
                                    <li><a href="javascript:void(0)">Category 3</a></li>
                                    <li><a href="javascript:void(0)">Category 4</a></li>
                                    <li><a href="javascript:void(0)">Category 5</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)">Sales</a></li>
                        </ul>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.html">Men</a></li>
                        <li><a href="shop.html">Women</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li>
                            <a href="javascript:void(0)">Category
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="javascript:void(0)">Category 1</a></li>
                                <li><a href="javascript:void(0)">Category 2</a></li>
                                <li><a href="javascript:void(0)">Category 3</a></li>
                                <li><a href="javascript:void(0)">Category 4</a></li>
                                <li><a href="javascript:void(0)">Category 5</a></li>
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
                                        <span class="cart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrl; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                    </a>
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

    <main>
        <!--Banner Area Start -->
        <section class="banner-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="banner-area__content">
                            <h4>New Collection</h4>
                            <h2>FASHION TRENDS
                            </h2>
                            <p>Uncompromising in style, quality and performance</p>
                            <!--  صفحة المنتجات كلها من غير جندر رابط الصفحة من يوسف ؟  -->
                            <a class="btn bg-primary" href="olog-html-master/shop.php">Shop Now</a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="banner-area__img">
                            <img src="dist/images/banner_aseel.jpg" alt="banner-img" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- <div class="brand-area">
                            <div class="brand-area-image">
                                <img src="dist/images/brand/01.png" alt="Brand" class="img-fluid">
                            </div>
                            <div class="brand-area-image">
                                <img src="dist/images/brand/02.png" alt="Brand" class="img-fluid">
                            </div>
                            <div class="brand-area-image">
                                <img src="dist/images/brand/03.png" alt="Brand" class="img-fluid">
                            </div>
                            <div class="brand-area-image">
                                <img src="dist/images/brand/04.png" alt="Brand" class="img-fluid">
                            </div>
                            <div class="brand-area-image">
                                <img src="dist/images/brand/02.png" alt="Brand" class="img-fluid">
                            </div>
                            <div class="brand-area-image">
                                <img src="dist/images/brand/05.png" alt="Brand" class="img-fluid">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>
        <!--Banner Area End -->

        <!-- Features Section Start -->
        <section class="features">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Featured Products</h2>
                        </div>
                    </div>
                </div>
                <div class="features-wrapper">
                    <div class="features-active">
                        <?php while ($product = $result->fetch_assoc()) : ?>
                            <?php
                            // Check if the product is in the wishlist
                            $isInWishlist = isset($_SESSION['wishlist']) && in_array($product['product_id'], $_SESSION['wishlist']);
                            ?>
                            <div class="product-item">
                                <div class="product-item-image">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                        <?php
                                        if (isset($product['image']) && !empty($product['image'])) {
                                            $imgData = base64_encode($product['image']);
                                            $src = 'data:image/jpeg;base64,' . $imgData;
                                        } else {
                                            $src = '/dist/images/nike-shoe.jpg';
                                        }
                                        ?>
                                        <img src="<?php echo $src; ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid">
                                    </a>
                                    <div class="cart-icon">
                                        <form id="wishlist-form-<?php echo $product['product_id']; ?>" method="post" style="display:inline;" onsubmit="return toggleWishlist(event, <?php echo $product['product_id']; ?>)">
                                            <input type="hidden" name="action" value="<?php echo $isInWishlist ? 'remove_from_wishlist' : 'add_to_wishlist'; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px; margin-right: 3px;">
                                                <i id="wishlist-icon-<?php echo $product['product_id']; ?>" class="<?php echo $isInWishlist ? 'fas fa-heart' : 'far fa-heart'; ?>"></i>
                                            </button>
                                        </form>

                                        <form method="post" action="cartAction.php" target="cart-frame-<?php echo $product['product_id']; ?>" style="display:inline;">
                                            <input type="hidden" name="action" value="add_to_cart">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px;">
                                                <svg id="cart-icon-<?php echo $product['product_id']; ?>" xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                                    <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                        <g id="Icon" transform="translate(0 1)">
                                                            <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>
                                        <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                    </div>
                                </div>
                                <div class="product-item-info">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a>
                                    <span>$<?php echo $product['price']; ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <!-- <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/05.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"> <img src="dist/images/product/04.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/01.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"> <img src="dist/images/product/02.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/03.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div> -->
                    </div>
                    <div class="slider-arrows">
                        <div class="prev-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="next-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-right" data-name="Icon feather-chevron-right" d="M13.5,23l5.25-5.25.438-.437L20.5,16l-7-7" transform="translate(-12.086 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="features-morebutton text-center">
                            <a class="btn bt-glass" href="#">View All Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features Section End -->

        <!-- About Area Start -->
        <section class="about-area">
            <div class="container">
                <div class="about-area-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 ">
                            <div class="about-area-content-img">
                                <img src="dist/images/feature/medicine.jpg" alt="img" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-area-content-text">
                                <h3>Why Shop with Olog</h3>
                                <p>Fortify your hair follicles, give thinning areas some volume, and treat your
                                    body’s
                                    skin like driving your dream car off the lot.</p>
                                <div class="icon-area-content">
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>Secure Payment Method.</span>
                                    </div>
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>24/7 Customers Services.</span>
                                    </div>
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>Shop in 2 languages</span>
                                    </div>
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>Mauris congue eros in iaculis.</span>
                                    </div>
                                </div>

                                <a class="btn bg-primary" href="#">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->

        <!-- Populer Product Strat -->
        <section class="populerproduct">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Popular Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/01.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">PUMA air max 97</a>
                                <span>$975</span> <del>$999</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/02.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Echo Studio. Amazon Echo Studio</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/03.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Corning Sunglasses for Men.</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/04.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Canon PowerShot SX540</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/05.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">BERRY TYPE-II: C1N Backpack</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/06.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Kauri Marine Blue (Green Sole)</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/07.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Full Set for photographer</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/08.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Face Masks,Face Masks of 50 Pack</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item">
                            <div class="product-item-image">
                                <a href="product-details.html"><img src="dist/images/product/09.jpg" alt="Product Name" class="img-fluid"></a>
                                <div class="cart-icon">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                            <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                <g id="Icon" transform="translate(0 1)">
                                                    <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="product-item-info">
                                <a href="product-details.html">Fossil Men's Nate Stainless Steel Chronograph Quartz
                                    Watch</a>
                                <span>$175</span> <del>$199</del>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Populer Product End -->

        <!-- Categorys Section Start -->
        <section class="categorys">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Shop with top categorys</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/tree dasher.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Tree Dasher</h6>
                                    <span>480 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/wool-shoe.jpg" alt="images"> </a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Wool Runner Shoes</h6>
                                    <span>40 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/jumper.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Jumper</h6>
                                    <span>75 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/iphone.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Apple</h6>
                                    <span>12 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/iphone.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Electronic</h6>
                                    <span>50 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/drone.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Drone</h6>
                                    <span>20 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/headphone.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Headphone</h6>
                                    <span>10 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="#"><img src="dist/images/categorys/chosma.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="#">
                                    <h6>Sunglass</h6>
                                    <span>25 Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="features-morebutton text-center">
                            <a class="btn bt-glass" href="#">View All Categorys</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Categorys Section End -->

        <!-- Features Section Start -->
        <section class="customersreview">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>What Our Customers Says</h2>
                        </div>
                    </div>
                </div>
                <div class="customersreview-wrapper">
                    <div class="customersreview-active">
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Ryan Ford</h6>
                                <span>Content Writer</span>
                            </div>
                        </div>
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Tyler Wood</h6>
                                <span>Fashion Designer</span>
                            </div>
                        </div>
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Ryan Ford</h6>
                                <span>Content Writer</span>
                            </div>
                        </div>
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Tyler Wood</h6>
                                <span>Fashion Designer</span>
                            </div>
                        </div>
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Ryan Ford</h6>
                                <span>Content Writer</span>
                            </div>
                        </div>
                        <div class="customersreview-item">
                            <p>It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout.</p>
                            <div class="name">
                                <h6>Tyler Wood</h6>
                                <span>Fashion Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="slider-arrows">
                        <div class="prev-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="next-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-right" data-name="Icon feather-chevron-right" d="M13.5,23l5.25-5.25.438-.437L20.5,16l-7-7" transform="translate(-12.086 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features Section End -->
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center newsletter-area">
                <div class="col-lg-5">
                    <div class="newsletter-area-text">
                        <h4 class="text-white">Subscribe to get notification.</h4>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
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
            <div class="row main-footer">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="main-footer-info">
                        <img src="dist/images/logo/white.png" alt="Logo" class="img-fluid">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie malesuada
                            metus, non molestie ligula laoreet vitae. Ut et fringilla risus, vel.
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-2 col-md-4 col-sm-6 col-12">
                    <div class="main-footer-quicklinks">
                        <h6>Company</h6>
                        <ul class="quicklink">
                            <li><a href="#">About</a></li>
                            <li><a href="#">Help &amp; Support</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                    <div class="main-footer-quicklinks">
                        <h6>Quick links</h6>
                        <ul class="quicklink">
                            <li><a href="#">New Realease</a></li>
                            <li><a href="#">Customize</a></li>
                            <li><a href="#">Sale &amp; Discount</a></li>
                            <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                    <div class="main-footer-quicklinks">
                        <h6>Account</h6>
                        <ul class="quicklink">
                            <li><a href="#">Your Bag</a></li>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Order Completed</a></li>
                            <li><a href="#">Log-out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright d-flex justify-content-between align-items-center">
                        <div class="copyright-text order-2 order-lg-1">
                            <p>&copy; 2020. Design and Developed by <a href="#">Zakir Soft</a></p>
                        </div>
                        <div class="copyright-links order-1 order-lg-2">
                            <a href="#" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->

    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/scss/vendors/plugin/js/slick.min.js"></script>
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

            fetch("", { // Use the current page URL
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
    </script>
</body>