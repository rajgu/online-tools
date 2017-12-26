
function Api_Send (data) {

    console.log ("Api_Send: ");
    console.log (data);

    if (typeof data['lock'] !== 'undefined' &&
        data['lock'] === true) {   

        var opts = {
          lines: 12, // The number of lines to draw
          length: 38, // The length of each line
          width: 17, // The line thickness
          radius: 45, // The radius of the inner circle
          scale: 0.95, // Scales overall size of the spinner
          corners: 1, // Corner roundness (0..1)
          color: '#ffffff', // CSS color or array of colors
          fadeColor: 'transparent', // CSS color or array of colors
          opacity: 0.25, // Opacity of the lines
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          speed: 1, // Rounds per second
          trail: 74, // Afterglow percentage
          fps: 20, // Frames per second when using setTimeout() as a fallback in IE 9
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          className: 'spin', // The CSS class to assign to the spinner
          top: '50%', // Top position relative to parent
          left: '50%', // Left position relative to parent
          shadow: 'none', // Box-shadow for the lines
          position: 'absolute' // Element positioning
        };

        $('#spinnerContainer').css('display', 'block');

        var $target = $('#spinnerConainer2');
       // $target.show();
        var spinner = new Spinner(opts).spin($target);

    }

    var requestData = {
        "type":    data['type'],
        "command": data['command'],
        "params":  data['params']
    }

    console.log (requestData);

    $.ajax({
        type: "POST",
        url: "/api",
        data: JSON.stringify (requestData),
        success: function () { console.log(123)}
    });
}


