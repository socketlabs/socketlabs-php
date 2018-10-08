var getExample = function(fileNameOfExample) {
    $('#output').removeClass( "hidden" );
    $("#responseJson>textarea").empty();
    $("#requestJson>textarea").empty();

    displayExampleCode(fileNameOfExample);
    displayData(fileNameOfExample);
}

var displayData = function(fileNameOfExample) {
    $.ajax({
        url: '../Examples/Index/PHP/RunExampleCode.php',
        type: 'POST',
        datatype: "json",
        data: {
            fileNameOfExample : fileNameOfExample
        },
        success: function(data) {

            // // tab1 - Example Code
            // var exCode = data[0];
            // // remove all carriage returns so the <pre> tags work properly
            // exCode = exCode.replace(/[\n\r]/g, ''); 
            // document.getElementById("codeExample").innerHTML = '<pre>' + exCode + '</pre>';

            // // tab2 - Response JSON
            // var respJson = data[3];
            // document.getElementById("responseJson").innerHTML = '<pre>' + respJson + '</pre>';
            var response = data.response
            var respJson = JSON.stringify(response, null, 2);
            $("#responseJson>textarea").html(respJson);
            // document.getElementById("responseJson").innerHTML = '<pre>' + respJson + '</pre>';

            // // tab3 - Request JSON
            var request = data.request
            var reqJson = JSON.stringify(request, null, 2);
            $("#requestJson>textarea").html(reqJson);
            // document.getElementById("requestJson").innerHTML = '<pre>' + reqJson + '</pre>';

            // //tab4 - Message Values
            // var varValues = data[1];
            // // get rid of the path/file name in the output since we don't need to display it
            // variableValues = variableValues.replace(/<small>[\s\S]*?<\/small>/, '<small>' + '' + '<\/small>');
            // document.getElementById("variableValues").innerHTML = varValues; // <pre> tags are already added by php

        },
        error: function (jqXHR, exception) {
            alert("error: " + jqXHR.status);
            alert("error: " + jqXHR.responseText);
            alert("error: " + exception);
        }
    });
};

var displayExampleCode = function(fileNameOfExample) {
    $.ajax({
        url: '../Examples/Index/PHP/DisplayExampleCode.php',
        type: 'POST',
        contentype: "text/html; charset=UTF-8",
        datatype: "html",
        data: {
            fileNameOfExample : fileNameOfExample
        },
        success: function(data) {
            data = data.replace(/[\n\r]/g, ''); // remove all carriage returns so the <pre> tags work properly
            document.getElementById("codeExample").innerHTML = '<pre>' + data + '</pre>';
        },
        error: function (jqXHR, exception) {
            alert("error: " + jqXHR.status);
            alert("error: " + jqXHR.responseText);
            alert("error: " + exception);
        }
    });
};

var displayVariableValues = function(fileNameOfExample) {
    $.ajax({
        url: '../Examples/Index/PHP/DisplayVariableValues.php',
        type: 'POST',
        contentype: "text/html; charset=UTF-8",
        datatype: "html",
        data: {
            fileNameOfExample : fileNameOfExample
        },
        success: function(data) {
            // get rid of the path/file name in the output since we don't need to display it
            data = data.replace(/<small>[\s\S]*?<\/small>/, '<small>' + '' + '<\/small>');

            document.getElementById("variableValues").innerHTML = data; // <pre> tags are already added by php
        },
        error: function (jqXHR, exception) {
            alert("error: " + jqXHR.status);
            alert("error: " + jqXHR.responseText);
            alert("error: " + exception);
        }
    });
};
