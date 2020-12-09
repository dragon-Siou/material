$(function() {

    //先建物建
    let loginChecking = new LoginChecking();

    /*
        loginChecking.notLogin=function(){
            //跳轉
            //alert("跳轉");
            window.location.href="sign.php";
        }*/

    //設定ID
    if (loginChecking.isLogin()) {
        window.memberID = loginChecking.memberID;
        window.isLogin=true;
        //setOwnPage();
    }
    else{
        window.isLogin=false;
    }

    //檢查是不是跳轉的
    let urlParameter = new UrlParameter(location.href);
    //alert(urlParameter.data["mID"]);
    //用跳轉過來的
    if (urlParameter.hasKey("mID")) {
        //alert("跳轉的");
        //不一樣的話，表示在瀏覽別人的，要關掉
        //alert(window.memberID);
        //alert(urlParameter.data["mID"]);
        //設定頁面ID
        window.pageMID = urlParameter.data["mID"];
        //瀏覽別人的
        if (window.memberID !== urlParameter.data["mID"]) {
            //closeEdit();
            setOtherPage();
            //登入
            if (loginChecking.isLogin()) {
                window.memberID = loginChecking.memberID;
                setLogin();
            }
            //沒登入
            else {
                setNotLogin();
            }
        } else {
            //是自己
            setOwnPage();
        }



    } else {
        //不是跳轉的話，要檢查有沒有登入
        //檢查是否登入
        //沒登入跳登入
        if (loginChecking.isLogin()) {
            setOwnPage();
        } else {
            window.location.href = "sign.php";
        }

        window.pageMID = window.memberID;
    }


    //掛事件
    $("form").bind(
        "submit",
        function() {
            return false;
        }
    );

    $("#uploadButton").click(upload);

    //顯示資料
    loadData();

    //顯示交易紀錄
    loadTransaction();

    //初始化頁面資訊
    setUserData();

    //初始化粉絲
    //去自己頁面跟別人頁面設定
    //setFans();

    //掛上修改資料事件
    setEditEvent();
});

//抓粉絲資料
function setFans(){
    let formData = new FormData();
    formData.append("pageMID", window.pageMID);

    $.ajax({
        url: "../Connector/FansConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        //dataType: 'json',
        type: 'post',
        success: function(data) {
            $("#userFans")
            .html(data + "位粉絲");
        },
        error: function() {
            alert("連接粉絲資訊失敗");
        }
    });
}

//右上跳回登入
function setNotLogin() {
    //跳回自己葉面
    $("#bigHeadOrLogout")
        .prop("src", "images/logout.png");

    $("#bigHeadOrLogoutLink")
        .css("cursor", "pointer")
        .prop("href", "sign.php");
}

//右上改成跳回自己葉面
function setLogin() {
    //alert("setLogin");

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

            //跳回自己葉面
            $("#bigHeadOrLogout")
                .prop("src", "../" + data.pLink);

            $("#bigHeadOrLogoutLink")
                .css("cursor", "pointer")
                .prop("href", "person_main.html");


        },
        error: function() {
            alert("連接個人資訊失敗");
        }
    });

}

//自己
//設定登出
function setOwnPage() {

    //設定粉絲
    setFans();
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




        },
        error: function() {
            alert("連接個人資訊失敗");
        }
    });

    $("#bigHeadOrLogout")
        .prop("src", "images/logout.png");



    $("#bigHeadOrLogoutLink")
        .css("cursor", "pointer")
        .on("click", userLogout);
}

function userLogout() {
    //alert("登出");
    swal({
            title: "確定要登出嗎",
            text: "確認登出後會跳回首頁",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                //登出
                $.ajax({
                    url: "../Connector/LogoutConnector.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    //dataType:'json',
                    type: 'post',
                    success: function(data) {
                        location.href = "index.html";
                    },
                    error: function() {
                        alert("連接個人資訊失敗");
                    }
                });
            }
        });

}

//別人
function setOtherPage() {
    closeEdit();

    //重新設定user區塊
    $("#userButton").empty();

    
    //設定粉絲
    setFans();

    //設定追蹤
    let formData=new FormData();
    formData.append("trackID",window.pageMID);

    $.ajax({
        url: "../Connector/TrackConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType:'json',
        type: 'post',
        success: function(data) {
            //設定追蹤

            let followElement=new FollowElement(data);

            $("#userButton")
            .append(
                followElement.getFollowElement(),

                $("<div/>")
                .addClass("userAct")
                .append(
                    $("<a/>")
                    .append(
                        $("<img>")
                        .prop("src","images/send_message.png")
                    )
                    .on("click",function(){
                        //有登入
                        if(window.isLogin){
                            location.href=
                                "messages.html?chatID="+window.pageMID;
                        }
                        else{
                            swal("請先登入");
                        }
                    })
                ),

                $("<div/>")
                .addClass("clear")
                
            );

  

        },
        error: function() {
            swal("連接追蹤失敗");
        }
    });

    


    
    //設定跳轉
    //alert("設定");
    let href = $("#galleryPage").prop("href");
    href += "&mID=" + window.pageMID;
    $("#galleryPage").prop("href", href);

    //alert($("#galleryPage").prop("href"));

    href = $("#productPage").prop("href");
    href += "&mID=" + window.pageMID;
    $("#productPage").prop("href", href);

    href = $("#commissionPage").prop("href");
    href += "&mID=" + window.pageMID;
    $("#commissionPage").prop("href", href);

}


//修改事件
function setEditEvent() {



    //修改基本資料
    $("#editProfileSubmit").click(function() {
        let form = $("#editProfileForm").get(0);
        let formData = new FormData(form);
        formData.append("mID", window.memberID);

        //取得檔案
        let bigHead = $("#file-upload")
            .prop("files")[0];

        formData.append("bigHead", bigHead)

        $.ajax({
            url: "../Connector/EditProfileConnector.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            //dataType:'json',
            type: 'post',
            success: function(message) {
                swal({
                    title: "修改成功",
                    //text: "You clicked the button!",
                    icon: "success",
                    button: "OK",
                });
                setUserData();
            },
            error: function() {
                alert("連接失敗");
            }
        });

        //alert("修改個人資料");
    });

    //修改密碼
    $("#editPasswordSubmit").click(function() {
        let form = $("#editPasswordForm").get(0);
        let formData = new FormData(form);
        formData.append("mID", window.memberID);

        $.ajax({
            url: "../Connector/EditPasswordConnector.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            //dataType:'json',
            type: 'post',
            success: function(message) {
                swal(message);
                setUserData();
            },
            error: function() {
                alert("連接失敗");
            }
        });
    });


}

//初始化頁面資訊
function setUserData() {

    //關掉上傳檔案
    $(".closeInUpload").on("click", function() {
        location.href = "#";
    })

    let formData = new FormData();
    formData.append("pageMID", window.pageMID);

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

            //清空
            $("#userName")
                .empty();
            $("#infoFirst_name")
                .empty();
            $("#profile")
                .empty();


            //設定頁面資訊
            $("#userName")
                .append(data.userName);
            $("#infoFirst_name")
                .append(data.userName);
            $("#profile")
                .append(data.profile);
            $("#editUserName")
                .prop("value", data.userName);
            $("#editProfile")
                .prop("value", data.profile);

            //設定大頭貼
            // $(".personSmallHead")
            // .prop("src", "../" +data.pLink);
            $("#bigHead")
                .prop("src", "../" + data.pLink);
            $(".infoFirst_SmallHead")
                .prop("src", "../" + data.pLink);

        },
        error: function() {
            alert("連接失敗");
        }
    });

}

//關閉編輯
function closeEdit() {
    //alert("關掉編輯");
    $(".userAct")
        .css("display", "none");
}


function upload() {

    let form = $("#uploadForm").get(0);
    let formData = new FormData(form);

    //檢查不過
    if (!checkUploadData(formData)) {
        return;
    }


    $.ajax({
        url: "../Connector/UploadConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        //dataType:'json',
        type: 'post',
        success: function(message) {
            //alert(message);
            //關掉上傳視窗
            swal({
                title: message,
                //text: "You clicked the button!",
                icon: "success",
                button: "OK",
            });

            $(".closeInUpload").trigger("click");
            loadData();

        },
        error: function() {
            alert("連接失敗");
        }
    });

    //alert("成功");
}

function checkUploadData(formData) {
    //沒有資料
    if (formData.get("uploadTitle").length == 0) {
        alert("標題未填寫");
        return false;
    }


    //alert(formData.get("uploadType"));

    //alert(formData.get("file-upload1").name.length==0);
    if (formData.get("file-upload1").name.length == 0) {
        alert("請選擇檔案");
        return false;
    }

    //alert(formData.get("uploadType"));

    return true;
}

//下載資料
function loadData() {
    let urlParameter = new UrlParameter(location.href);
    //清空資料
    $(".content").empty();

    let formData = new FormData();
    formData.append("pageMID", window.pageMID);
    if (urlParameter.hasKey("showDataType")) {
        let data = urlParameter.data["showDataType"];
        formData.append("showDataType", data);
    } else {
        formData.append("showDataType", "gallery");
    }

    $.ajax({
        type: "post",
        url: "../Connector/PersonMainConnector.php",
        data: formData,
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            //alert("連接成功");
            showData(data)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert(XMLHttpRequest.status);
            // alert(XMLHttpRequest.readyState);
            // alert(textStatus);
        }
    });

}

function loadTransaction() {
    //清空
    //$(".buyRecord").empty();
    //資料全部都在後端，直接抓
    $.ajax({
        type: "post",
        url: "../Connector/BuyRecordConnector.php",
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            // alert(data);
            showTransaction(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert(XMLHttpRequest.status);
            // alert(XMLHttpRequest.readyState);
            // alert(textStatus);
        }
    });


}

function showTransaction(data) {
    //alert(data);
    for (let item of data) {
        //alert(item.member.mID);
        buyRecordItem = new BuyRecordItem(item);
        $(".buyRecord")
            .append(buyRecordItem.getBuyRecordItem());
    }
}

class BuyRecordItem {

    buyRecordItem;

    buyRecordList_leftImage;
    buyRecordList_midInfo;
    buyRecordList_rightPrice;


    constructor(item) {
        this.initialize(item);

        //組裝
        this.buyRecordItem = $("<div>")
            .addClass("buyRecordList")
            .append(
                this.buyRecordList_leftImage,
                this.buyRecordList_midInfo,
                this.buyRecordList_rightPrice,
                $("<div/>")
                .addClass("clear")
            );
    }

    initialize(item) {

        this.buyRecordList_leftImage = $("<div/>")
            .addClass("buyRecordList_leftImage")
            .append(
                $("<img/>")
                .addClass("buyRecordList_image")
                .prop("src", "../" + item.product.link)
            );

        this.buyRecordList_midInfo = $("<div/>")
            .addClass("buyRecordList_midInfo")
            .append(
                $("<div/>")
                .addClass("buyRecordList_midInfo_first")
                .append(
                    $("<div/>")
                    .addClass("buyRecordList_midInfo_first_headContainer")
                    .append(
                        $("<img/>")
                        .addClass("buyRecordList_midInfo_smallHead")
                        //頭貼
                        .prop("src", "../" + item.member.pLink)
                    ),

                    $("<div/>")
                    .addClass("buyRecordList_midInfo_first_name")
                    .append(
                        $("<a/>")
                        .addClass("buyRecordName")
                        .prop("href", "person_main.html?mID=" + item.member.mID)
                        .append(
                            item.member.userName
                        )
                    ),

                    //聯絡
                    // $("<div/>")
                    // .addClass("buyRecordList_midInfo_first_conact")
                    // .append(
                    $("<a/>")
                    .prop("href", "messages.html?chatID=" + item.member.mID)
                    .append(
                        $("<img>")
                        .addClass("buyRecordList_midInfo__conactBTN")
                        .prop("src", "images/userControllPage/conact.png")
                    ),

                    // ),

                    $("<div/>")
                    .addClass("clear")
                ),

                $("<div/>")
                .addClass("buyRecordList_midInfo_two")
                //應該是標題吧
                .append(item.product.title),

                //交易日期
                $("<div/>")
                .addClass("buyRecordList_midInfo_three")
                .append(item.transaction.tTime),

                //取得檔案
                $("<div/>")
                .addClass("buyRecordList_midInfo_four")
                .append(
                    $("<a/>")
                    .prop("href", "../" + item.product.link)
                    .prop("download", item.product.title)
                    .append(
                        $("<div/>")
                        .append(
                            $("<img/>")
                            .addClass("buyRecordList_midInfo_getBTN")
                            .prop("src", "images/userControllPage/getFile.png")
                        )
                    )

                )

            );

        this.buyRecordList_rightPrice = $("<div/>")
            .addClass("buyRecordList_rightPrice")
            .append("$" + item.transaction.price);
    }

    getBuyRecordItem() {
        return this.buyRecordItem;
    }

}



class FollowElement{
    followElement;

    constructor(data){

        let img;

        //有追蹤
        if(data.isTrack){
            img="images/following.png";
        }
        else{
            img="images/follow.png";
        }

        let editTrack=this.editTrack;

        this.followElement=$("<div/>")
        .addClass("userAct")
        .append(
            $("<a/>")
            .addClass("followContainer")
            //弄錯的
            //.prop("href","message.html?chatID=" + window.pageMID)
            .append(
                $("<img/>")
                .addClass("follow")
                .prop("src",img)
            )
        )
        .on("click",function(){
            //沒登入
            if(!data.isLogin){
                swal("請先登入");
                return;
            }

            //有登入
            
            //如果是追蹤中，要跳alert
            if(data.isTrack){
                swal({
                    title: "確定要取消追蹤嗎",
                    //text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                    //   swal("Poof! Your imaginary file has been deleted!", {
                    //     icon: "success",
                    //   });
                        editTrack(data);
                    } 
                  });
            }
            else{
                //直接傳
                editTrack(data);
            }

            
        


        })
    }

    editTrack(data){
        //這裡要傳後端
        let formData=new FormData();
        formData.append("trackID",window.pageMID);
        formData.append("isTrack",data.isTrack);



        $.ajax({
            url: "../Connector/EditTrackConnector.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            //dataType:'json',
            type: 'post',
            success: function(data) {

                //swal(data);
                //刷新
                setOtherPage();
                
            },
            error: function() {
                swal("連接更新追蹤失敗");
            }
        });
    }

    getFollowElement(){
        return this.followElement;
    }

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
            $("<div/>")
            .addClass('box')
            
            .append(
                $("<a>/").prop("id","backTo"+item.ID),

                $("<a>/")
                //.prop("href","#" + item.ID)
                .prop("name",item.ID)
                .append(
                    $("<img/>").prop("src", "../"+item.link)
                )
                //點擊才製作燈箱
                .click(
                    function(e){

                        let formData=new FormData();
                        formData.append("itemID",item.ID);
                        formData.append("showDataType",item.type);

                        //要資料
                        $.ajax({
                            type: "post",
                            url: "../Connector/LightBoxElementConnector.php",
                            data: formData,
                            processData: false,
                            cache: false,
                            contentType: false,
                            dataType: "json",
                            success: function (item) {
                                //alert(data.ID + " " + data.type);
                                createLightBox(item);
                                //跳轉
                                location.href="#" + item.showData.ID;
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("連接燈箱資料錯誤")
                            }
                        });
                    }
                )
            )
            
            
            
        );




        // $("body").append(
        //     (new LightBoxData(item)).getLightBox()
        // );


        let lightbox=
        //製作描點區
        $(".content").append(
            //div
            $("<div/>")
            .addClass("lightbox")
            .prop("id",item.ID)
            .append(
                $("<div/>")
                .addClass("brightFilter")
                .append(
                    $("<img/>")
                    .prop("src","../"+item.link)
                ),

                $("<div/>")
                .addClass("whiteInfo")
                .append(
                    $("<div/>")
                    .addClass("toolRow")
                    .append(
                        $("<img/>")
                        .prop("src","images/picInfoPage/edit.png"),

                        $("<img/>")
                        .prop("src","images/picInfoPage/more.png"),

                        $("<a/>")
                        .prop("href","backTo"+item.ID)

                    ),

                    $("<div/>")
                    .addClass("realInfoContainer")
                    .append(
                        $("<div/>")
                        .addClass("userNameInClick")
                        .append(
                            $("<div/>")
                            .addClass("userName")
                            .append(
                                $("<img/>")
                                .prop("src","images/bigHead/8.png")
                            )
                        )
                    )
                )
            )
        );

    }
}*/




{
    /* <div class="lightbox" id="pic1">
            <div class="brightFilter">
                <img src="images/nieuGivePhoto/1.jpg">
            </div>
            <div class="whiteInfo">
                <div class="toolRow">
                    <img src="images/picInfoPage/edit.png">
                    <img src="images/picInfoPage/more.png">
                    <a href="#backtoPic1"><img src="images/picInfoPage/close.png"></a>
                </div>

                <div class="realInfoContainer">
                    <!--工具列下方第一欄-->
                    <div class="userNameInClick">
                        <div class="userName">
                            <img src="images/bigHead/8.png">

                        </div>
                        <div class="realnameInClick">fubi_ccy</div>
                        <div class="time">
                            2020/5/11 10:17 P.M.
                        </div>

                        <div class="clear"></div>
                    </div>
                    <!--工具列下方第二欄，標題-->
                    <div class="picTitleInClick">
                        My Drawings
                    </div>
                    <!--工具列下方第三欄，標籤-->
                    <div class="picTagInClick">
                        <ul>
                            <li>#art</li>
                            <li>#drawing</li>
                            <li>#pic</li>
                            <li>#moody</li>
                            <li>#cute</li>
                        </ul>
                    </div>
                    <!--工具列下方第四欄，敘述-->
                    <div class="desctiptionInClick">
                        I am always looking for models to shoot!<br> Comment down if you want a photoshoot!<br> need a photoshoot ? Conacting in bio!
                    </div>

                </div>

                <div class="commentArea">
                    <!--一則留言開始-->
                    <div class="commentInClick">
                        <img src="images/bigHead/3.png">
                        <div class="name">
                            book_fish
                            <span class="comment">好酷喔!拍什麼呀?</span>
                            <span class="sentMinute">4分鐘</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="commentInClick">
                        <img src="images/bigHead/3.png">
                        <div class="name">
                            book_fish
                            <span class="comment">好酷喔!拍什麼呀?</span>
                            <span class="sentMinute">4分鐘</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="commentInClick">
                        <img src="images/bigHead/3.png">
                        <div class="name">
                            book_fish
                            <span class="comment">好酷喔!拍什麼呀?</span>
                            <span class="sentMinute">4分鐘</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="enterArea">
                    <form>
                        <img src="images/bigHead/5.png" class="bigHeadInSentComment">
                        <input type="text" placeholder="留言..." class="typeWordInSentComment">
                    </form>
                </div>
            </div>
        </div> */
}