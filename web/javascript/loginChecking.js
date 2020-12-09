
class LoginChecking{

    notLogin;
    memberID;
    userName;
    member;

    constructor(){
        //空的
        this.notLogin=function(){

        }
    }

    isLogin(){
        let notLogin=this.notLogin;
        let memberID;
        let member;
        let check=false;
        $.ajax({
            url:"../Connector/LoginConnector.php",
            cache: false,
            contentType: false,
            processData: false,
            async:false,
            dataType:'json',
            type:'post',
            success:function(data){
                //還沒登入
                //alert(data.isLogin);
                if(!data.isLogin){
                    check=false;
                    notLogin();
                }
                else{
                    memberID=data.memberID;
                    member=data.member;
                    check=true;
                    //alert("登入成功");
                }

            },
            error:function(){
                swal("登入失敗");
            }
        });

        this.memberID=memberID;
        this.member=member;

        return check;
        
    }
/*
    notLogin(){
        //跳轉
        alert("跳轉");
        window.location.href="sign.php";
    }*/
}
