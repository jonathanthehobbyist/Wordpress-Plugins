    function readTimeScroll() {

         /*  ----------- USER CONFIG ----------  */

        // Tests to see if HEX input is blank
        function isValidAlphanumeric(input) {
            // Check if input is a string and has at least 3 alphanumeric characters
            const regexHex = /^[a-zA-Z0-9]{3,}$/;
            return regexHex.test(input);
        }

        // Tests to see if HEIGHT input is blank
        function isValidNumericOne(input) {
            // Check if input is a string and has at least 3 alphanumeric characters
            const regexHeight = /^[0-9]{1,}$/;
            return regexHeight.test(input);
        }

        // Test if color has been defined
        if (typeof readProgressScriptData.readProgressColor !== 'undefined' && isValidAlphanumeric(readProgressScriptData.readProgressColor)) {
            // Variable that's easier to read
            var readProgressHexColor = '#' + readProgressScriptData.readProgressColor;
        } else {
            // Set a default
            var readProgressHexColor = '#888888';
        }

        // Test if height has been defined
        if (typeof readProgressScriptData.readProgressHeight !== 'undefined' && isValidNumericOne(readProgressScriptData.readProgressHeight)) {
            // Variable that's easier to read
            var readProgressHeight = readProgressScriptData.readProgressHeight + 'px';
        } else {
            // Set a default
            var readProgressHeight = '4px';
        }

        // Create the new div elements
        let barElement = document.createElement('div');
        barElement.className = 'read-time-progress-bar';
        barElement.id = '_progress';
        //let bodyElem = document.querySelector("body");
        //console.log(bodyElem);
        
        document.addEventListener("DOMContentLoaded", function(event) { 
            
            // Add element to the HTML body
            document.body.prepend(barElement);

            // Set --progress-color variable in css
            barElement.style.setProperty('--progress-color', readProgressHexColor);
            //console.log('readProgressHexColor', readProgressHexColor);

            // Set height 
            barElement.style.height = readProgressHeight;

        });
    } //end function
    
document.addEventListener(
  "scroll",
  function() {
    var scrollTop =
      document.documentElement["scrollTop"] || document.body["scrollTop"];
    var scrollBottom =
      (document.documentElement["scrollHeight"] ||
        document.body["scrollHeight"]) - document.documentElement.clientHeight;
    scrollPercent = scrollTop / scrollBottom * 100 + "%";
    document
      .getElementById("_progress")
      .style.setProperty("--scroll", scrollPercent);
  },
  { passive: true }
);
    
readTimeScroll();
    
    