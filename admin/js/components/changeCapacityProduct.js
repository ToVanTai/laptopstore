import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
let id = Object.fromEntries(new URLSearchParams(window.location.search).entries()).id
fetch(`${baseURL}admin/controller/capacities.php?id=${id}`,{
    method: "GET", 
    credentials: "include"
}).then(res=>{
    if(res.status===200||res.status===201){
        res.text().then(res=>{
            let resCapacity = JSON.parse(res)
            document.getElementById("capacity_name").value = resCapacity.capacity_name
            document.getElementById("price").value = resCapacity.price
            document.getElementById("quantity").value = resCapacity.quantity

            // on submit
            let form = document.getElementById("form-change-capacity")
            form.addEventListener("submit",e=>{
                e.preventDefault()
                let formData = new FormData(form)
                fetch(`${baseURL}admin/controller/capacities.php?id=${id}`,{
                    method: "POST",
                    credentials: "include",
                    body: formData
                }).then(res=>{
                    if(res.status===200||res.status===201){
                        alert("Cập nhật dung lượng sản phẩm thành công")
                        let productid = Object.fromEntries(
                            new URLSearchParams(window.location.search).entries()
                        ).productid;
                        if(Number(productid)){
                            window.location.href= "http://localhost/laptopstore/admin/index.php?view=product&id="+Number(productid);
                        }
                    }else {
                        res.text().then(res=>alert(res))
                    }
                }).catch(err=>alert(err))
            })
        })
        
    }
})