<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script></head>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<body>
    <center>
        <br/>
        <div id="google_translate_element"></div><br/>
        Country:&nbsp;<span id="country"></span>
        <h1>Hello my friends this is a cool code.</h1>
    </center>
    <script>
    function hc(dc){
        lang = Cookies.get('language');
        if(lang != dc){
            window.location.hash = 'googtrans(en|' + dc + ')';
            location.reload();
            Cookies.set('language', dc);
        }
    }
    $.ajax({
        type: "GET",
        url: "https://geolocation-db.com/jsonp/",
        jsonpCallback: "callback",
        dataType: "jsonp",
        success: function( location ) {
            $('#country').html(location.country_code);
            co = location.country_code;
            co = co.toLowerCase();
            hc(co); // Replace here
        }
    });
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    
    <script>
   $.get("https://api.myip.com/", function (data) {
      // There are 3 values only returned handle them as needed
      console.log(data.ip); // Visitors IP Address
      console.log(data.country); // Country Name in English
      console.log(data.cc); // Country Code
   }, "json");
</script>
</body>
</html>