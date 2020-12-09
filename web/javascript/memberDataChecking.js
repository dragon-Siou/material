/*
$(function(){
    $("#registeredButton").click(checkData);
});
    */
class MemberDataChecking{
    
    account;
    userName;
    password;
    confirmPassword;
    isDataCorrect;
    
    checkFormat;

    constructor(){
        //alert("空的");
        this.checkFormat = /[^ \w @ .]/;
        this.isDataCorrect=true;
    }

    chechAccount(){
        //本來就沒過
        if(!this.isDataCorrect){
            return;
        }

        if(this.account.length == 0){
            swal("帳號為空");
            this.isDataCorrect=false;
            return;
        }
        //有非法字元
        if(this.checkFormat.test(this.account)){
            swal("帳號含有非法字元");
            this.isDataCorrect=false;
            return;
        }
        
    }

    checkUserName(){
        //本來就沒過
        if(!this.isDataCorrect){
            return;
        }
        if(this.userName.length == 0){
            swal("使用者名稱為空");
            this.isDataCorrect=false;
            return;
        }
    }

    checkPassword(){
        //本來就沒過
        if(!this.isDataCorrect){
            return;
        }
        if(this.password.length == 0){
            swal("密碼為空");
            this.isDataCorrect=false;
            return;
        }
        //密碼有非法字元
        if(this.checkFormat.test(this.password)){
            swal("密碼含有非法字元");
            this.isDataCorrect=false;
            return;
        }
    }

    checkConfirmPassword(){
        //本來就沒過
        if(!this.isDataCorrect){
            return;
        }
        if(this.confirmPassword.length == 0){
            swal("確認密碼為空");
            this.isDataCorrect=false;
            return;
        }
        if(this.password != this.confirmPassword){
            swal("確認密碼不相同");
            this.isDataCorrect=false;
            return;
        }
        
    }

    
}
/*
//資料驗證
function checkData(){
    //alert("空的");
    let form = $("#member").get(0);
    let formData=new FormData(form);
    
    let account=formData.get("account");
    let userName=formData.get("userName");
    let password=formData.get("password");
    let confirmPassword=formData.get("confirmPassword");

    //let memberDataChecking = new MemberDataChecking();
    

    //是否為空
    if(account.length == 0){
        alert("帳號為空");
        return;
    }
    if(userName.length == 0){
        alert("使用者名稱為空");
        return;
    }
    if(password.length == 0){
        alert("密碼為空");
        return;
    }
    if(confirmPassword.length == 0){
        alert("確認密碼為空");
        return;
    }

    //資料值限制
    let checkStr = /[^ \w @ .]/;
    
    //帳號有不合法字元
    if(checkStr.test(account)){
        alert("帳號有不合法字元");
        return;
    }
    //密碼不合法
    if(checkStr.test(password)){
        alert("密碼有不合法字元");
        return;
    }

    //長度限制


    //資料正確性
    if(password != confirmPassword){
        alert("確認密碼不相同");
        return;
    }

    //提交
    $("#member").submit();
}
*/