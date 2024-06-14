<?php
// Template Name: Homepage

$options = get_option('ct_options');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CT Contact Page</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..700&family=Ubuntu:wght@300;400&display=swap" rel="stylesheet" />
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- seo tags -->
    <meta name="description" content="CT Contact Page" />
    <meta name="keywords" content="CT Contact Page, coalition technologies skills test, coalition technologies" />
    <meta name="author" content="Aya Zayed" />
</head>

<body>
    <nav>
        <div class="call-us">
            <h4>Call us now! <span class="num"><?php echo $options['ct-phone'] ?></span></h4>
        </div>
        <div class="auth-btns">
            <a href="#">Login</a>
            <a href="#">Signup</a>
        </div>
    </nav>
    <header>
        <img class="logo" src="<?php echo get_template_directory_uri(); ?>/logo.png" alt="Your Logo" />
        <ul class="nav-list">
            <li class="nav-item"><a href="#">Title 1</a></li>
            <li class="nav-item active">
                <a href="#">Title 2</a>
                <ul class="submenu">
                    <li><a href="#">Submenu 1</a></li>
                    <li><a href="#">submenu 2</a></li>
                    <li class="sub-sub-parent">
                        <a href="#">submenu 3</a>
                        <ul class="sub-sub-menu">
                            <li><a href="#">Submenu 1</a></li>
                            <li><a href="#">submenu 2</a></li>
                            <li><a href="#">submenu 3</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a href="#">Title 3</a></li>
            <li class="nav-item"><a href="#">Title 4</a></li>
            <li class="nav-item"><a href="#">Title 5</a></li>
            <li class="nav-item"><a href="#">Title 6</a></li>
            <li class="nav-item"><a href="#">Title 7</a></li>
        </ul>
        <a href="#" aria-label="Mobile Menu" class="mobile"><i class="fa-solid fa-bars"></i></a>
    </header>
    <main>
        <div class="pagination">
            <h4>
                <a href="#">Home</a> / <a href="#">Who We Are</a> /
                <a href="#" class="active">Contact</a>
            </h4>
        </div>
        <section class="contact-section">
            <h2 class="heading">Contact</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam
                posuere ipsum nec velit mattis elementum. Cum sociis natoque penatibus
                et magnis dis parturient montes, nascetur ridiculus mus. Maecenas eu
                placerat metus, eget placerat libero.
            </p>
            <div class="contact">
                <div class="col">
                    <h3 class="heading">Contact us</h3>
                    <!-- <form action="post">
                        <input type="text" aria-label="name" name="name" id="name" placeholder="Name *" />
                        <div class="col-2">
                            <input aria-label="phone" type="tel" name="phone" id="phone" placeholder="Phone *" />
                            <input aria-label="email" type="email" name="email" id="email" placeholder="Email *" />
                        </div>
                        <textarea aria-label="message" name="message" id="message" placeholder="Message *" rows="4"></textarea>
                        <input type="submit" value="Submit" />
                    </form> -->
                    <?php echo do_shortcode('
                    [contact-form-7 id="0e10dd4" title="Contact form 1"]
                    '); ?>
                </div>
                <div class="col contact-info">
                    <h3 class="heading">Reach us</h3>
                    <h6>Coalition Skills Test</h6>
                    <h6>
                        <span><?php echo $options['ct-address']; ?></span>
                    </h6>
                    <h6>
                        <span> Phone: <?php echo $options['ct-phone']; ?></span>
                        <span>Fax: <?php echo $options['ct-tax']; ?></span>
                    </h6>
                    <div class="icons">
                        <a href="<?php echo $options['ct-social-facebook']; ?>" class="active" aria-label="facebook link"><i class="fa-brands fa-facebook"></i></a>
                        <a href="<?php echo $options['ct-social-twitter']; ?>" aria-label="twitter link"><i class="fa-brands fa-twitter"></i></a>
                        <a aria-label="linkedin link" href="<?php echo $options['ct-social-linkedin']; ?>"><i class="fa-brands fa-linkedin"></i></a>
                        <a aria-label="pinterest link" href="<?php echo $options['ct-social-pinterest']; ?>"><i class="fa-brands fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        const mobileIcon = document.querySelector(".mobile");
        const navList = document.querySelectorAll(".nav-list");

        mobileIcon.addEventListener("click", () => {
            document.querySelector(".nav-list").classList.toggle("open");
        });
    </script>
</body>

</html>