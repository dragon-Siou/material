<html>
    <head>
    <script src="web/jquery.js"></script>
    <script>  
 /*
        $("#formInput").submit(
            function upload() {
                

                let form = $("#formInput").get(0);
                let myurl = form.getAttribute("action");

                let formData=new FormData(form);

                
                //alert(formData.get("str"));
                //alert(url);
               
                if(formData.get("str").length>5){
                    //alert(formData.get("str"));
                    
                    $.ajax({
                        //type: "POST",
                        //url:"test.php",
                        data: formData, // serializes the form's elements.
                        type: 'POST',
                        url: 'test.php',
                        //data: {name: 'John', location: 'Boston'},

                        processData: false,
                        contentType: false,
                        success: function(data) {
                            alert('Data Saved: ' + data);
                            window.location.href="test.php";
                        }
                    });
                    
                }
                
                

                //e.preventDefault(); // avoid to execute the actual submit of the form.
            }
        );*/
        $(function(){
            $('#b1').click(
                function(){
                    //alert('成功');
                    
                    let form = $("#formInput").get(0);
                    //let myurl = form.getAttribute("action");

                    let formData=new FormData(form);

                    

                    
                    //if(formData.get("str").length>5){
                        //$("#formInput").submit();
                        //alert("成功");
                        $.ajax({
                            url:'test.php',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            //dataType:'json',
                            type:'post',
                            success:function(data){
                                alert(data);
                            }
                        });
                    //}
                }
            );
        });
        
    </script>  



        
    </head>
    <body>
        <form id="formInput" action="test.php" method="POST">  
            Enter No:<input type="text" id="str" name="str"/><br/>
            <input id="test" name="file1" type="file"><br/>
            <button id="b1" name="b1" type="button"  >送出</button>  
        </form>       
        
    </body>
</html>