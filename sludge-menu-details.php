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

//ADD TO CART button pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['qty'])) {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    // Check if already in cart
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    // Get product details
    $select_p = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $select_p->execute([$product_id]);
    $fetch_p = $select_p->fetch(PDO::FETCH_ASSOC);

    if ($fetch_p) {
        $price = $fetch_p['price'];

        if ($verify_cart->rowCount() > 0) {
            // Update existing cart entry
            $update_cart = $conn->prepare("UPDATE cart SET qty = qty + ? WHERE user_id = ? AND product_id = ?");
            $update_cart->execute([$qty, $user_id, $product_id]);
        } else {
            // Insert new cart entry
            $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
            $insert_cart->execute([$user_id, $product_id, $price, $qty]);
        }

        header("Location: cart.php");
        exit();
}
}

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
        <style>
            /* Remove arrows in Chrome, Safari, Edge, Opera */
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
        </style>
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
        </header><!--====== End Header Area ======-->
        <!--====== Start Page Section ======-->
        <section class="page-banner">
            <div class="page-bg-wrapper p-r z-1 bg_cover pt-100 pb-110" style="background-image: url(assets/images/bg/page-bg.jpg);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Page Banner Content ===-->
                            <div class="page-banner-content text-center">
                                <h1 class="page-title">Menu Details - Sludge Shake </h1>
                                <ul class="breadcrumb-link">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Menu Details</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Page Section ======-->
        <!--====== Start Menu Section ======-->
        <section class="menu-details-section pt-130 pb-65">
            <div class="container">
                <!--=== Menu Details Wrapper ===-->
                <div class="menu-details-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <!--=== Menu Image ===-->
                            <div class="menu-image mb-50 wow fadeInLeft">
                                <img src="assets/images/menu/sludgeshake.png" alt="Product Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!--=== Menu Info ===-->
                            <div class="menu-info-content mb-50 wow fadeInRight">
                                <h4 class="title">Sludge Shake</h4>
                                <p>Begin out first currently only dessert item, we had to go all out for this shake. It's a mixture of rocky rock ice cream, goat's milk, mold from old oranges, and broken glass we found outside.</p>
                                <span class="price"><span class="currency">$</span>8.00 </span>
                                <form action="" method="POST">
                                    <input type="hidden" name="product_id" value="5">
                                    <div class="product-cart-variation">
                                        <ul>
                                        <li>
                                            <div class="quantity-input">
                                            <button type="button" class="quantity-down"><i class="far fa-minus"></i></button>
                                            <input class="quantity no-arrows" type="number" value="1" name="qty" min="1">
                                            <button type="button" class="quantity-up"><i class="far fa-plus"></i></button>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="add-to-cart">
                                        <input type="submit" class="theme-btn style-one" name="add_to_cart" value="Add to Cart">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <!--=== Description Content Wrapper ===-->
                            <div class="description-content-wrapper mb-30 wow fadeInDown">
                                <!--=== Foodix Tabs ===-->
                                <div class="foodix-tabs style-three mb-20">
                                    <ul class="nav nav-tabs wow fadeInDown">
                                        <li>
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#cat1">Food Details</button>
                                        </li>
                                        <li>
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat2" >Reviews</button>
                                        </li>
                                        <li>
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cat3">Nutrition</button>
                                        </li>
                                    </ul>
                                </div>
                                <!--=== Foodix Tab Content ===-->
                                <div class="tab-content">
                                    <!--=== Tab Pane ===-->
                                    <div class="tab-pane fade show active" id="cat1">
                                       <div class="content-box">
<h3>Sludge Shake</h3>
<p>Behold our first (and currently only) dessert item: the infamous <strong>Sludge Shake</strong>. When we decided to dabble in desserts, we knew we had to go big — or horrifying. This shake is a cursed blend of Rocky Rock™ ice cream, goat’s milk of questionable origin, the noble fuzz of long-forgotten oranges, and just a sprinkle of broken glass found lovingly outside our establishment.</p>
<p>The texture is... unique. Think gravel meets expired dairy. It's crunchy, chunky, and confusing in all the worst ways. Some say it tastes like childhood trauma. Others say it tastes like vengeance. Either way, your dentist will thank you — in profits, not in kind words.</p>
<p>It’s not for the faint of heart or strong of stomach. But if you're brave (or just trying to impress someone), order the <strong>Sludge Shake</strong> and sip your way into our Hall of Shame. Bonus points if you can finish it without crying.</p>

<h4>Ingredients:</h4>
<ul class="check-list mb-30">
    <li>Rocky Rock™ ice cream (we're legally not allowed to say “chocolate”)</li>
    <li>Goat’s milk from that one farm with zero reviews</li>
    <li>Premium orange mold aged for flavor complexity</li>
    <li>Crushed sidewalk glass (adds “crunch” and danger)</li>
    <li>A hint of spoiled vanilla extract (for balance, allegedly)</li>
    <li>Optional: a tiny umbrella that immediately sinks</li>
</ul>

<h4>Preparation:</h4>
<ul class="check-list mb-30">
    <li>Scoop ice cream aggressively until it screams</li>
    <li>Add goat’s milk without asking the goat</li>
    <li>Garnish with the worst parts of citrus neglect</li>
    <li>Drop in shattered glass like it’s boba</li>
    <li>Blend until OSHA calls</li>
    <li>Serve in a cup that clearly gave up on life</li>
</ul>


                                        
</div>
                                    </div>
                                    <div class="tab-pane fade" id="cat2">
                                        <div class="content-box">
                                            <div class="review-box">
                                                <h4 class="mb-4">Customer Reviews</h4>
                                                <ul class="review-list">
                                            
                                            <!-- Review 1 -->
<li class="review-item mb-4">
    <div class="review-header">
        <strong>Eric W.</strong>
        <div class="star-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
        </div>
    </div>
    <p>"Pretty sure I chipped a tooth on a mystery chunk. Tasted like sadness with a hint of driveway gravel."</p>
</li>

<!-- Review 2 -->
<li class="review-item mb-4">
    <div class="review-header">
        <strong>Janine L.</strong>
        <div class="star-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
        </div>
    </div>
    <p>"The mold gave it a weird citrus note. I’m not mad, just deeply confused. 10/10 for emotional turbulence."</p>
</li>

<!-- Review 3 -->
<li class="review-item mb-4">
    <div class="review-header">
        <strong>Sooty (the Stove Spirit)</strong>
        <div class="star-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
        </div>
    </div>
    <p>"I usually haunt the grill, but the Sludge Shake called to me. It's like drinking cursed memories. I approve."</p>
</li>

<!-- Review 4 -->
<li class="review-item mb-4">
    <div class="review-header">
        <strong>Kelly T.</strong>
        <div class="star-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
            <i class="far fa-star text-muted"></i>
        </div>
    </div>
    <p>"My straw melted halfway through. There was definitely glass. I’m both impressed and mildly cursed now."</p>
</li>

<!-- Review 5 -->
<li class="review-item mb-4">
    <div class="review-header">
        <strong>Marcus Z.</strong>
        <div class="star-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="far fa-star text-muted"></i>
        </div>
    </div>
    <p>"It hurt going down, but it changed me. The glass was crunchy, the mold was bold. Dessert should be this dangerous."</p>
</li>


                                            </div>
                                            
                                        </div>
                                    </div>

                                    <!--=== NUTRINAL FACTS ===-->
                                    <div class="tab-pane fade" id="cat3">
                                        <div class="content-box">
                                            <div class="nutrition-facts-box">
                                                <h4 class="mb-3">Nutritional Facts</h4>
                                                <table class="table table-bordered text-start w-100" style="max-width: 400px;">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Serving Size</strong></td>
                                                            <td>1 cursed cup</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Calories</strong></td>
                                                            <td>666 (give or take a demon)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total Fat</strong></td>
                                                            <td>48g (mostly from the goat’s milk... probably)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">Saturated Fat</td>
                                                            <td>32g (orange mold is surprisingly creamy)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Cholesterol</strong></td>
                                                            <td>140mg (consult your local wizard)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Sodium</strong></td>
                                                            <td>1,230mg (the glass is oddly salty)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total Carbohydrates</strong></td>
                                                            <td>51g (rocky road never stood a chance)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">Dietary Fiber</td>
                                                            <td>0g (fiber disintegrated on contact)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">Sugars</td>
                                                            <td>19g (mostly from the mold’s final stand)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Protein</strong></td>
                                                            <td>8g (glass shards not included)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Glass Content</strong></td>
                                                            <td>3 shards (varies by location)</td>
                                                        </tr>
                                                        <tr class="table-danger">
                                                            <td colspan="2" class="text-center"><em>*May cause existential dread, minor bleeding, and an appreciation for real milkshakes*</em></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        </div>
                    </div>
                    <!--=== Releted Item WRapper ===-->
                    <div class="releted-item-wrap pt-45">
                        <!--=== Releted Title ===-->
                        <h3 class="releted-title mb-30 wow fadeInDown">Related items</h3>
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <!--=== Menu Item ===-->
                                <div class="menu-item related-menu-item text-center mb-30 wow fadeInUp">
                                    <div class="menu-image">
                                        <img src="assets/images/menu/dumpsterfire.png" alt="Image">
                                    </div>
                                    <div class="menu-info">
                                        <h4 class="title"><a href="dump-menu-details.php">The Dumpster Fire</a></h4>
                                        <p>Our social media famous burger, The Dumpster Fire, is a simple cheese burger covered in whatever we found outback and our spicy homemade sauce. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <!--=== Menu Item ===-->
                                <div class="menu-item related-menu-item text-center mb-30 wow fadeInUp">
                                    <div class="menu-image">
                                        <img src="assets/images/menu/crudsticks.png" alt="Image">
                                    </div>
                                    <div class="menu-info">
                                        <h4 class="title"><a href="crud-menu-details.php">Crudsticks</a></h4>
                                        <p>This is our vegan friendly option!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <!--=== Menu Item ===-->
                                <div class="menu-item related-menu-item text-center mb-30 wow fadeInUp">
                                    <div class="menu-image">
                                        <img src="assets/images/menu/hairyfries.png" alt="Image">
                                    </div>
                                    <div class="menu-info">
                                        <h4 class="title"><a href="hair-menu-details.php">Hairy Fries</a></h4>
                                        <p>Fries that are hairy... DUHHHH!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--====== End Menu Section ======-->
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