$(function() {
    //alert("測試");
    //檢查是否登入
    let loginChecking = new LoginChecking();
    loginChecking.notLogin = function() {

    }

    if (loginChecking.isLogin()) {
        //alert("已登入");
        window.memberID = loginChecking.memberID;
    }

    $("form").on(
        "submit",
        function() {
            return false;
        }
    );

    //設定購買按鈕
    //這邊會重複綁到
    $("#buyButton").on("click", function() {
        buy();
    });

    //載資料
    loadData();



    //初始化使用者頁面資訊
    setUserData();

});

function setUserData() {
    let formData = new FormData();
    formData.append("pageMID", window.memberID);

    $.ajax({
        url: "../Connector/UserInfoConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        type: 'post',
        success: function(data) {
            //alert(data.userName);

            //設定大頭貼
            $(".personSmallHead")
                .prop("src", "../" + data.pLink);

        },
        error: function() {
            alert("使用者資訊連接失敗");
        }
    });
}

function loadData() {
    //清空
    $(".infoContaineInChecker").empty();
    //價格歸0
    window.productPrice = 0;
    window.productCount = 0;



    //要資料，因為東西都在session，所以不用傳
    $.ajax({
        type: "post",
        url: "../Connector/ShopCartDataConnector.php",
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            //alert(data.debug);
            showData(data);
            //顯示價格
            $("#productCount")
                .text(window.productCount);

            $("#productPrice")
                .text(window.productPrice);
        },
        error: function() {
            //alert("要資料連接錯誤");
        }
    });


}

function buy() {
    $.ajax({
        type: "post",
        url: "../Connector/BuyProductConnector.php",
        processData: false,
        cache: false,
        contentType: false,
        //dataType: "json",
        success: function(message) {
            loadData();
            swal(message);
        },
        error: function() {
            alert("購買連接錯誤");
        }
    });
}

function showData(data) {
    for (let item of data) {
        //alert(item.pID);
        //alert(item.showData.link);
        //價格++
        window.productPrice += item.showData.price;
        window.productCount++;

        let shopCartItem = new ShopCartItem(item);

        $(".infoContaineInChecker")
            .append(shopCartItem.getShopCartItem());

        shopCartItem.setEvent();
    }
}

class ShopCartItem {

    shopCartItem;

    picInfoInChecker;
    workInfoInChecker;
    typeInfoInChecker;
    goodInfoInChecker;
    priceInfoInChecker;
    trashInChecker;


    constructor(item) {
        this.initialize(item);

        //組裝
        this.shopCartItem = $("<div/>")
            .addClass("productInfoInContainer")
            .append(
                this.picInfoInChecker,
                this.workInfoInChecker,
                this.typeInfoInChecker,
                this.goodInfoInChecker,
                this.priceInfoInChecker,
                this.trashInChecker,

                $("<div/>")
                .addClass("clear")
            );
    }

    initialize(item) {
        this.picInfoInChecker = $("<div/>")
            .addClass("picInfoinChecker")
            .append(
                $("<img/>")
                .prop("src", "../" + item.showData.link)
            );

        this.workInfoInChecker = $("<div/>")
            .addClass("workInfoInChecker")
            .append(
                $("<div/>")
                .addClass("userInforInChecker")
                .append(
                    $("<img/>")
                    .addClass("bigHeadInWorkInfoChecker")
                    //頭貼
                    .prop("src", "../" + item.member.pLink),

                    $("<span/>")
                    .addClass("authorInWorkInfoChecker")
                    .append(
                        $("<a/>")
                        .addClass("buyRecordName")

                        .prop("href", "person_main.html?mID=" + item.member.mID)
                        .append(
                            item.member.userName
                        )
                    ),

                    $("<a/>")
                    .prop("href", "messages.html?chatID=" + item.member.mID)
                    .append(
                        $("<img/>")
                        .addClass("conactInWorkInfoChecker")
                        .prop("src", "images/userControllPage/conact.png"),
                    ),

                    $("<div/>")
                    .addClass("clear")
                ),

                $("<div/>")
                .addClass("nameInWorkInfoChecker")
                .append(item.showData.title)
            );

        this.typeInfoInChecker = $("<div/>")
            .addClass("typeInfoInChecker")
            .append(
                $("<div/>")
                .addClass("typetext")
                //我不知道這是衝三小的啦幹
                .append("照片")
            );

        this.goodInfoInChecker = $("<div>")
            .addClass("goodInfoInChecker")
            .append(
                $("<label/>")
                .addClass("custom_good_icon")
                .prop("for", "goodIcon1")
                .append(
                    $("<input>")
                    .addClass("goodInfo")
                    .prop("type", "goodInfo")
                    //這裡有個ID不知道衝三小的
                )
            );

        this.priceInfoInChecker = $("<div/>")
            .addClass("priceInfoInChecker")
            .append(
                $("<div/>")
                .append("$" + item.showData.price)
            )

        this.trashInChecker = $("<div/>")
            .addClass("trashInChecker")
            .append(
                $("<img>")
                .addClass("picIngood")
                .prop("src", "images/checkerPage/trash.png")
                .click(function() {

                    let formData = new FormData();
                    formData.append("pID", item.showData.pID);

                    swal({
                            title: "是否移除商品？",
                            //text: "Once deleted, you will not be able to recover this imaginary file!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,

                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    type: "post",
                                    url: "../Connector/RemoveShopCartDataConnector.php",
                                    processData: false,
                                    cache: false,
                                    contentType: false,
                                    data: formData,
                                    //dataType: "json",
                                    success: function(message) {

                                        //刷新
                                        loadData();
                                        swal("刪除成功", {
                                            icon: "success",
                                        });
                                        //alert(message);
                                    },
                                    error: function() {
                                        alert("刪除錯誤");
                                    }
                                });
                            }
                        });



                })
            )


    }

    setEvent() {

    }

    getShopCartItem() {
        return this.shopCartItem;
    }
}