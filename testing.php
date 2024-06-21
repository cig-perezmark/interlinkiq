<!DOCTYPE html>
<html>
    <head>
        <!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
        <!--<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>-->
    </head>
    <body>
        <center>
            <div id="google_translate_element"></div><br/>
            Country:&nbsp;<span id="country"></span>
            <h1>Hello my friends this is a cool code.</h1>

            <div id="userLang"></div>
            <div id="ip"></div>
            <div id="address"></div>
            <div id="country"></div>
            <hr/>Full response: <pre id="details"></pre>
        </center>
        <?php
        
            $email = 'maplelawndiary@stny.rr.com';
            $email = 'greeggimongalasdsd@gmail.com';
            /* Read the "email" request variable. */
            if (isset($_REQUEST['email'])) {
               
               $email = $_REQUEST['email'];
            }
            /* Validate the address. */
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               
               echo $email . ' is NOT a valid email address.';
               die();
            }
            /* Check the domain. */
            $atPos = mb_strpos($email, '@');
            $domain = mb_substr($email, $atPos + 1);
            // A, MX, NS, SOA, PTR, CNAME, AAAA, A6, SRV, NAPTR, TXT or ANY.
            echo checkdnsrr($domain . '.', 'A') . '<br>';
            echo checkdnsrr($domain . '.', 'MX') . '<br>';
            echo checkdnsrr($domain . '.', 'NS') . '<br>';
            echo checkdnsrr($domain . '.', 'SOA') . '<br>';
            echo checkdnsrr($domain . '.', 'PTR') . '<br>';
            echo checkdnsrr($domain . '.', 'CNAME') . '<br>';
            echo checkdnsrr($domain . '.', 'AAAA') . '<br>';
            echo checkdnsrr($domain . '.', 'A6') . '<br>';
            echo checkdnsrr($domain . '.', 'SRV') . '<br>';
            echo checkdnsrr($domain . '.', 'NAPTR') . '<br>';
            echo checkdnsrr($domain . '.', 'TXT') . '<br>';
            if (!checkdnsrr($domain . '.', 'MX')) {
            // if (!checkdnsrr(idn_to_ascii($domain . '.'), 'MX')) {
                // var_dump(checkdnsrr(idn_to_ascii('ñandu.cl'), 'A')); // return true
               
               echo 'Domain "' . $domain . '" is not valid';
               die();
            }
            /* The address is valid. */
            echo $email . ' is a valid email address.';
        ?>

        <!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
        <script>
            // var userLang = navigator.language || navigator.userLanguage; 
            // //alert ("The language is: " + userLang);
            // $("#userLang").text("Lang: " +userLang);
            // var defaultLang = "en";


            // function setCookie(key, value, expiry) {
            //     var expires = new Date();
            //     expires.setTime(expires.getTime() + (15 * 60 * 1000)); 
            //     document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
            // }

            // // WITH IP: https://ipinfo.io/160.16.118.127
            // $.get("https://ipinfo.io", function (response) {
            //     $("#ip").html("IP: " + response.ip);
            //     $("#address").html("Location: " + response.city + ", " + response.region);
            //     $("#country").html("Country: " + response.country);
            //     // hc(response.country);
            //     $("#details").html(JSON.stringify(response, null, 4));
            //     co = response.country;
            //     co = co.toLowerCase();
            //     // if (userLang !== "en") {
            //         setCookie('googtrans', '/en/'+co, 1); //set your language here
            //     // }
            // }, "jsonp");

            // function googleTranslateElementInit() {            
            //     new google.translate.TranslateElement({
            //     // includedLanguages: 'en,es', //list your included languages here with the default first
            //     layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
            //     }, 'google_translate_element');
            // }


        // $.ajax({
        //     type: "GET",
        //     url: "https://geolocation-db.com/jsonp/",
        //     jsonpCallback: "callback",
        //     dataType: "jsonp",
        //     success: function( location ) {
        //         $('#country').html(location.country_code);
        //         co = location.country_code;
        //         co = co.toLowerCase();
        //         // hc(co); // Replace here
        //     }
        // });
        </script>
    </body>
</html>