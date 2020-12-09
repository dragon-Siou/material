<html>
    <head>
        <script src="web/jquery-3.5.0.min.js"></script>
        <script>
            // $(function(){
            //     $("#text").keypress(test)
            // });

            // function test(){
            //     if(event.keyCode == 13){
            //         //alert($("#text").prop("value"));
            //         let content=$("#text").prop("value");

            //         $("#text").before(
            //             $("<div/>")
            //             .append(content)
            //         );
            //         $("#text").prop("value","");
            //     }
            // }
            $(function(){
                alert(
                    $("#test").find("span")[1].textContent
                );
            })
            
            

        </script>
    </head>
    <body>
        <ul id="test">
            <li>
                <span>123</span>
            </li>
            <li>
                <span>52</span>
            </li>
        </ul>
    </body>
</html>