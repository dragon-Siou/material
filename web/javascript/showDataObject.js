//創造一個新的燈箱
function createLightBox(item) {

    //決定生產哪類的燈箱
    let lightBoxData; //= new GalleryLightBoxData(item);
    //alert(item.showData.type);

    switch (item.showData.type) {
        case "gallery":
            lightBoxData = new GalleryLightBoxData(item);
            break;
        case "product":
            lightBoxData = new ProductLightBoxData(item);
            break;
        case "commission":
            lightBoxData = new CommissionLightBoxData(item);
            break;
    }

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

class GalleryLightBoxData {
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

        let editImage = $("<img/>")
            .prop("id", "editImage");

        let deleteButton = "";

        //可以編輯
        if (window.memberID === this.item.showData.mID) {

            editImage
                .addClass("toolRowJS")
                .prop("src", "images/picInfoPage/edit.png")
                .click(function() {
                    //alert("可編輯");
                    //編輯按鈕事件
                    //把自己隱藏
                    $(this).css("display", "none");
                    //隱藏讚數
                    $("#likeCountArea").css("display", "none");

                });
            //可以刪除
            deleteButton = $("<li/>")
                .append(
                    $("<a/>")
                    .prop("id", "delete")
                    .append("刪除")
                );

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
                            .prop("href", "../" + this.item.showData.link)
                            .prop("download", this.item.showData.title)
                            .append("下載圖片")
                        ),

                        deleteButton
                    )
                ),

                //關掉
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
            .addClass("ulForJS")
            .prop("id", "editTags");

        for (let tag of this.item.tags) {
            let tagElement = new TagElement(tag.tName);
            tags.append(
                tagElement.tag
            );
        }

        let goodOnclick = $("<div/>")
            .addClass("editAndGoodInClick");

        //有按讚
        if (this.item.isLike) {
            goodOnclick
                .append(
                    $("<img/>")
                    .addClass("emptyGood")
                    .prop("src", "images/checkerPage/fullGood.png")

                );
            window.isGoodFull = true;
        }
        //沒有按讚
        else {
            goodOnclick
                .append(
                    $("<img/>")
                    .addClass("emptyGood")
                    .prop("src", "images/checkerPage/emptyGood.png")
                );
            window.isGoodFull = false;
        }

        //讚數
        goodOnclick
            .append(
                $("<div/>")
                .addClass("numInGoodClick")
                .css("display", "inline-block")
                .css("width", "23px")
                .css("height", "23px")
                .css("line-height", "23px")
                .css("margin", "3px 5px")
                .prop("id", "likeCountArea")
                .append(
                    this.item.likeCount
                ),

                $("<div/>")
                .addClass("clear")
            );


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
                        .prop("src", "../" + this.item.member.pLink)


                    ),

                    $("<div/>")
                    .addClass("realnameInClick")
                    //這邊加上點擊使用者的超連結
                    .append(
                        $("<a/>")
                        .prop("href", "person_main.html?mID=" + this.item.member.mID)
                        .append(this.item.userName)
                        .addClass("realname")
                    ),

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
                    .prop("id", "editTitle")
                    .prop("type", "text")
                    .prop("value", this.item.showData.title)
                    .prop("disabled", "true")
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
                    .prop("id", "editDescription")
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

                goodOnclick

            );

        //留言等等處理
        this.commentArea = $("<div/>")
            .addClass("commentArea")
            .prop("id", "commentArea");


        //一個個抓留言出來
        for (let comment of this.item.comments) {
            let commentElement = new CommentElement(
                comment.userName,
                comment.content,
                comment.cTime,
                comment.pLink
            );

            //附加留言
            this.commentArea
                .append(
                    commentElement.comment
                )
        }


        //送出留言
        this.enterArea = $("<div/>")
            .addClass("enterArea")
            .append(
                $("<form/>")
                .prop("id", "commentForm")
                .append(
                    $("<img/>")
                    .addClass("bigHeadInSentComment")
                    .prop("src", "../" + this.item.pLink),

                    $("<input/>")
                    .addClass("typeWordInSentComment")
                    .prop("id", "commentContent")
                    .prop("name", "commentContent")
                    .prop("type", "text")
                    .prop("placeholder", "留言...")
                )
            );


    }

    setEvent() {
        //事件委託，當圖片是愛心做的事情
        //alert("事件委託1");
        let gID = this.item.showData.ID;
        let type = this.item.showData.type;

        //按愛心的事件
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
                window.isGoodFull = true;
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
                            swal("請先登入");
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
                window.isGoodFull = false;
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

        //按下儲存事件
        $(".editAndGoodInClick").delegate(".edit", "click", function() {
            //alert("儲存");

            let img = $(this);
            //有按讚
            if (window.isGoodFull) {
                img.prop("src", "images/checkerPage/fullGood.png");
                $(".edit").addClass("emptyGood")
                $(".emptyGood").removeClass("edit");
            }
            //沒按讚
            else {
                img.prop("src", "images/checkerPage/emptyGood.png");
                $(".edit").addClass("emptyGood")
                $(".emptyGood").removeClass("edit");
            }

            //顯示東西
            //把自己開起來
            $("#editImage").css("display", "");
            //開啟讚數
            $("#likeCountArea").css("display", "");

            //這邊要存資料


            let formData = new FormData();

            // alert(
            //     $("#editTitle").prop("value")
            // );

            // alert(
            //     $("#editDescription").prop("value")
            // );

            // alert(
            //     $("#editTags").find("span")[1].textContent
            // );

            formData.append("gID", gID);
            formData.append("editTitle", $("#editTitle").prop("value"));
            formData.append("editDescription", $("#editDescription").prop("value"));
            let tags = $("#editTags").find("span");
            //let tagData=[];

            for (let tag of tags) {
                //alert(tag.textContent);
                formData.append("editTags[]", tag.textContent);
                //tagData.push(tag.textContent);
            }

            //formData.append("editTags" ,tagData);

            $.ajax({
                type: "post",
                url: "../Connector/EditGalleryConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                //dataType: "json",
                success: function(data) {
                    //alert(message);
                    //alert(data.editTags[1]);
                    //alert(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("修改連接錯誤" + errorThrown);
                }
            });


        });

        //留言事件
        //取消表單預設行為
        $("#commentForm").on("submit", function() {
            return false;
        })

        //留言按下enter
        $("#commentContent").keyup(function(e) {
            //不是按下enter
            if (event.keyCode != 13) {
                return;
            }

            //未登入
            if (window.memberID === undefined) {
                swal("請先登入");
                return;
            }

            let form = $("#commentForm").get(0);
            let formData = new FormData(form);
            formData.append("gID", gID);
            formData.append("mID", window.memberID);

            //不能送空的
            if (formData.get("commentContent").length == 0) {
                //swal("123");
                return;
            }

            //丟資料
            $.ajax({
                type: "post",
                url: "../Connector/CommentConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: "json",
                success: function(data) {

                    //alert(data);
                    //更新資料
                    let comment = new CommentElement(
                        data.name,
                        data.content,
                        data.time,
                        data.pLink
                    ).comment;

                    $("#commentArea")
                        .append(
                            comment
                        );

                    $("#commentContent")
                        .prop("value", "");

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("留言連接錯誤");

                }
            });

        });

        //刪除
        $("#delete").on("click", function() {
            let formData = new FormData();

            formData.append("id", gID);
            formData.append("type", type);

            swal({
                    title: "是否要刪除該作品",
                    //text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        //使用者確認後，把資料送後端，刪掉
                        $.ajax({
                            type: "post",
                            url: "../Connector/DeleteConnector.php",
                            data: formData,
                            processData: false,
                            cache: false,
                            contentType: false,
                            //dataType: "json",
                            success: function(message) {
                                //alert(message);
                                //alert(data.editTags[1]);
                                //alert(message);
                                swal(message, {
                                    icon: "success",
                                });

                                //刪東西
                                $(`#${gID}`).remove();
                                //重新載入資料
                                loadData();


                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("刪除連接錯誤" + errorThrown);
                            }
                        });
                    }
                });
        });

    }
}

class ProductLightBoxData {
    item;

    lightbox;

    brightFilter;
    whiteInfo;
    toolRow;

    realInfoContainer;


    //留言等等處理
    //commentArea;


    //按鈕
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
                //this.commentArea,
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

        let deleteButton = "";
        //可以編輯
        if (window.memberID === this.item.showData.mID) {

            editImage
                .addClass("toolRowJS")
                .prop("src", "images/picInfoPage/edit.png")
                .click(function() {
                    //把自己隱藏
                    $(this).css("display", "none");
                });
            //alert("可編輯");
            deleteButton = $("<li/>")
                .append(
                    $("<a/>")
                    .prop("id", "delete")
                    .append("刪除")
                );
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

                        // $("<li/>")
                        // .append(
                        //     $("<a/>")
                        //     .append("刪除")
                        // )

                        deleteButton
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
            .addClass("ulForJS")
            .prop("id", "editTags");

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
            );
        // .click(function(){
        //     //開啟
        //     $(".toolRowJS")
        //     .css("display","");

        // });

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
                        .prop("src", "../" + this.item.member.pLink)


                    ),

                    $("<div/>")
                    .addClass("realnameInClick")
                    //這邊加上點擊使用者的超連結
                    .append(
                        $("<a/>")
                        .prop("href", "person_main.html?mID=" + this.item.member.mID)
                        .append(this.item.userName)
                        .addClass("realname")
                    ),

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
                    .prop("id", "editTitle")
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
                    .prop("id", "editPrice")
                    .prop("type", "text")
                    .prop("disabled", "true")
                    .prop("value", "$" + this.item.showData.price)
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
                    .prop("id", "editDescription")
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
        let pID = this.item.showData.ID;
        let type = this.item.showData.type;
        /*商品按讚不須留言，記得把按讚相關的東西砍光光*/

        //送資料
        $(".submitInProduct").on("click", function() {
            //開啟
            $(".toolRowJS")
                .css("display", "");

            let formData = new FormData();
            formData.append("pID", pID);
            formData.append("editTitle", $("#editTitle").prop("value"));
            formData.append("editDescription", $("#editDescription").prop("value"));
            formData.append("editPrice", $("#editPrice").prop("value"));
            //價格

            let tags = $("#editTags").find("span");

            for (let tag of tags) {
                //alert(tag.textContent);
                formData.append("editTags[]", tag.textContent);
                //tagData.push(tag.textContent);
            }

            $.ajax({
                type: "post",
                url: "../Connector/EditProductConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                //dataType: "json",
                success: function(data) {
                    //alert(message);
                    //alert(data.editTags[1]);
                    //alert(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("修改商品連接錯誤" + errorThrown);
                }
            });
            //alert("儲存");
        });


        //加入購物車
        $(".putShopCart_product").on("click", function() {
            let formData = new FormData();
            formData.append("pID", pID);

            $.ajax({
                type: "post",
                url: "../Connector/ShopCartConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                //dataType: "json",
                success: function(message) {
                    //alert(message);
                    //alert(data.editTags[1]);
                    swal(message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("購物車連接錯誤" + errorThrown);
                }
            });
        });

        //刪除
        //刪除
        $("#delete").on("click", function() {
            let formData = new FormData();

            formData.append("id", pID);
            formData.append("type", type);

            swal({
                    title: "是否要刪除該商品",
                    //text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        //使用者確認後，把資料送後端，刪掉
                        $.ajax({
                            type: "post",
                            url: "../Connector/DeleteConnector.php",
                            data: formData,
                            processData: false,
                            cache: false,
                            contentType: false,
                            //dataType: "json",
                            success: function(message) {
                                //alert(message);
                                //alert(data.editTags[1]);
                                //alert(message);
                                swal(message, {
                                    icon: "success",
                                });

                                //刪東西
                                $(`#${pID}`).remove();
                                //重新載入資料
                                loadData();


                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("刪除連接錯誤" + errorThrown);
                            }
                        });
                    }
                });

        });

        //取消表單預設行為
        $("form").on("submit", function() {
            return false;
        });

    }
}

//委託
class CommissionLightBoxData {
    item;

    lightbox;

    brightFilter;
    whiteInfo;
    toolRow;

    realInfoContainer;


    //留言等等處理
    //commentArea;


    //聯絡委託
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
                // this.commentArea,
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

        let editImage = $("<img/>")
            .prop("id", "editImage");

        let deleteButton = "";

        //可以編輯
        if (window.memberID === this.item.showData.mID) {

            editImage
                .addClass("toolRowJS")
                .prop("src", "images/picInfoPage/edit.png")
                .click(function() {
                    //alert("可編輯");
                    //編輯按鈕事件
                    //把自己隱藏
                    $(this).css("display", "none");
                    //隱藏讚數
                    //$("#likeCountArea").css("display","none");

                });
            //可以刪除
            deleteButton = $("<li/>")
                .append(
                    $("<a/>")
                    .prop("id", "delete")
                    .append("刪除")
                );

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
                            .prop("href", "../" + this.item.showData.link)
                            .prop("download", this.item.showData.title)
                            .append("下載圖片")
                        ),

                        deleteButton
                    )
                ),

                //關掉
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
            .addClass("ulForJS")
            .prop("id", "editTags");

        for (let tag of this.item.tags) {
            let tagElement = new TagElement(tag.tName);
            tags.append(
                tagElement.tag
            );
        }


        let editOnclick = $("<div/>")
            .addClass("editAndGoodInClick")
            .append(
                $("<img/>")
                .addClass("edit")
                .css("display", "none")
                .prop("src", "images/picInfoPage/store.png")
            );
        /*
                //有按讚
                if(this.item.isLike){
                    goodOnclick
                    .append(
                        $("<img/>")
                        .addClass("emptyGood")
                        .prop("src","images/checkerPage/fullGood.png")

                    );
                    window.isGoodFull=true;
                }
                //沒有按讚
                else{
                    goodOnclick
                    .append(
                        $("<img/>")
                        .addClass("emptyGood")
                        .prop("src","images/checkerPage/emptyGood.png")
                    );
                    window.isGoodFull=false;
                }

                //讚數
                goodOnclick
                .append(
                    $("<div/>")
                        .addClass("numInGoodClick")
                        .prop("id", "likeCountArea")
                        .append(
                            this.item.likeCount
                        ),

                        $("<div/>")
                        .addClass("clear")
                );*/


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
                        .prop("src", "../" + this.item.member.pLink)


                    ),

                    $("<div/>")
                    .addClass("realnameInClick")
                    //這邊加上點擊使用者的超連結
                    .append(
                        $("<a/>")
                        .prop("href", "person_main.html?mID=" + this.item.member.mID)
                        .append(this.item.userName)
                        .addClass("realname")
                    ),

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
                    .prop("id", "editTitle")
                    .prop("type", "text")
                    .prop("value", this.item.showData.title)
                    .prop("disabled", "true")
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
                    .prop("id", "editDescription")
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

                editOnclick

            );

        /*
        //留言等等處理
        this.commentArea=$("<div/>")
        .addClass("commentArea")
        .prop("id","commentArea");


        //一個個抓留言出來
        for(let comment of this.item.comments){
            let commentElement=new CommentElement(
                comment.userName,
                comment.content,
                comment.cTime,
                comment.pLink
            );

            //附加留言
            this.commentArea
            .append(
                commentElement.comment
            )
        }
        

        //送出留言
        this.enterArea=$("<div/>")
        .addClass("enterArea")
        .append(
            $("<form/>")
            .prop("id","commentForm")
            .append(
                $("<img/>")
                .addClass("bigHeadInSentComment")
                .prop("src","../" + this.item.pLink),
                
                $("<input/>")
                .addClass("typeWordInSentComment")
                .prop("id","commentContent")
                .prop("name","commentContent")
                .prop("type","text")
                .prop("placeholder","留言...")
            )
        );*/

        this.enterArea = $("<div/>")
            .addClass("enterArea")
            .append(
                $("<form/>")
                .append(
                    $("<input>")
                    .addClass("delegate_product")
                    .prop("id", "askCommission")
                    .prop("type", "submit")
                    .prop("value", "")
                    //這行不要刪掉，因為如果value不給空字串，圖片上會出現提交兩個字


                )
            );



    }

    setEvent() {
        //事件委託，當圖片是愛心做的事情
        //alert("事件委託1");
        let cID = this.item.showData.ID;
        let type = this.item.showData.type;

        /*
                //按愛心的事件
                $(".editAndGoodInClick").delegate(".emptyGood", "click", function() {
                    //判斷是否為空的愛心或是滿的愛心
                    //alert("事件委託");
                    let a = $(this).attr("src");
                    let b = a.slice(a.lastIndexOf("/") + 1, a.lastIndexOf("."));

                    let formData=new FormData();
                    formData.append("gID",gID);

                    let img=$(this);

                    //空的
                    if (b == "emptyGood") {
                        //alert("沒有按讚");
                        //改圖
                        //$(this).attr("src", "images/checkerPage/fullGood.png");
                        window.isGoodFull=true;
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
                            success: function (data) {
                                //未登入
                                //alert(data.isLogin)
                                if(!data.isLogin){
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
                        window.isGoodFull=false;
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
                            success: function (data) {
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
        */
        //按下編輯
        $("#editImage").on("click", function() {
            //開啟儲存
            $(".edit").css("display", "");
        })

        //按下儲存事件
        $(".editAndGoodInClick").delegate(".edit", "click", function() {
            //alert("儲存");

            let img = $(this);
            /*
            //有按讚
            if(window.isGoodFull){
                img.prop("src", "images/checkerPage/fullGood.png");
                $(".edit").addClass("emptyGood")
                $(".emptyGood").removeClass("edit");
            }
            //沒按讚
            else{
                img.prop("src", "images/checkerPage/emptyGood.png");
                $(".edit").addClass("emptyGood")
                $(".emptyGood").removeClass("edit");
            }
*/
            //顯示東西
            //把編輯開起來
            $("#editImage").css("display", "");

            //關掉儲存
            $(".edit").css("display", "none");

            //開啟讚數
            //$("#likeCountArea").css("display","");

            //這邊要存資料


            let formData = new FormData();

            // alert(
            //     $("#editTitle").prop("value")
            // );

            // alert(
            //     $("#editDescription").prop("value")
            // );

            // alert(
            //     $("#editTags").find("span")[1].textContent
            // );

            formData.append("cID", cID);
            formData.append("editTitle", $("#editTitle").prop("value"));
            formData.append("editDescription", $("#editDescription").prop("value"));
            let tags = $("#editTags").find("span");
            //let tagData=[];

            for (let tag of tags) {
                //alert(tag.textContent);
                formData.append("editTags[]", tag.textContent);
                //tagData.push(tag.textContent);
            }

            //formData.append("editTags" ,tagData);

            $.ajax({
                type: "post",
                url: "../Connector/EditCommissionConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                //dataType: "json",
                success: function(data) {
                    //alert(message);
                    //alert(data.editTags[1]);
                    //alert(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("修改連接錯誤" + errorThrown);
                }
            });


        });

        //留言事件
        //取消表單預設行為
        $("form").on("submit", function() {
            return false;
        })

        let mID = this.item.showData.mID;

        //詢問委託
        $("#askCommission").on("click", function() {
            //alert("嗨");

            //跳轉
            window.location.href =
                "messages.html?chatID=" +
                mID;

        })

        /*
        //留言按下enter
        $("#commentContent").keyup(function (e) { 
            //不是按下enter
            if (event.keyCode != 13) {
                return;
            }

            //未登入
            if(window.memberID === undefined){
                alert("請先登入");
                return;
            }

            let form = $("#commentForm").get(0);
            let formData = new FormData(form);
            formData.append("gID",gID);
            formData.append("mID",window.memberID);

            //丟資料
            $.ajax({
                type: "post",
                url: "../Connector/CommentConnector.php",
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                dataType: "json",
                success: function (data) {

                    //alert(data);
                    //更新資料
                    let comment=new CommentElement(
                        data.name,
                        data.content,
                        data.time,
                        data.pLink
                    ).comment;

                    $("#commentArea")
                    .append(
                        comment
                    );

                    $("#commentContent")
                    .prop("value","");

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("留言連接錯誤");
                }
            });

        });
*/
        //刪除
        $("#delete").on("click", function() {
            let formData = new FormData();

            formData.append("id", cID);
            formData.append("type", type);


            swal({
                    title: "是否要刪除該委託",
                    //text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        //使用者確認後，把資料送後端，刪掉
                        $.ajax({
                            type: "post",
                            url: "../Connector/DeleteConnector.php",
                            data: formData,
                            processData: false,
                            cache: false,
                            contentType: false,
                            //dataType: "json",
                            success: function(message) {
                                //alert(message);
                                //alert(data.editTags[1]);
                                //alert(message);
                                swal(message, {
                                    icon: "success",
                                });

                                //刪東西
                                $(`#${cID}`).remove();
                                //重新載入資料
                                loadData();


                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert("刪除連接錯誤" + errorThrown);
                            }
                        });
                    }
                });


        });

    }
}

//留言
class CommentElement {
    comment;

    //拿東西
    constructor(mName, content, time, pLink) {

        this.comment = $("<div/>")
            .addClass("commentInClick")
            .append(

                $("<div/>")
                .addClass("headInComment")
                .append(
                    $("<img/>")
                    .prop("src", "../" + pLink)
                ),

                $("<div/>")
                .addClass("name")
                .append(mName),

                $("<div/>")
                .addClass("comment")
                .append(content),

                $("<div/>")
                .addClass("sentMinute")
                .append(time),

                // $("<div/>")
                // .addClass("name")
                // .append(
                //     mName,

                //     $("<span/>")
                //     .addClass("comment")
                //     .append(content),

                //     $("<span/>")
                //     .addClass("sentMinute")
                //     .append(time)
                // ),

                $("<div/>")
                .addClass("clear")
            );

    }

}

class TagElement {
    tag;

    constructor(tag) {
        this.tag = $("<li/>")
            .append(
                $("<span/>")
                .append("#" + tag)
            );
    }
}