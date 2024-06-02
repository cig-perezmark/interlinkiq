<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
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


        <!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
        <script>
            var userLang = navigator.language || navigator.userLanguage; 
            //alert ("The language is: " + userLang);
            $("#userLang").text("Lang: " +userLang);
            var defaultLang = "en";


            function setCookie(key, value, expiry) {
                var expires = new Date();
                expires.setTime(expires.getTime() + (15 * 60 * 1000)); 
                document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
            }

            // WITH IP: https://ipinfo.io/160.16.118.127
            $.get("https://ipinfo.io", function (response) {
                $("#ip").html("IP: " + response.ip);
                $("#address").html("Location: " + response.city + ", " + response.region);
                $("#country").html("Country: " + response.country);
                // hc(response.country);
                $("#details").html(JSON.stringify(response, null, 4));
                co = response.country;
                co = co.toLowerCase();
                // if (userLang !== "en") {
                    setCookie('googtrans', '/en/'+co, 1); //set your language here
                // }
            }, "jsonp");

            function googleTranslateElementInit() {            
                new google.translate.TranslateElement({
                // includedLanguages: 'en,es', //list your included languages here with the default first
                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                }, 'google_translate_element');
            }


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