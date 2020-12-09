$(function() {
    resetLightBox();
});

function resetLightBox() {
    penButton();
    closeLightBox();
    hideTagEnterKeydown();
    closeTag();
    //goodInClick();
    editInClick();
    more();
    //(index_productPreview用)
    submitInProduct();
}


function more() {
    $(".more").click(function() {
        var a = $(this).next().css("display");
        if (a == "none") {
            $(this).next().css("display", "inline-block");
        } else {
            $(this).next().css("display", "none");
        }

    });
}



function penButton() {
    $(".toolRowJS").click(function() {

        //標題開啟輸入
        $(this).parent().next().find(".disableTitle").attr("disabled", false);
        $(this).parent().next().find(".disableTitle").css("border", "1px solid #7F2A13");
        $(this).parent().next().find(".disableTitle").css("border-radius", "5px");
        //價格開啟輸入(index_productPreview專用)
        $(this).parent().next().find(".disablePrice").attr("disabled", false);
        $(this).parent().next().find(".disablePrice").css("border", "1px solid #7F2A13");
        $(this).parent().next().find(".disablePrice").css("border-radius", "5px");
        //描述開啟輸入
        $(this).parent().next().find(".disableTextarea").attr("disabled", false);
        $(this).parent().next().find(".disableTextarea").css("border", "1px solid #7F2A13");
        $(this).parent().next().find(".disableTextarea").css("border-radius", "5px");
        //標籤開啟輸入
        $(this).parent().next().find(".hideTagEnter").css("display", "inline-block");

        //將目前有的標籤加入x
        const closeTag = document.createElement('a');
        closeTag.textContent = "x";
        closeTag.setAttribute("class", "closeInTag");
        $(this).parent().next().find(".ulForJS").children().append(closeTag);
        //愛心變成儲存按鈕
        $(this).parent().next().find(".emptyGood").attr("src", "images/picInfoPage/store.png");
        $(this).parent().next().find(".emptyGood").addClass("edit");
        $(this).parent().next().find(".edit").removeClass("emptyGood");
        //打開儲存按鈕(index_productPreview專用)
        $(this).parent().next().find(".submitInProduct").css("display", "block");
    });
}

function closeLightBox() {
    $(".closeIcon").click(function() {

        //標題關閉輸入
        $(this).parent().parent().next().find(".disableTitle").attr("disabled", true);
        $(this).parent().parent().next().find(".disableTitle").css("border", "none");
        //價格關閉輸入(index_productPreview專用)
        $(this).parent().parent().next().find(".disablePrice").attr("disabled", true);
        $(this).parent().parent().next().find(".disablePrice").css("border", "none");
        //描述關閉輸入
        $(this).parent().parent().next().find(".disableTextarea").attr("disabled", true);
        $(this).parent().parent().next().find(".disableTextarea").css("border", "none");
        //標籤關閉輸入
        $(this).parent().parent().next().find(".hideTagEnter").css("display", "none");
        $(this).parent().parent().next().find(".closeInTag").remove();
        //更改圖片(提交修改&按愛心)
        $(this).parent().parent().next().find(".edit").attr("src", "images/checkerPage/emptyGood.png");
        $(this).parent().parent().next().find(".edit").addClass("emptyGood");
        $(this).parent().parent().next().find(".emptyGood").removeClass("edit");
        //關閉儲存按鈕(index_productPreview專用)
        $(this).parent().parent().next().find(".submitInProduct").css("display", "none");
    });
}

function hideTagEnterKeydown() {
    $(".hideTagEnter").keyup(function() {
        if (event.keyCode == 13) {
            //按下輸入加入x按鈕
            const liTag = document.createElement('li');


            const nameElement = document.querySelector(".hideTagEnter")
            const name = $(this).val();

            if (name.length == 0) {
                return;
            }

            $(liTag)
                .append(
                    $("<span/>")
                    .append("#" + name)
                );

            //清空
            $(this).prop("value", "");
            const closeTag = document.createElement('a');
            closeTag.textContent = "x";
            closeTag.setAttribute("class", "closeInTag");
            //liTag.textContent = "#" + name;
            liTag.appendChild(closeTag);
            $(this).prev().append(
                // $("<span/>")
                // .append(liTag)
                liTag
            );
        }
    });
}
//標籤前的x
function closeTag() {
    $(".ulForJS").delegate(".closeInTag", "click", function() {
        //將編輯中的標籤刪掉
        $(this).parent().remove();
    });
}
//按愛心
/*
function goodInClick() {
    //事件委託，當圖片是愛心做的事情
    $(".editAndGoodInClick").delegate(".emptyGood", "click", function() {
        //判斷是否為空的愛心或是滿的愛心
        var a = $(this).attr("src");
        var b = a.slice(a.lastIndexOf("/") + 1, a.lastIndexOf("."));


        if (b == "emptyGood") {
            $(this).attr("src", "images/checkerPage/fullGood.png");
        } else {
            $(this).attr("src", "images/checkerPage/emptyGood.png");
        }
    });
}*/

function editInClick() {
    //事件委託，當在編輯模式下，按儲存會將所有開啟輸入的東西關掉
    $(".editAndGoodInClick").delegate(".edit", "click", function() {
        $(".disableTitle").attr("disabled", true);
        $(".disableTitle").css("border", "none");
        $(".disableTextarea").attr("disabled", true);
        $(".disableTextarea").css("border", "none");
        $(".hideTagEnter").css("display", "none");
        $(".numInGoodClick").css("display","inline");
        $(".closeInTag").remove();
        //移動到showDataObject
        // $(".edit").attr("src", "images/checkerPage/emptyGood.png");
        // $(".edit").addClass("emptyGood")
        // $(".emptyGood").removeClass("edit");
    });
}

function submitInProduct() {
    //事件委託，當在編輯模式下，按儲存會將所有開啟輸入的東西關掉
    $(".submitInProduct").click(function() {
        $(".disableTitle").attr("disabled", true);
        $(".disableTitle").css("border", "none");
        $(".disableTextarea").attr("disabled", true);
        $(".disableTextarea").css("border", "none");
        $(".disablePrice").attr("disabled", true);
        $(".disablePrice").css("border", "none");
        $(".hideTagEnter").css("display", "none");
        $(".closeInTag").remove();
        $(this).css("display", "none");
    });
}