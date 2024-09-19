    function readTimeScroll() {
         console.log('Background Color Value:', readProgressScriptData.readProgressColor);
  //console.log("fired");
        /*
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
https://youmightnotneedjquery.com/#ready
        */
        // Create the new div elements
        let barElement = document.createElement('div');
        barElement.className = 'read-time-progress-bar';
        barElement.id = '_progress';
        //let bodyElem = document.querySelector("body");
        //console.log(bodyElem);
        
        document.addEventListener("DOMContentLoaded", function(event) { 
            
            // Add element to the HTML body
            document.body.prepend(barElement);

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
    
    