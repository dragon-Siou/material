$(function() {

    let loginChecking = new LoginChecking();
    loginChecking.notLogin = function() {
        window.location.href = "sign.php";
    }

    if (loginChecking.isLogin()) {
        //alert("已登入");
        window.memberID = loginChecking.memberID;
    }

    //先設定目前聊天室ID為空
    window.chatroomID = "";

    checkNewChatroom();

    //把form的submit解掉
    $("form").on("submit", function() {
        return false;
    })

    setUserData();

    //設定送出訊息
    $("#sendMessage")
        .on("keyup", sendMessage);

    loadData();

});

//設定右上角圖片
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
            // $(".personSmallHead")
            // .prop("src", "../" +data.pLink);
            // $("#bigHead")
            // .prop("src", "../" +data.pLink);
            // $(".infoFirst_SmallHead")
            // .prop("src", "../" +data.pLink);
            $(".personSmallHead")
                .prop("src", "../" + data.pLink);

        },
        error: function() {
            swal("連接失敗");
        }
    });
}

//看看是不是跳轉的
function checkNewChatroom() {
    let urlParameter = new UrlParameter(location.href);
    if (urlParameter.hasKey("chatID")) {
        //alert("跳轉成功");

        //嘗試創建新的聊天室
        let formData = new FormData();
        formData.append("chatID", urlParameter.data["chatID"]);
        formData.append("mID", window.memberID);

        //取得聊天室ID
        $.ajax({
            url: "../Connector/CreateOrGetChatroomConnector.php",
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: formData,
            //dataType:'json',
            type: 'post',
            success: function(data) {
                //alert(data);
                window.chatroomID = data;

                //設定右邊資料
                loadChatRecord(data, urlParameter.data["chatID"]);
            },
            error: function() {
                swal("創建聊天室連接失敗");
            }
        });


    }
}

//設定送出訊息
function sendMessage() {
    if (event.keyCode != 13) {
        return;
    }

    let content = $("#sendMessage")
        .prop("value");

    if (content.length == 0) {
        return;
    }

    //alert("送出訊息!")

    //將訊息丟給後端處理
    let formData = new FormData();
    formData.append("chatroomID", window.chatroomID);
    formData.append("content", content);
    formData.append("sendMID", window.memberID);

    $.ajax({
        url: "../Connector/SendMessageConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        type: 'post',
        success: function(data) {
            //alert(data);
            //新增訊息
            let myMessage = new MyMessageItem(
                data.content,
                data.sendTime
            );

            $(".realChatroom")
                .append(
                    myMessage.getItem()
                );

            //把訊息清空
            $("#sendMessage")
                .prop("value", "");
        },
        error: function() {
            swal("傳送訊息連接失敗");
        }
    });

}

function loadData() {
    //清空資料
    $(".backGroudInList").empty();

    //左邊區塊的資料
    let formData = new FormData();
    formData.append("memberID", window.memberID);

    $.ajax({
        url: "../Connector/ChatroomConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        type: 'post',
        success: function(data) {

            //設定左邊資料
            showChatroom(data);

            //設定當前聊天室ID
            //是空的才能設定
            if (window.chatroomID == "") {
                //設定右邊資料
                loadChatRecord(data[0].chatroom.crID, data[0].chatroom.mID2);
                window.chatroomID = data[0].chatroom.crID;
            }


        },
        error: function() {
            swal("聊天室連接失敗");
        }
    });



}

function showChatroom(data) {
    for (let item of data) {
        //alert(item.chatroom.mID2);
        let chatroomItem = new ChatroomItem(
            item.chatroom.crID,
            item.chatroom.mID2,
            item.member.userName,
            item.member.pLink,
            item.newChatRecord.content
        )

        $(".backGroudInList")
            .append(
                chatroomItem.getChatroomItem()
            )
    }
}

//右邊介面
function loadChatRecord(chatroomID, chatID) {

    //清空
    $(".realChatroom").empty();

    //左邊區塊的資料
    let formData = new FormData();
    formData.append("chatroomID", chatroomID);
    formData.append("chatID", chatID);
    // alert(chatroomID);
    // alert(chatID);


    $.ajax({
        url: "../Connector/ChatRecordConnector.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        type: 'post',
        success: function(data) {
            //alert("連接成功");
            showChatRecord(data);
        },
        error: function() {
            swal("聊天紀錄連接失敗");
        }
    });
}

function showChatRecord(data) {


    //alert(window.chatID);
    //設定聊天室名稱
    $(".nameInC_title")
        .html(
            $("<a>")
            .prop("href", "person_main.html?mID=" + data.chatMember.mID)
            .append(data.chatMember.userName)
            .addClass("linkInMessage")
        );

    $("#chatHeadPic")
        .prop("src", "../" + data.chatMember.pLink);

    for (let item of data.showData) {
        //alert(item.content);

        let messageItem;
        //是自己發的
        if (item.sendMID == window.memberID) {
            messageItem = new MyMessageItem(
                item.content,
                item.sendTime
            )
        }
        //別人發的
        else {
            messageItem = new OtherMessageItem(
                data.chatMember.pLink,
                item.content,
                item.sendTime
            )
        }

        //增加資料
        $(".realChatroom")
            .append(
                messageItem.getItem()
            )
    }


    // let myMessageItem=new MyMessageItem(
    //     "測試",
    //     "2020"   
    // );
    // let otherMessageItem=new OtherMessageItem(
    //     null,
    //     "別人的訊息",
    //     "2020"
    // )

    // $(".realChatroom")
    // .append(
    //     myMessageItem.getMyMessage(),
    //     otherMessageItem.getOtherMessageItem()
    // )
}

class ChatroomItem {
    chatroomItem;

    constructor(crID, chatID, name, pLink, newMessage) {
        this.chatroomItem = $("<div/>")
            .addClass("personInList")
            .append(
                $("<div/>")
                .addClass("picInPerson")
                .append(
                    $("<img>")
                    .prop("src", "../" + pLink)
                ),

                $("<div/>")
                .addClass("infoInPerson")
                .append(
                    $("<div/>")
                    .addClass("nameInInfo")
                    .append(
                        name
                    ),

                    $("<div/>")
                    .addClass("tellInInfo")
                    .append(newMessage)
                ),

                $("<div/>")
                .addClass("clear")

            )
            //點擊事件
            .on("click", function() {
                //alert(chatID);
                loadChatRecord(crID, chatID);
                //設定當前在聊天的ID
                window.chatroomID = crID;
            });
    }

    getChatroomItem() {
        return this.chatroomItem;
    }
}

class MyMessageItem {
    myMessageItem;

    constructor(content, time) {

        this.myMessageItem = $("<div/>")
            .addClass("myMessage")
            .append(
                $("<div/>")
                .addClass("myMessage_mes_content")
                .append(content),

                $("<div/>")
                .addClass("myMessage_mes_time")
                .append(time)
            );

    }

    getItem() {
        return this.myMessageItem;
    }
}

class OtherMessageItem {
    otherMessageItem;

    constructor(pLink, content, time) {

        this.otherMessageItem = $("<div/>")
            .addClass("otherMessage")
            .append(
                $("<div/>")
                .addClass("otherMessage_head")
                .append(
                    $("<img/>")
                    .prop("src", "../" + pLink)
                ),

                $("<div/>")
                .addClass("otherMessage_mes")
                .append(
                    $("<div/>")
                    .addClass("otherMessage_mes_content")
                    .append(content),

                    $("<div/>")
                    .addClass("otherMessage_mes_time")
                    .append(time)
                )
            );
    }

    getItem() {
        return this.otherMessageItem;
    }

}