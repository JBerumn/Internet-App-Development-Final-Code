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
    <body class="home-two">
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
</div><!--====== End Sidemenu-wrapper-cart Area ======-->
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
        </header><!--====== End Header Area ======-->
        <!--====== Start Hero Section ======-->
        <section class="hero-section">
            <!--=== Hero Wrapper ===-->
            <div class="hero-wrapper-two bg_cover" style="background-image: url(assets/images/home/4.png);">
                <div class="shape shape-one scene"><span data-depth=".5"><img src="assets/images/hero/shape-1.png" alt="shape image"></span></div>
                <div class="shape shape-two scene"><span data-depth=".7"><img src="assets/images/hero/shape-3.png" alt="shape image"></span></div>
                <div class="shape shape-three scene"><span data-depth=".8"><img src="assets/images/hero/shape-4.png" alt="shape image"></span></div>
                <!--=== Hero Image ===-->
                <div class="hero-image">
                    <img src="assets/images/home/3.png" class="wow fadeInRight" data-wow-delay=".65s" alt="Hero Image">
                    <div class="text-shape text-one wow bounceInUp"><span><img src="assets/images/home/1.png" alt="Text"></span></div>
                    <div class="text-shape text-two wow bounceInRight"><span><img src="assets/images/home/2.png" alt="Text"></span></div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <!--=== Hero Content ===-->
                            <div class="hero-content">
                                <span class="tag-line wow fadeInUp" data-wow-delay=".4s">The best in town</span>
                                <h1 class="wow fadeInDown" data-wow-delay=".5s">The Dumpster Fire</h1>
                                <p class="wow fadeInDown" data-wow-delay=".6s">Our social media famous burger, The Dumpster Fire, is a simple cheese burger covered in whatever we found outback and our spicy homemade sauce. It doesn't come out on fire but if you ask we'll cover it in alcohol and set it on fire.(ATTENTION: You must sign our waiver and be of age for this option)</p>
                                <div class="hero-button wow fadeInDown" data-wow-delay=".7s">
                                    <a href="dump-menu-details.php" class="theme-btn style-one">Order Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Hero Section ======-->
        <!--====== Start About Section ======-->
        <section class="about-section pt-130 pb-80 gray-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <!--=== Section Content Box ===-->
                        <div class="section-content-box mb-50">
                            <div class="section-title mb-35 wow fadeInDown">
                                <span class="sub-title">About Us</span>
                                <h2>Burgers so NASTEE its GOOD</h2>
                                <p>NASTEE Burger was founded in the summer of '87 by Nash Flanigan. Nash was known by many in the neighborhood as the neighborhood jokester. There wasn't a moment where Nash wasn't around toher craking jokes and making others laugh. Nash was also known for...</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!--=== Iconic Box ===-->
                                    <div class="iconic-box style-three mb-30 wow fadeInUp">
                                        <div class="icon">
                                            <img src="assets/images/icon/icon-5.svg" alt="icon">
                                        </div>
                                        <div class="content">
                                            <h5>Fresh Perspective on Ideal Eating.</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!--=== Iconic Box ===-->
                                    <div class="iconic-box style-three mb-30 wow fadeInUp">
                                        <div class="icon">
                                            <img src="assets/images/icon/icon-6.svg" alt="icon">
                                        </div>
                                        <div class="content">
                                            <h5>Premium Natural Ingredients.</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--=== About Button ===-->
                            <div class="about-button wow fadeInUp">
                                <a href="about.php" class="theme-btn style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--=== About Image Box ===-->
                        <div class="section-image-box style-two mb-20">
                            <div class="row">
                                <div class="col-lg-9">
                                    <!--=== About Image ===-->
                                    <div class="image-box mb-30 wow fadeInDown">
                                        <img src="assets/images/menu/NASTEETruck.png" alt="image">
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End About Section ======-->
        <!--====== Start Banner Section ======-->
        <section class="foodix-banner-section gray-bg">
            <!--=== Foodix Banner ===-->
            <div class="foodix-banner-v1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6">
                            <!--=== Foodix Banner ITem ===-->
                            <div class="foodix-banner-item style-one mb-40 wow fadeInLeft">
                                <div class="banner-inner-wrap bg_cover" style="background-image: url(assets/images/bg/bg1.png);">
                                    <div class="banner-img"><img style="height: 470px;" src="assets/images/menu/ognastee.png" alt=""></div>
                                    <div class="banner-content">
                                        <h2>Original NASTEE Burger</h2>
                                        <p>This is it! The burger that started it all. A classic cheese burger
                                             covered in mold, drenched in our secret slime sauce. 
                                             It even comes with a free rat!</p>
                                        <p class="price"><span class="currency">$</span>100.00</p>
                                        <a href="og-menu-details.php" class="theme-btn style-one">Order Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!--=== Foodix Banner ITem ===-->
                            <div class="foodix-banner-item style-one mb-40 wow fadeInRight">
                                <div class="banner-inner-wrap bg_cover" style="background-image: url(assets/images/bg/bg2.png);">
                                    <div class="banner-img"><img style="height: 450px;" src="assets/images/menu/mysterymeat.png" alt=""></div>
                                    <div class="banner-content">
                                        <h2>Mystery Meat</h2>
                                        <p>We'll be honest, these ones scare us a bit. 
                                            It's pretty much whatever meat we can find put between 
                                            to pieces of bread. The Problem is we can't always identify the meat. 
                                            To make up for this we put a thick slize off cheese in there, 
                                            who doesn't love cheese?</p>
                                        <p class="price"><span class="currency">$</span>0.99</p>
                                        <a href="mystery-menu-details.php" class="theme-btn style-one">Order Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Banner Section ======-->
        <!--====== Start Foodix Menu Section ======-->
        <section class="foodix-menu-section pt-80 pb-90 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center mb-55 wow fadeInDown">
                            <span class="sub-title">Our Menu</span>
                            <h2>Choose Menu</h2>
                            <p>Savor the exceptional with our NEW Steak! Discover succulence redefined a tantalizing blend of flavors that promises a culinary...</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--=== Foodix Tabs ===-->
                        <div class="foodix-tabs style-four mb-70">
                            <ul class="nav nav-tabs wow fadeInDown">
                                <li>
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#cat1">Burgers</button>
                                </li>
                                <li>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat2" >Sandwiches</button>
                                </li>
                                <li>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat3">Drinks</button>
                                </li>
                                <li>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat4">Vegan Friendly</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--=== Tab Content ===-->
                        <div class="tab-content">
                            <!--=== Tab Pane ===-->
                            <div class="tab-pane fade show active" id="cat1">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/ognastee.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="og-menu-details.php">Original NASTEE Burger</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(4.8)</a></li>
                                                </ul>
                                                <p>This is it! The burger that started it all. A classic 
                                                    cheese burger covered in mold, drenched in our secret
                                                     slime sauce. It even comes with a free rat! </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>100.00</p>
                                                    <a href="og-menu-details.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/dumpsterfire.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="dump-menu-details.php">The Dumpster Fire</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(5.0)</a></li>
                                                </ul>
                                                <p>Our social media famous burger, The Dumpster Fire, 
                                                    is a simple cheese burger covered in whatever we 
                                                    found outback and our spicy homemade sauce. It doesn't
                                                     come out on fire but if you ask we'll cover it in alcohol 
                                                     and set it on fire.(ATTENTION: You must sign our waiver and 
                                                     be of age for this option) </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>12.14</p>
                                                    <a href="dump-menu-details.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/mysterymeat.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="mystery-menu-details.php">Mystery Meat</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="far fa-star"></i></li>
                                                    <li><i class="far fa-star"></i></li>
                                                    <li><i class="far fa-star"></i></li>
                                                    <li><i class="far fa-star"></i></li>
                                                    <li><a href="#">(1.2)</a></li>
                                                </ul>
                                                <p>We'll be honest, these ones scare us a bit. It's pretty much 
                                                    whatever meat we can find put between to pieces of bread. The 
                                                    Problem is we can't always identify the meat. To make up for this 
                                                    we put a thick slize off cheese in there, who doesn't love cheese? </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>0.99</p>
                                                    <a href="mystery-menu-details.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--=== Tab Pane ===-->
                            <div class="tab-pane fade" id="cat2">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
               




                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/stovegreasegrilledcheese.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="stove-menu-details.php">Stove Grease Grilled Cheese</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(4.7)</a></li>
                                                </ul>
                                                <p>Now don't let this normal looking grilled cheese fool you.
                                                     What we mean by Stove grease grilled, is that we literally 
                                                     cook it in all our stove's grease. So no matter what we were
                                                      making on this thing before, there a little bit of everything 
                                                      on this sandwich. This leads to a unique flavor everytime. </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>7.00</p>
                                                    <a href="cart.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                     
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--=== Tab Pane ===-->
                            <div class="tab-pane fade" id="cat3">
                                <div class="row justify-content-center">
                        
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/sludgeshake.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="sludge-menu-details.php">Sludge Shake</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(4.5)</a></li>
                                                </ul>
                                                <p>Begin out first currently only dessert item, we had 
                                                    to go all out for this shake. It's a mixture of 
                                                    rocky rock ice cream, goat's milk, mold from old 
                                                    oranges, and broken glass we found outside. </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>7.00</p>
                                                    <a href="cart.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!--=== Tab Pane ===-->
                            <div class="tab-pane fade" id="cat4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/crudsticks.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="crud-menu-details.php">Crud Sticks</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(4.5)</a></li>
                                                </ul>
                                                <p>This is our vegan friendly option!. It may look like a pickle but
                                                     it's a bunch of randomly picked green vegatables we grabbed, 
                                                     compacted together, and skewed on a stick. Then we dip them in vinegar, and bang! Crud Sticks. </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>7.00</p>
                                                    <a href="cart.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <!--=== Menu Item ===-->
                                        <div class="menu-item style-five mb-40">
                                            <div class="menu-thumbnail">
                                                <img src="assets/images/menu/hairyfries.png" alt="menu image">
                                            </div>
                                            <div class="menu-info">
                                                <h4 class="title"><a href="hair-menu-details.php">Hairy Fries</a></h4>
                                                <ul class="ratings">
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><a href="#">(4.1)</a></li>
                                                </ul>
                                                <p>Fries that are hairy... YUM! </p>
                                                <div class="menu-bottom">
                                                    <p class="price"><span class="currency">$</span>3.75</p>
                                                    <a href="cart.php" class="cart-icon"><i class="fas fa-cart-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Foodix Menu Section ======-->
        <!--====== Start Reservation Section ======-->
        <section class="reservation-section" id="reservation">
            <div class="booking-wrapper-two bg_cover pt-120 pb-130" style="background-image: url(assets/images/bg/reserved.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <!--=== Section Title ===-->
                            <div class="section-content-box wow fadeInDown">
                                <div class="section-title text-white mb-40">
                                    <span class="sub-title">Reservation</span>
                                    <h2>BOOK A TABLE</h2>
                                    <p>Book at NASTEE Burger TODAY! DO IT OR ELSE. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <!--=== Booking Form Wrapper ===-->
                            <div class="booking-form-box wow fadeInUp">
                                <form class="booking-form" action="reservation.php" method="post">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form_group">
                                                <input type="text" class="form_control" placeholder="Enter your name" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form_group">
                                                <input type="email" class="form_control" placeholder="Enter your Email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_group">
                                                <select class="wide" name="party" required>
                                                    <option value="1">1 People</option>
                                                    <option value="2">2 People</option>
                                                    <option value="3">3 People</option>
                                                    <option value="4">4 People</option>
                                                    <option value="5">5 People</option>
                                                    <option value="6">6 People</option>
                                                    <option value="7+">7+ People</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_group">
                                                <input type="text" class="form_control" placeholder="Date" id="datepicker" name="date" required>
                                                <span class="icon"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_group">
                                                <select class="wide" name="time" required>
                                                    <option value="10am-11am">10.00 Am - 11.00 Am</option>
                                                    <option value="11am-12pm">11.00 Am - 12.00 Pm</option>
                                                    <option value="12pm-1pm">12.00 Pm - 01.00 Pm</option>
                                                    <option value="1pm-2pm">02.00 Pm - 03.00 Pm</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_group">
                                                <input type="text" class="form_control" placeholder="Enter your phone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form_group">
                                                <button class="theme-btn style-one">Book a Table</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Reservation Section ======-->
        <!--====== Start Special Offer Section ======-->
        <section class="special-offer-section pt-120 pb-90 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--=== Section Title ===-->
                        <div class="section-title text-center mb-50 wow fadeInDown">
                            <span class="sub-title">Special offer</span>
                            <h2>Burger deal today!</h2>
                            <p>An irresistible offer awaits today with fantastic deals on a wide range of delicious, mouthwatering burgers for everyone's delight.</p>
                        </div>
                    </div>
                </div>
                <!--=== Special Off Slider ===-->
                <div class="special-off-slider wow fadeInUp">
                    <!--=== Special Off Item ===-->
                    <div class="special-off-item text-center mb-40">
                        <div class="sp-shape"><img src="assets/images/gallery/sp-shape-1.png" alt="shape"></div>
                        <div class="item-title">
                            <h4>Dumpster Fire Burger</h4>
                        </div>
                        <div class="image">
                            <img src="assets/images/menu/dumpsterfire.png" alt="image">
                        </div>
                        <div class="content">
                            <p>Our social media famous burger, The Dumpster Fire,
                                 is a simple cheese burger covered in whatever we found 
                                 outback and our spicy homemade sauce. It doesn't come out 
                                 on fire but if you ask we'll cover it in alcohol and set 
                                 it on fire.</p>
                        </div>
                    </div>
                    <!--=== Special Off Item ===-->
                    <div class="special-off-item text-center mb-40">
                        <div class="sp-shape"><img src="assets/images/gallery/sp-shape-1.png" alt="shape"></div>
                        <div class="item-title">
                            <h4>OG NASTEE Burger</h4>
                        </div>
                        <div class="image">
                            <img src="assets/images/menu/ognastee.png" alt="image">
                        </div>
                        <div class="content">
                            <p>This is it! The burger that started it all. A classic cheese burger 
                                covered in mold, drenched in our secret slime sauce. It even comes with a free rat!</p>
                        </div>
                    </div>
                    <!--=== Special Off Item ===-->
                    <div class="special-off-item text-center mb-40">
                        <div class="sp-shape"><img src="assets/images/gallery/sp-shape-1.png" alt="shape"></div>
                        <div class="item-title">
                            <h4>Crud Sticks</h4>
                        </div>
                        <div class="image">
                            <img src="assets/images/menu/crudsticks.png" alt="image">
                        </div>
                        <div class="content">
                            <p>This is our vegan friendly option!. It may look like a pickle but 
                                it's a bunch of randomly picked green vegatables we grabbed, 
                                compacted together, and skewed on a stick. Then we dip them in 
                                vinegar, and bang! Crud Sticks.</p>
                        </div>
                    </div>
                    <!--=== Special Off Item ===-->
                    <div class="special-off-item text-center mb-40">
                        <div class="sp-shape"><img src="assets/images/gallery/sp-shape-1.png" alt="shape"></div>
                        <div class="item-title">
                            <h4>Hairy Fries</h4>
                        </div>
                        <div class="image">
                            <img src="assets/images/menu/hairyfries.png" alt="image">
                        </div>
                        <div class="content">
                            <p>Fries that are hairy...</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Special Offer Section ======-->


        <!--====== Start Intro Section ======-->
        <section class="intro-section pt-120 pb-120">
            <div class="container">
                <!--=== Intro Bg Wrapper ===-->
                <div class="intro-wrapper_three bg_cover pt-130 pb-125" style="background-image: url(assets/images/bg/burg.jpg);">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-content-box text-white text-center wow fadeInDown">
                                <div class="play-button">
                                    <a href="https://www.youtube.com/watch?v=gcra417j9KA" class="video-popup"><i class="fas fa-play"></i></a>
                                </div>
                                <h2 class="text-uppercase">Possibilities Between Every <br> Burger Bite.</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Intro Section ======-->


        <!--====== Start Testimonial Section ======-->
        <section class="testimonial-section gray-bg pt-120 pb-130">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Section Title ===-->
                            <div class="section-title text-center mb-55 wow fadeInDown">
                                <span class="sub-title">Testimonial</span>
                                <h2>Our Customer Say</h2>
                                <p>Listen to our customers reviews! They were definetly not held at gun point :P</p>
                            </div>
                        </div>
                    </div>
                    <!--=== Testimonial Slider ===-->
                    <div class="testimonial-slider-two wow fadeInUp">
                        <!--=== Testimonial Item ===-->
                        <div class="testimonial-item style-two mb-40">
                            <div class="testimonial-content">
                                <div class="author-thumb-item">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimonial/1.png" alt="author image">
                                    </div>
                                    <div class="author-info">
                                        <h5>Jane Cooper</h5>
                                        <span>A week ago</span>
                                    </div>
                                </div>
                                <p>Actaully... Kinda good...</p>
                                <ul class="ratings rating-four">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <!--=== Testimonial Item ===-->
                        <div class="testimonial-item style-two mb-40">
                            <div class="testimonial-content">
                                <div class="author-thumb-item">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimonial/3.png" alt="author image">
                                    </div>
                                    <div class="author-info">
                                        <h5>Andy Anderson</h5>
                                        <span>A week ago</span>
                                    </div>
                                </div>
                                <p>SO DELICIOUS-GUYS HELP HELP, THE MYSTERY MEAT DONT EAT IT PLEASE SOS SOS SOMEBODY ANYBODY- THE BASEMENT LOOK IN THE BAS-</p>
                                <ul class="ratings rating-four">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <!--=== Testimonial Item ===-->
                        <div class="testimonial-item style-two mb-40">
                            <div class="testimonial-content">
                                <div class="author-thumb-item">
                                    <div class="author-thumb">
                                        <img src="assets/images/testimonial/2.png" alt="author image">
                                    </div>
                                    <div class="author-info">
                                        <h5>Mary Jane</h5>
                                        <span>A week ago</span>
                                    </div>
                                </div>
                                <p>Nice place, wonderful staff! Super Family friedndly the kiddos love the food!</p>
                                <ul class="ratings rating-five">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Testimonial Section ======-->
       
        
       
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