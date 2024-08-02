$(function(){
    // to get current year
    function getYear() {
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        document.querySelector("#displayYear").innerHTML = currentYear;
    }

    getYear();

    /** google_map js **/
    function myMap() {
        var mapProp = {
            center: new google.maps.LatLng(40.712775, -74.005973),
            zoom: 18,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }


    // Get the button
    let scrollTopBtn = document.getElementById("scrollTopBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };
    
  });


function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollTopBtn.style.display = "block";
    } else {
        scrollTopBtn.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function scrollToTop() {
    window.scrollTo({top: 0, behavior: 'smooth'});
    //document.body.scrollTop = 0; // For Safari
    //document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function ContactAgreement(checkbox) {
    var button = document.getElementById("contact-confirm");
      
    if (checkbox.checked) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}

  // Function to update the submit button state
  function updateSubmitButtonState() {
    const checkbox = document.getElementById('agree');
    const submitButton = document.getElementById('contact-confirm');
    submitButton.disabled = checkbox.checked;
}



//document.addEventListener('DOMContentLoaded', updateSubmitButtonState);
document.addEventListener('pageshow', updateSubmitButtonState);