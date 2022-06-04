import { $, $$ } from "../configs/constants.js";
import { baseUrl } from "../configs/configs.js";
let formAbout = $(".form__about");
// let params = new URLSearchParams(window.location.search);
// let aboutId=params.get("id");
fetch(`${baseUrl}api/user.php`,{
    credentials:"include",
    method:"GET"
})
.then(response=>{
    return response.text().then(res=>{
        if(res){
            let formContent='';
            let dataRes=JSON.parse(res);
            let name=dataRes.name==null?"":dataRes.name;
            let phoneNumber=dataRes.phone_number==null?"":dataRes.phone_number;
            let address=dataRes.address==null?"":dataRes.address;
            let avatar=dataRes.avatar==null?"./access/imgs/user.png":dataRes.avatar;
            let email=dataRes.email==null?"":dataRes.email;
            formContent=`
            <label for="name" >Họ và tên</label>
                <input type="text"  placeholder="Nhập họ tên" value="${name}"  required name="name"  id="name">

                <label for="phone_number">Số điện thoại nhận hàng</label>
                <input type="tel" placeholder="Nhập số điện thoại" value="${phoneNumber}"  required name="phone_number"  id="phone_number">
                
                <label for="address" >Địa chỉ nhận hàng</label>
                <input type="text" placeholder="Nhập địa chỉ" value="${address}" required name="address"  id="address">
                
                <label for="avatar">Ảnh đại diện</label>
                <input type="file" name="avatar"  id="avatar">

                <label for="email">Email</label>
                <input type="email" placeholder="Nhập email" value="${email}" required name="email"  id="email">
                <input type="hidden" name="crud_req" value="update" />
            `;
            formAbout.innerHTML=formContent+formAbout.innerHTML;
            let btnSubmit=document.getElementById("btn-submit");
            btnSubmit.addEventListener('click',function(event){
                event.preventDefault();
                let form = new FormData($(".form__about"));
                fetch(`${baseUrl}api/user.php`,{
                    credentials:"include",
                    method:"POST",
                    body:form
                }).then(resUpload=>{
                    return resUpload.text().then((resUploadData)=>{
                        alert(resUploadData);
                    })
                }).catch(err=>{
                    alert("Có lỗi xảy ra");
                })
            })
        }
    });
}).catch(err=>{
    alert("có lỗi xảy ra");
});
