<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youleggings Collections</title>

    <!-- Font / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #ffffff;
            color: #333;
        }

        /* NAVBAR */
        .navbar {
            background: #0f2341;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .logo {
            font-size: 22px;
            font-weight: 600;
        }

        .search-box {
            position: relative;
            width: 350px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px 10px 15px;
            border-radius: 25px;
            border: none;
        }

        .search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
        }

        .nav-icons i {
            margin-left: 20px;
            font-size: 20px;
            cursor: pointer;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -6px;
            right: -10px;
            background: #ff4d4d;
            color: white;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 10px;
        }

        /* SUB MENU */
        .sub-menu {
            background: #12294d;
            padding: 12px 40px;
            display: flex;
            align-items: center;
            gap: 25px;
            color: white;
        }

        .sub-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .breadcrumb {
            margin-left: auto;
            font-size: 14px;
            opacity: 0.8;
        }

        /* ABOUT SECTION */
        .about {
            padding: 20px 40px;
        }

        .about h2 {
            font-size: 28px;
            margin-bottom: 25px;
        }

        .about p {
            margin-bottom: 18px;
            line-height: 1.6;
            max-width: 900px;
        }

        /* FOOTER */
        footer {
            background: #f1f1f1;
            padding: 40px;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-column {
            width: 30%;
            min-width: 250px;
        }

        .footer-column h3 {
            margin-bottom: 15px;
        }

        .footer-column a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .footer-column p {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .social-icons i {
            font-size: 22px;
            margin-right: 12px;
            cursor: pointer;
        }

        copyright {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            font-size: 14px;
        }

        /* WHATSAPP BUTTON */
        .whatsapp-btn {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">youleggings Collections</div>

        <div class="search-box">
            <input type="text" placeholder="Search entire store...">
            <i class="fa fa-search"></i>
        </div>

        <div class="nav-icons">
            <i class="fa-regular fa-user"></i>
            <i class="fa-regular fa-heart"></i>
            <div class="cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count">0</span>
            </div>
        </div>
    </nav>

    <!-- SUB MENU -->
    <div class="sub-menu">
        <a href="#">All Categories</a>
        <a href="#">Kurti Collection</a>
        <a href="#">Night Wears</a>
        <a href="#">Our Brand youleggings</a>
        <span class="breadcrumb">Home / About Us</span>
    </div>

    <!-- ABOUT SECTION -->
    <section class="about">
        <h2>About Us</h2>

        <p><strong>youleggings Collections</strong></p>

        <p>At You Legging, we believe every woman deserves comfort without compromise. Born from the trusted legacy of
            TANTEX, we specialize in bottom wear that blends affordability with high-end quality.</p>

        <p>Our leggings are crafted with premium fabrics, designed to offer:</br>
            • A perfect fit that flatters every body type</br>
            • Stretch that adapts to your lifestyle</br>
            • Durability that lasts wash after wash</p>
    </section>

    <section class="about">

        <p><strong>Classic Leggings </strong></p>

        <p> • Premium cotton-rich fabric for all-day comfort</br>
            • 4-way stretch for the perfect fit</br>
            • Fade-resistant colors that last wash after wash</br>
            • Available in multiple sizes and versatile shades</br>
        </p>

        <p><strong> Ankle-Length Leggings </strong></p>

        <p> • High-quality fabric with perfect stretch & recovery</br>
            • Slim fit that enhances your silhouette</br>
            • Ideal for pairing with kurtis, tops, and tunics</br>
            • Sweat-absorbent, breathable, and durable</br>
        </p>

    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-container">

            <div class="footer-column">
                <h3>Quick Links</h3>
                <a href="#">About Us</a>
                <a href="#">Cart</a>
                <a href="#">Shop Now!</a>
                <a href="#">Contact Us</a>
            </div>

            <div class="footer-column">
                <h3>Customer Support</h3>
                <a href="#">Terms and Conditions</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Reviews</a>
            </div>

            <div class="footer-column">
                <h3>Information</h3>
                <p><i class="fa fa-location-dot"></i> Provident Cosmo City, DR Abdul Kalam Road, Pudhupakkam Village,
                    Chengalpet 603103</p>
                <p><i class="fa fa-phone"></i> +91 91590 24967</p>
                <p><i class="fa fa-envelope"></i> youleggings@gmail.com</p>

                <div class="social-icons">
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="copyright">
            ©2024 youleggings Collections. All Rights Reserved. Developed & Maintained by Ocean Softwares.
        </div>
    </footer>

    <!-- WHATSAPP FLOATING BUTTON -->
    <a href="#" class="whatsapp-btn">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>

</html>
