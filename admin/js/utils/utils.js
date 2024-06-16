export const loading = function(){
    let overlay = document.getElementById("spin-overlay");
    overlay.classList.remove("hide")
};
export const unLoading = function(){
    let overlay = document.getElementById("spin-overlay");
    overlay.classList.add("hide")
};