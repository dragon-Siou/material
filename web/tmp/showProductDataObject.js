//創造一個新的燈箱
function createLightBox(item) {
    let lightBoxData = new LightBoxData(item);
    $("body").append(
        lightBoxData.getLightBox()
    );
    lightBoxData.setEvent();
    resetLightBox();
}


function showData(data) {
    //決定如何處理
    for (let item of data) {
        // <div class='box'>
        //         <img src='../{$data->link}'>
        //         </div>
        //alert(item.gID);
        $(".content").append(
            $("<div/>")
            .addClass('box')

            .append(
                $("<a>/").prop("id", "backTo" + item.ID),

                $("<a>/")
                //.prop("href","#" + item.ID)
                .prop("name", item.ID)
                .append(
                    $("<img/>").prop("src", "../" + item.link)
                )
                //點擊才製作燈箱
                .click(
                    function(e) {

                        let formData = new FormData();
                        formData.append("itemID", item.ID);
                        formData.append("showDataType", item.type);

                        //要資料
                        $.ajax({
                            type: "post",
                            url: "../Connector/LightBoxElementConnector.php",
                            data: formData,
                            processData: false,
                            cache: false,
                            contentType: false,
                            dataType: "json",
                            success: function(item) {
                                //alert(data.ID + " " + data.type);
                                createLightBox(item);
                                //跳轉
                                location.href = "#" + item.showData.ID;
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("連接燈箱資料錯誤");
                            }
                        });
                    }
                )
            )


        );


    }
}

class LightBoxData {
    item;

    lightbox;

    brightFilter;
    whiteInfo;
    toolRow;

    realInfoContainer;


    //留言等等處理
    commentArea;


    //送出留言
    enterArea;

    constructor(item) {
        this.item = item;
        this.initialize();

        //組裝物件

        // this.commentArea
        // .append(
        //     this.commentElement,
        //     this.commentElement
        // )

        this.whiteInfo
            .append(
                this.toolRow,
                this.realInfoContainer,
                this.commentArea,
                this.enterArea
            )


        this.lightbox
            .append(
                this.brightFilter,
                this.whiteInfo
            )


    }

    getLightBox() {
        return this.lightbox;
    }

    initialize() {
        this.lightbox = $("<div/>")
            .addClass("lightbox")
            .prop("id", this.item.showData.ID);

        this.brightFilter = $("<div/>")
            .addClass("brightFilter")
            .append(
                $("<img/>")
                .prop("src", "../" + this.item.showData.link)
            );

        this.whiteInfo = $("<div/>")
            .addClass("whiteInfo");

        let ID = this.item.showData.ID;

        let editImage = $("<img/>");
        //可以編輯
        if (window.memberID === this.item.showData.mID) {

            editImage
                .addClass("toolRowJS")
                .prop("src", "images/picInfoPage/edit.png");
            //alert("可編輯");
        }
        //不能編輯
        else {
            editImage
                .css("display", "none");
        }


        this.toolRow = $("<div/>")
            .addClass("toolRow")
            .append(
                editImage,

                $("<span/>")
                .append(
                    $("<img/>")
                    .addClass("more")
                    .prop("src", "images/picInfoPage/more.png"),

                    $("<ul/>")
                    .addClass("moreOption")
                    .append(
                        $("<li/>")
                        .append(
                            $("<a/>")
                            .append("下載圖片")
                        ),

                        $("<li/>")
                        .append(
                            $("<a/>")
                            .append("分享連結")
                        )
                    )
                ),

                $("<a/>")
                //.prop("href","#backTo"+this.item.showData.ID)
                .append(
                    $("<img/>")
                    .addClass("closeIcon")
                    .prop("src", "images/picInfoPage/close.png")
                    //關掉

                )
                .click(
                    function() {
                        //刪掉
                        $("#" + ID).remove();
                        //跳轉
                        location.href = "#";
                    }
                )

            );

        //標籤陣列
        let tags = $("<ul/>")
            .addClass("ulForJS");

        for (let tag of this.item.tags) {
            let tagElement = new TagElement(tag.tName);
            tags.append(
                tagElement.tag
            );
        }
        //商品編輯後出現儲存按鈕
        let store = $("<div/>")
            .addClass("submitInProduct")
            .append(
                $("<img/>")
                .prop("src", "images/picInfoPage/store.png")
            )

        //有按讚
        /*
        if (this.item.isLike) {
            goodOnclick
                .append(
                    $("<img/>")
                    .addClass("emptyGood")
                    .prop("src", "images/checkerPage/fullGood.png"),

                    $("<div/>")
                    .addClass("numInGoodClick")
                    .prop("id", "likeCountArea")
                    .append(
                        this.item.likeCount
                    ),


                    $("<div/>")
                    .addClass("clear")

                );
        } else {
            goodOnclick
                .append(
                    $("<img/>")
                    .addClass("emptyGood")
                    .prop("src", "images/checkerPage/emptyGood.png"),

                    $("<div/>")
                    .addClass("numInGoodClick")
                    .prop("id", "likeCountArea")
                    .append(
                        this.item.likeCount
                    ),

                    $("<div/>")
                    .addClass("clear")
                );
        }
        */

        this.realInfoContainer = $("<div/>")
            .addClass("realInfoContainer")
            .append(
                //工具列下方第一欄
                $("<div/>")
                .addClass("userNameInClick")
                .append(
                    $("<div/>")
                    .addClass("userName")
                    .append(
                        //大頭貼
                        $("<img/>")
                        .prop("src", "images/bigHead/8.png")


                    ),

                    $("<div/>")
                    .addClass("realnameInClick")
                    .append(this.item.userName),

                    $("<div/>")
                    .addClass("time")
                    .append(this.item.showData.time),

                    $("<div/>")
                    .addClass("clear")
                ),

                //標題
                $("<div/>")
                .addClass("picTitleInClick")
                .append(
                    $("<input>")
                    .addClass("disableTitle")
                    .prop("type", "text")
                    .prop("value", this.item.showData.title)
                    .prop("disabled", "true")
                ),

                //價錢
                $("<div/>")
                .addClass("picPriceInClick_product")
                .append(
                    $("<input>")
                    .addClass("disablePrice")
                    .prop("type", "text")
                    .prop("disabled", "true")
                    //這裡要加價格
                    //.append(this.item.showData.time)
                ),

                //標籤，這我等等做
                $("<div/>")
                .addClass("picTagInClick")
                .append(tags)
                .append(
                    $("<input>")
                    .addClass("hideTagEnter")
                    .prop("type", "text")
                    .prop("placeholder", "輸入標籤...")
                ),

                //敘述
                $("<div/>")
                .addClass("desctiptionInClick")
                .append(
                    $("<textarea/>")
                    .addClass("disableTextarea")
                    .prop("disabled", "true")
                    .append(
                        this.item.showData.content
                    )
                ),

                //按讚或提交
                // $("<div/>")
                // .addClass("editAndGoodInClick")
                // .append(
                //     $("<img/>")
                //     .addClass("emptyGood")
                //     .prop("src","images/checkerPage/emptyGood.png")
                // )

                store //(產品預覽不需按讚)

                /*
                $("<span/>")
                .prop("id", "likeCountArea")
                .append(
                    this.item.likeCount
                )
                */
            );

        //留言等等處理
        /*商品頁面不須留言，記得把留言相關的東西砍光光
        this.commentArea = $("<div/>")
            .addClass("commentArea");


        //一個個抓留言出來
        for (let comment of this.item.comments) {
            let commentElement = new CommentElement(
                comment.mID,
                comment.content,
                comment.time
            );

            //附加留言
            this.commentArea
                .append(
                    commentElement.comment
                )
        }
        */

        //加入追蹤清單&放入購物車
        this.enterArea = $("<div/>")
            .addClass("enterArea")
            .append(
                $("<form/>")
                .append(
                    $("<input>")
                    .addClass("addFollowList_product")
                    .prop("type", "submit")
                    .prop("value", ""),
                    //這行不要刪掉，因為如果value不給空字串，圖片上會出現提交兩個字

                    $("<input>")
                    .addClass("putShopCart_product")
                    .prop("type", "submit")
                    .prop("value", "")
                    //這行不要刪掉，因為如果value不給空字串，圖片上會出現提交兩個字
                )
            );


    }

    setEvent() {
        //事件委託，當圖片是愛心做的事情
        //alert("事件委託1");
        let gID = this.item.showData.ID;
        /*商品按讚不須留言，記得把按讚相關的東西砍光光*/
        $(".editAndGoodInClick").delegate(".emptyGood", "click", function() {
            //判斷是否為空的愛心或是滿的愛心
            //alert("事件委託");
            let a = $(this).attr("src");
            let b = a.slice(a.lastIndexOf("/") + 1, a.lastIndexOf("."));

            let formData = new FormData();
            formData.append("gID", gID);

            let img = $(this);

            //空的
            if (b == "emptyGood") {
                //alert("沒有按讚");
                //改圖
                //$(this).attr("src", "images/checkerPage/fullGood.png");
                //新增按讚
                formData.append("dealType", "add");
                $.ajax({
                    type: "post",
                    url: "../Connector/LikeConnector.php",
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    dataType: "json",
                    success: function(data) {
                        //未登入
                        //alert(data.isLogin)
                        if (!data.isLogin) {
                            alert("請先登入");
                            return;
                        }

                        //alert("已經登入");
                        //更新圖片和讚數
                        $("#likeCountArea")
                            .empty()
                            .append(data.newLikeCount);

                        img.prop("src", "images/checkerPage/fullGood.png");

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("add連接錯誤");
                    }
                });

            }
            //有按過讚 
            else {
                //alert("有按讚");
                //改圖
                //$(this).attr("src", "images/checkerPage/emptyGood.png");
                //刪除按讚
                formData.append("dealType", "reduce");
                $.ajax({
                    type: "post",
                    url: "../Connector/LikeConnector.php",
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    dataType: "json",
                    success: function(data) {
                        //更新圖片和讚數
                        $("#likeCountArea")
                            .empty()
                            .append(data.newLikeCount);

                        img.prop("src", "images/checkerPage/emptyGood.png");
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("reduce連接錯誤");
                    }
                });
            }
        });
    }
}

/*商品按讚不須留言，記得把留言相關的東西砍光光*/
class CommentElement {
    comment;

    //拿東西
    constructor(mName, content, time) {

        this.comment = $("<div/>")
            .addClass("commentInClick")
            .append(
                $("<img/>")
                .prop("src", "images/bigHead/3.png"),

                $("<div/>")
                .addClass("name")
                .append(
                    mName,

                    $("<span/>")
                    .addClass("comment")
                    .append(content),

                    $("<span/>")
                    .addClass("sentMinute")
                    .append(time)
                ),

                $("<div/>")
                .addClass("clear")
            );

    }

}


class TagElement {
    tag;

    constructor(tag) {
        this.tag = $("<li/>")
            .append("#" + tag);
    }
}