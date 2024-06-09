import {$,$$} from "../configs/constants.js";
import {baseURL} from "../configs/configs.js";
let formProduct = document.getElementById("form-add-product")
let brandsHtml=""
let brands
fetch(`${baseURL}admin/controller/brands.php`,{
    method:"GET",
    credentials: "include",
}).then(res=>{
    if(res.status===200||res.status===201){
        res.text().then(res=>{
            brands = JSON.parse(res)
            brands.forEach(brand=>{
                brandsHtml+=`<option value="${brand["id"]}">${brand["name"]}</option>`
            })
            document.getElementById("brand").innerHTML=brandsHtml

            //when submit
            formProduct.addEventListener("submit",(e)=>{
                e.preventDefault()
                let formData = new FormData(formProduct)
                fetch(`${baseURL}admin/controller/product.php`,{
                    method: "POST",
                    credentials: "include",
                    body: formData
                }).then(async res=>{
                    if(res.status===200||res.status===201){
                        alert("Thêm sản phẩm thành công");
                        let id = await res.text();
                        if(Number(id)){
                            window.location.href= "http://localhost/laptopstore/admin/index.php?view=product&id="+Number(id)
                        }
                    }else{
                        alert("Thêm sản phẩm thất bại")
                    }
                }).catch(err=>{
                    alert(err)
                })
            })
        })
    }
})