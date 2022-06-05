import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
let brandList = document.getElementById("brand__list");
document.title="Trang quản lý hãng";
fetch(`${baseURL}admin/controller/brands.php`,{
    method:"GET",
    credentials:"include"
}).then(res=>{
    return res.text().then(resData=>{
        brandList.innerHTML=resData;
        // let btnDetetes=$$(".btn-delete");
        // btnDetetes.forEach(element=>{
        //     element.addEventListener('click',function (event){
        //         let nodeDelete = event.target.parentNode.parentNode;
        //         let id = this.dataset.id;
        //         let isConfirm = confirm("Bạn chắc chắn muấn xóa chứ!");
        //         if(isConfirm){
        //             fetch(`${baseURL}admin/controller/brands.php?id=${id}`,{
        //                 method: "DELETE",
        //                 credentials:"include"
        //             }).then(res=>{
        //                 if(res.status==201||res.status==200){
        //                     alert("xóa thành công");
        //                     nodeDelete.parentNode.removeChild(nodeDelete);
        //                 }else{
        //                     alert("xóa thất bại");
        //                 }
        //             });
        //         }
        //     })
        // })
    })
})