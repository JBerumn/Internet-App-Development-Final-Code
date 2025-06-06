<?php
include 'connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = create_unique_id();
    setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 30);
}
//Corner cart display
// Fetch all cart items
$get_cart = $conn->prepare("SELECT cart.*, products.name, products.image FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$get_cart->execute([$user_id]);
$cart_items = $get_cart->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!--====== Required meta tags ======-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Insurance, Health, Agency">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--====== Title ======-->
        <title>NASTEE Burger</title>
        <!--====== Favicon Icon ======-->
        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
        <!--====== Google Fonts ======-->
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!--====== FontAwesome css ======-->
        <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.min.css">
        <!--====== Bootstrap css ======-->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <!--====== Slick-popup css ======-->
        <link rel="stylesheet" href="assets/vendor/slick/slick.css">
        <!--====== Nice Select css ======-->
        <link rel="stylesheet" href="assets/vendor/nice-select/css/nice-select.css">
        <!--====== magnific-popup css ======-->
        <link rel="stylesheet" href="assets/vendor/magnific-popup/dist/magnific-popup.css">
        <!--====== Jquery UI css ======-->
        <link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.min.css">
        <!--====== Animate css ======-->
        <link rel="stylesheet" href="assets/vendor/animate.css">
        <!--====== Default css ======-->
        <link rel="stylesheet" href="assets/css/default.css">
        <!--====== Style css ======-->
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <!--====== Start Loader Area ======-->
        <div class="fd-preloader">
            <div class="loader"></div>
        </div><!--====== End Loader Area ======-->
        <!--====== Start Overlay ======-->
        <div class="offcanvas__overlay"></div>
        <!--====== End Overlay ======-->
        <!--====== Start Sidemenu-wrapper-cart Area ======-->
        <div class="sidemenu-wrapper-cart">
    <div class="sidemenu-content">
        <div class="widget widget-shopping-cart">
            <h4>My cart</h4>
            <div class="sidemenu-cart-close"><i class="far fa-times"></i></div>
            <div class="widget-shopping-cart-content">
                <ul class="foodix-mini-cart-list">
                    <?php 
                    $subtotal = 0;
                    if (!empty($cart_items)): 
                            foreach ($cart_items as $item): 
                            $item_total = $item['qty'] * $item['price'];
                            $subtotal += $item_total;
                        ?>
                            <li class="foodix-menu-cart">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?> image">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                                <span class="quantity"><?= $item['qty'] ?> × 
                                    <span><span class="currency">$</span><?= number_format($item['price'], 2) ?></span>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="foodix-menu-cart">Your cart is empty.</li>
                    <?php endif; ?>
                </ul>
                <div class="cart-mini-total">
                    <div class="cart-total">
                        <span><strong>Subtotal:</strong></span>
                        <span class="currency">$</span><?= number_format($subtotal, 2) ?>
                    </div>
                </div>
                <div class="cart-button">
                    <a href="checkout.php" class="theme-btn style-one">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
        <!--====== End Sidemenu-wrapper-cart Area ======-->
               <!--====== Start Header Area ======-->
               <header class="header-area header-one navigation-white transparent-header">
                <div class="container">
                    <div class="header-navigation">
                        <div class="nav-overlay"></div>
                        <div class="primary-menu">
                            <!--=== Site Branding ===-->
                            <div class="site-branding">
                                <a href="index.php" class="brand-logo"><img src="assets/images/logo/nasteelogo.png" alt="Logo"></a>
                            </div>
                            <div class="nav-inner-menu">
                                <!--=== Foodix Nav Menu ===-->
                                <div class="foodix-nav-menu">
                                    <!--=== Mobile Logo ===-->
                                    <div class="mobile-logo mb-30 d-block d-xl-none text-center">
                                        <a href="index.php" class="brand-logo"><img src="assets/images/logo/nasteelogo.png" alt="Site Logo"></a>
                                    </div>
                                    <!--=== Main Menu ===-->
                                    <nav class="main-menu">
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="menu.php">Menu</a></li>
                                            <li class="menu-item has-children"><a href="about.php">About Us</a>
                                                <ul class="sub-menu">
                                                    <li><a href="faq.php">Faqs</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="merch.php">Merch</a></li>
                                            <li class="menu-item"><a href="contact.php">Contact</a></li>
                                        </ul>
                                    </nav>
                                    <!--=== Nav Button ===-->
                                    <div class="nav-button mt-50 d-block d-xl-none  text-center">
                                        <a href="index.php#reservation" class="theme-btn style-one">Book A Table</a>
                                    </div>
                                </div>
                                <!--=== Nav Right Item ===-->
                                <div class="nav-right-item">
                                    <div class="nav-button d-none d-xl-block">
                                        <a href="index.php#reservation" class="theme-btn style-one">Book A Table</a>
                                    </div>
                                    <div class="cart-button">
                                        <i class="far fa-shopping-cart"></i>
                                    </div>
                                    <div class="navbar-toggler">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header><!--====== End Header Area ======-->->
        <!--====== Start Page Section ======-->
        <section class="page-banner">
            <div class="page-bg-wrapper p-r z-1 bg_cover pt-100 pb-110" style="background-image: url(assets/images/bg/page-bg.jpg);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Page Banner Content ===-->
                            <div class="page-banner-content text-center">
                                <h1 class="page-title">Contact</h1>
                                <ul class="breadcrumb-link">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Page Section ======-->
        <!--====== Start Checkout Section ======-->
        <section class="checkout-section pt-130 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--===  Checkout Faqs  ===-->
                        <?php
                        $name = $_POST['name'];
                        ?>
                        </style>
                        <div class="checkout-faqs wow fadeInUp" id="checkout-faq">
                            <h2>Contact Form Submitted</h2>
                            <br><h3>Hi, <strong><?php echo htmlspecialchars($name); ?></strong>.</h3>
                            <h3 style="font-weight: normal">Thank you for your interest in NASTEE Burger! We have received your message and will respond within 3-5 business days.</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--=== Checkout Wrapper ===-->
                        <div class="checkout-wrapper mt-50 wow fadeInUp">
                            <!--=== Checkout Form ===-->
                            
        </section><!--====== End Checkout Section ======-->
        <!--====== Start Footer ======-->
        <footer class="footer-default p-r z-1">
            <div class="footer-shape f-shape_one scene"><span data-depth=".3"><img src="assets/images/shape/shape-2.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_two scene"><span data-depth=".4"><img src="assets/images/shape/shape-3.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_three scene"><span data-depth=".5"><img src="assets/images/shape/shape-4.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_four scene"><span data-depth=".6"><img src="assets/images/shape/shape-5.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_five scene"><span data-depth=".7"><img src="assets/images/shape/shape-6.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_six scene"><span data-depth=".8"><img src="assets/images/shape/shape-7.png" alt="shape"></span></div>
            <div class="footer-shape f-shape_seven scene"><span data-depth=".9"><img src="assets/images/shape/shape-8.png" alt="shape"></span></div>
            <div class="container">
                <!--=== Footer Widget Area ===-->
                <div class="footer-widget-area pt-120 pb-75">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <!--=== Footer Widget ===-->
                            <div class="footer-widget footer-about-widget mb-40 wow fadeInUp">
                                <div class="widget-content">
                                    <div class="footer-logo mb-25">
                                        <a href="index.php"><img src="assets/images/logo/nasteelogo.png" alt="Brand Logo"></a>
                                    </div>
                                    <p>So NASTEE its GOOD</p>
                                    <ul class="social-link">
                                        <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://x.com"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <!--=== Footer Widget ===-->
                            <div class="footer-widget footer-contact-widget mb-40 wow fadeInUp">
                                <div class="widget-content">
                                    <h4 class="widget-title">Contact Us</h4>
                                    <ul class="address-list">
                                        <li>1234 Your Moms House, California 91767</li>
                                        <li><a href="tel:+88-344-667-999">+1-123-345-567</a></li>
                                        <li><a href="mailto:order@nasteeBurger.com">order@nasteeBurger.com</a></li>		
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <!--=== Footer Widget ===-->
                            <div class="footer-widget footer-nav-widget mb-40 wow fadeInUp">
                                <div class="widget-content">
                                    <h4 class="widget-title">Quick Link</h4>
                                    <ul class="widget-menu">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="menu.php">menu</a></li>
                                        <li><a href="about.php">About Us</a></li>
                                        <li><a href="faq.php">FAQs</a></li>
                                        <li><a href="merch.php">Our Menu</a></li>
                                        <li><a href="contact.php">Gallery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <!--=== Footer Widget ===-->
                            <div class="footer-widget footer-opening-widget mb-40 wow fadeInUp">
                                <div class="widget-content">
                                    <h4 class="widget-title">Opining time</h4>
                                    <ul class="opening-schedule">
                                        <li>Monday<span>: 10.00am - 05.00pm </span></li>
                                        <li>Tuesday<span>: 10.20am - 05.30pm </span></li>
                                        <li>Wednesday<span>: 10.30am - 05.50pm </span></li>
                                        <li>Thursday<span>: 11.00am - 07.10pm </span></li>
                                        <li>Friday : <span class="of-close">Closed</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--=== Copyright Area ===-->
            <div class="copyright-area text-center">
                <div class="container">
                    <div class="copyright-text">
                        <p>&copy; 2025 All rights reserved design by Nastee Burger</p>
                    </div>
                </div>
            </div>
        </footer><!--====== End Footer ======-->
        <!--====== Back To Top  ======-->
        <a href="#" class="back-to-top" ><i class="far fa-angle-up"></i></a>
        <!--====== Jquery js ======-->
        <script src="assets/vendor/jquery-3.6.0.min.js"></script>
        <!--====== Popper js ======-->
        <script src="assets/vendor/popper/popper.min.js"></script>
        <!--====== Bootstrap js ======-->
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--====== Slick js ======-->
        <script src="assets/vendor/slick/slick.min.js"></script>
        <!--====== Magnific js ======-->
        <script src="assets/vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
        <!--====== Nice-select js ======-->
        <script src="assets/vendor/nice-select/js/jquery.nice-select.min.js"></script>
        <!--====== Parallax js ======-->
        <script src="assets/vendor/parallax.min.js"></script>
        <!--====== jquery UI js ======-->
        <script src="assets/vendor/jquery-ui/jquery-ui.min.js"></script>
        <!--====== WOW js ======-->
        <script src="assets/vendor/wow.min.js"></script>
        <!--====== Main js ======-->
        <script src="assets/js/theme.js"></script>
    </body>
</html>