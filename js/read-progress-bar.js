    function readTimeScroll() {

         /*  ----------- USER CONFIG ----------  */

         /*
        if (typeof myVariable !== 'undefined') {
            console.log('myVariable is defined');
        } else {
            console.log('myVariable is not defined');
        }
         */



        //
        var readProgressHexColor = '#' + readProgressScriptData.readProgressColor;
        var readProgressHeight = readProgressScriptData.readProgressHeight + 'px';

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
    
    