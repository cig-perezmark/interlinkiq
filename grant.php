<!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
    <header>
        <div class="logo">
            <img src="	https://consultareinc.com/wp-content/uploads/2023/04/consultare-inc-group-white.png">
        </div>
        <nav>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="//consultareinc.com/shop">SOPKing</a></li>
            <li><a href="management_services">Services</a></li>
            <li><a href="directory">Directory</a></li>
            <li><a href="blog_posts_table">Blog</a></li>
            <li><a href="forum/index">Forum</a></li>
            <li><a href="specialist">Specialist</a></li>
            <li><a href="grant">Grant Service</a></li>
            <li><a href="contact">Contact Us</a></li>
        </ul>
        </nav>
        <div class="burger" onclick="toggleMenu()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        </div>
    </header>

    <div class="content">
        <div class="banner">
            <div class="banner-text">
                <div class="marquee-container">
                    <div class="marquee-content">
                        Grant Management Writing and Application Submission Services
                    </div>
                </div>
            </div>
        </div>
        <div class="services" style="padding:40px">
            <ul>
                <li>Grant Proposal Writing</li>
                <li>Grant Research</li>
                <li>Grant Application Services</li>
                <li>Grant Editing</li>
                <li>Grant Management</li>
                <li>Grant Strategy Assessment</li>
                <li>Budget Preparation</li>
                <li>Grant Compliance Management &amp; Auditing</li>
                <li>Regulatory Management</li>
                <li>Training and Development Compliance</li>
            </ul>
        </div>
        <div class="additional-text" style="padding:40px">
            <p>Our team works with our clients on a daily basis in identifying funding sources that align with their priorities. We utilize teams of project managers and proposal development specialists to craft competitive grant applications for submission to Federal agencies and national foundations.</p>
            <p>We support Grant proposal development efforts of all sizes from small or single-investigator proposals, to institution-wide grants, to complex, center-level research proposals.</p>
            <p>We work closely with each client to identify and target funding opportunities that align with their goals.</p>
        </div>
        <div class="contact-button">
            <a href="https://consultareinc.com/" target="_blank" class="button">Contact Us</a>
        </div>
        <div class="faq" style="padding:40px">
            <h2>FAQ</h2>
            <ul>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> Can I cancel service at any time?</strong>
                  <div class="faq-answer">
                    <p> - Cancellation of services requires a 10-day notice to our team so we may terminate the service.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> What if my application was not approved?</strong>
                  <div class="faq-answer">
                    <p> - Our team will continue to assist your application process until approval or when the Grant submission date expires, whichever comes first.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> Once the services are terminated, can we still continue in the future?</strong>
                  <div class="faq-answer">
                    <p> - Continuing your Grant application requires only a notification to our Grant Service Team.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> What are your processing fees?</strong>
                  <div class="faq-answer">
                    <p> - Our processing fees are based on the percentage of the grant being processed.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> Is it possible to receive a refund for my payment in the event that my application is disapproved?</strong>
                  <div class="faq-answer">
                    <p> - Processing fees paid are not refundable.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> What is the expected processing time for my Grant application until it receives approval?</strong>
                  <div class="faq-answer">
                    <p> - Processing time differs depending on your type of application and complying with the requirements.</p>
                  </div>
                </li>
                <li>
                  <strong class="faq-question"><span class="toggle-icon">+</span> What are the essential criteria that my Grant application must meet to obtain approval?</strong>
                  <div class="faq-answer">
                    <p> - We follow the strict guidelines stated on the Grant requirements. We then provide action items for you to comply and meet those requirements.</p>
                  </div>
                </li>
              </ul>

        </div>
    </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    </body>
    </html>
    <script>
    $(document).ready(function() {
       // Toggle the answer and rotate the icon when clicking the question
      $('.faq-question').click(function() {
        // Toggle the 'rotate' class on the '+' icon
        $(this).find('.toggle-icon').toggleClass('rotate');
    
        // Toggle the visibility of the answer
        $(this).next('.faq-answer').slideToggle();
      });
    });
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            const burger = document.querySelector('.burger');

            const computedStyle = window.getComputedStyle(navLinks);
            const display = computedStyle.getPropertyValue('display');

            navLinks.style.display = (display === 'flex') ? 'none' : 'flex';
            burger.classList.toggle('active');
        }
    </script>
<style>
    *{
        margin:0;
        padding:0;
    }
    .faq-answer {
      display: none;
    }
    
    .faq-question {
      cursor: pointer;
    }
    
    
    .rotate {
      transform: rotate(45deg);
    }
    .marquee-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .marquee-content {
        display: inline-block;
        white-space: nowrap;
        animation: marquee 10s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    .contact-button {
        display: flex;
        justify-content: flex-start;
        margin-top: 20px;
        padding-left:10px;
    }

    .faq {
        padding: 20px;
    }

    .faq h2 {
        font-size: 35px;
        margin-bottom: 10px;
        text-align:center;
    }

    .faq ul {
        list-style-type: none;
        padding: 0;
    }

    .faq ul li {
        font-size: 22px;
        margin-bottom: 20px;
    }
    .button {
        display: inline-block;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        color: white;
        background: linear-gradient(0deg, #d9d9d900, #d9d9d900), linear-gradient(0deg, #54C9EE, #54C9EE);
        background-origin: border-box;
        background-clip: content-box, border-box;
        border-radius: 25px;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    /*.button:hover {*/
        /*background: linear-gradient(0deg, #D9D9D9, #D9D9D9), linear-gradient(0deg, #54C9EE, #54C9EE);*/
    /*    background-origin: border-box;*/
    /*    background-clip: content-box, border-box;*/
    /*}*/

    .additional-text {
        text-align: left;
        padding: 20px;
    }

    .additional-text p {
        font-size: 22px;
        margin-bottom: 10px;
    }
    .services {
        text-align: left;
        padding: 20px;
    }

    .services ul {
        list-style-type: none;
        padding: 0;
    }

    .services ul li {
        font-size: 22px;
        margin-bottom: 10px;
    }

    .services ul li::before {
        content: "-";
        margin-right: 10px;
    }
    .content .banner {
        position: relative;
        background-image: url("images/banner2.png"); /* Replace with the correct path to your image */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        min-height: 500px;
        display: flex;
        justify-content: center;
        align-items: end;
        text-align: center;
        color: white;
        padding-bottom:10px;
    }

    .banner-text {
        font-size: 60px; /* Adjust the font size as needed */
        font-weight: bold; /* Adjust the font weight as needed */
        /* width:600px; */
        z-index: 1;
    }

    .nav-links li a {
        font-weight: 500; 
        font-size: 15px; 
        line-height: 11.9px; 
        color: white;
        text-decoration: none; 
    }
    body {
        font-family: Arial, sans-serif;
    }
    .logo img {
        width: 230px; /* Adjust the width as needed */
        height: auto; /* Maintain aspect ratio */
        display: block; /* Remove extra space below image */
    }
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #294C69;
        color: white;
        min-height:50px;
    }

    .logo {
    font-size: 24px;
    }

    .nav-links {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    }

    .nav-links li {
    margin-left: 20px;
    }

    .nav-links li:first-child {
    margin-left: 0;
    }

    .nav-links li a {
    color: white;
    text-decoration: none;
    }

    .burger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    }

    .burger div {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 3px 0;
    }
    .burger .line {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 3px 0;
    transition: transform 0.3s ease;
    }

    .burger.active .line:nth-child(1) {
    transform: rotate(-45deg) translate(-5px, 6px);
    }

    .burger.active .line:nth-child(2) {
    opacity: 0;
    }

    .burger.active .line:nth-child(3) {
    transform: rotate(45deg) translate(-5px, -6px);
    }
    /* Add hover effect for nav links */
    .nav-links li a:hover {
        color: #ffd700; /* Change to your desired hover color */
        transition: color 0.3s ease; /* Add a transition for smooth color change */
    }

    /* Add hover effect for burger menu lines */
    .burger .line:hover {
        background-color: #ffd700; /* Change to your desired hover color */
    }
    @media screen and (max-width: 928px) {
        
    .nav-links {
        display: none;
        flex-direction: column;
    }

    .nav-links li {
        margin: 10px 0;
    }

    .burger {
        display: flex;
    }
    }

    </style>
