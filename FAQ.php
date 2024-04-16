<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="faq/faq_style.css">
    <script type="text/javascript" src="faq/faq_js.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="https://interlinkiq.com/assets/img/interlink%20icon.png" type="image/png">
    
</head>
<body>

<div class="master-box">
  
  <div class="faq-header">
      
    <img width="400" height="180" src="LandingPageFiles/img/iqlogo_small.png">
    <h1 class="subtitle">Frequently Asked Questions</h1>
    <div class="filter-search">
      <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search">
      <div id="myBtnContainer">
        <button class="btn active" onclick="filterSelection('all')"> Show all</button>
        <button class="btn" onclick="filterSelection('account')">Account</button>
        <button class="btn" onclick="filterSelection('orders')">Orders</button>
        <button class="btn" onclick="filterSelection('bugs')">Bugs</button>
        <button class="btn" onclick="filterSelection('promotions')">Promotions</button>
      </div>
    </div>  
  </div>
  
  <ul id="myUL">
    <li class="filterDiv account">
      <span class="accordion-thumb">How can I reset my password?</span>
      <p class="accordion-panel">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    </li>
    <li class="filterDiv orders">
      <span class="accordion-thumb">Where can I find the <a href='#link'>tracking number</a> of my order?</span>
      <p class="accordion-panel">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <a href='#link'>LINK</a> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </li>
    <li class="filterDiv orders">
      <span class="accordion-thumb">Can I return a product?</span>
      <p class="accordion-panel">Lorem ipsum dolor sit amet, ut labore et dolore magna aliqua. Ut enim ad minim veniam, consectetur adipisicing elit.</p>
    </li>
    <li class="filterDiv bugs">
      <span class="accordion-thumb">Can you fix my bugs?</span>
      <p class="accordion-panel">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </li>
    <li class="filterDiv orders">
      <span class="accordion-thumb">I haven't received my order</span>
      <p class="accordion-panel">Dictumst quisque sagittis purus sit amet volutpat consequat. Quis varius quam quisque id. Urna duis convallis convallis tellus id interdum. Ultrices tincidunt arcu non sodales. Justo laoreet sit amet cursus sit. Vulputate ut pharetra sit amet aliquam id diam maecenas.</p>
    </li>
    <li class="filterDiv promotions">
      <span class="accordion-thumb">Do you have any promotions available?</span>
      <p class="accordion-panel">Tellus at urna condimentum mattis pellentesque id. Mollis nunc sed id semper risus in hendrerit gravida.</p>
    </li>
    <li class="filterDiv orders">
      <span class="accordion-thumb">Can I change the delivery address for my completed order?</span>
      <p class="accordion-panel">gestas maecenas pharetra convallis posuere morbi leo urna molestie. Semper eget duis at tellus at urna condimentum mattis. Phasellus faucibus scelerisque eleifend donec. Sagittis nisl rhoncus mattis rhoncus urna neque. Velit egestas dui id ornare arcu. Ac feugiat sed lectus vestibulum mattis. Euismod quis viverra nibh cras pulvinar mattis nunc sed. Purus semper eget duis at. Blandit massa enim nec dui nunc mattis enim. Potenti nullam ac tortor vitae purus faucibus ornare.</p>
    </li>
    <li class="filterDiv orders">
      <span class="accordion-thumb">How much will the shipping be for my product?</span>
      <p class="accordion-panel">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    </li>
    <li class="filterDiv bugs">
      <span class="accordion-thumb">My mouse doesn't work properly</span>
      <p class="accordion-panel">Dictum sit amet justo donec enim diam. Mus mauris vitae ultricies leo integer malesuada nunc. At lectus urna duis convallis convallis tellus id interdum velit. At volutpat diam ut venenatis tellus in metus.</p>
    </li>
    <li class="filterDiv account orders">
      <span class="accordion-thumb">Can I make an order without creating an account?</span>
      <p class="accordion-panel">Pharetra et ultrices neque ornare aenean euismod elementum nisi quis. Urna duis convallis convallis tellus id interdum velit. Elit pellentesque habitant morbi tristique senectus et. Habitant morbi tristique senectus et netus et malesuada fames. Sed viverra tellus in hac habitasse platea dictumst vestibulum. Pretium aenean pharetra magna ac placerat. Odio ut sem nulla pharetra diam sit amet. Rhoncus mattis rhoncus urna neque viverra justo nec ultrices dui. At erat pellentesque adipiscing commodo elit at. Sed viverra tellus in hac habitasse platea. Eu ultrices vitae auctor eu augue ut lectus. Sagittis purus sit amet volutpat consequat mauris nunc congue nisi. Volutpat diam ut venenatis tellus.</p>
    </li>
    <li class="filterDiv promotions">
      <span class="accordion-thumb">If I buy 2 products or more, do I get a discount?</span>
      <p class="accordion-panel">Sed adipiscing diam donec adipiscing. Mattis vulputate enim nulla aliquet porttitor lacus. Id venenatis a condimentum vitae sapien pellentesque habitant.</p>
    </li>
    <li class="filterDiv account">
      <span class="accordion-thumb">Can I have two accounts?</span>
      <p class="accordion-panel">Et malesuada fames ac turpis egestas sed tempus urna.</p>
    </li>
    <li class="filterDiv account">
      <span class="accordion-thumb">How can I create an account?</span>
      <p class="accordion-panel">Vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam. Etiam sit amet nisl purus. Volutpat maecenas volutpat blandit aliquam etiam.</p>
    </li>
    <li class="filterDiv promotions">
      <span class="accordion-thumb">Do I have a discount if I have a lot of friends?</span>
      <p class="accordion-panel">In aliquam sem fringilla ut morbi tincidunt augue interdum velit. Et malesuada fames ac turpis. Pretium quam vulputate dignissim suspendisse in est ante in nibh. Venenatis a condimentum vitae sapien. Facilisis gravida neque convallis a. Ac tortor vitae purus faucibus ornare suspendisse sed</p>
    </li>
    <li class="filterDiv bugs">
      <span class="accordion-thumb">Website is bugged</span>
      <p class="accordion-panel">Aliquet nec ullamcorper sit amet risus nullam. Purus ut faucibus pulvinar elementum integer enim neque volutpat. Dignissim cras tincidunt lobortis feugiat vivamus at augue eget arcu. Diam donec adipiscing tristique risus nec feugiat. Pharetra sit amet aliquam id diam maecenas ultricies mi eget. Dolor magna eget est lorem ipsum dolor sit amet consectetur.</p>
    </li>
    <li class="filterDiv account promotion bugs">
      <span class="accordion-thumb">Can you tell me what am I looking for?</span>
      <p class="accordion-panel">Purus non enim praesent elementum facilisis. Platea dictumst quisque sagittis purus sit. Nec dui nunc mattis enim. Vitae congue eu consequat ac felis donec et odio pellentesque. Pulvinar elementum integer enim neque volutpat. Vel facilisis volutpat est velit egestas dui. Eget arcu dictum varius duis at consectetur lorem. Diam sollicitudin tempor id eu nisl nunc mi ipsum. Vitae auctor eu augue ut. Sed libero enim sed faucibus turpis in. Mauris sit amet massa vitae.</p>
    </li>
  </ul>
  

</div>

    
</body>
</html>

<script>
    function searchFunction() {
    var input, filter, ul, li, s, p, i, txtValue;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');
  
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      p = li[i].getElementsByTagName("p")[0];
      s = li[i].getElementsByTagName("span")[0];
      txtValue = (s.textContent || s.innerText) + " " + (p.textContent || p.innerText) ;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
  
  filterSelection("all")
  function filterSelection(c) {
    var x, i;
    x = document.getElementsByClassName("filterDiv");
    if (c == "all") c = "";
    // Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
    for (i = 0; i < x.length; i++) {
      faqRemoveClass(x[i], "show");
      if (x[i].className.indexOf(c) > -1) faqAddClass(x[i], "show");
    }
  }
  
  // Show filtered elements
  function faqAddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      if (arr1.indexOf(arr2[i]) == -1) {
        element.className += " " + arr2[i];
      }
    }
  }
  
  // Hide elements that are not selected
  function faqRemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      while (arr1.indexOf(arr2[i]) > -1) {
        arr1.splice(arr1.indexOf(arr2[i]), 1); 
      }
    }
    element.className = arr1.join(" ");
  }
  
  // Add active class to the current control button (highlight it)
  var btnContainer = document.getElementById("myBtnContainer");
  var btns = btnContainer.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }
  
  
  // Accordion Function
  $(function() {
      // (Optional) Active an item if it has the class "is-active"	
      $("#myUL > .filterDiv.is-active").children(".accordion-panel").slideDown();
      
      $("#myUL > .filterDiv > span").click(function() {
      //event.preventDefault();
          // Cancel the siblings
          $(this).closest('li').siblings(".filterDiv").removeClass("is-active").children(".accordion-panel").slideUp();
          // Toggle the item
          $(this).closest('li').toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
      });
  });
</script>