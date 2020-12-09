//加上enter事件，自動送出
$(function() {

    //檢查是否登入
    let loginChecking = new LoginChecking();
    loginChecking.notLogin = function() {

    }

    if (loginChecking.isLogin()) {
        //alert("已登入");
        window.memberID = loginChecking.memberID;
        //已經登入，頭像改掉
        $("#userHeadPic")
            .prop("src", "../" + loginChecking.member.pLink);
    } else {
        $("#shopcartHerf")
            .prop("href", "")
            .on("click", function() {
                return false;
            });

        //為登入的話，跳請先登入
        $("#shopcartHerf").on("click", function() {
            swal("請先登入");
        });
    }


    //預先執行一次showData

    $("form").bind(
        "submit",
        function() {
            return false;
        }
    );

    $("#search").keyup(search);
    loadData();

    //按下按鈕事件
    $("#searchButton").on("click", function() {
        loadData();
    });

});

function search() {

    //有輸入東西
    //不是按下neter
    if (event.keyCode != 13) {
        return;
    }

    loadData();


}

function loadData() {

    let form = $("#searchForm").get(0);
    let formData = new FormData(form);
    let searchStr = formData.get("search");
    //alert(searchStr);
    // if(searchStr.length==0){
    //     //alert("輸入為空");
    //     return;
    // }
    //先清空
    $(".content").empty();
    //alert("輸入為空");

    //抓searchtype
    let urlParameter = new UrlParameter(location.href);

    if (urlParameter.hasKey("searchType")) {
        let data = urlParameter.data["searchType"];
        formData.append("searchType", data);
    } else {
        formData.append("searchType", "gallery");
    }

    //alert("測試");
    //
    //去跟後端要資料
    $.ajax({
        type: "post",
        url: "../Connector/IndexConnector.php",
        data: formData,
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            //alert(data.debug);
            showData(data);
        },
        error: function() {
            swal("連接錯誤");
        }
    });

    //$("#searchForm").submit();
}

/*
function showData(data){
    //決定如何處理
    for(let item of data){
        // <div class='box'>
        //         <img src='../{$data->link}'>
        //         </div>
        //alert(item.gID);
        $(".content").append(
            $("<div/>").append(
                $("<img/>").prop("src", "../"+item.link)
            )
            .addClass('box')
        );
    }
}

*/