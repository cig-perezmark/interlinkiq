  <!--==================== FOOTER ====================-->
        <footer class="footer section" style=" background-color: var(--first-color-second);">
            <div class="footer__container  grid">
                <div class="footer__content grid">
                    <div class="footer__data">
                        <h3 class="footer__title">INTERLINK<div class="underline">
                            <!--<span></span>-->
                            </div>
                            </h3>
                        <p class="footer__description"> Where process meets
                            regulatory and industry standards connectivity.
                        </p>
                        <div>
                            <a href="//www.facebook.com/" target="_blank" class="footer__social">
                                <i class="ri-facebook-box-fill"></i>
                            </a>
                            <a href="//twitter.com/" target="_blank" class="footer__social">
                                <i class="ri-twitter-fill"></i>
                            </a>
                            <a href="//www.linkedin.com/login" target="_blank" class="footer__social">
                                <i class="ri-linkedin-box-fill"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCLbjTwJUmtaa25OPqRjIwfA" target="_blank" class="footer__social">
                                <i class="ri-youtube-fill"></i>
                            </a>
                        </div>
                    </div>
    
                    <div class="footer__data">
                        <h3 class="footer__subtitle">Office<div class="underline">
                            <!--<span></span>-->
                        </div></h3>
                        <ul>
                            <li class="footer__item">
                                <a href="" class="footer__link">202-982-3002</a>
                            </li>
                            <li class="footer__item">
                                <a href="" class="footer__link"> services@interlinkiq.com</a>
                            </li>
                            <li class="footer__item">
                                <a href="" class="footer__link"> 5221 Franconia Road 10456 ,Alexandria, VA 2231</a>
                            </li>
                        </ul>
                    </div>
    
                    <div class="footer__data hide">
                        <h3 class="footer__subtitle">Links<div class="underline">
                            <!--<span></span>-->
                            </div></h3>
                        <ul>
                            <li class="footer__item">
                                <a href="" target="_blank" class="footer__link"></a>
                            </li>
                            <li class="footer__item">
                                <a href="" target="_blank" class="footer__link"></a>
                            </li>
                            <li class="footer__item">
                                <a href="login" target="_blank" class="footer__link"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer__data">
                        <h3 class="footer__subtitle">Newsletter<div class="underline">
                            <!--<span></span>-->
                        </div></h3>
                        <p class="footer__description"> Subscribe to our newsletter and get an updates.
                        </p>
                        <!-- <ul>
                            <li class="footer__item">
                                <a href="" class="footer__link">About Us</a>
                            </li>
                            <li class="footer__item">
                                <a href="" class="footer__link">Features</a>
                            </li>
                            <li class="footer__item">
                                <a href="" class="footer__link">App Store</a>
                            </li>
                        </ul> -->
                        <form>
                            <i class="fa fa-envelope"></i>
                            <input type="email" placeholder="Enter Your email " required>
                        <button type="submit">  <i class="ri-mail-send-fill"></i></button>
                        </form>
                    </div>
                </div>

                <div class="footer__rights">
                    <p class="footer__copy">&#169; 2022 INTERLINKIQ. V1. All rigths reserved.</p>
                    <div class="footer__terms">
                        <a href="terms_of_services/pdfviewer.php" target="_blank" class="footer__terms-link">Terms & Service</a>
                        <a href="#" class="footer__terms-link">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </footer>

         <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line scrollup__icon"></i>
        </a>

        <!--=============== SCROLL REVEAL===============-->
        


   
    </body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
         <!-- thirdparty -->
<script src='//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/EasePack.min.js'></script>
<script src='//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/rAF.js'></script>
<script src='//www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/TweenLite.min.js'></script>

<script>
  

// for background animated
(function() {

var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

// Main
initHeader();
initAnimation();
addListeners();

function initHeader() {
    width = window.innerWidth;
    height = window.innerHeight;
    target = {x: width/2, y: height/2};

    largeHeader = document.getElementById('home');
    largeHeader.style.height = height+'px';

    canvas = document.getElementById('demo-canvas');
    canvas.width = width;
    canvas.height = height;
    ctx = canvas.getContext('2d');

    // create points
    points = [];
    for(var x = 0; x < width; x = x + width/20) {
        for(var y = 0; y < height; y = y + height/20) {
            var px = x + Math.random()*width/20;
            var py = y + Math.random()*height/20;
            var p = {x: px, originX: px, y: py, originY: py };
            points.push(p);
        }
    }

    // for each point find the 5 closest points
    for(var i = 0; i < points.length; i++) {
        var closest = [];
        var p1 = points[i];
        for(var j = 0; j < points.length; j++) {
            var p2 = points[j]
            if(!(p1 == p2)) {
                var placed = false;
                for(var k = 0; k < 5; k++) {
                    if(!placed) {
                        if(closest[k] == undefined) {
                            closest[k] = p2;
                            placed = true;
                        }
                    }
                }

                for(var k = 0; k < 5; k++) {
                    if(!placed) {
                        if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                            closest[k] = p2;
                            placed = true;
                        }
                    }
                }
            }
        }
        p1.closest = closest;
    }

    // assign a circle to each point
    for(var i in points) {
        var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
        points[i].circle = c;
    }
}

// Event handling
function addListeners() {
    if(!('ontouchstart' in window)) {
        window.addEventListener('mousemove', mouseMove);
    }
    window.addEventListener('scroll', scrollCheck);
    window.addEventListener('resize', resize);
}

function mouseMove(e) {
    var posx = posy = 0;
    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;
    }
    else if (e.clientX || e.clientY)    {
        posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
        posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
    }
    target.x = posx;
    target.y = posy;
}

function scrollCheck() {
    if(document.body.scrollTop > height) animateHeader = false;
    else animateHeader = true;
}

function resize() {
    width = window.innerWidth;
    height = window.innerHeight;
    largeHeader.style.height = height+'px';
    canvas.width = width;
    canvas.height = height;
}

// animation
function initAnimation() {
    animate();
    for(var i in points) {
        shiftPoint(points[i]);
    }
}

function animate() {
    if(animateHeader) {
        ctx.clearRect(0,0,width,height);
        for(var i in points) {
            // detect points in range
            if(Math.abs(getDistance(target, points[i])) < 4000) {
                points[i].active = 0.3;
                points[i].circle.active = 0.6;
            } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                points[i].active = 0.1;
                points[i].circle.active = 0.3;
            } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                points[i].active = 0.02;
                points[i].circle.active = 0.1;
            } else {
                points[i].active = 0;
                points[i].circle.active = 0;
            }

            drawLines(points[i]);
            points[i].circle.draw();
        }
    }
    requestAnimationFrame(animate);
}

function shiftPoint(p) {
    TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
        y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
        onComplete: function() {
            shiftPoint(p);
        }});
}

// Canvas manipulation
function drawLines(p) {
    if(!p.active) return;
    for(var i in p.closest) {
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
        ctx.lineTo(p.closest[i].x, p.closest[i].y);
        ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
        ctx.stroke();
    }
}

function Circle(pos,rad,color) {
    var _this = this;

    // constructor
    (function() {
        _this.pos = pos || null;
        _this.radius = rad || null;
        _this.color = color || null;
    })();

    this.draw = function() {
        if(!_this.active) return;
        ctx.beginPath();
        ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
        ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
        ctx.fill();
    };
}

// Util
function getDistance(p1, p2) {
    return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
}

})();



// for marquee
const root = document.documentElement;
const marqueeElementsDisplayed = getComputedStyle(root).getPropertyValue("--marquee-elements-displayed");
const marqueeContent = document.querySelector("ul.marquee-content");

root.style.setProperty("--marquee-elements", marqueeContent.children.length);

for(let i=0; i<marqueeElementsDisplayed; i++) {
  marqueeContent.appendChild(marqueeContent.children[i].cloneNode(true));
}

// for cookies
let cookieModal = document.querySelector(".cookie-consent-modal")
let cancelCookieBtn = document.querySelector(".btn.cancel")
let acceptCookieBtn = document.querySelector(".btn.accept")

cancelCookieBtn.addEventListener("click", function (){
    cookieModal.classList.remove("active")
})
acceptCookieBtn.addEventListener("click", function (){
    cookieModal.classList.remove("active")
    localStorage.setItem("cookieAccepted", "yes")
})

setTimeout(function (){
    let cookieAccepted = localStorage.getItem("cookieAccepted")
    if (cookieAccepted != "yes"){
        cookieModal.classList.add("active")
    }
}, 2000) 

    </script>
    
    <style>
        .hide{
            display:none;
        }
    </style>
</html>